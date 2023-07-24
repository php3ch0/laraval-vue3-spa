<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Mail;

class ContactController extends  Controller
{

    public function sendEnquiry() {

            sleep(2);
            $v = Validator::make(Request::all(), [
                'name'=>'required',
                'telephone'=>'required',
                'email'=>'required|email',
                'message'=>'required'
            ]);

            if ($v->fails())
            {
                return response()->json($v->errors(),422);
            }

            $data = Request::all();
            $data['messagebody']=Request::get('message');



                Mail::send('emails.contact', $data, function($message) use ($data)
                {
                    $message->from(getenv('MAIL_FROM_ADDRESS'));
                    $message->replyTo($data['email']);
                    $message->to(getenv('MAIL_TO_ADDRESS'));
                    $message->subject('New Message From Shepway Computers');
                });


            return response()->json([],200);
        }

    public function sendRoomEnquiry() {

        sleep(2);
        $v = Validator::make(Request::all(), [
            'name'=>'required',
            'telephone'=>'required',
            'email'=>'required|email',
            'message'=>'required',
            'arrival_date'=>'required',
            'departure_date'=>'required'
        ]);

        if ($v->fails())
        {
            return response()->json($v->errors(),422);
        }

        $data = Request::all();
        $data['messagebody']=Request::get('message');



        Mail::send('emails.room', $data, function($message) use ($data)
        {
            $message->from(getenv('MAIL_FROM_ADDRESS'));
            $message->replyTo($data['email']);
            $message->to(getenv('MAIL_TO_ADDRESS'));
            $message->subject('Room Enquiry From Whichcote Arms');
        });


        return response()->json([],200);
    }

    public function sendRestaurantEnquiry() {

        sleep(2);
        $v = Validator::make(Request::all(), [
            'name'=>'required',
            'telephone'=>'required',
            'email'=>'required|email',
            'people'=>'required',
            'date'=>'required',
        ]);

        if ($v->fails())
        {
            return response()->json($v->errors(),422);
        }

        $data = Request::all();
        $data['messagebody']=Request::get('message');



        Mail::send('emails.restaurant', $data, function($message) use ($data)
        {
            $message->from(getenv('MAIL_FROM_ADDRESS'));
            $message->replyTo($data['email']);
            $message->to(getenv('MAIL_TO_ADDRESS'));
            $message->subject('Restaurant Enquiry From Whichcote Arms');
        });

        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {

            try {
                Mail::send('emails.restaurantPleaseWait', $data, function ($message) use ($data) {
                    $message->from(getenv('MAIL_FROM_ADDRESS'));
                    $message->to($data['email']);
                    $message->subject('Whichcote Arms Booking');
                });
            } catch (\Exception $e) {

            }



        }

        return response()->json([],200);
    }


}
