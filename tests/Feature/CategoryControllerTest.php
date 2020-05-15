<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testInsertCategory()
    {
        
        $category = Category::create([
            'description' => 'Cozinha'
        ]);
        
        $this->assertDatabaseHas('categories', ['description' => 'Cozinha']);

        
    }

    public function testReturnCategories() {
        $this->get('/api/categories')->assertJsonFragment([
            'categories' => Category::all()
        ]);
    }

    public function testRegisterCategory() {

        $data = [
                    'category' => 
                        [
                            'description' => 'Informática'
                        ]
                ];

        $response = $this->post('/api/category', $data,  ['contentType' => 'application/json']);

        $response->assertStatus(201);
    }
}
