<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Widgets extends Model
{
    protected $fillable = [
        'name', 'type','value','data','url','alt'
    ];

    public function html() {
        $html=null;

        if($this->type == "IMAGE") {
            if(!empty($this->url) and !in_array($this->url,['http://','null'])) {
                $html .= "<a href=\"".$this->url."\">";
            }
            $html .= "<img src=\"/storage/uploads/".$this->value."\" class=\"img-fluid\" alt=\"".$this->alt."\" />";

            if(!empty($this->url) and !in_array($this->url,['http://','null'])) {
                $html .= "</a>";
            }
        }
        if($this->type=="TEXT") {
            $html .= $this->data;
        }

        return $html;
    }
}
