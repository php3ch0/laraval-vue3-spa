<?php

namespace App\Http\Controllers\Api\Projects;

use http\Env\Response;
use Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Projects\ProjectsImages;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ProjectsImagesController extends Controller {

    private string $dir = "/images/projects/";

    public function add() {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $v = Validator::make(Request::all(), [
            'project_id'=>'required|numeric'
        ]);

        if ($v->fails())
        {
            $data['status']='error';
            $data['errors'] = $v->errors();
            return response()->json($data,200);
        }

        if (Request::hasFile('file')) {

            $item = new ProjectsImages();
            $item->project_id=Request::get('project_id');
            $item->save();


            $dir= storage_path("/app/public".$this->dir);
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

    public function delete($id) {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $item = ProjectsImages::find($id);

        if(isset($item->id)) {
            $dir= storage_path("/app/public".$this->dir);
            unlink($dir.$item->image);
            $item->delete();
        }

        $data['status']='success';
        return response()->json($data,200);

    }
    public function order() {

        if(Auth::User()->cannot('access-admin')) {
            return abort(401);
        }

        $data = Request::get('images');



        foreach($data as $key=>$value) {
            $item = ProjectsImages::find($value['id']);
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

        $gi = ProjectsImages::find($id);
        if($gi->id) {

            $dir = $this->dir;
            $oldimage= storage_path("app/public".$dir.$gi->image);

            $img = Image::make($oldimage);
            $img->rotate(-90);
            $newimage = bin2hex(random_bytes(3)).$gi->image;
            $img->save(storage_path("app/public".$dir.$newimage));

            //delete old image to cleanup
            @unlink($dir.$oldimage);

            //save new image name to database
            $gi->image = $newimage;
            $gi->save();

            return response()->json(200);

        }

    }

}
