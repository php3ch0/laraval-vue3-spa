<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UsersController extends  Controller
{

    public function index() {

        if(Auth::User()->cannot('access-admin')) {
            return response()->json(['Auth Error'],401);
        }

        if(Request::Get('search')) {
            $data = User::search(Request::Get('search',true,true))->paginate(25);
        } else {
            $data = User::whereRaw('1=1')->paginate(25);
        }



        return response()->json($data,200);

    }

    public function add() {

        if(Auth::User()->cannot('access-admin')) {
            return response()->json(['Auth Error'],401);
        }

        $v = Validator::make(Request::all(), [
            'firstname' => 'required',
            'lastname'=>'required',
            'email' => 'required|email|max:255|unique:users,email,'.Auth::User()->id,
            'password'=>'required|confirmed'
        ]);

        if ($v->fails()) {
            return response()->json($v->errors(),422);
        }

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

        $v = Validator::make(Request::all(), [
            'firstname' => 'required',
            'lastname'=>'required',
            'email' => 'required|email|max:255|unique:users,email,'.Request::get('id'),
            'password'=>'confirmed'
        ]);

        if ($v->fails()) {
            return response()->json($v->errors(),422);
        }

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

    public function register() {

        $v = Validator::make(Request::all(), [
            'firstname' => 'required',
            'lastname'=>'required',
            'email' => 'required|email|max:255|unique:users,email',
            'password'=>'required|confirmed'
        ]);

        if ($v->fails()) {
            return response()->json($v->errors(),422);
        }

        $user = new User();
        $user->fill(Request::all());
        $user->role='user';
        $user->password = bcrypt(Request::get('password'));
        $user->save();


        Auth::loginUsingId($user->id);

        return response()->json($user,200);


    }

    public function update() {

        if(Auth::User()->cannot('access-user')) {
            return response()->json(['Auth Error'],401);
        }

        $v = Validator::make(Request::all(), [
            'firstname' => 'required',
            'lastname'=>'required',
            'skills'=>'required',
            'day'=>'required|numeric',
            'month'=>'required|numeric',
            'year'=>'required|numeric',
            'telephone'=>'required',
            'email' => 'required|email|max:255|unique:users,email,'.Auth::User()->id
        ]);

        if ($v->fails()) {
            return response()->json($v->errors(),422);
        }

        $user = Auth::User();
        $user->fill(Request::all());
        $user->dob = date('Y-m-d',strtotime(Request::get('day').'/'.Request::Get('month').'/'.Request::get('year')));
        $user->save();

        if(Request::hasFile('file')) {
            $ext = Request::file('file')->getClientOriginalExtension();
            $value=$user->id.date('YmdHis').'.'.$ext;
            Storage::disk('private')->putFileAs('cvfiles/'.$user->id,Request::file('file'), $value);
            $user->cvfile = $value;
            $user->save();
        }


        return response()->json($user,200);


    }

    public function downloadCV($id) {
        if(Auth::User()->cannot('access-admin')) {
            return response()->json(['Auth Error'],401);
        }

        $user = User::find($id);

        if($user->cvfile) {
            $dir = 'cvfiles/'.$user->id.'/'.$user->cvfile;
            if(Storage::disk('private')->exists($dir)) {
                return Storage::disk('private')->download($dir);
            }
        }

        return response()->json(['error'=>'file not found'],404);


    }
}
