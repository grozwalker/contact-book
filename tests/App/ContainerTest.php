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
        $config = [
            'value1' => 5,
            'value2' => 'string',
            'value3' => ['5' => 'test'],
            'value4' => new \stdClass(),
        ];

        $container = new Container([
            'value1' => 5,
            'value2' => 'string',
            'value3' => ['5' => 'test'],
            'value4' => new \stdClass(),
        ]);

        $this::assertEquals($config['value1'], $container->get('value1'));

        $this::assertEquals($config['value2'], $container->get('value2'));

        $this::assertEquals($config['value3'], $container->get('value3'));

        $this::assertEquals($config['value4'], $container->get('value4'));
    }

    /** @test */
    public function callback_not_running()
    {
        $container = new Container([
            'value' => function () {
                return new \stdClass();
            }
        ]);

        $this::assertNotNull($container->get('value'));
        $this->assertInstanceOf(\stdClass::class, $container->get('value'));

    }

    /** @test */
    public function pass_myself_as_params()
    {
        $container = new Container([
            'param' => 5,
            'value' => function (Container $container) {
                $object = new \stdClass();
                $object->param = $container->get('param');
                return $object;
            }
        ]);

        $this::assertObjectHasAttribute('param', $object = $container->get('value'));
        $this::assertEquals(5, $object->param);

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
        $container = new Container([
            'value' => function () {
                return new \stdClass();
            }
        ]);

        $this::assertNotNull($value1 = $container->get('value'));
        $this::assertNotNull($value2 = $container->get('value'));

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
        $container = new Container([
            'value' => 5
        ]);

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