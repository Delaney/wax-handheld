<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private $messages = [
        'email' => "Email is required",
        'password' => "Password is required",
        'first_name' => "First name is required",
        'last_name' => "Last name is required",
    ];

    public function signup(Request $request)
    {        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ], $this->messages);

        if ($validator->fails()){
            return $this->errorResponse($validator->errors()->toArray(), 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        return $this->response([
            'name' => $user->name,
            'username' => $user->username,
            'token' => $user->createToken('Handheld')->plainTextToken,
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ], $this->messages);

        if ($validator->fails()){
            return $this->errorResponse($validator->errors()->toArray(), 400);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user();
            return $this->response([
                'name' => $user->name,
                'username' => $user->username,
                'token' => $user->createToken('Handheld')->plainTextToken,
            ]);
        } 
        else {
            return $this->errorResponse('Unauthenticated', 401);
        } 
    }
}
