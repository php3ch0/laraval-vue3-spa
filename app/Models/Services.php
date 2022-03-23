<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $fillable = [
        'name','slug','order_by','short_text','text','gallery_id'
    ];

    protected $appends = ['image_icon_url','image_header_url','url'];

    public function getImageIconUrlAttribute() {

        if(empty($this->image_icon) || !file_exists(public_path('storage/images/services/'.$this->image_icon))) {
            return "/storage/images/no-image.png";
        } else {
            return "/storage/images/services/".$this->image_icon;
        }
     }

    public function getImageHeaderUrlAttribute() {

        if(empty($this->image_header) || !file_exists(public_path('storage/images/services/'.$this->image_header))) {
            return "/storage/images/no-image.png";
        } else {
            return "/storage/images/services/".$this->image_header;
        }
    }
    public function getUrlAttribute() {
        return '/services/'.$this->slug;
    }
}
