<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Mail;

class ContactController extends Controller
{



    public function contact() {


            $v = Validator::make(Request::all(), [
                'contact_name' => 'required',
                'email'=>'required|email',
                'company_name'=>'required',
                'phone'=>'required',
                'message'=>'required'

            ]);

            if ($v->fails())
            {
                return response()->json($v->errors(),422);
            }

            $data= Request::all();
            $data['messagebody']=Request::Get('message');

            Mail::send('emails.contact', $data, function($message) use ($data)
            {
                $message->from(getenv('MAIL_FROM_ADDRESS'));
                $message->replyTo($data['email']);
                $message->to(getenv('MAIL_TO_ADDRESS'));
                $message->subject('Enquiry From '.getenv('APP_NAME'));
            });

            return response(200);
        }






}
