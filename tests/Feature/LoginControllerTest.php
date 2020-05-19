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

        User::create([
            'name' => 'user2',
            'email' => 'user2@user.com',
            "password" => bcrypt('123')
        ]);

        $response = $this->post('/api/login', ['email' => 'user2@user.com', 'password' => '123']);
        $response->assertStatus(200);
    }

    public function testRegisterProcess() {

        $response = $this->post('/api/register', ['name'=> 'user','email' => 'user10@user.com', 'password' => '123']);
        $response->assertStatus(200);
    }
}
