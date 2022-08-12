<?php


//convert 'null' to ''

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class ConvertNullStrings extends TransformsRequest
{

/**
* Transform the given value.
*
* @param  string  $key
* @param  mixed  $value
* @return mixed
*/
protected function transform($key, $value) {
    if(is_string($value) && $value=='null') {
       $value='';
    }

    return $value;
    }
}
