<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TransitionConditionTest extends TestCase
{
    use DatabaseTransactions;

    public function testSeeTransitionWhenConditionPasses()
    {
        // brian may is a developer and the developer field of the task is set to him
        $user = User::where('email', 'brianmay@gmail.com')->first();
        $response = $this->actingAs($user, 'api')->get('tasks/1');
        $response
            ->assertStatus(200)
            ->assertJson([
                'transitions' => [
                    [
                        'slug' => 'start-coding'
                    ]
                ]
            ]);
    }

    public function testDontSeeTransitionWhenConditionFails()
    {
        // john deacon is a developer, but the development of the task is assigned to brian may
        $user = User::where('email', 'johndeacon@gmail.com')->first();
        $response = $this->actingAs($user, 'api')->get('tasks/1');
        $response
            ->assertStatus(200)
            ->assertJsonMissing([
                'transitions' => [
                    [
                        'slug' => 'start-coding'
                    ]
                ]
            ]);
    }
}
