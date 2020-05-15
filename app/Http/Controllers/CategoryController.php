<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Response;
use Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index() {

        return response()->json(['categories' => Category::all()]);
    }

    public function create(Request $request) {
        
        $rules = [
            'description' => [
                'required'
        ]
    ];

        $validator = Validator::make($request->category, $rules);

        if ($validator->passes()) {

            Category::create(
                [
                    'description' => $request->category['description']
                ]
            );
            
            return Response::json(['message' => 'Category registrated with success!'], 201);
        }else {
            return Response::json(['errors' => $validator->errors()->all()], 422);
        }
    }

    public function update($id, Request $request) {
        $rules = [
            'category' => [
                'required'
            ]
        ];

        $category = Category::find($id);

        if ($category) {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->passes()) {
                $category->fill($request->category)->save();
                
                if ($category->wasChanged()) {
                    return Response::json(['message' => 'Category registrated with success!'], 200);
                }else {
                    return Response::json(['error' => 'category not changed'], 500);
                }
                
            }else {
                return Response::json(['errors' => $validator->errors()->all()], 422);
            } 
        }else {
            return Response::json(['error' => 'category not found'], 404);
        }
        
    }
}
