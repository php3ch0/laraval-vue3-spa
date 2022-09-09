<?php

namespace App\Http\Controllers\Api\Projects;


use http\Env\Response;
use Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Projects\Projects;
use App\Models\Projects\ProjectsImages;
use Schema;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ProjectsController extends Controller
{

    private string $imgdir = "/images/projects/";

    public function index() {

        $page=0;
        $limit=12;

        if(Request::get('page')) {
            $page=Request::get('page');
        }
        if(Request::get('limit')) {
            $limit=Request::get('limit');
        }



        $start = $page*$limit;

        $data = Projects::whereRaw('1=1');

        $all = $data->count();
        $results = $data->orderby('created_at','DESC')->offset($start)->limit($limit)->get();



        if($results->count()) {

            $data=[];
            $data['results']=$results;
            $data['total'] = $all;
            $data['page'] = $page;


            return response()->json($data,200);
        }
        return response()->json([],200);

    }

    public function get($id=null) {

        if(is_numeric($id)) {
            $item =  Projects::where('id','=',$id)->with(['images'])->first();
        } else {
            $item =  Projects::where('slug','=',$id)->with(['images'])->first();
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

        $item = new Projects();
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
            'slug'=>'required|max:255|unique:projects,slug,'.Request::get('id')
        ]);

        if ($v->fails())
        {
            return response()->json($v->errors(),422);
        }

        $item = Projects::find(Request::get('id'));


        if(isset($item->id)) {
            $item->fill(Request::all());

            if (Request::hasFile('image')) {

                if(!is_dir(storage_path('app/public'.$this->imgdir))) {
                    mkdir(storage_path('app/public'.$this->imgdir));
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

        $item = Projects::where('id','=',$id)->first();

        if($item->id) {
            ProjectsImages::where('project_id','=',$id)->delete();
            $item->delete();
        }

        $data['status']='success';
        return response()->json($data,200);

    }

    public function order() {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $data = Request::get('projects');

        foreach($data as $key=>$value) {
            $item = Projects::find($value['id']);
            if(isset($item->id)) {
                $item->order_by =  str_pad($key, 4, '0', STR_PAD_LEFT);
                $item->save();
            }
        }

        return response()->json([],200);

    }


}
