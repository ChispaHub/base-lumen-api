<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use Helpers;

    public function error($errmsg)
    {
        return response()->json(
            $errmsg
        , 401);
    }
    
    public function errorValidator($validator)
    {
        return $this->error($validator->errors());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}