<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Galleries;
use App\Models\GalleriesImages;
use Illuminate\Support\MessageBag;

class GalleriesImagesController extends Controller
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

        $item = GalleriesImages::where('id','=',$id)->first();

        if(!isset($item->id)) { // item not found
            return abort(404);
        }

        return $item;
    }

    /* Specific Functions */

    public function add() {

        $this->restrict_admin();

        //validation

        $v = Validator::make(Request::all(), [
            'gallery_id' => 'required',
        ]);

        if ($v->fails())
        {
            $data['status'] = '422';
            $data['errors'] = $v->errors();
            return response()->json($data,422);
        }


        //check gallery exists
        $gallery = Galleries::find(Request::get('gallery_id'));

        if(!isset($gallery->id)) { // item not found
            return abort(404);
        }

        if(!is_dir(public_path('/storage/images/galleries'))) {
            mkdir(public_path('/storage/images/galleries'));
        }

        $images = ['file'];
        //directory to upload images to
        $dir= public_path('/storage/images/galleries/'.$gallery->id.'/');

        //image size to reduce the image to
        $size = 1400;

        //mk directory if does not exist
        if(!is_dir($dir)) {
            mkdir($dir);
        }

        foreach($images as $input_image) {
            if (Request::hasFile($input_image)) {

                //upload image
                $extension = Request::file($input_image)->getClientOriginalExtension();

                $filename= preg_replace('/[^a-z0-9]/i','',str_replace($extension,'',Request::file($input_image)->getClientOriginalName()).rand(0,999)).".".$extension;

                Image::make(Request::file($input_image))->resize(null, $size, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($dir . $filename);

                $item = new GalleriesImages();
                $item->gallery_id = $gallery->id;

                $item->image = $filename;
                $item->save();

                return response()->json($item,200);

            }
        }

        $errors = new MessageBag;
        $errors->add('error', 'Error Uploading Image');
        $data['errors'] = $errors;
        return response()->json($data,500);

    }

    public function edit() {

        $this->restrict_admin();
        $item = $this->check_exists(Request::get('id'));

        $item->fill(Request::all());
        $item->save();

        $data['status'] = '200';
        $data['errors'] = [];
        $data['results']=$item;

        return response()->json($data,200);


    }

    public function delete($id) {
        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }
        $image = GalleriesImages::find($id);
        if($image->id) {
            $dir= public_path("/storage/images/galleries/".$image->gallery_id.'/');
            @unlink($dir.$image->image);
            $image->delete();
            return response()->json(200);
        }
    }

    public function get($id) {

        $item = $this->check_exists($id);

        $data['status'] = '200';
        $data['errors'] = [];
        $data['results'] = $item;

        return response()->json($data, 200);

    }

    public function order() {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $data = Request::all();

        foreach($data as $key=>$value) {
           $image = GalleriesImages::find($value['id']);
           if(isset($image->id)) {
               $image->orderby =  str_pad($key, 4, '0', STR_PAD_LEFT);
               $image->save();
           }
        }

        return response(200);

    }

    public function rotate($id=0) {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $gi = GalleriesImages::find($id);
        if($gi->id) {

            $dir = "/storage/images/galleries/".$gi->gallery_id."/";
            $oldimage= public_path($dir.$gi->image);

            $img = Image::make($oldimage);
            $img->rotate(-90);
            $newimage = bin2hex(random_bytes(3)).$gi->image;
            $img->save(public_path($dir.$newimage));

            //delete old image to cleanup
            @unlink($dir.$oldimage);

            //save new image name to database
            $gi->image = $newimage;
            $gi->save();

            return response()->json(200);

        }

    }



}
