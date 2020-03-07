<?php

use Illuminate\Database\Seeder;

class UserGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_groups')->insert([
            [
                'id' => 1,
                'slug' => 'admins',
                'name' => 'Administrators',
                'description' => 'Administration users',
                'organization_id' => 1,
            ],
            [
                'id' => 2,
                'slug' => 'developers',
                'name' => 'Developers',
                'description' => 'Users responsible to write the code for the features.',
                'organization_id' => 1,
            ],
            [
                'id' => 3,
                'slug' => 'code-reviewer',
                'name' => 'Code Reviewers',
                'description' => 'Users responsible by the reviewing of other developers code.',
                'organization_id' => 1,
            ],
            [
                'id' => 4,
                'slug' => 'qa',
                'name' => 'QA Analysts',
                'description' => 'Users responsible by the quality assurance of the developed features.',
                'organization_id' => 1,
            ],
        ]);
    }
}
