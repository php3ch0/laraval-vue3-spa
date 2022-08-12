<?php

namespace App\Http\Controllers\Api\Galleries;

use http\Env\Response;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Models\Galleries\Galleries;
use App\Models\Galleries\GalleriesImages;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;


class GalleriesController extends Controller
{

    /* Specific Functions */

    public function index() {

        $page = 0; //page
        $limit=50; //results per page

        $data=[];

        if(Request::get('page')) { $page=Request::get('page'); }
        if(Request::get('limit')) { $limit=Request::get('limit'); }

        $start = $page*$limit; //where to start the pagination

        $items = Galleries::whereRaw('1=1');

        $total = $items->count();

        $items->orderby('name','ASC')->offset($start)->limit($limit)->get();


        $data['total'] = $total;
        $data['page']= $page;
        $data['results'] = $items->get();

        return response()->json($data,200);

    }


    public function get($id) {

        $item = Galleries::find($id);

        if(!isset($item->id)) {
            return response()->json(['error'=>'Gallery not found by id'],404);
        }

        return response()->json($item, 200);

    }


    public function add() {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $v = Validator::make(Request::all(), [
            'name' => 'required',
        ]);

        if ($v->fails())
        {
            return response()->json($v->errors(),422);
        }

        //now add
        $item = new Galleries();
        $item->fill(Request::all());
        $item->save();

        return response()->json($item,200);


    }

    public function edit() {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $v = Validator::make(Request::all(), [
            'id' => 'required',
            'name' => 'required',
        ]);

        if ($v->fails())
        {
            return response()->json($v->errors(),422);
        }

        $item = Galleries::find(Request::get('id'));

        if(!isset($item->id)) {
            return response()->json(['error'=>'Gallery not found by id'],404);
        }
        //now update the data
        $item->fill(Request::all());
        $item->save();

        //directory to upload images to
        $dir= storage_path('/app/public/images/galleries/');
        //mk directory if does not exist
        if(!is_dir($dir)) {
            mkdir($dir);
        }

        //directory to upload images to
        $dir= storage_path('/app/public/images/galleries/'.$item->id);
        //mk directory if does not exist
        if(!is_dir($dir)) {
            mkdir($dir);
        }


        return response()->json($item,200);


    }

    //order items for drag and drop
    public function order() {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $data = Request::all();

        foreach($data as $key=>$value) {
            $item = Galleries::find($value['id']);
            if(isset($item->id)) {
                $item->orderby =  str_pad($key, 4, '0', STR_PAD_LEFT);
                $item->save();
            }
        }

        return response(200);

    }

    public function delete($id) {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $item = Galleries::find($id);

        if(!isset($item->id)) {
            return response()->json(['error'=>'Gallery not found by id'],404);
        }

        $dir= storage_path('/app/public/images/galleries/'.$item->id);

        GalleriesImages::where('gallery_id','=',$item->id)->delete();

        Storage::deleteDirectory($dir);

        $item->delete();

        return response()->json([], 200);


    }


}
