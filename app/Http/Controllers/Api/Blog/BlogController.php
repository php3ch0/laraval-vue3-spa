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
use App\Models\Blog\BlogImages;
use Schema;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    private string $imgdir = "/images/blog/";

    public function index() {


        $limit=Request::get('limit');

        if(Request::get('limit')) {
            $limit=Request::get('limit');
        }

        $data = Blog::orderby('created_at','DESC')->paginate($limit);



        return response()->json($data,200);

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

        $item->slug = $item->id.'-'.preg_replace('/\W+/', '-', strtolower($item->title));
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
            'slug'=>'required|max:255|unique:blog,slug,'.Request::get('id')
        ]);

        if ($v->fails())
        {
            return response()->json($v->errors(),422);
        }

        $item = Blog::find(Request::get('id'));


        if(isset($item->id)) {
            $item->fill(Request::all());

            $item->slug = preg_replace('/\W+/', '-', strtolower(Request::get('slug')));

            $dd = Request::get('created_at');
            if(is_int($dd)) {
                $dd=($dd/1000);
                $item->created_at = date('Y-m-d H:i:s',$dd);
            } else {
                $item->created_at = date('Y-m-d H:i:s',strtotime(Request::Get('created_at')));
            }


            if (Request::hasFile('image')) {

                if(!is_dir(storage_path('app/public'.$this->imgdir))) {
                    mkdir(storage_path('app/public'.$this->imgdir));
                }

                $extension = Request::file('image')->getClientOriginalExtension();
                $filename= preg_replace('/\W+/', '-', strtolower(Request::get('title'))."-i".date('Ymdhis')).".".$extension;
                Image::make(Request::file('image'))->resize(1800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public'.$this->imgdir . $filename));

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
        BlogImages::where('blog_id','=',$id)->delete();

        if($item->id) {
            $item->delete();
        }

        $data['status']='success';
        return response()->json($data,200);

    }


}
