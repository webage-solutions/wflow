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
                // 1
                'name' => 'Queen Inc.',
                'ui_client_id' => 'fce73bc2-02da-47c1-a81d-6dd1ca27b58e',
                'settings' => json_encode([
                    'locale' => [
                        'value' => 'pt-BR',
                        'final' => true
                    ],
                ]),
                'created_at' => now()
            ],
            [
                // 2
                'name' => 'Free Inc.',
                'ui_client_id' => '93e4dbdc-24ec-40c5-abc5-1f5fe5c49c82',
                'settings' => null,
                'created_at' => now()
            ],
            [
                // 3
                'name' => 'Bad Company',
                'ui_client_id' => 'c775807b-eeac-439d-b819-da827d559829',
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
