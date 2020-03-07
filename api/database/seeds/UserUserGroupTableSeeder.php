<?php

use Illuminate\Database\Seeder;

class UserUserGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_user_group')->insert([
            [
                'user_id' => 2,
                'user_group_id' => 1,
                'member_since' => now()->subDays(rand(5,30))
            ],
            [
                'user_id' => 3,
                'user_group_id' => 2,
                'member_since' => now()->subDays(rand(5,30))
            ],
            [
                'user_id' => 3,
                'user_group_id' => 3,
                'member_since' => now()->subDays(rand(5,30))
            ],
            [
                'user_id' => 6,
                'user_group_id' => 2,
                'member_since' => now()->subDays(rand(5,30))
            ],
            [
                'user_id' => 7,
                'user_group_id' => 4,
                'member_since' => now()->subDays(rand(5,30))
            ],
        ]);
    }
}
