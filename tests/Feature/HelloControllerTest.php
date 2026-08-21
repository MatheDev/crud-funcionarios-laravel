<?php

namespace Tests\Feature;

use Tests\TestCase;

class HelloControllerTest extends TestCase
{
    public function test_hello_endpoint_returns_expected_json(): void
    {
        $response = $this->getJson('/api/hello');

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'timestamp'])
            ->assertJson(['message' => 'Hello World']);
    }
}
