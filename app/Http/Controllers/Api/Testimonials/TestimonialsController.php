<?php

namespace App\Http\Controllers\Api\Testimonials;

use App\Models\Testimonials\Testimonials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;

class TestimonialsController extends Controller
{
    public function index() {

        $page = 0; //page
        $limit=50; //results per page

        $data=[];

        if(Request::get('page')) { $page=Request::get('page'); }
        if(Request::get('limit')) { $limit=Request::get('limit'); }

        $start = $page*$limit; //where to start the pagination

        $items = Testimonials::whereRaw('1=1');

        $total = $items->count();

        $items->orderby('name','ASC')->offset($start)->limit($limit)->get();


        $data['total'] = $total;
        $data['page']= $page;
        $data['results'] = $items->get();

        return response()->json($data,200);

    }

    public function get($id) {

        $item = Testimonials::find($id);
        if(isset($item->id)) {
            return response()->json($item,200);
        }

        return response()->json([],404);

    }

    public function add() {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }


            $v = Validator::make(Request::all(), [
                        'name'=>'required',
                        'score'=>'required|numeric',
                        'review'=>'required',
             ]);


            if ($v->fails()) {
                return response()->json($v->errors(),422);
            }


        $item = new Testimonials();
        $item->fill(Request::all());
        $item->save();

        return response()->json($item,200);

    }

    public function edit() {
        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }
        $v = Validator::make(Request::all(), [
            'name'=>'required',
            'score'=>'required|numeric',
            'review'=>'required']);

        if ($v->fails())
        {
            return response()->json($v->errors(),422);
        }

        $item = Testimonials::find(Request::get('id'));

        if(isset($item->id)) {
            $item->fill(Request::all());
            $item->save();
        }


        return response()->json($item,200);



    }

    public function delete($id) {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $item = Testimonials::find($id);
        if(isset($item->id)) {
            $item->delete();
        }

        return response()->json([],200);


    }

}
