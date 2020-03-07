<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->insert([
            [
                'id' => 1,
                'organization_id' => 1,
                'slug' => 'todo',
                'name' => 'To Do',
                'description' => 'The task was not started',
                'created_at' => now()
            ], [
                'id' => 2,
                'organization_id' => 1,
                'slug' => 'dev-in-progress',
                'name' => 'Development in progress',
                'description' => 'The task is been coded',
                'created_at' => now()
            ], [
                'id' => 3,
                'organization_id' => 1,
                'slug' => 'blocked',
                'name' => 'Development blocked',
                'description' => 'The coding is blocked',
                'created_at' => now()
            ], [
                'id' => 4,
                'organization_id' => 1,
                'slug' => 'waiting-code-review',
                'name' => 'Ready for code review',
                'description' => 'The task coding is done, waiting for review',
                'created_at' => now()
            ], [
                'id' => 5,
                'organization_id' => 1,
                'slug' => 'code-review-in-progress',
                'name' => 'Code review in progress',
                'description' => 'The code is been reviewed',
                'created_at' => now()
            ], [
                'id' => 6,
                'organization_id' => 1,
                'slug' => 'waiting-qa',
                'name' => 'Code approved, waiting for QA check',
                'description' => 'The code is approved, and it\'s waiting for quality assurance.',
                'created_at' => now()
            ], [
                'id' => 7,
                'organization_id' => 1,
                'slug' => 'qa-in-progress',
                'name' => 'The task is been verified for QA',
                'description' => 'The feature is been verified for quality assurance',
                'created_at' => now()
            ], [
                'id' => 8,
                'organization_id' => 1,
                'slug' => 'done',
                'name' => 'The task is done.',
                'description' => 'The task was approved by QA, and it\'s done',
                'created_at' => now()
            ],
        ]);
    }
}
