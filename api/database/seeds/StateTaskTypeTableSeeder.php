<?php

use Illuminate\Database\Seeder;

class StateTaskTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('state_task_type')->insert([
            [
                'state_id' => 1,
                'task_type_id' => 1,
            ], [
                'state_id' => 2,
                'task_type_id' => 1,
            ], [
                'state_id' => 3,
                'task_type_id' => 1,
            ], [
                'state_id' => 4,
                'task_type_id' => 1,
            ], [
                'state_id' => 5,
                'task_type_id' => 1,
            ], [
                'state_id' => 6,
                'task_type_id' => 1,
            ], [
                'state_id' => 7,
                'task_type_id' => 1,
            ], [
                'state_id' => 8,
                'task_type_id' => 1,
            ],
        ]);
    }
}
