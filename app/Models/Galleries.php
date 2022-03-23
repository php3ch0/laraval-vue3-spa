<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galleries extends Model
{

    protected $imgdir = '/storage/images/galleries/'; //default image directory
    protected $url = '/galleries/'; //default url parent

    protected $fillable = [
        'name','show','slug','order_by'
    ];

    public function images() {
        return $this->hasMany('\App\Models\GalleriesImages','gallery_id','id')->orderby('order_by','ASC');
    }

    protected $appends = ['image_url','url'];


    public function getImageUrlAttribute() {

        if($this->has('images')) {
            $image = $this->images->first();
            if(isset($image->id)) {
                return $image->image_url;
            }

        }

        return '/storage/images/noimage.png';


    }

    public function getUrlAttribute() {
        return $this->url.$this->slug;
    }




}
