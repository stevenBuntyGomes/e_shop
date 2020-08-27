<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product_Image extends Model
{
    protected $guarded = [];
    use SoftDeletes;
}
