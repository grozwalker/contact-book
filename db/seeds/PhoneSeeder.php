<?php


use Phinx\Seed\AbstractSeed;

class PhoneSeeder extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'UserSeeder',
        ];
    }
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 1; $i < 11; $i++) {
            for ($k = 0; $k < $faker->numberBetween(0, 5); $k++) {
                $data[] = [
                    'user_id'   => $i,
                    'phone'     => $faker->tollFreePhoneNumber,
                ];
            }
        }

        $this->table('phones')->insert($data)->save();
    }
}
