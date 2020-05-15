<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Validator;
use Response;
use DB;

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
            return Response::json(['message' => 'product registrated with success!'], 201);
        }else {
            return Response::json(['errors' => $validation->errors()->all()], 422);
        }
    }

    public function update($id, Request $request) {
       /*  $product = Product::find($id);
        return $product->getAttributes(); */
        
         $rules = [
            'product' => 'required',
            'description' => 'sometimes',
            'price' => 'sometimes|integer',
            'category_id' => 'sometimes|integer|exists:categories, id'
        ];

         $validator = Validator::make($request->all(), $rules); 

        if ($validator->passes()) {
            $product = Product::find($id);
            if ($product) {
                
                $product->fill($request->product)->save();
                
                if ($product->wasChanged()) {
                    return Response::json(['message' => 'product updated with success!'], 200);
                }else {
                    return Response::json(['error' => 'product not changed'], 500);
                }

            }else {
                return Response::json(['error' => 'product not found!'], 404);
            }

            
        }else {
            return Response::json(['errors' => $validator->errors()->all()], 422);
        }
       
    }

    public function destroy($id, Request $request) {
        $product = Product::destroy($id);

        if($product) {
            return Response::json(['message' => 'product deleted with success!'], 200);
        }else {
            return Response::json(['error' => 'product not found'], 404);
        }
    }

}
