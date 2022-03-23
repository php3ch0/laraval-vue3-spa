<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Widgets;
use Schema;

class WidgetsController extends Controller
{


    public function index($page=0) {
        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $page=0;
        $limit=50;

        if(Request::get('page')) {
            $page=Request::get('page');
        }
        if(Request::get('limit')) {
            $limit=Request::get('limit');
        }

        $start = $page*$limit;

        $data['results'] = Widgets::orderBy('name','ASC')->offset($start)->limit($limit)->get();
        $data['total'] = Widgets::all()->count();

        return response()->json($data,200);
    }

    public function get($id=null) {
        $widget = Widgets::where('name','=',$id)->orWhere('id','=',$id)->first();
        if(isset($widget->id)) {
            $data=$widget->toArray();
            $data['html']=$widget->html();
            return response()->json($data,200);
        } else {
            $data['id']='add';
            $data['name']=null;
            $data['html']="Please Create Widget: ".$id;
            return response()->json($data,200);
        }

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
            $data['status']='error';
            $data['errors'] = $v->errors();
            return response()->json($data,200);
        }

        $widget = new Widgets();
        $widget->name=Request::get('name');
        $widget->type='TEXT';
        $widget->save();

        return response()->json($widget,200);

    }

    public function edit() {
        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }
        $v = Validator::make(Request::all(), [
            'id' => 'required',
            'name'=>'required',
            'type' => 'required',
        ]);

        if ($v->fails())
        {
            $data['status']='error';
            $data['errors'] = $v->errors();
            return response()->json($data,200);
        }

        $widget = Widgets::find(Request::get('id'));
        if($widget) {
            $widget->fill(Request::all());

            if (Request::hasFile('image')) {

                $dir= storage_path("app/public/uploads/");
                $extension = Request::file('image')->getClientOriginalExtension();
                $filename= preg_replace('/\W+/', '-', strtolower(Request::get('name'))."-".date('Ymdhis')).".".$extension;
                Image::make(Request::file('image'))->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($dir . $filename);

                $widget->value = $filename;

            }

            $widget->save();
        }

        return response()->json($widget,200);
    }

    public function delete($id) {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $widget = Widgets::find($id)->delete();
        $data['status']='success';
        return response()->json($data,200);

    }


    public function upload() {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        if (Request::hasFile('upload')) {

            $dir= storage_path("app/public/uploads/");

            $extension = Request::file('upload')->getClientOriginalExtension();
            $filename= preg_replace('/\W+/', '-', strtolower(pathinfo(Request::file('upload')->getClientOriginalName(), PATHINFO_FILENAME))."-".date('Ymdhis')).".".$extension;
            Image::make(Request::file('upload'))->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($dir . $filename);

            return response()->json([ 'fileName' => $filename, 'uploaded' => true, 'url' => url('/storage/uploads/'.$filename)],200);

        }

        return response()->json(['error'=>'no file detected'],422);

    }



}
