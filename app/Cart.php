<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    protected $guarded = [];

    function product(){
      return $this->belongsTo('App\Product');
    }

    use SoftDeletes;
}
