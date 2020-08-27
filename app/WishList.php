<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WishList extends Model
{
    protected $guarded = [];
    use SoftDeletes;

    function product(){
        return $this->belongsTo('App\Product');
    }
}
