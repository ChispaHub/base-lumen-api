<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|between:3,60',
            'username' => 'required|unique:users|max:100',
            'email' => 'required|email|unique:users|max:100',
            'password' => 'required|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'
        ]);

        if($validator->fails()) {
            return $this->errorValidator($validator);
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = (new BcryptHasher)->make($request->input('password'));
        $user->save();
        $token = Auth::guard('api')->fromUser($user);
        return $this->respondWithToken($token);
    }

    public function show($id)
    {
        $user = User::where('id', $id)->first();
        return response()->json($user);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|between:3,60',
            'email' => 'required|email|unique:users|max:100'
        ]);

        if($validator->fails()) {
            return $this->errorValidator($validator);
        }

        $user = Auth::guard('api')->user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
        ]);

        if($validator->fails()) {
            return $this->errorValidator($validator);
        }

        $user = Auth::guard('api')->user();

        if($user->password === (new BcryptHasher)->make($request->input('old_password'))) {
            $user->password = (new BcryptHasher)->make($request->input('new_password'));
            $user->save();
            return response()->json(['success' => 'Password updated.']);
        } 

        return response()->json(['error' => 'Wrong password.'], 401);
    }
}