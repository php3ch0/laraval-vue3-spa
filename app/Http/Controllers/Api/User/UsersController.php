<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersController extends  Controller
{

    public function index() {

        if(Auth::User()->cannot('access-admin')) {
            return response()->json(['Auth Error'],401);
        }

        $users = User::all();

        return response()->json($users,200);

    }

    public function add() {

        if(Auth::User()->cannot('access-admin')) {
            return response()->json(['Auth Error'],401);
        }

        Validator::make(Request::all(), [
            'firstname' => 'required',
            'lastname'=>'required',
            'email' => 'required|email|max:255|unique:users,email,'.Auth::User()->id,
            'password'=>'required|confirmed'
        ])->validate();

        $user = new User();
        $user->fill(Request::all());
        $user->role = Request::get('role');
        $user->password = Hash::make(request::get('password'));
        $user->save();

        return response()->json([],200);

    }

    public function get($id) {
        if(Auth::User()->cannot('access-admin')) {
            return response()->json(['Auth Error'],401);
        }

        $data = User::find($id);

        if(!isset($data->id)) {
            return response()->json(['error'=>'Cannot find item by ID'],404);
        }

        return response()->json($data,200);

    }

    public function edit() {
        if(Auth::User()->cannot('access-admin')) {
            return response()->json(['Auth Error'],401);
        }

        Validator::make(Request::all(), [
            'firstname' => 'required',
            'lastname'=>'required',
            'email' => 'required|email|max:255|unique:users,email,'.Request::get('id'),
            'password'=>'confirmed'
        ])->validate();

        $data = User::find(Request::get('id'));

        if(!isset($data->id)) {
            return response()->json(['error'=>'Cannot find item by ID'],4040);
        }

        $data->fill(Request::all());
        $data->role = Request::get('role');

        if(Request::get('password')) {
            $data->password = Hash::make(request::get('password'));
        }

        $data->save();

        return response()->json($data,200);
    }

    public function delete($id) {

        if(Auth::User()->cannot('access-admin')) {
            return response()->json(['Auth Error'],401);
        }

        $data = User::find($id);

        if(!isset($data->id)) {
            return response()->json(['error'=>'Cannot find item by ID'],4040);
        }

        $data->delete();

        return response()->json([],200);

    }
}
