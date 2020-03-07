<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CustomFieldsTest extends TestCase
{
    use DatabaseTransactions;

    public function testViewCustomFields()
    {
        $user = User::where('email', 'brianmay@gmail.com')->first();
        $response = $this->actingAs($user, 'api')->get('tasks/2');
        $response
            ->assertStatus(200)
            ->assertJson([
                'fields' => [
                    'developer' => [
                        'email' => 'brianmay@gmail.com',
                        'name' => 'Brian May',
                    ]
                ]
            ]);
    }
}
