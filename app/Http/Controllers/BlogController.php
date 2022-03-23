<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Blog;
use Schema;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{

    public function index() {

        $page=0;
        $limit=12;
        $not=false;
        $lang=null;

        if(Request::get('page')) {
            $page=Request::get('page');
        }
        if(Request::get('limit')) {
            $limit=Request::get('limit');
        }
        if(Request::get('not')) {
            $not= Request::get('not');
        }
        if(Request::get('lang')) {
            $lang= Request::get('lang');
        }


        $start = $page*$limit;

        $data = Blog::whereRaw('1=1');

        if($lang) {
           $data = $data->where('lang','=',$lang);
        }

        $all = $data->count();
        $blogs = $data->orderby('created_at','DESC')->offset($start)->limit($limit)->get();



        if($blogs->count()) {

            $data=[];
            $data['posts']=[];
            foreach($blogs as $b) {

                $item =  [
                'id' => $b->id,
                'title' => $b->title,
                'imageurl' => $b->image(),
                'preview_text' => mb_convert_encoding(substr(strip_tags(nl2br($b->article)),0,100).'...','UTF-8', 'UTF-8')
                ];
                $data['posts'][] = $item;
            }
            $data['total'] = $all;
            $data['page'] = $page;


            return response()->json($data,200);
        }
        return response()->json([],200);

    }

    public function get($id=null) {
        if(!$id) { $id = Request::get('id'); }

        if(is_numeric($id)) {
            $item =  Blog::where('id','=',$id)->first();
        } else {
            $item =  Blog::where('slug','=',$id)->first();
        }

        $item->files;
        $item->images;

        if($item) {
            $data=$item->toArray();
            $data['imageurl'] = $item->image();
            $data['seo'] = [
                'title'=>$item->title,
                'description'=>substr(strip_tags($item->article),0,255),
                'url'=>url($item->url()),
                'image'=>url($item->image())
            ];
            $data['published']=date('d-m-Y',strtotime($item->created_at));

            return response()->json($data,200);
        }
        return response()->json([],200);

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

        $item->slug = $item->id.'-'.preg_replace('/[^\w-]/', '',$item->title);
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


        if($item) {
            $item->fill(Request::all());

            if (Request::hasFile('image')) {

                $dir= public_path("/storage/images/blog/");

                if(!is_dir($dir)) {
                    mkdir($dir);
                }

                $extension = Request::file('image')->getClientOriginalExtension();
                 $filename= preg_replace('/\W+/', '-', strtolower(Request::get('title'))."-i".date('Ymdhis')).".".$extension;
                    Image::make(Request::file('image'))->resize(1800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($dir . $filename);

                 $item->image = $filename;

            }

            if(Request::hasFile('file')) {

                $dir= public_path('/storage/files/blog');
                //mk directory if does not exist
                if(!is_dir($dir)) {
                    mkdir($dir);
                }

                //upload file
                $extension = Request::file('file')->getClientOriginalExtension();
                $filename= preg_replace('/\W+/', '-', strtolower(Request::get('slug'))."-".date('Ymdhis')).".".$extension;
                Storage::disk('public')->putFileAs('files/blog',Request::file('file'),$filename);

                $item->file = $filename;

                //now save a preview if it is pdf
                if($extension=='pdf') {

                    $pdf = new \Spatie\PdfToImage\Pdf(public_path('/storage/files/blog/'.$filename));
                    $imagefilename= preg_replace('/\W+/', '-', strtolower(Request::get('title'))."-i".date('Ymdhis')).".jpg";
                    $pdf->saveImage(public_path("/storage/images/blog/".$imagefilename));
                    $item->image = $imagefilename;
                    $item->save();


                }



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
