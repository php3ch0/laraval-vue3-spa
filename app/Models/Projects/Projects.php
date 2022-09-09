<?php

namespace App\Models\Projects;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{

    protected  $table = 'projects';
    protected string $urldir = '/projects/';
    protected string $imgdir="/images/projects/";

    protected $fillable = [
        'title', 'article','slug','image'
    ];
    protected $guarded = [
        'image','created_at','order_by'
    ];

    protected $appends =['preview_text','article_html','image_url','url'];


    public function getImageUrlAttribute() {



        if(!file_exists(storage_path('app/public'.$this->imgdir.$this->image)) || empty($this->image)) {
            return '/storage/images/no-image.png';
        } else {
            return '/storage'.$this->imgdir.$this->image;
        }

    }

    public function images() {
        return $this->hasMany(ProjectsImages::class,'project_id','id')->orderBy('order_by','ASC');
    }

    public function getUrlAttribute() {
        return $this->urldir.$this->slug;
    }



    public function getPreviewTextAttribute() {

        $text = strip_tags(html_entity_decode($this->article));

        return substr($text,0,180);

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
                <div class="flex justify-center">
                    <div class="w-full lg:w-2/3 xl:w-1/2 mx-auto ">
                        <div class="blog-image"><img src="'.$image->image_url.'" alt="'.$this->title.'" /></div>
                    </div>
                </div>
                ';

            $html = str_replace($find,$replace,$html);

            $find = "[[image66=".$image->id."]]";
            $replace = '
                <div class="flex justify-center">
                    <div class="w-full lg:w-2/3 xl:w-2/3 mx-auto ">
                        <div class="blog-image"><img src="'.$image->image_url.'" alt="'.$this->title.'" /></div>
                    </div>
                </div>
                ';

            $html = str_replace($find,$replace,$html);

            $find = "[[image33=".$image->id."]]";
            $replace = '
                <div class="flex justify-center">
                    <div class="w-full lg:w-2/3 xl:w-1/3 mx-auto ">
                        <div class="blog-image"><img src="'.$image->image_url.'" alt="'.$this->title.'" /></div>
                    </div>
                </div>
                ';

            $html = str_replace($find,$replace,$html);

            $find = "[[image80=".$image->id."]]";
            $replace = '
                <div class="flex justify-center">
                    <div class="w-full lg:w-3/4 xl:w-3/4 mx-auto ">
                        <div class="blog-image"><img src="'.$image->image_url.'" alt="'.$this->title.'" /></div>
                    </div>
                </div>
                ';

            $html = str_replace($find,$replace,$html);



        }

        return $html;

    }

}
