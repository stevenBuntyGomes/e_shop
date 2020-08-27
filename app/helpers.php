<?php

use Illuminate\Support\Facades\DB;

function totalProductCount(){
  return App\Product::count();
}
// cart counter
function cart_counter(){
  return App\Cart::where('generated_cart_id', Cookie::get('g_cart_id'))->count();
}
// cart counter
// cart items
function cart_items(){
  return App\Cart::where('generated_cart_id', Cookie::get('g_cart_id'))->get();
}

// wishList Items and counter starts

function wish_items(){
    return App\WishList::where('generated_wish_id', Cookie::get('g_wish_id'))->get();
}

function wish_count(){
    return App\WishList::where('generated_wish_id', Cookie::get('g_wish_id'))->count();
}

// wishList Items and counter ends


function review_customer_count($product_id){
    return App\Order_detail::where('product_id', $product_id)->whereNotNull('review')->count();
}

function average_stars($product_id){
    // App\Order_detail::where('product_id', $product_id)->whereNotNull('reviewe')->sum('stars');
    $get_reviews = App\Order_detail::where('product_id', $product_id)->whereNotNull('review')->get();
    $count_amount = App\Order_detail::where('product_id', $product_id)->whereNotNull('review')->count();
    $addition = 0;
    $average = 0;

    foreach($get_reviews as $get_review){
        $addition += $get_review->stars;
    }

    if($addition == 0){
        return 0;
    }else{
        $average = $addition / $count_amount;
        return ceil($average);
    }
}

function total_product_alert(){
    // return App\Product::where('product_quantity', '<=', 'alert_quantity')->get();
    return DB::table('products')->whereRaw('product_quantity <= alert_quantity')->count();
    // if()
}
// cart items
