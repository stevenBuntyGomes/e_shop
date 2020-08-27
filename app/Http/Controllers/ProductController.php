<?php

namespace App\Http\Controllers;
use App\Category;
// use App\Category;
use Illuminate\Http\Request;
use Image;
use App\Product, App\Product_Image;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkrole');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        return view('admin.product.index', [
          'active_categories' => Category::all(),
          'products' => Product::with('oneToOneRelationCategory')->get(),
        //   'products' => Product::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $product_id = Product::insertGetId([
        //   'product_name' => $request->product_name,
        //   'product_short_description' => $request->product_short_description,
        //   'product_long_description' => $request->product_long_description,
        //   'product_price' => $request->product_price,
        //   'product_quantity' => $request->product_quantity,
        //   'alert_quantity' => $request->alert_quantity,
        //   'product_category_id' => $request->product_category_id,
        // ]);
        // if($request->hasFile('product_thumbnail_photo')){
        //   if(Product::find($product_id)->product_thumbnail_photo != 'default.png'){
        //     $old_photo_location = 'public/uploads/product_photos/product_thumbnail_photos/' . Product::find($product_id)->product_thumbnail_photo;
        //     unlink(base_path($old_photo_location));
        //   }
        //   $uploaded_photo = $request->file('product_thumbnail_photo');
        //   $new_photo_name = $product_id . '.' . $uploaded_photo->getClientOriginalExtension();
        //   $new_file_location = 'public/uploads/product_photos/product_thumbnail_photos/' . $new_photo_name;
        //   Image::make($uploaded_photo)->save(base_path($new_file_location));
        //   Product::find($product_id)->update([
        //     'product_thumbnail_photo' => $new_photo_name,
        //   ]);
        // }
        //new data entry
        $request->validate([
          'product_name' => 'required',
          'product_short_description' => 'required',
          'product_long_description' => 'required',
          'product_price' => 'required|numeric',
          'product_quantity' => 'required|numeric',
          'alert_quantity' => 'required',
          'product_thumbnail_photo' => 'required|image',
          'product_category_id' => 'required|numeric',
        ]);
        $product_id = Product::insertGetId($request->except('_token', 'product_thumbnail_photo', 'product_multiple_photo', 'slug') + [
          'slug' => Str::slug($request->product_name . '-' . Str::random(8)),
          'created_at' => Carbon::now(),
        ]);
        if($request->hasFile('product_thumbnail_photo')){
          if(Product::find($product_id)->product_thumbnail_photo != 'default.png'){
            $old_file_location = 'public/uploads/product_photos/product_thumbnail_photos/' . Product::find($product_id)->product_thumbnail_photo;
            unlink(base_path($old_file_location));
          }
          $uploaded_file = $request->file('product_thumbnail_photo');
          $new_photo_name = $product_id . '.' . $uploaded_file->getClientOriginalExtension();
          $new_file_location = 'public/uploads/product_photos/product_thumbnail_photos/' . $new_photo_name;
          Image::make($uploaded_file)->resize(600, 622)->save(base_path($new_file_location));
          Product::find($product_id)->update([
            'product_thumbnail_photo' => $new_photo_name,
          ]);
        }
        if($request->hasFile('product_multiple_photo')){
          $flag = 1;
          foreach($request->file('product_multiple_photo') as $single_photo){
            //upload multiple photos
            $uploaded_file = $single_photo;
            $new_photo_name = $product_id . '-' . $flag . '.' . $uploaded_file->getClientOriginalExtension();
            $new_file_location = 'public/uploads/product_photos/product_multiple_photos/' . $new_photo_name;
            Image::make($uploaded_file)->resize(600, 622)->save(base_path($new_file_location));
            Product_Image::insert([
              'product_id' => $product_id,
              'product_multiple_photo' => $new_photo_name,
              'created_at' => Carbon::now(),
            ]);
            $flag++;
          }
        }
        return back()->with('product_inserted', 'products inserted successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.product.show', [
          'product_info' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.product.edit', [
          'product_info' => $product,
          'active_categories' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // print_r($request->except('_token', '_method'));
        $product->update($request->except('_token', '_method', 'product_thumbnail_photo'));
        if($request->hasFile('product_thumbnail_photo')){
          if($product->product_thumbnail_photo != 'default.png'){
            $old_file_location = 'public/uploads/product_photos/product_thumbnail_photos/' . $product->product_thumbnail_photo;
            unlink(base_path($old_file_location));
          }
          $uploaded_file = $request->file('product_thumbnail_photo');
          $new_photo_name = $product->id . '.' . $uploaded_file->getClientOriginalExtension();
          $new_file_location = 'public/uploads/product_photos/product_thumbnail_photos/' . $new_photo_name;
          Image::make($uploaded_file)->save(base_path($new_file_location));
          $product->update([
            'product_thumbnail_photo' => $new_photo_name,
          ]);
        }
        return redirect('product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back();
    }
}
