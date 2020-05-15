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



    public function testReturnProducts()
    {
        $this->withoutMiddleware();
      
        $response = $this->get('/api/products');
        $response->assertStatus(200);
        $response->assertJsonFragment(['products' => Product::all()]);
      
    }

    public function testInsertProduct() {

        $category = Category::create([
            'description' => 'Informática'
        ]);

        $product = Product::create([
            'description' => 'Computador Positivo',
            'price' => 2199.95,
            'category_id' => $category->id
        ]);

        $this->assertDatabaseHas('products', [
            'description' => 'Computador Positivo',
            'price' => 2199.95,
            'category_id' => $category->id
        ]);
    }

    public function testRegisterProduct() {

        $data = [
            'product' => [
                'description' => 'Computador LG 4gb',
                'price' => 2000.00,
                'category_id' => 3
            ]
        ];
        
        $response = $this->post('/api/product', $data);
        $response->assertJsonFragment(['message' => 'product registrated with success!']);
    }

    public function testUpdateProduct() {
        $data = [
            'product' => [
                'description' => 'Computador 2'
            ]
        ];

        $response = $this->put('/api/product/1', $data);
        $response->assertJsonFragment(['message' => 'product updated with success!']);
    }

    public function testUpdateProductNotChanged() {
        $data = [
            'product' => [
                'description' => 'Computador 2'
            ]
        ];

        $response = $this->put('/api/product/1', $data);
        $response->assertJsonFragment(['error' => 'product not changed']);
    }

    public function testDestroyProduct() {

        $response = $this->delete('/api/product/1');
        $response->assertJsonFragment(['message' => 'product deleted with success!']);
    }

    public function testDestroyProductNotExists() {

        $response = $this->delete('/api/product/11');
        $response->assertJsonFragment(['error' => 'product not found']);
    }
}
