<?php

namespace App\Http\Controllers;

use App\Models\Services;
use http\Env\Response;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;

class ServicesController extends Controller
{

    public function index() {


        $results = Services::orderby('order_by','ASC')->get();

        $data['results'] = $results;

        return response()->json($data,200);


    }

    public function get($id) {

        if(is_numeric($id)) {
            $item = Services::find($id);
        } else {
            $item = Services::where('slug','=',$id)->first();
        }


        if(!isset($item->id)) {
            return response()->json(['error'=>'Unable to find item by ID'],404);
        }


        if(empty($item->slug)) {
            $item->slug = preg_replace('/[^\w-]/', '',$item->name);
            $item->save();
        }
        return response()->json($item,200);

    }
    public function add() {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }
        $v = Validator::make(Request::all(), [
            'name'=>'required',
        ]);

        if ($v->fails())
        {
            return response()->json($v->errors(),422);
        }

        $item = new Services();
        $item->name=Request::get('name');
        $item->save();

        $item->slug = preg_replace('/[^\w-]/', '',$item->id.$item->name);
        $item->save();

        return response()->json($item,200);

    }
    public function edit() {
        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }
        $v = Validator::make(Request::all(), [
            'id' => 'required',
        ]);

        if ($v->fails())
        {
            $data['status']='error';
            $data['errors'] = $v->errors();
            return response()->json($data,422);
        }

        $data = Services::find(Request::get('id'));
        if($data) {
            $data->fill(Request::all());
            if (Request::hasFile('image_icon')) {

                $dir= public_path('/storage/images/services/');

                if(!is_dir($dir)) {
                    mkdir($dir);
                }

                $extension = Request::file('image_icon')->getClientOriginalExtension();
                $filename= date('mdhis').rand(0,99).".".$extension;
                Image::make(Request::file('image_icon'))->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($dir . $filename);

                $data->image_icon = $filename;

            }
            if (Request::hasFile('image_header')) {

                $dir= public_path('/storage/images/services/');

                if(!is_dir($dir)) {
                    mkdir($dir);
                }

                $extension = Request::file('image_header')->getClientOriginalExtension();
                $filename= date('mdhis').rand(0,99).".".$extension;
                Image::make(Request::file('image_header'))->resize(1600, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($dir . $filename);

                $data->image_header = $filename;

            }
            $data->save();
        }

        return response()->json($data,200);
    }
    public function delete($id) {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $service = Services::where('id','=',$id)->delete();

        return response()->json([],200);

    }

    public function order() {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $data = Request::all();

        foreach($data as $key=>$value) {
            $data = Services::find($value['id']);
            if(isset($data->id)) {
                $data->order_by =  str_pad($key, 4, '0', STR_PAD_LEFT);
                $data->save();
            }
        }

        return response(200);

    }

    public function rotate($id=0,$image='image_icon') {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $gi = Services::find($id);
        if($gi->id) {

            $dir = "/storage/images/services/";
            $oldimage= public_path($dir.$gi->{$image});

            $img = Image::make($oldimage);
            $img->rotate(-90);
            $newimage = bin2hex(random_bytes(3)).$gi->{$image};
            $img->save(public_path($dir.$newimage));

            //delete old image to cleanup
            @unlink($dir.$oldimage);

            //save new image name to database
            $gi->{$image} = $newimage;
            $gi->save();



        }
        return response()->json([],200);
    }


}
