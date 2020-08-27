<?php

namespace App\Http\Controllers;

use App\City;
use App\User;
use App\Order;
use App\Billing;
use App\Country;
use App\Product;
use App\Shipping;
use Carbon\Carbon;
use App\Order_detail;
use Illuminate\Support\Facades\Session;
// use Auth;
use Illuminate\Http\Request;
use App\Mail\PurchaseConfirm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('frontend.checkout', [
            'user' => User::find(Auth::id()),
            'countries' => Country::all(),
        ]);
    }

    public function store(Request $request){
        if(isset($request->shipping_address_status)){
            $shipping_id = Shipping::insertGetId([
                'name' => $request->shipping_name,
                'email' => $request->shipping_email,
                'phone_number' => $request->shipping_phone_number,
                'country_id' => $request->shipping_country_id,
                'city_id' => $request->shipping_city_id,
                'address' => $request->shipping_address,
                'created_at' => Carbon::now(),
            ]);
        }else{
            $shipping_id = Shipping::insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'address' => $request->address,
                'created_at' => Carbon::now(),
            ]);
        }
        $billing_id = Billing::insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'notes' => $request->notes,
            'created_at' => Carbon::now(),
        ]);

        $order_id = Order::insertGetId([
            'user_id' => Auth::id(),
            'sub_total' => session('sub_total'),
            'discount_amount' => session('discount_amount'),
            'cupon_name' => session('cupon_name'),
            'total' => session('sub_total') - session('discount_amount'),
            'payment_option' => $request->payment_option,
            'billing_id' => $billing_id,
            'shipping_id' => $shipping_id,
            'created_at' => Carbon::now(),
        ]);

        foreach(cart_items() as $cart_item){
            Order_detail::insert([
                'order_id' => $order_id,
                'user_id' => Auth::id(),
                'product_id' => $cart_item->product_id,
                'product_quantity' => $cart_item->product_quantity,
                'product_price' => $cart_item->product->product_price,
                'created_at' => Carbon::now(),
            ]);
            // product table decrement
            Product::find($cart_item->product_id)->decrement('product_quantity', $cart_item->product_quantity);
            // delet from cart table
            $cart_item->forceDelete();
        }
        $order_details = Order_detail::where('order_id', $order_id)->get();
        Mail::to($request->email)->send(new PurchaseConfirm($order_details));
        if($request->payment_option != 2){
            session(['order_id_from_checkout_page' => $order_id]);
            return redirect('stripe');
        }else{
            return redirect('cart');
        }

        // return back();
    }

    public function testMail()
    {
        // echo "hi!";
        $order_details = Order_detail::where('order_id', 3)->get();
        return (new PurchaseConfirm($order_details))->render();
    }

    public function testSMS(){
        $url = "http://66.45.237.70/api.php";
        $number = "01845878794";
        $text = "You have successfully purchased the product. Check your email.";
        $data = array(
            'username' => "01840416216",
            'password' => "CKT4SMZF",
            'number' => "01845878794",
            'message' => "Product purchase successful",
        );

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("|", $smsresult);
        $sendstatus = $p[0];
        echo $sendstatus = $p[0];
    }

    public function getCityAjax(Request $request){
        $stringToSend = "";
        // $cities = City::where('country_id', $request->country_id)->pluck('id', 'name');
        $cities = City::where('country_id', $request->country_id)->get();
        // echo "this is country id " . $request->country_id;
        foreach($cities as $city){
            $stringToSend .= "<option value='" . $city->id . "'>" . $city->name . "</option>";
        }
        return $stringToSend;
    }


}
