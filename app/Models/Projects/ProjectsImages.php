<?php

namespace App\Models\Projects;

use Illuminate\Database\Eloquent\Model;

class ProjectsImages extends Model
{

    protected $table = 'projects_images';

    protected $fillable = [
        'project_id','image'
    ];


    protected $appends =['image_url','short_code'];


    public function getImageUrlAttribute() {

        $dir = '/images/projects/';

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
