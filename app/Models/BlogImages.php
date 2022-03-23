<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogImages extends Model
{

    protected $table = 'blog_images';

    protected $fillable = [
        'blog_id','image'
    ];


    protected $appends =['image_url','short_code'];


    public function getImageUrlAttribute() {

        $dir = '/storage/images/blog/';

        if(!file_exists(public_path($dir.$this->image)) || empty($this->image)) {
            return '/storage/images/no-image.png';
        } else {
            return $dir.$this->image;
        }

    }

    public function getShortCodeAttribute() {
        return "[[image=".$this->id."]]";
    }


}
