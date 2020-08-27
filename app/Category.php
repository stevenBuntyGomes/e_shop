<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $fillable = ['category_name', 'category_description', 'category_photo'];

    function categoryOneToManyProducts(){
      return $this->hasMany('App\Product', 'product_category_id', 'id');
    }

    use SoftDeletes;
}
