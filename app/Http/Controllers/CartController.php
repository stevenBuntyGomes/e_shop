<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Image;
use App\Cart;
use App\Cupon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('checkrole');
    // }


    public function cartIndex($cupon_name = ""){
      $msg = "";
      $total_amount = 0;
      $discount_amount = 0;
      if($cupon_name == ""){
        $msg = "";
      }else{
        if(!Cupon::where('cupon_name', $cupon_name)->exists()){
          $msg = "wrong cupon";
        }else{
          if(Carbon::now()->format('Y-m-d') > Cupon::where('cupon_name', $cupon_name)->first()->validity_till){
            $msg = "cupon has been expired";
          }else{

            foreach(cart_items() as $cart_item){
              $total_amount += $cart_item->product_quantity * $cart_item->product->product_price;
            }
            if(Cupon::where('cupon_name', $cupon_name)->first()->minimum_purchase_amount > $total_amount){
              $msg = "the subtotal amount doesn't exceed minimum cupon price requirements";
            }else{
              $discount_amount = Cupon::where('cupon_name', $cupon_name)->first()->discount_amount;
            }
          }
        }

      }
      $valid_cupon = Cupon::whereDate('validity_till', '>=', Carbon::now()->format('Y-m-d'))->get();
      // return view('frontend.cart', compact('msg', 'discount_amount'));
      return view('frontend.cart', [
        'cart_info' => Cart::all(),
        'msg' => $msg,
        'discount_amount' => $discount_amount,
        'cupon_name' => $cupon_name,
        'valid_cupon' => $valid_cupon,
      ]);
    }

    // public function cartCupon($cupon_name){

    // }

    public function cartStore(Request $request){
      // print_r($request->all());
      if(Cookie::get('g_cart_id')){
        $generated_cart_id = Cookie::get('g_cart_id');
      }else{
        $generated_cart_id = str::random(10).rand(2, 99999);
        $minutes = 43200;
        Cookie::queue('g_cart_id', $generated_cart_id, $minutes);
      }
      if(Cart::where('generated_cart_id', $generated_cart_id)->where('product_id', $request->product_id)->exists()){
        Cart::where('generated_cart_id', $generated_cart_id)->where('product_id', $request->product_id)->increment('product_quantity', $request->product_quantity);
      }else{
        Cart::insert([
          'generated_cart_id' => $generated_cart_id,
          'product_id' => $request->product_id,
          'product_quantity' => $request->product_quantity,
          'created_at' => Carbon::now(),
        ]);
      }
      return back();
    }

    public function cartRemove($cart_id){
      Cart::find($cart_id)->delete();
      return back()->with('cart_item_deleted', 'cart item has been deleted.');
    }

    public function cartUpdate(Request $request){
      foreach($request->product_info as $cart_id => $product_quantity){
        Cart::find($cart_id)->update([
          'product_quantity' => $product_quantity,
        ]);
      }
      return back()->with('update_success', 'cart items updated successfully.');
    }
}
