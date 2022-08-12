<?php

namespace App\Http\Controllers\Api\Galleries;

use http\Env\Response;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Galleries\Galleries;
use App\Models\Galleries\GalleriesImages;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class GalleriesImagesController extends Controller
{
    /* Specific Functions */

    public function add() {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }
        //validation

        $v = Validator::make(Request::all(), [
            'gallery_id' => 'required',
        ]);

        if ($v->fails())
        {
            return response()->json($v->errors(),422);
        }


        //check gallery exists
        $gallery = Galleries::find(Request::get('gallery_id'));

        if(!isset($gallery->id)) { // item not found
            return abort(404);
        }


        $images = ['file'];
        //directory to upload images to
        $dir= storage_path('/app/public/images/galleries/'.$gallery->id.'/');
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

                $filename= preg_replace('/\W+/', '-', str_replace($extension,'',Request::file($input_image)->getClientOriginalName())).rand(0,999).".webp";

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

    public function edit($id=0) {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $item = GalleriesImages::find(Request::get('id'));

        if(!isset($item->id)) {
            return response()->json(['error'=>'Could not find Gallery image By ID'],404);
        }

        $item->fill(Request::all());
        $item->save();


        return response()->json($item,200);


    }

    public function delete($id) {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $image = GalleriesImages::find($id);

        if($image->id) {
            $dir= storage_path("/app/public/images/galleries/".$image->gallery_id.'/');
            @unlink($dir.$image->image);
            $image->delete();
            return response()->json(200);
        }
    }

    public function get($id) {

        $item = GalleriesImages::find(Request::get('id'));

        if(!isset($item->id)) {
            return response()->json(['error'=>'Could not find Gallery image By ID'],404);
        }



        return response()->json($item, 200);

    }

    public function order() {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $data = Request::get('images');



        foreach($data as $key=>$value) {
            $item = GalleriesImages::find($value['id']);
            if(isset($item->id)) {
                $item->order_by =  str_pad($key, 4, '0', STR_PAD_LEFT);
                $item->save();
            }
        }

        return response()->json([],200);

    }

    public function rotate($id=0) {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $gi = GalleriesImages::find($id);
        if($gi->id) {

            $dir = "app/public/images/galleries/".$gi->gallery_id."/";
            $oldimage= storage_path($dir.$gi->image);

            $img = Image::make($oldimage);
            $img->rotate(-90);
            $newimage = bin2hex(random_bytes(3)).$gi->image;
            $img->save(storage_path($dir.$newimage));

            //delete old image to cleanup
            @unlink($dir.$oldimage);

            //save new image name to database
            $gi->image = $newimage;
            $gi->save();

            return response()->json(200);

        }

    }



}
