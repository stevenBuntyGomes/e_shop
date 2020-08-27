<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class CustomerController extends Controller
{
    public function customerHome(){
        return view('customer/home', [
            'order_info' => Order::with('order_detail')->where('user_id', Auth::id())->get(),
        ]);
    }

    public function CustomerInvoice($order_id){
        // echo $order_id;
        $order_info = Order::find($order_id);
        $pdf = PDF::loadView('pdf_invoice.pdf_invoice', compact('order_info'));
        return $pdf->download('invoice_ID(' . $order_id . ').pdf');
        // return $pdf->stream();
    }
}
