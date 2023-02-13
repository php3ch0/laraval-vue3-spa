<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Request;
use Illuminate\Support\Facades\Auth;


class UserController extends  Controller
{
    public function __invoke(Request $request)
    {
        if(Auth::check()) {
            $data=['data'=>Auth::User()];
             return response()->json($data,200);
        }
        return response()->json(['message'=>'unauthenticated'],401);
        return new UserResource($request->user());
    }


}
