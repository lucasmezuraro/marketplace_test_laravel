<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\User;

class LoginControllerTest extends TestCase
{
    
    use WithoutMiddleware;
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    protected $user;

    public function setUp(): void {
        parent::setUp();
    }


    public function testLoginDenied() {
        $response = $this->post('/api/login', ['email' => 'email@email.com', 'password' => '1234']);

        $response->assertStatus(401);
    }

    public function testLoginParameters() {
        $response = $this->post('/api/login', ['email1' => 'email@email.com', 'password1' => '1234']);

        $response->assertStatus(401);
    }

    public function testLogoutRoute() {
        $response = $this->get('/api/logout');

        $response->assertStatus(500);
    }

    public function testLoginProcess() {

        $this->user = User::create([
            'name' => 'user',
            'email' => 'user@user.com',
            "password" => '123'
        ]);

        $response = $this->post('/api/login', ['email' => 'user@user.com', 'password' => '123']);
        $response->assertStatus(200);
    }
}