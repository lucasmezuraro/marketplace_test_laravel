<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\User;
use App\Customer;

class CustomerControllerTest extends TestCase
{
    
    use WithoutMiddleware;
    use DatabaseTransactions;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCustomerRoute()
    {
        $user = User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt(123)]);
        
        Customer::create(
            ['name' => $user->name,
            'lastname' => 'test',
            'cpf' => '0120930193',
            'user_id' => $user->id]
        );

        $this->actingAs($user)->get('/api/my')->assertStatus(200);
    }
}
