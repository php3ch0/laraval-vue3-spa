<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Testimonials extends Model
{

    protected $table = 'testimonials';

    protected $fillable = [
        'id','name','text','job_title','company','order_by'
    ];

    protected $appends = ['size','color'];


    public function getHtmlAttribute() {
        return nl2br($this->text);
    }

    public function getSizeAttribute() {
        $sizeslarge = ['tall','wide'];

        if(strlen($this->text) >400) {
            return "big";
        }

        if(strlen($this->text) > 200) {
            $key = array_rand($sizeslarge);
            return $sizeslarge[$key];
        }

        return "normal";
    }

    public function getColorAttribute() {

        $colors = [
            '#624F73','#ffb124','#8CBE26','#81838c','#4a4a51','#017d8f','#33323d','#22278b','#FA824C','#3C91E6','#342E37','#61988E','#A0B2A6','#8ACB88','#575761',
            '#575761','#136F63','#D8CBC7','#33673B','#19231A','#023618','#005C69','#950952','#00B4D8','#90E0EF','#457EAC','#686868'
        ];

        $key = array_rand($colors);
        return $colors[$key];
    }

}
