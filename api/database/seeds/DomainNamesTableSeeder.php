<?php

use Illuminate\Database\Seeder;

class DomainNamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        DB::table('domain_names')->insert([
            [
                'id' => 1,
                'domain' => 'queen.localhost',
                'organization_id' => 1,
                'created_at' => now()
            ],
            [
                'id' => 2,
                'domain' => 'wflow.queen.io',
                'organization_id' => 1,
                'created_at' => now()
            ],
            [
                'id' => 3,
                'domain' => 'free.localhost',
                'organization_id' => 2,
                'created_at' => now()
            ],
            [
                'id' => 4,
                'domain' => 'bad-company.localhost',
                'organization_id' => 3,
                'created_at' => now()
            ],
        ]);

    }
}
