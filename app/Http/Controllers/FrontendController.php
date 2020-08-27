<?php

namespace App\Http\Controllers;

use Hash;
// use App\Category, App\Products;
use App\User;
use App\Slider;
use App\Contact;
use App\Product;
use App\Category;
use Carbon\Carbon;
use App\Testimonial;
use App\Order_detail;
use DB;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request; //will be discussed later

class FrontendController extends Controller
{
    function index(){
      $best_seller = DB::table('order_details')
      ->select('product_id', DB::raw('COUNT(*) as total'))
      ->groupBy('product_id')->get()->sortByDesc('total')->take(4);
      return view('frontend.index', [
        'category_info' => Category::all(),
        'active_products' => Product::latest()->get(),
        'active_sliders' => Slider::all(),
        'active_testimonial' => Testimonial::all(),
        'best_seller' => $best_seller,
      ]);
    }

    function contact(){
      return view('frontend.contact');
    }

    function contactInsertion(Request $request){
      $contact_id = Contact::insertGetId($request->except('_token', 'contact_attachment') + [
        'created_at' => Carbon::now(),
      ]);
      if($request->hasFile('contact_attachment')){
        // $uploaded_path = $request->file('contact_attachment')->store('contact_uploads');
        $path = $request->file('contact_attachment')->storeAs(
            'contact_uploads', $contact_id . '.' . $request->file('contact_attachment')->getClientOriginalExtension(),
        );
        Contact::find($contact_id)->update([
          'contact_attachment' => $path,
        ]);
      }
      return back()->with('contact_file_sent', 'contact file has been successfully sent.');
    }

    function about(){
      return view('about');
    }

    function supportfromus(){
      echo "Hi! We are here to provide you with 24/7 support";
    }

    function service(){
      return view('service');
    }

    function productDetails($slug){
      $product_info = Product::where('slug', $slug)->firstOrFail();
      $related_products = Product::where('product_category_id', $product_info->product_category_id)->where('id', '!=', $product_info->id)->limit(4)->get();
      if(Order_detail::where('user_id', Auth::id())->where('product_id', $product_info->id)->whereNull('review')->exists()){
        $show_review_form = 1;
        $order_details_id = Order_detail::where('user_id', Auth::id())->where('product_id', $product_info->id)->whereNull('review')->first()->id;
      }else{
        $show_review_form = 2;
        $order_details_id = 0;
      }

      $reviews = Order_detail::where('product_id', $product_info->id)->whereNotNull('review')->get();
      return view('frontend.productDetails', [
        'product_info' => $product_info,
        'related_products' => $related_products,
        'show_review_form' => $show_review_form,
        'order_details_id' => $order_details_id,
        'reviews' => $reviews,
      ]);
    }

    function shop(){
      return view('frontend.shop', [
        'active_categories' => Category::all(),
        'active_products' => Product::all(),
      ]);
    }

    public function customerRegister(){
      return view('frontend.customer_register');
    }

    public function customerRegisterPost(Request $request){
      User::insert([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 2,
        'created_at' => Carbon::now(),
      ]);
      if(Auth::attempt(['email' => $request->email, 'password' => $request->password,])){
        return redirect('customer/home');
      }
    }
    // review of posts
    public function reviewPost(Request $request){
        // print_r($request->all());
        Order_detail::find($request->order_details_id)->update([
            'review' => $request->massage,
            'stars' => $request->star,
        ]);
        return back();
    }


    public function search(){
        // $product_category_name =;
        $search_results = QueryBuilder::for(Product::class)
        ->allowedFilters(['product_name', 'product_category_id'])
        ->allowedSorts(['product_name'])
        ->get();
        return view('frontend.search', [
            'search_results' => $search_results,
        ]);
        // if I use only ids for search query it generates big error. It is a bug that doesnt actually show errors.
    }
//     star

// email
// order_details_id

    // review of posts
}
