<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $table = 'countries';
    protected $fillable = [
        'name','code'
    ];


        public function deliveryTypes() {
            return $this->belongsToMany(DeliveryTypes::class,'delivery_types_countries','country_id','type_id')->withPivot(['id']);
        }



}
