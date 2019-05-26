<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class CourseTest extends TestCase
{
    protected $token;

    /**
     * @throws \Exception
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->initToken();
    }

    /**
     * Test get courses
     *
     * @return void
     */
    public function testGet()
    {
        $this->assertAuthenticated($guard = null);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('GET', '/api/v1/courses');

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => true,
                'data' => true
            ]);
    }

    /**
     * Test get levels
     *
     * @return void
     */
    public function testGetLevels()
    {
        $this->assertAuthenticated($guard = null);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('GET', '/api/v1/courses/levels');

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => true,
                'data' => true
            ]);
    }

    protected function initToken()
    {
        $response = $this->json('POST', '/api/v1/login', ['email' => 'weimann.orval@example.org', 'password' => 'password']);

        $content = $response->getOriginalContent();

        $this->token = $content['data']['token'];
    }
}
