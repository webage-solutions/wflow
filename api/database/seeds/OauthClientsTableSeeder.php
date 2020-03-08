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
                // 2
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
                // 3
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
                // 4
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