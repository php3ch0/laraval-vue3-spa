<?php

namespace App\Models\Galleries;

use App\Models\Galleries\GalleriesImages;
use Illuminate\Database\Eloquent\Model;

class Galleries extends Model
{

    protected $imgdir = '/storage/images/galleries/'; //default image directory

    protected $fillable = [
        'name'
    ];

    public function images() {
        return $this->hasMany(GalleriesImages::class,'gallery_id','id')->orderby('order_by','ASC');
    }

    protected $appends = ['image_url'];


    public function getImageUrlAttribute() {

        if($this->has('images')) {
            $image = $this->images->first();
            if(isset($image->id)) {
                return $image->image_url;
            }

        }

        return '/storage/images/noimage.png';


    }





}
