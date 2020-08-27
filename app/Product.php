<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //$fillable lets the query to change independently. Fill and change
    // protected $fillable = ['product_name', 'product_short_description', 'product_long_description', 'product_price', 'product_price', 'product_quantity', 'alert_quantity', 'product_thumbnail_photo', 'product_category_id'];
    // $guarded = don't let any of the query be updated or changed
    protected $guarded = [];
    function oneToOneRelationCategory(){
      // return $this->hasOne('App\Category', 'id', 'product_category_id')->withTrashed();
      return $this->hasOne('App\Category', 'id', 'product_category_id');
    }

    function oneToManyRelationProductImage(){
      return $this->hasMany('App\Product_Image', 'product_id', 'id');
    }

    use SoftDeletes;
}
