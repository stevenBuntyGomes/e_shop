<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use App\WishList;
use Carbon\Carbon;

class WishListController extends Controller
{

    public function index(){
        return view('frontend.wishlist');
    }

    public function wishStore($wish_id){
        if(Cookie::get('g_wish_id')){
            $generated_wish_id = Cookie::get('g_wish_id');
        }else{
            $generated_wish_id = str::random(10).rand(2, 9999);
            $minutes = 43200;
            Cookie::queue('g_wish_id', $generated_wish_id, $minutes);
        }

        if(WishList::where('generated_wish_id', $generated_wish_id)->where('product_id', $wish_id)->exists()){
            return redirect('wishList')->with('already_added_wish', 'The Product is already added in the wishlist. Thank You!');
        }else{
            WishList::insert([
                'generated_wish_id' => $generated_wish_id,
                'product_id' => $wish_id,
                'created_at' => Carbon::now(),
            ]);
        }
        return redirect('wishList');
    }


    public function removeWishList($wish_id){
        WishList::find($wish_id)->delete();
        return redirect('wishList')->with('wish_deleted', 'wishlist item removed successfully');;
    }
}
