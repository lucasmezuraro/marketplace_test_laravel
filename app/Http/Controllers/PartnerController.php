<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Partner;
use Auth;
use Response;
use Validator;

class PartnerController extends Controller
{

    
    public function index() {
        
        if(Auth::user()) {
            $partner = Partner::where(['user_id'=>Auth::user()->id])->get();
            if ($partner) {
                return Response::json(['partner' => $partner]);
            }else {
                return Response::json(['error' => 'Partner not found in database'], 404);
            }
        }else {
            return Response::json(['error' => 'You are not logged, please check our credentials']);
        }
    }

    public function create(Request $request) {

        $rules = [
            'name' => 'required',
            'cnpj' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            try {
                $customer = Partner::create([
                    'name' => $request->name,
                    'cnpj' => $request->cnpj,
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
}
