<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Category;

class CategoryTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;
    

    protected $category;

    public function setUp() : void {
        parent::setUp();

        $this->category = Category::create([
            'description' => 'Cozinha'
        ]);
    }
    
    
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testInsertCategory()
    {
        $this->assertDatabaseHas('categories', ['description' => 'Cozinha']);
    }

    public function testReturnCategories() {
        $response = $this->get('/api/categories');
        $response->assertStatus(200);
    }

    public function testRegisterCategory() {

        $data = [
                    'category' => 
                        [
                            'description' => 'Informática'
                        ]
                ];

        $response = $this->post('/api/category', $data);

        $response->assertStatus(201);
    }

    public function testUpdateCategory() {
        $data = [
            'category' => [
                'description' => 'Informátic'
            ]
        ];

        $response = $this->put('/api/category/'.$this->category->id, $data);

        $response->assertStatus(200);

    }

    public function testUpdateCategoryNotFound() {

        $data = [
            'category' => [
                'description' => 'Informátic'
            ]
        ];
        $response = $this->put('/api/category/11111', $data,  ['contentType' => 'application/json']);
        $response->assertStatus(404);

    }

    public function testDestroyCategory() {

        $response = $this->delete('/api/category/'.Category::first()->id);
        $response->assertJsonFragment(['message' => 'category deleted with success!']);
    }

    public function testDestroyCategoryNotExists() {

        $response = $this->delete('/api/category/111111');
        $response->assertJsonFragment(['error' => 'category not found']);
    }
}
