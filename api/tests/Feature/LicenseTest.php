<?php

namespace Tests\Feature;

use Tests\TestCase;

class LicenseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAddServerLicense()
    {
        $response = $this->post('/licenses');
        $response->assertStatus(200);
    }
}
