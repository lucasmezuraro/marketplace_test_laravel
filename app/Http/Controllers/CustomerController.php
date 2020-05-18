<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Auth;
use Response;
use Validator;
use App\Customer;

class CustomerController extends Controller
{

    public function index() {
        $id = Auth::user()->id;
        return Response::json(['my' => Customer::find($id)]);
    }

    public function create(Request $request) {

        $rules = [
            'name' => 'required',
            'lastname' => 'required',
            'cpf' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            try {
                $customer = Customer::create([
                    'name' => $request->name,
                    'lastname' => $request->lastname,
                    'cpf' => $request->cpf,
                    'user_id' => Auth::user()->id
                ]);
                
                return Response::json(['message' => 'customer registrated with success!'], 201);
            }catch(QueryException $e) {
                return Response::json(['error' => $e->getMessage()], 500);
            }
            
            
            


        }else {
            return Response::json(['error' => $validator->errors()->all()], 422);
        }

        
    }

    public function update($id, Request $request) {

        $rules = [
            'name' => 'sometimes',
            'lastname' => 'sometimes',
            'cpf' => 'sometimes', 
        ];

        $validator = Validator($request->all(), $rules);

        if ($validator->passes()) {
            $customer = Customer::find($id);
            
            if ($customer) {
                $customer->fill($request->all())->save();
                if ($customer->wasChanged()) {
                    return Response::json(['message' => 'customer informations changed with success'], 200);
                }else {
                    return Response::json(['message' => 'customer informations not changed'], 500);
                }
                
            }else {
                return Response::json(['error' => 'customer not found'], 404);
            }       

            
        }else {
            return Response::json(['error' => $validator->errors()->all()], 422);
        }
    }
}
