<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class BlogImages extends Model
{

    protected $table = 'blog_images';

    protected $fillable = [
        'blog_id','image'
    ];


    protected $appends =['image_url','short_code'];


    public function getImageUrlAttribute() {

        $dir = '/images/blog/';

        if(!file_exists(storage_path('app/public/'.$dir.$this->image)) || empty($this->image)) {
            return '/storage/images/no-image.png';
        } else {
            return '/storage/'.$dir.$this->image;
        }

    }

    public function getShortCodeAttribute() {
        return "[[image=".$this->id."]]";
    }


}
