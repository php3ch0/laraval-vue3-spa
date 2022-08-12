<?php namespace App\Models\Galleries;

use Illuminate\Database\Eloquent\Model;

class GalleriesImages extends Model {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'galleries_images';
    protected $imgdir = '/storage/images/galleries/'; //default image directory

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['gallery_id','order_by','image','alt','url'];


    protected $appends = ['image_url'];

    public function getImageUrlAttribute() {

        if(!empty($this->image) && !empty($this->gallery_id)) {
            $dir = public_path('/storage/images/galleries/'.$this->gallery_id.'/'.$this->image);


            if($this->image && file_exists($dir)) {
                return '/storage/images/galleries/'.$this->gallery_id.'/'.$this->image;
            }
        }


        return '/storage/images/noimage.png';

    }


}
