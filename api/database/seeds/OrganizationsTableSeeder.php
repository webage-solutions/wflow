<?php

use Illuminate\Database\Seeder;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        DB::table('organizations')->insert([
            [
                'id' => 1,
                'name' => 'Queen Inc.',
                'ui_client_id' => 2,
                'settings' => json_encode([
                    'locale' => [
                        'value' => 'pt-BR',
                        'final' => true
                    ],
                ]),
                'created_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Free Inc.',
                'ui_client_id' => 3,
                'settings' => null,
                'created_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'Bad Company',
                'ui_client_id' => 4,
                'settings' => null,
                'created_at' => now()
            ],
        ]);

//        $extraData = [];
//        foreach (range(0, 50) as $i) {
//            $extraData[] = [
//                'name' => $faker->company
//            ];
//        }

//        DB::table('organizations')->insert($extraData);
    }
}
