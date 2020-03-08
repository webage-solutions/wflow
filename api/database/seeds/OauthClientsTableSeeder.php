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
                'user_id' => null,
                'name' => 'Web App [Queen Inc.]',
                'secret' => null,
                'redirect' => 'http://queen.localhost:8080/oauth-callback,http://wflow.queen.io:8080/oauth-callback',
                'personal_access_client' => false,
                'password_client' => false,
                'revoked' => false,
                'auto_authorize' => true,
                'organization_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => null,
                'name' => 'Web App [Free Inc.]',
                'secret' => null,
                'redirect' => 'http://free.localhost:8080/oauth-callback',
                'personal_access_client' => false,
                'password_client' => false,
                'revoked' => false,
                'auto_authorize' => true,
                'organization_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => null,
                'name' => 'Web App [Bad Company]',
                'secret' => null,
                'redirect' => 'http://bad-company.localhost:8080/oauth-callback',
                'personal_access_client' => false,
                'password_client' => false,
                'revoked' => false,
                'auto_authorize' => true,
                'organization_id' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

    }
}
