<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HelloDbControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_hello_db_endpoint_returns_expected_json(): void
    {
        $response = $this->getJson('/api/hello-db');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Hello World from PostgreSQL']);
    }
}
