<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Validator;
use Response;

class ProductController extends Controller
{
    
    public function index() {

        return response()->json(['products' => Product::all()]);

    }

    public function create(Request $request) {

        $rules = [
            'description' => 'required|unique:products',
            'price' => 'required|min:0.01',
            'category_id' => 'exists:categories,id'
        ];

        $validation = Validator::make($request->product, $rules);

        if ($validation->passes()) {
            return Response::json(['message' => $request->get('product')], 201);
        }else {
            return Response::json(['errors' => $validation->errors()->all()], 422);
        }

        
       /*  $product = Product::create([
            'description' => 
        ]); */
    }

}
