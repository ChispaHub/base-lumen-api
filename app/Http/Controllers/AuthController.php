<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exception\HttpResponseException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorValidator($validator);
        }

        if(filter_var($request->user, FILTER_VALIDATE_EMAIL)) {
            $token = Auth::guard('api')->attempt(['email' => $request->user, 'password' => $request->password]);
        } else {
            $token = Auth::guard('api')->attempt(['username' => $request->user, 'password' => $request->password]);
        }

        if(!$token) {
            return response()->json(['errmsg' => 'Unauthorized.'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return response(['message' => 'logged out']);
    }

    public function refresh()
    {
        $token = Auth::guard('api')->refresh();
        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    public function getCurrentToken()
    {
        $token = Auth::guard('api')->getToken()->get();
        return $this->respondWithToken($token);
    }
}