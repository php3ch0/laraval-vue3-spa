<?php

namespace App\Models\Widgets;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Widgets extends Model
{

    protected $table = "widgets";

    protected $fillable = [
        'name','type','data',
    ];


    protected $appends =['html','image_url','alt'];

    public function getHtmlAttribute() {
        if($this->type=='TEXT') {
            return $this->data;
        }
        return null;
    }

    public function getImageUrlAttribute() {
        if($this->type=='IMAGE') {

            $data = json_decode($this->data);
            if(isset($data->image)) {
                return '/storage/images/uploads/'.$data->image;
            }

        }
        return null;
    }

    public function getAltAttribute() {
        if($this->type=='IMAGE') {

            $data = json_decode($this->data);
            if(isset($data->alt)) {
                return $data->alt;
            }

        }
        return null;
    }


}
