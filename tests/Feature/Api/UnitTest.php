<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class UnitTest extends TestCase
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
     * Test get units
     *
     * @return void
     */
    public function testGet()
    {
        $this->assertAuthenticated($guard = null);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('GET', '/api/v1/units/search');

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
