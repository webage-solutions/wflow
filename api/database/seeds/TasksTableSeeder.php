<?php

use Illuminate\Database\Seeder;

class                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert([
            [
                'id' => 1,
                'organization_id' => 1,
                'task_type_id' => 1,
                'current_state_id' => 1,
                'code' => 1,
                'title' => 'Task 1 - todo',
                'description' => 'Task long description...',
                'history' => json_encode([]),
                'fields' => json_encode([
                    'developer' => 3
                ]),
                'created_at' => now(),
            ], [
                'id' => 2,
                'organization_id' => 1,
                'task_type_id' => 1,
                'current_state_id' => 2,
                'code' => 2,
                'title' => 'Task 2 - dev in progress',
                'description' => 'Task long description...',
                'history' => json_encode([]),
                'fields' => json_encode([
                    'developer' => 3
                ]),
                'created_at' => now(),
            ], [
                'id' => 3,
                'organization_id' => 1,
                'task_type_id' => 1,
                'current_state_id' => 3,
                'code' => 3,
                'title' => 'Task 3 - Blocked',
                'description' => 'Task long description...',
                'history' => json_encode([]),
                'fields' => json_encode([]),
                'created_at' => now(),
            ],
            [
                'id' => 4,
                'organization_id' => 1,
                'task_type_id' => 1,
                'current_state_id' => 4,
                'code' => 4,
                'title' => 'Task 4 - Waiting code review',
                'description' => 'Task long description...',
                'history' => json_encode([]),
                'fields' => json_encode([]),
                'created_at' => now(),
            ], [
                'id' => 5,
                'organization_id' => 1,
                'task_type_id' => 1,
                'current_state_id' => 5,
                'code' => 5,
                'title' => 'Task 5 - Code review in progress',
                'description' => 'Task long description...',
                'history' => json_encode([]),
                'fields' => json_encode([]),
                'created_at' => now(),
            ],[
                'id' => 6,
                'organization_id' => 1,
                'task_type_id' => 1,
                'current_state_id' => 6,
                'code' => 6,
                'title' => 'Task 6 - Waiting QA',
                'description' => 'Task long description...',
                'history' => json_encode([]),
                'fields' => json_encode([]),
                'created_at' => now(),
            ],[
                'id' => 7,
                'organization_id' => 1,
                'task_type_id' => 1,
                'current_state_id' => 7,
                'code' => 7,
                'title' => 'Task 7 - QA in progress',
                'description' => 'Task long description...',
                'history' => json_encode([]),
                'fields' => json_encode([]),
                'created_at' => now(),
            ]
        ]);
    }
}
