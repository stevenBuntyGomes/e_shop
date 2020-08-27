<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order_detail extends Model
{
    protected $fillable = ['review', 'stars'];
    use SoftDeletes;
    function product(){
        return $this->belongsTo('App\Product');
    }
}
