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
    
    private $user;
    private $customer;
    
    public function setUp(): void {
        parent::setUp();

        $this->user = User::create([
            'name' => 'User1',
            'email' => 'user1@user.com',
            'password' => bcrypt(123)]);
        $this->customer= Customer::create(
                ['name' => $this->user->name,
                'lastname' => 'test',
                'cpf' => '0120930193',
                'user_id' => $this->user->id]
            );
    }
    
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCustomerRoute()
    {
        $this->actingAs($this->user)->get('/api/my')->assertStatus(200);
    }

    public function testCustomerInsert() {

        Customer::create(
            ['name' => $this->user->name,
            'lastname' => 'test',
            'cpf' => '0120930193',
            'user_id' => $this->user->id]
        );

        $this->assertDatabaseHas('customers', ['lastname' => 'test']);
    }

    public function testCustomerRegistration() {
        $this->actingAs($this->user)->post('/api/customer', ['name' => 'user', 'lastname' => 'test', 'cpf' => '0120930193'])->assertStatus(201);
    }

    public function testUpdateCustomer() {
        $this->actingAs($this->user)->put('/api/customer/'.$this->customer->id, ['name' => 'User 2'])->assertStatus(200);
    }

    public function testDeleteCustomer() {
        $this->actingAs($this->user)->delete('/api/customer/'.$this->customer->id)->assertStatus(200);
    }
}
