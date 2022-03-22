<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Stock;
use App\Models\StockMargins;
use App\Models\User;
use App\Models\UserPrices;
use Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Support\MessageBag;
use Hash;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoiceData;
use App\Models\Orders;

class UserController extends Controller
{

    public function index() {

        if(!Auth::check() || Auth::User()->cannot('access-admin')) {
            return response()->json(['error'=>'Admin not authenticated'],422);
        }

        $term=null;
        $limit=25;
        $page=1;
        $order='lastname';
        $direction='ASC';

        if(Request::get('term') && Request::Get('term') !=='null') { $term = Request::Get('term'); }
        if(Request::get('limit') && Request::Get('limit') !=='null') { $limit = intval(Request::Get('limit')); }
        if(Request::get('page') && Request::Get('page') !=='null') { $page = intval(Request::Get('page')); }
        if(Request::get('order') && Request::Get('order') !=='null') { $order = Request::Get('order'); }
        if(Request::get('direction') && Request::Get('direction') !=='null') { $direction = Request::Get('direction'); }

        //fix page
        if($page<1){ $page=1;}

        $start = ($page-1)*$limit;

        $results = User::whereRaw('1=1');

        if($term) {
           $results = $results->search($term,null,true,null);
        }

        $data['total'] = $results->count();
        $data['results']=$results->orderBy($order,$direction)->offset($start)->limit($limit)->get();

        return response()->json($data,200);



    }

    public function current() //get the current logged in user
    {
        if(Auth::check()) {
            return response()->json(Auth::User(),200);
        }
        return response()->json([],200);
    }

    public function currentInvoices() {
        if(Auth::check()) {
            return response()->json(Auth::User()->invoices,200);
        }
        return response()->json([],200);
    }

    public function currentUpdate() { //User updates their own account

        if(!Auth::check() || Auth::User()->cannot('access-user')) {
            return response()->json(['error'=>'User not authenticated'],422);
        }

        //validate
        $v = Validator::make(Request::all(), [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.Request::get('id'),
            'address1'=>'required',
            'town'=>'required',
            'company_name'=>'required',
            'postcode'=>'required',
            'country_id'=>'required'
        ]);

        if ($v->fails()) {
            return response()->json($v->errors(),422);
        }

        $user = Auth::User();
        $user->fill(Request::all());
        $user->save();

        return response()->json(['message'=>'User Updated'],200);


    }

    public function currentPassword() { //User updates their own account

        if(!Auth::check() || Auth::User()->cannot('access-user')) {
            return response()->json(['error'=>'User not authenticated'],422);
        }

        //validate
        $v = Validator::make(Request::all(), [
            'password' => 'required|confirmed|min:6',
        ]);

        if ($v->fails()) {
            return response()->json($v->errors(),422);
        }


        $user = Auth::User();
        $user->password = bcrypt(Request::get('password'));
        $user->save();

        return response()->json(['message'=>'password Updated'],200);


    }

    public function get($id) {

        if(!Auth::check() || Auth::User()->cannot('access-admin')) {
            return response()->json(['error'=>'Admin not authenticated'],422);
        }

        $data = User::find($id);

        if(!isset($data->id)) {
            return response()->json(['error'=>'User not found by ID'],404);
        }

        $data->prices;
        $data->invoices;

        return response()->json($data,200);

    }

    public function add() { //Admin adds a user

        if(!Auth::check() || Auth::User()->cannot('access-admin')) {
            return response()->json(['error'=>'Admin User not authenticated'],422);
        }

        //validate
        $v = Validator::make(Request::all(), [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'address1'=>'required',
            'town'=>'required',
            'company_name'=>'required',
            'postcode'=>'required',
            'country_id'=>'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($v->fails()) {
            return response()->json($v->errors(),422);
        }

        $user = new User();

        $user->fill(Request::all());
        $user->role = Request::Get('role');

        if(Request::get('password')) {
            $user->password = bcrypt(Request::get('password'));
        }

        $user->save();

        return response()->json(['message'=>'User Created'],200);


    }

    public function update() { //Admin updates a user

        if(!Auth::check() || Auth::User()->cannot('access-admin')) {
            return response()->json(['error'=>'Admin User not authenticated'],422);
        }

        //validate
        $v = Validator::make(Request::all(), [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.Request::get('id'),
            'address1'=>'required',
            'town'=>'required',
            'company_name'=>'required',
            'postcode'=>'required',
            'country_id'=>'required'
        ]);

        if ($v->fails()) {
            return response()->json($v->errors(),422);
        }

        $user = User::find(Request::get('id'));

        if(!isset($user->id)) {
            return response()->json(['email'=>['This user does not exist']],422);
        }

        $user->fill(Request::all());
        $user->role = Request::Get('role');

        if(Request::get('password')) {
            $user->password = bcrypt(Request::get('password'));
        }

        if (Request::hasFile('image')) {

            $dir= public_path("/storage/images/logos/");


            //delete old if exists
            if(!empty($user->company_logo) && Storage::disk('public')->exists('images/logos/'.$user->company_logo)) {
                Storage::disk('public')->delete('images/logos/'.$user->company_logo);
            }

            $extension = Request::file('image')->getClientOriginalExtension();
            $filename= strtolower(date('Ymdhis').".".$extension);
            Image::make(Request::file('image'))->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($dir . $filename);

            $user->company_logo = $filename;

        }

        $user->save();

        return response()->json(['message'=>'User Updated'],200);


    }

    public function downloadOrders($id) {

        if(!Auth::check() || Auth::User()->cannot('access-admin')) {
            return response()->json(['error'=>'Admin User not authenticated'],422);
        }
        $data['orders'] = Orders::where('user_id','=',$id)->get();
        return Excel::download(new InvoiceData($data), 'invoicedata.xlsx');

    }

    public function downloadOrdersDispatched($id) {

        if(!Auth::check() || Auth::User()->cannot('access-admin')) {
            return response()->json(['error'=>'Admin User not authenticated'],422);
        }

        $data['orders'] = Orders::where('user_id','=',$id)->where('status','=','DISPATCHED')->get();
        return Excel::download(new InvoiceData($data), 'invoicedatadispatched.xlsx');

    }

    public function getPrices() {

        if(!Auth::check() || Auth::User()->cannot('access-user')) {
            return response()->json(['error'=>'User not authenticated'],422);
        }

        $product = Products::find(Request::get('pid'));
        $stock = Stock::find(Request::get('sid'));

        if(!isset($product->id) || !isset($stock->id)) {
            return response()->json(['error'=>'Could Not Find product Or Stock'],404);
        }

        $prices = StockMargins::where('product_id','=',Request::Get('pid'))->where('stock_id','=',Request::get('sid'))->with(['product','stock'])->orderByRaw("CAST(qty as UNSIGNED) ASC")->get()->makeHidden(['price_margin_sheet','price_margin_single','price_margin_double','crap_profit','crap_sheets','crap_cost']);

        $userDiscount = UserPrices::where('product_id','=',Request::get('pid'))->where('user_id','=',Auth::User()->id)->first();
        $discount=0;
        if(isset($userDiscount->discount)) {
            $discount=$userDiscount->discount;
        }



        $data=[
            'product'=>$product->name.' '.$stock->name,
            'results'=>[]
        ];

        foreach($prices as $p) {
            $data['results'][] = [
                'qty'=>$p->qty,
                'price'=>number_format($p->crap_rrp*(1-($discount/100)),2,'.',''),
                'discount'=>$discount
            ];
        }

        return response()->json($data,200);

    }

    public function countOrders() {
        if(!Auth::check() || Auth::User()->cannot('access-user')) {
            return response()->json(['error'=>'User not authenticated'],422);
        }

        $data =[];
        $data['live'] = Auth::User()->orders()->whereIn('status',['PENDING'])->count();
        $data['problem'] = Auth::User()->orders()->whereIn('status',['PROBLEM'])->count();
        $data['printing'] = Auth::User()->orders()->whereIn('status',['PRINTING','PROCESSING','PROCESSED'])->count();
        $data['dispatched'] = Auth::User()->orders()->whereIn('status',['DISPATCHED'])->count();

        return response()->json($data,200);
    }



}
