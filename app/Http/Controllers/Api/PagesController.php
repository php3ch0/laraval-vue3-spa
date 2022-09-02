<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Mail;

class PagesController extends  Controller
{

    public function contact() {

            sleep(2);
            $v = Validator::make(Request::all(), [
                'name'=>'required',
                'telephone'=>'required',
                'email'=>'required|email',
                'message'=>'required'
            ]);

            if ($v->fails())
            {
                return respons()->json($v->errors(),422);
            }

            $data = Request::all();


            if(filter_var($data, FILTER_VALIDATE_EMAIL)) {

                Mail::send('emails.contact', $data, function($message) use ($data)
                {
                    $message->from(getenv('MAIL_FROM_ADDRESS'));
                    $message->replyTo($data['email']);
                    $message->to(getenv('MAIL_TO_ADDRESS'));
                    $message->subject('New Message From Shepway Computers');
                });

            }

            return response()->json([],200);
        }


}
