<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Order;
use Auth;

class StripePaymentController extends Controller
{
    /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function stripe()

    {
        if(session('order_id_from_checkout_page')){
            return view('test.stripe');
        }else{
            abort(404);
            // return redirect('cart')->with('no_order_id', 'checkout has not been procided');
        }
    }

    /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function stripePost(Request $request)

    {
        Stripe\Stripe::setApiKey('sk_test_51H9EP2BNMg4E7zr1ruxq9TeRdPJkHfhamSz3hmlEq7mXHWfnpUPgpj6kmm7PEOHFBXuDuzeZMMbkjzKtfiDBEGw600qxQoE0rn');

        Stripe\Charge::create([

            "amount" => session('sub_total') - session('discount_amount') * 100,

            "currency" => "usd",

            "source" => $request->stripeToken,

            "description" => "Test payment from Order Id: " . session('order_id_from_checkout_page') . " Name: " . Auth::user()->name,

        ]);



        Session::flash('success', 'Payment successful!');

        Order::find(session('order_id_from_checkout_page'))->update([
            'payment_status' => 2,
        ]);

        Session([
            'sub_total' => '',
            'cupon_name' => '',
            'discount_amount' => '',
            'order_id_from_checkout_page' => '',
        ]);


        return redirect('/');
    }
}
