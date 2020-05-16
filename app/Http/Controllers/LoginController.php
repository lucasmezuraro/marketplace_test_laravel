<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Response;
use App\User;

class LoginController extends Controller
{
    
    public function login(Request $request) {
        $rules = [
            'email' => 'required|string',
            'password' => 'required|string'
        ];
        
        
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $credentials = $request->only('email', 'password');
            if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], false, false)) {
                $payload = [
                    'email' => $request->user()->email,
                    'token' => $request->user()->createToken('token')->accessToken
                ];
                return Response::json(['payload' => $payload], 200);
            }else {
                return Response::json(['error' => 'invalid credentials'], 401);
            }

        }else {
           return Response::json(['error' => $validator->errors()->all()], 401);
        }

    }

    public function register(Request $request) {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string'
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => (request('password'))
            ]);

            if($user) {
                Auth::login($user);

                if (Auth::user()) {
                    $payload = [
                        'email' => $request->user()->email,
                        'token' => $request->user()->createToken('token')->accessToken
                    ];

                    return Response::json($payload, 200);
                }else {
                    return Response::json(['error' => 'user created, but are a problem in authentication system, sorry! Please, try again later'], 500);
                }
                

            }else {
                return Response::json(['error' => 'We cannot finish the registration, please try again later'], 500);
            }

        }else {
           return Response::json(['message' => $validator->errors()->all()], 422);
        }
    }

    public function logout(Request $request) {

        
        $logoutProcess = $request->user()->token()->revoke();
        
        if ($logoutProcess) {
            return Response::json(['message' => 'Logout with success!'], 200);
        }else {
            return Response::json(['error' => 'Sorry, an error occurred in logout process, we will analyse it']);
        }
    }
}
