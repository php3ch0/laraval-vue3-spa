<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    /**
     * Create a new user instance after a valid registration.
     */
    protected function register()
    {

        $v = Validator::make(Request::all(), [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'address1'=>'required',
            'town'=>'required',
            'postcode'=>'required',
            'country_id'=>'required'
        ]);

        if ($v->fails()) {
            return response()->json($v->errors(),422);
        }

        $user = new User();
        $user->fill(Request::all());
        $user->role='user';
        $user->password = bcrypt(Request::get('password'));
        $user->save();


        return response()->json($user,200);

    }
}
