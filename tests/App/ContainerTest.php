<?php

namespace test\App;

use App\Container\KeyNotFoundException;
use App\Container\Container;
use PHPUnit\Framework\TestCase;
use stdClass;

class ContainerTest extends TestCase
{
    /** @test */
    public function can_add_params()
    {
        $container = new Container();

        $container->set($key = 'value', $value = 5);
        $this::assertEquals($value, $container->get($key));

        $container->set($key = 'value', $value = 'string');
        $this::assertEquals($value, $container->get($key));

        $container->set($key = 'value', $value = ['5' => 'test']);
        $this::assertEquals($value, $container->get($key));

        $container->set($key = 'value', $value = new \stdClass());
        $this::assertEquals($value, $container->get($key));
    }

    /** @test */
    public function callback_not_running()
    {
        $container = new Container();

        $container->set($key = 'value', function () {
            return new \stdClass();
        });

        $this::assertNotNull($container->get($key));
        $this->assertInstanceOf(\stdClass::class, $container->get($key));

    }

    /** @test */
    public function pass_myself_as_params()
    {
        $container = new Container();

        $container->set('param', $param = 5);
        $container->set($key = 'value', function (Container $container) {
            $object = new \stdClass();
            $object->param = $container->get('param');
            return $object;
        });

        $this::assertObjectHasAttribute('param', $object = $container->get($key));
        $this::assertEquals($param, $object->param);

    }

    /** @test */
    public function autocreate_simple_object()
    {
        $container = new Container();

        $this::assertNotNull($value1 = $container->get(stdClass::class));
        $this::assertNotNull($value2 = $container->get(stdClass::class));

        $this::assertInstanceOf(stdClass::class, $value1);
        $this::assertInstanceOf(stdClass::class, $value2);

        $this::assertSame($value1, $value2);

    }

    /** @test */
    public function can_cache_keys()
    {
        $container = new Container();

        $container->set($key = 'value', function () {
            return new \stdClass();
        });

        $this::assertNotNull($value1 = $container->get($key));
        $this::assertNotNull($value2 = $container->get($key));

        $this::assertSame($value1, $value2);

    }

    /** @test */
    public function reflection_construct()
    {
        $container = new Container();

        $this::assertNotNull($first = $container->get(First::class));
        $this::assertInstanceOf(First::class, $first);


        $this::assertNotNull($second = $first->firstSub);
        $this::assertInstanceOf(FirstSub::class, $second);


        $this::assertNotNull($third = $second->secondSub);
        $this::assertInstanceOf(SecondSub::class, $third);

    }

    /** @test */
    public function exception_when_params_not_found()
    {
        $container = new Container();

        $container->set('value', $value = 5);

        $this::expectException(KeyNotFoundException::class);
        $container->get('error name');
    }


}

class First
{
    public $firstSub;

    public function __construct(FirstSub $firstSub)
    {
        $this->firstSub = $firstSub;
    }
}

class FirstSub
{
    public $secondSub;

    public function __construct(SecondSub $secondSub)
    {
        $this->secondSub = $secondSub;
    }
}

class SecondSub
{

}