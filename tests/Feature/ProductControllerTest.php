<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Product;
use App\Category;

class ProductControllerTest extends TestCase
{

    use WithoutMiddleware;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testReturnProducts()
    {
        $this->withoutMiddleware();
      
        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertJsonFragment(['products' => Product::all()]);
      
    }

    public function testInsertProducts() {

        Category::create([
            'description' => 'Informática'
        ]);

        $product = Product::create([
            'description' => 'Computador Positivo',
            'price' => 2199.90,
            'category_id' => 2
        ]);

        $this->assertDatabaseHas('products', [
            'description' => 'Computador Positivo',
            'price' => 2199.90,
            'category_id' => 2
        ]);
    }

    public function registerProducts() {

        $response = $this->post('/api/product', ['description' => 'Computador LG 4GB',
        'price' => 2000.00,
        'category_id' => 2]);

        $response->assertJsonFragment(['message' => 'registrated with success!']);
    }
}
