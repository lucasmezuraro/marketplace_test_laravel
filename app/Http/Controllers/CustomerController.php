<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
