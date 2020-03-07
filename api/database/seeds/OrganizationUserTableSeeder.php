<?php

use Illuminate\Database\Seeder;

class OrganizationUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organization_user')->insert([
            [
                'organization_id' => 1,
                'user_id' => 2,
                'member_since' => now()->subDays(rand(5,30))
            ],
            [
                'organization_id' => 1,
                'user_id' => 3,
                'member_since' => now()->subDays(rand(5,30))
            ],
            [
                'organization_id' => 1,
                'user_id' => 4,
                'member_since' => now()->subDays(rand(5,30))
            ],
            [
                'organization_id' => 2,
                'user_id' => 4,
                'member_since' => now()->subDays(rand(5,30))
            ],
            [
                'organization_id' => 3,
                'user_id' => 4,
                'member_since' => now()->subDays(rand(5,30))
            ],[
                'organization_id' => 2,
                'user_id' => 5,
                'member_since' => now()->subDays(rand(5,30))
            ],[
                'organization_id' => 1,
                'user_id' => 6,
                'member_since' => now()->subDays(rand(5,30))
            ],[
                'organization_id' => 1,
                'user_id' => 7,
                'member_since' => now()->subDays(rand(5,30))
            ],
        ]);
    }
}
