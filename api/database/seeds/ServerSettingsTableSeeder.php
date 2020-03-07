<?php

use Illuminate\Database\Seeder;

class ServerSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('server_settings')->insert([
            [
                'settings' => json_encode([
                    'locale' => [
                        'value' => 'en-US'
                    ],
                ])
            ]
        ]);
    }
}
