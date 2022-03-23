<?php

namespace App\Http\Controllers;

use App\Models\Testimonials;
use http\Env\Response;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Request;
use Illuminate\Support\Facades\Redirect;

class TestimonialsController extends Controller
{

    public function index() {

        $data = Testimonials::orderby('order_by','ASC')->get();


        return response()->json($data,200);

    }

    public function get($id) {

        $testimonial = Testimonials::find($id);
        if(isset($testimonial->id)) {
            return response()->json($testimonial,200);
        }
        return response()->json(['error'=>'Item could not be found by ID: $id'],404);

    }


    public function add() {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }
        $v = Validator::make(Request::all(), [
            'name'=>'required',
        ],[
            'name.required'=>'You must enter a name.'
        ]);

        if ($v->fails())
        {
            return response()->json($v->errors(),422);
        }

        $item = new Testimonials();
        $item->name=Request::get('name');
        $item->save();

        return response()->json($item,200);

    }

    public function edit() {
        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }
        $v = Validator::make(Request::all(), [
            'id' => 'required',
            'name'=>'required',
        ],[
            'name.required'=>'You have not entered a name'
        ]);

        if ($v->fails())
        {
            return response()->json($v->errors(),422);
        }

        $item = Testimonials::find(Request::get('id'));
        if($item) {
            $item->fill(Request::all());
            if (Request::hasFile('image')) {
                $dir= public_path("/storage/images/testimonials/");
                $extension = Request::file('image')->getClientOriginalExtension();
                $filename= preg_replace('/\W+/', '-', strtolower(Request::get('name'))."-i".date('Ymdhis')).".".$extension;
                Image::make(Request::file('image'))->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($dir . $filename);

                $item->image = $filename;

            }
            $item->save();
        }

        return response()->json($item,200);
    }

    public function delete($id) {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $item = Testimonials::find($id);
        if($item) {
            $imagepath = '/images/testimonials/'.$item->image;
            if(!empty($item->image) && Storage::disk('public')->exists($imagepath)) {
                Storage::disk('public')->delete($imagepath);
            }
            $item->delete();
            return response()->json([],200);
        }
        return response()->json(['error'=>'Item could not be found by ID: $id'],422);

    }

    public function order() {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $data = Request::all();

        foreach($data as $key=>$value) {
            $item = Testimonials::find($value['id']);
            if(isset($item->id)) {
                $item->order_by =  str_pad($key, 4, '0', STR_PAD_LEFT);
                $item->save();
            }
        }

        return response()->json([],200);

    }




}
