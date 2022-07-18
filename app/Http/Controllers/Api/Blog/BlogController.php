<?php

namespace App\Http\Controllers\Api\Blog;

use http\Env\Response;
use Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Blog\Blog;
use Schema;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{

    public function index() {

        $page=0;
        $limit=12;
        $lang=null;

        if(Request::get('page')) {
            $page=Request::get('page');
        }
        if(Request::get('limit')) {
            $limit=Request::get('limit');
        }



        $start = $page*$limit;

        $data = Blog::whereRaw('1=1');

        $all = $data->count();
        $blogs = $data->orderby('created_at','DESC')->offset($start)->limit($limit)->get();



        if($blogs->count()) {

            $data=[];
            $data['posts']=$blogs;
            $data['total'] = $all;
            $data['page'] = $page;


            return response()->json($data,200);
        }
        return response()->json([],200);

    }

    public function get($id=null) {

        if(is_numeric($id)) {
            $item =  Blog::where('id','=',$id)->with(['images'])->first();
        } else {
            $item =  Blog::where('slug','=',$id)->with(['images'])->first();
        }

        if(!isset($item->id)) {
            return response()->json(['error'=>'Item not found by ID'],404);
        }


        return response()->json($item,200);


    }

    public function add() {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $v = Validator::make(Request::all(), [
            'title'=>'required',
        ]);

        if ($v->fails())
        {
            $data['status']='error';
            $data['errors'] = $v->errors();
            return response()->json($data,200);
        }

        $item = new Blog();
        $item->title=Request::get('title');
        $item->save();

        $item->slug = $item->id.'-'.strtolower(preg_replace("/[^A-Za-z0-9 ]/", '-',$item->title));
        $item->save();

        return response()->json($item,200);

    }

    public function edit() {



        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $v = Validator::make(Request::all(), [
            'id' => 'required',
            'title'=>'required',
            'slug'=>'required|max:255|unique:blog,slug,'.Request::get('id'),
            'created_at'=>'required'
        ]);

        if ($v->fails())
        {
            return response()->json($v->errors(),422);
        }

        $item = Blog::find(Request::get('id'));


        if($item) {
            $item->fill(Request::all());

            $dd = Request::get('created_at');
            if(is_int($dd)) {
                $dd=($dd/1000);
                $item->created_at = date('Y-m-d H:i:s',$dd);
            } else {
                $item->created_at = date('Y-m-d H:i:s',strtotime(Request::Get('created_at')));
            }


            if (Request::hasFile('image')) {
                $dir="/images/blog/";
                if(!is_dir(storage_path('app/public'.$dir))) {
                    mkdir(storage_path('app/public'.$dir));
                }

                $extension = Request::file('image')->getClientOriginalExtension();
                 $filename= preg_replace('/\W+/', '-', strtolower(Request::get('title'))."-i".date('Ymdhis')).".".$extension;
                    Image::make(Request::file('image'))->resize(1800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(storage_path('app/public'.$dir . $filename));

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

        $item = Blog::where('id','=',$id)->first();

        if($item->id) {
            $item->delete();
        }

        $data['status']='success';
        return response()->json($data,200);

    }


}
