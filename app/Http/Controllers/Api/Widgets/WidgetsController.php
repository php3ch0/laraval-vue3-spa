<?php

namespace App\Http\Controllers\Api\Widgets;


use App\Models\Widgets\Widgets;
use http\Env\Response;
use Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class WidgetsController extends Controller
{


    public function index() {
        if(Auth::User()->cannot('access-admin')) {
            return abort(403);
        }

        $data = Widgets::all();

        return response()->json($data,200);


    }






    public function get($id) {

       $item = Widgets::where('id','=',$id)->orWhere('name','=',$id)->first();


        if(!isset($item->id)) {
            return response()->json(['error'=>'Widget not found by ID'],404);
        }

        return response()->json($item,200);

    }

    public function add() {
        if(Auth::User()->cannot('access-admin')) {
            return abort(403);
        }

        $v = Validator::make(Request::all(), [
            'name'=>'required',
            'type'=>'required'
        ]);

        if ($v->fails())
        {
            return response()->json($v->errors(),422);
        }

        $item = new Widgets();
        $item->fill(Request::all());
        $item->name=preg_replace('/\W+/', '-', strtolower(Request::get('name')));;
        $item->save();


        return response()->json($item,200);

    }

    public function edit() {

        if(Auth::User()->cannot('access-admin')) {
            return abort(403);
        }

        $v = Validator::make(Request::all(), [
            'id'=>'required',
            'name'=>'required',
            'type'=>'required'
        ]);

        if ($v->fails())
        {
            return response()->json($v->errors(),422);
        }

        $item = Widgets::find(Request::get('id'));

        if($item->id) {
            $item->fill(Request::all());
            $item->name = preg_replace('/\W+/', '-', strtolower(Request::get('name')));
            $item->data=Request::get('html');
            $item->save();

            if (Request::hasFile('image')) {

                $dir= storage_path("app/public/images/uploads/");

                if(!is_dir($dir)) { mkdir($dir); }

                $filename= preg_replace('/\W+/', '-', strtolower(Request::get('name'))."-".date('Ymdhis')).".webp";
                Image::make(Request::file('image'))->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($dir . $filename);

                $imagedata = [
                    'image'=>$filename,
                    'alt'=>Request::get('alt')
                ];
                $item->data = json_encode($imagedata);
                $item->save();

            }

        }

        return response()->json($item,200);


    }

    public function delete($id) {
        if(Auth::User()->cannot('access-admin')) {
            return abort(403);
        }

        $item = Widgets::find($id);
        $item->delete();

        return response()->json([],200);

    }




}
