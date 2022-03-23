<?php

namespace App\Http\Controllers;

use App\Models\GalleriesImages;
use http\Env\Response;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Galleries;
use Illuminate\Support\MessageBag;

class GalleriesController extends Controller
{

    public function restrict_admin() {
        if(Auth::User()->cannot('access-admin')) {
            $data['status'] = '401';

            $errors = new MessageBag;
            $errors->add('error', 'Unauthorised Request');

            $data['errors'] = $errors;
            return response()->json($data,401);
        }

        return true;
    }

    public function check_exists($id) {

        $item = Galleries::where('id','=',$id)->orWhere('slug','=',$id)->first();

        if(!isset($item->id)) { // item not found
            return abort(404);
        }
        return $item;
    }

    /* Specific Functions */

    public function index() {

        $page = 0; //page
        $limit=50; //results per page
        $search=null;
        $hidden=false;


        $data=[];

        if(Request::get('page')) { $page=Request::get('page'); }
        if(Request::get('limit')) { $limit=Request::get('limit'); }
        if(Request::get('hidden')) { $hidden=Request::get('hidden'); }

        $start = $page*$limit; //where to start the pagination

        $items = Galleries::whereRaw('1=1');



        if($search) { //if just listing all
            $items->where('name','like','%'.$search.'%');
        }


        if(!$hidden || $hidden!=='true') {
            $items->where('show','=','Y');
        }


        $items->orderby('order_by','ASC')->offset($start)->limit($limit)->get();


        $data['status'] = '200';
        $data['errors'] = [];
        $data['results'] = $items->get();

        return response()->json($data,200);

    }


    public function get($id) {

        $item = $this->check_exists($id);

        $data['status'] = '200';
        $data['errors'] = [];
        $data['results'] = $item;

        return response()->json($data, 200);

    }


    public function add() {

        $this->restrict_admin();

        $v = Validator::make(Request::all(), [
            'name' => 'required',
        ]);

        if ($v->fails())
        {
            $data['status'] = '422';
            $data['errors'] = $v->errors();
            return response()->json($data,422);
        }


        //now add
        $item = new Galleries();
        $item->fill(Request::all());
        $item->save();

        //generate a slug
        $item->slug = preg_replace('/[^a-z0-9]/i','',$item->id.$item->name);
        $item->save();

        //now return success and the item inserted
        $data['status'] = '200';
        $data['errors'] = [];
        $data['results']=$item;

        return response()->json($data,200);


    }

    public function edit() {

        $this->restrict_admin();

        $v = Validator::make(Request::all(), [
            'id' => 'required',
            'slug'=>'required|max:255|unique:galleries,slug,'.Request::get('id'),
            'show'=>'required',
            'name' => 'required',
        ]);

        if ($v->fails())
        {
            $data['status'] = '422';
            $data['errors'] = $v->errors();
            return response()->json($data,422);
        }

        $item = $this->check_exists(Request::get('id'));

        //now update the data
        $item->fill(Request::all());
        $item->slug = preg_replace('/[^a-z0-9]/i','',Request::get('slug'));
        $item->save();

        //directory to upload images to
        $dir= public_path('/storage/images/galleries/');
        //mk directory if does not exist
        if(!is_dir($dir)) {
            mkdir($dir);
        }

        //directory to upload images to
        $dir= public_path('/storage/images/galleries/'.$item->id);
        //mk directory if does not exist
        if(!is_dir($dir)) {
            mkdir($dir);
        }

        $data['status'] = '200';
        $data['errors'] = [];
        $data['results']=$item;

        return response()->json($data,200);


    }

    //order items for drag and drop
    public function order() {

        $this->restrict_admin();
        $data = Request::all();

        foreach($data as $key=>$value) {
            $item = Galleries::find($value['id']);
            if(isset($item->id)) {
                $item->order_by =  str_pad($key, 4, '0', STR_PAD_LEFT);
                $item->save();
            }
        }

        return response(200);

    }

    public function delete($id) {

        $this->restrict_admin();

        $item = $this->check_exists($id);

        if(isset($item->id)) {
            //now delete related images
            GalleriesImages::where('gallery_id','=',$item->id)->delete();

            //delete directory
            if(is_dir(public_path('/storage/galleries/'.$item->id))) {
                Storage::deleteDirectory('/images/galleries/'.$item->id);
            }

            $item->delete();
        }






        return response()->json([], 200);


    }


}
