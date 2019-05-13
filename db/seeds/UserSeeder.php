<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
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
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'first_name'    => $faker->firstName,
                'last_name'     => $faker->lastName,
                'comment'       => $faker->paragraph,
            ];
        }

        $this->table('users')->insert($data)->save();

    }
}
