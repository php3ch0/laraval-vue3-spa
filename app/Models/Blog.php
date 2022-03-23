<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    protected $table = 'blog';
    protected $filedir='/storage/files/blog/';

    protected $fillable = [
        'title', 'article','slug','image','file'
    ];
    protected $guarded = [
        'image',
    ];

    protected $appends =['preview_text','fileurl','article_html','url'];


    public function image() {

        $dir = '/storage/images/blog/';

        if(!file_exists(public_path($dir.$this->image)) || empty($this->image)) {
            return '/storage/images/no-image.png';
        } else {
            return $dir.$this->image;
        }

    }

    public function images() {
        return $this->hasMany(BlogImages::class,'blog_id','id');
    }

    public function getUrlAttribute() {
        return "/blog/".$this->slug;
    }



    public function getPreviewTextAttribute() {

        $text = strip_tags(html_entity_decode($this->article));

        $text= substr($text,0,180);
        $text = preg_replace('/\[\[.*?\]\]/m','',$text);

        return $text;

    }

    public function getfileUrlAttribute() {

        if(!file_exists(public_path($this->filedir.$this->file)) || empty($this->file)) {
            return false;
        } else {
            return $this->filedir.$this->file;
        }

    }

    public function getArticleHtmlAttribute() {

        $html = $this->article;

        $images = $this->images;

        foreach($images as $image) {

            $find = ["[[image100=".$image->id."]]","[[image=".$image->id."]]"];
            $replace = '<div class="blog-image"><img src="'.$image->image_url.'" alt="'.$this->title.'" /></div>';
            $html = str_replace($find,$replace,$html);

            $find = "[[image50=".$image->id."]]";
            $replace = '
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6">
                        <div class="blog-image"><img src="'.$image->image_url.'" alt="'.$this->title.'" /></div>
                    </div>
                </div>
                ';

            $html = str_replace($find,$replace,$html);

            $find = "[[image66=".$image->id."]]";
            $replace = '
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8">
                        <div class="blog-image"><img src="'.$image->image_url.'" alt="'.$this->title.'" /></div>
                    </div>
                </div>
                ';

            $html = str_replace($find,$replace,$html);

            $find = "[[image33=".$image->id."]]";
            $replace = '
                <div class="row justify-content-center">
                    <div class="col-12 col-md-4">
                        <div class="blog-image"><img src="'.$image->image_url.'" alt="'.$this->title.'" /></div>
                    </div>
                </div>
                ';

            $html = str_replace($find,$replace,$html);

            $find = "[[image80=".$image->id."]]";
            $replace = '
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10">
                        <div class="blog-image"><img src="'.$image->image_url.'" alt="'.$this->title.'" /></div>
                    </div>
                </div>
                ';

            $html = str_replace($find,$replace,$html);



        }

        return $html;

    }





}
