<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\User;

class PartnerControllerTest extends TestCase
{

    use WithoutMiddleware;
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    private $user;

    public function setUp(): void {
        parent::setUp();

        $this->user = User::create([
            'name' => 'User33',
            'email' => 'user33@user.com',
            'password' => bcrypt('123')
        ]);
    }

    public function testPartnersRoute()
    {
        $response = $this->get('/api/partner');

        $response->assertStatus(200);
    }

    public function testCreatePartner() {

        $params = [
            'name' => 'Company',
            'cnpj' => '0019230191231'
        ];

        $response = $this->actingAs($this->user)->post('/api/partner', $params)->assertStatus(201);
    }
}
