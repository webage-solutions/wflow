<?php

use Illuminate\Database\Seeder;

class TaskTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_types')->insert([
            [
                'id' => 1,
                'organization_id' => 1,
                'slug' => 'dev',
                'name' => 'Developement ticket',
                'description' => 'Tickets for development requirements',
                'fields' => json_encode([
                    'developer' => [
                        'type' => \App\Components\CustomFields\Types\SingleUserFromGroup::class,
                        'params' => [
                            'group' => 'developers'
                        ]
                    ]
                ]),
                'workflows' => json_encode([
                    [
                        'name' => 'Admin Workflow',
                        'when' => '"admins" in loggedUserGroups',
                        'transitions' => [
                            [
                                'from' => null, // initial transition
                                'to' => 'todo',
                                'slug' => 'initial',
                            ], [
                                'from' => '_all',
                                'to' => '_all',
                            ]
                        ]
                    ],
                    [
                        'name' => 'Default Workflow',
                        'when' => "true", //default WF
                        'transitions' => [
                            [
                                'from' => null, // initial transition
                                'to' => 'todo',
                                'slug' => 'initial',
                            ], [
                                'from' => 'todo',
                                'to' => 'dev-in-progress',
                                'name' => 'Start coding',
                                'slug' => 'start-coding',
                                'condition' => '"developers" in loggedUserGroups && taskFields.developer == loggedUser' // only the developer of the task
                            ], [
                                'from' => 'dev-in-progress',
                                'to' => 'todo',
                                'name' => 'Pause coding',
                                'slug' => 'pause-coding',
                                // condition - only the developer of the task
                            ], [
                                'from' => 'dev-in-progress',
                                'to' => 'blocked',
                                'name' => 'Block',
                                'slug' => 'block',
                                // condition - only the developer of the task
                            ], [
                                'from' => 'blocked',
                                'to' => 'dev-in-progress',
                                'name' => 'Unblock',
                                'slug' => 'unblock',
                                // condition - only the developer of the task
                            ], [
                                'from' => 'dev-in-progress',
                                'to' => 'waiting-code-review',
                                'name' => 'Deliver code',
                                'slug' => 'deliver-code',
                                // condition - only the developer of the task
                            ], [
                                'from' => 'waiting-code-review',
                                'to' => 'code-review-in-progress',
                                'name' => 'Start code review',
                                'slug' => 'start-code-review',
                                // condition - field reviewer set to a user with role reviewers && only the reviewer of the task
                            ], [
                                'from' => 'code-review-in-progress',
                                'to' => 'todo',
                                'name' => 'Reprove code',
                                'slug' => 'reprove-code',
                                // condition - only the reviewer of the task
                            ], [
                                'from' => 'code-review-in-progress',
                                'to' => 'waiting-qa',
                                'name' => 'Approve code',
                                'slug' => 'approve-code',
                                // condition - only the reviewer of the task
                            ], [
                                'from' => 'waiting-qa',
                                'to' => 'qa-in-progress',
                                'name' => 'Start QA',
                                'slug' => 'start-qa',
                                // condition - field qa_analist set to a user with role QA Analists && only the qa_analist of the task
                            ], [
                                'from' => 'qa-in-progress',
                                'to' => 'todo',
                                'name' => 'Reprove',
                                'slug' => 'reprove',
                                // condition - only the qa_analist of the task
                            ], [
                                'from' => 'qa-in-progress',
                                'to' => 'done', // final condition
                                'name' => 'Approve',
                                'slug' => 'approve',
                                // condition - only the qa_analist of the task
                            ]
                        ]
                    ]
                ]),
                'created_at' => now()
            ]
        ]);
    }
}
