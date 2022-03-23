<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galleries extends Model
{

    protected $imgdir = '/storage/images/galleries/'; //default image directory
    protected $url = '/gallery/'; //default url parent

    protected $fillable = [
        'name','show','slug','orderby'
    ];

    public function images() {
        return $this->hasMany('\App\Models\GalleriesImages','gallery_id','id')->orderby('orderby','ASC');
    }

    protected $appends = ['imageurl','url'];


    public function getImageurlAttribute() {

        if($this->has('images')) {
            $image = $this->images->first();
            if(isset($image->id)) {
                return $image->imageurl;
            }

        }

        return '/storage/images/noimage.png';


    }

    public function getUrlAttribute() {
        return $this->url.$this->slug;
    }




}
