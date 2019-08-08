<?php

use Phinx\Seed\AbstractSeed;

class ClientSeeder extends AbstractSeed
{
    public function run()
    {
        $table = $this->table('clients');
        $table->truncate();

        $faker = Faker\Factory::create('pt_BR');

        $clients = [];
        for ($i=0; $i<60; $i++) {
            $datetime = $faker->date($format = 'Y-m-d', $max = 'now') . " " . $faker->time($format = 'H:i:s', $max = 'now');
            $clients[] = [
                'name' => $faker->name,
                'email' => $faker->email,
                'birthdate' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'cpf' => $faker->cpf(false),
                'zipcode' => $faker->numberBetween(15000000, 99990000),
                'address' => $faker->streetName,
                'number' => $faker->numberBetween(100, 2000),
                'complement' => $faker->sentence(4, true),
                'district' => $faker->sentence(2, true),
                'city' => $faker->city,
                'state' => $faker->stateAbbr,
                'phone' => $faker->areaCode.$faker->phone(false),
                'obs' => '',
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ];
        }

        $table->insert($clients)->save();
    }
}
