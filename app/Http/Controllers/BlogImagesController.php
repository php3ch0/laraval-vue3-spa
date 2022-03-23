<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use http\Env\Response;
use Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\BlogImages;
use Illuminate\Support\Facades\Storage;

class BlogImagesController extends Controller
{

    public function add() {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $v = Validator::make(Request::all(), [
            'blog_id'=>'required|numeric'
        ]);

        if ($v->fails())
        {
            $data['status']='error';
            $data['errors'] = $v->errors();
            return response()->json($data,200);
        }

        if (Request::hasFile('file')) {

            $item = new BlogImages();
            $item->blog_id=Request::get('blog_id');
            $item->save();

            $blog = Blog::find(Request::get('blog_id'));


            $dir= public_path("/storage/images/blog/");
            $extension = Request::file('file')->getClientOriginalExtension();
            $filename= preg_replace('/\W+/', '-', strtolower($item->id)."-".date('Ymdhis')).".".$extension;
            Image::make(Request::file('file'))->resize(1800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($dir . $filename);

            $item->image = $filename;
            $item->save();

        }


        return response()->json([],200);

    }

    public function delete($did=0,$id) {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $item = BlogImages::find($id);

        if(isset($item->id)) {
            $dir= public_path("/storage/images/blog/");
            unlink($dir.$item->image);
            $item->delete();
        }

        $data['status']='success';
        return response()->json($data,200);

    }


}
