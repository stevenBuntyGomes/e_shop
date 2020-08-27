<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Order;
use App\Product;
use App\Mail\NewsLetter;
use Mail;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkrole');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   //raw php
        // $select_user_query = "SELECT * FROM `users`";
        // $select_usr = mysqli_query($db_connect, $select_user_query);
        // print_r($select_usr);
        // $users = User::all(); Collection return
        //$users = User::orderBy('id', 'desc')->get(); //Method chaining
        $users = User::latest()->paginate(2);
        $users_count = User::count(); //count datas of users
        //Method 1
        // return view('home', compact('users', 'users_count')); //compact binds datas from model to the blade.php page and shows to UI
        //method 2
        $total_stock_price = 0;

        foreach(Product::all() as $single_product){
            $total_stock_price += ($single_product->product_quantity * $single_product->product_price);
        }
        // echo $total_sale = Order::where('payment_status', 1)->sum('total');
        // echo "<br>";
        // echo $total_stock_price;
        // die();
        return view('home', [
          'users' => User::latest()->paginate(2),
          'users_count' => User::count(),
          'unpaid' => Order::where('payment_status', 1)->count(),
          'paid' => Order::where('payment_status', 2)->count(),
          'canceled' => Order::where('payment_status', 3)->count(),
          'total_sale' => Order::where('payment_status',2)->sum('total'),
          'total_stock_price' => $total_stock_price,
        ]);
        //method 3
        // return view('home')->with('users', User::latest()->paginate(2))->with('users_count', User::count());
    }

    public function newsLetters(){
      //echo User::all()->pluck('email', 'name');
      foreach(User::all()->pluck('email') as $email){
        Mail::to($email)->queue(new NewsLetter());
      }
      return back()->with('good_status', 'Mail Sent');
        // $email = User::find(1)->email;
        // Mail::to($email)->send(new NewsLetter());
        // echo "success";
        // return back();
        // $email = User::find(1)->email;
        // Mail::to($email)->send(new NewsLetter());
    }
}
