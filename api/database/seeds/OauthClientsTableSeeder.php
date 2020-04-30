<?php

use Illuminate\Database\Seeder;

class OauthClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        $now = now();
        DB::table('oauth_clients')->insert([
            [
                'id' => 'fce73bc2-02da-47c1-a81d-6dd1ca27b58e',
                'user_id' => null,
                'name' => 'Web App [Queen Inc.]',
                'secret' => null,
                'redirect' => 'http://queen.localhost:8080/oauth-callback,http://wflow.queen.io:8080/oauth-callback',
                'personal_access_client' => false,
                'password_client' => false,
                'revoked' => false,
                'auto_authorize' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => '93e4dbdc-24ec-40c5-abc5-1f5fe5c49c82',
                'user_id' => null,
                'name' => 'Web App [Free Inc.]',
                'secret' => null,
                'redirect' => 'http://free.localhost:8080/oauth-callback',
                'personal_access_client' => false,
                'password_client' => false,
                'revoked' => false,
                'auto_authorize' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 'c775807b-eeac-439d-b819-da827d559829',
                'user_id' => null,
                'name' => 'Web App [Bad Company]',
                'secret' => null,
                'redirect' => 'http://bad-company.localhost:8080/oauth-callback',
                'personal_access_client' => false,
                'password_client' => false,
                'revoked' => false,
                'auto_authorize' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

    }
}
