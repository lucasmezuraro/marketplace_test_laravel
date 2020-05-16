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
    use DatabaseTransactions;

    protected $product;
    protected $category;
    protected $data;
    /**
     * @ before Class
     */

    public function setUp(): void {
        parent::setUp();

        $this->category = Category::create([
            'description' => 'Informática'
        ]);

        $this->product = Product::create([
            'description' => 'Computador Positivo',
            'price' => 2199.95,
            'category_id' => $this->category->id
        ]);

        $this->data = [
            'product' => [
                'description' => 'Computador LG 4gb',
                'price' => 2000.00,
                'category_id' => Category::first()->id
            ]
        ];

    }

    public function testReturnProducts()
    {
        $this->withoutMiddleware();
      
        $response = $this->get('/api/products');
        $response->assertStatus(200);
      
    }

    public function testInsertProduct() {

        $this->assertDatabaseHas('products', [
            'description' => 'Computador Positivo',
            'price' => 2199.95,
            'category_id' => $this->category->id
        ]);
    }

    public function testRegisterProduct() {

        $response = $this->post('/api/product', $this->data);
        $response->assertJsonFragment(['message' => 'product registrated with success!']);
    }

    public function testUpdateProduct() {
        

        $data = [
            'product' => [
                'description' => 'Computador 2'
            ]
        ];

        $response = $this->put('/api/product/'.$this->product->id, $this->data);
        $response->assertJsonFragment(['message' => 'product updated with success!']);
    }

    public function testUpdateProductNotChanged() {
        $data = [
            'product' => [
                'description1' => 'Computador 2'
            ]
        ];

        $response = $this->put('/api/product/'.Product::first()->id, $data);
        $response->assertJsonFragment(['error' => 'product not changed']);
    }

    public function testDestroyProduct() {

        $response = $this->delete('/api/product/'.Product::first()->id);
        $response->assertJsonFragment(['message' => 'product deleted with success!']);
    }

    public function testDestroyProductNotExists() {

        $response = $this->delete('/api/product/111111');
        $response->assertJsonFragment(['error' => 'product not found']);
    }
}
