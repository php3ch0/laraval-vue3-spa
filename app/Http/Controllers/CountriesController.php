<?php

namespace App\Http\Controllers;


use http\Env\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Countries;
use App\Models\DeliveryTypesCountries;

class CountriesController extends Controller
{

    public function index() {

        $data = Countries::orderby('name','ASC')->with(['deliveryTypes'])->get();

        if($data->count()) {
            return response()->json($data,200);
        }
        return response()->json([],200);

    }

    public function get($id) {

        $data = Countries::find($id);

        if(isset($data->id)) {
            return response()->json($data,200);
        }
        return response()->json([],404);

    }

    public function add() {

        if(Auth::User()->cannot('access-admin')) {
            return response()->json(['error'=>'Admin not authorised'],401);
        }

        $v = Validator::make(Request::all(), [
            'name' => 'required|max:255',
            'code' => 'required|max:255',
        ]);

        if ($v->fails()) {
            return response()->json($v->errors(),422);
        }

        $item = new Countries();
        $item->fill(Request::all());
        $item->save();

        return response()->json($item,200);

    }

    public function edit($id) {

        if(Auth::User()->cannot('access-admin')) {
            return response()->json(['error'=>'Admin not authorised'],401);
        }

        $v = Validator::make(Request::all(), [
            'id'=>'required|numeric',
            'name' => 'required|max:255',
            'code' => 'required|max:255',
        ]);

        if ($v->fails()) {
            return response()->json($v->errors(),422);
        }

        $item = Countries::find(Request::Get('id'));

        if(!isset($item->id)) {
            return response()->json(['error'=>'Could not find item by ID'],404);
        }

        $item->fill(Request::all());
        $item->save();

        return response()->json($item,200);
    }

    public function delete($id) {

        if(Auth::User()->cannot('access-admin')) {
            return response()->json(['error'=>'Admin not authorised'],401);
        }

        DeliveryTypesCountries::where('country_id','=',$id)->delete();
        Countries::where('id','=',$id)->delete();

        return response()->json([],200);

    }


}
