<?php

namespace App\Models\Testimonials;

use Illuminate\Database\Eloquent\Model;

class Testimonials extends Model
{

    protected $table = "testimonials";

    protected $fillable = [
        'score','name','email','review','published'
    ];



}
