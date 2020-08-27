<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; //class created for processing form datas
use App\Http\Requests\CategoryForm;
use App\Category;
use App\Product;
use Carbon\Carbon;
use Auth;
use Image;
use App\Mail\ChangePasswordConfirmMail;

class CategoryController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('checkrole');
    }

    function product(){
      return view('admin/categories/product', [
        'categories' => Category::all(),
        'deleted_categories' => Category::onlyTrashed()->get(),
      ]);
    }

    function addcategoryPost(CategoryForm $request){
      // $request->validate([
      //   'category_name' => 'required|numeric',
      //   'category_description' => 'required'
      // ],[
      //   'category_name.required' => 'Fill the category field',
      //   'category_name.numeric' => 'The category field must be number',
      //   'category_description.required' => 'Fill the category description field'
      // ]);
      // Category::insert([
      //   'table_field' => $value
      // ]);
      // echo Auth::user()->id;
      // echo Auth::user()->name;
      // echo $request->category_name;

      $get_id = Category::insertGetId([
        'category_name' => $request->category_name,
        'category_description' => $request->category_description,
        'user_id' => Auth::user()->id,
        'created_at' => Carbon::now(),
      ]);

      if($request->hasFile('category_photo')){
        // if(Category::find($get_id)->category_photo != 'default.png'){
        //   $old_file_location = 'public/uploads/category_photos/' . Category::find($get_id)->category_photo;
        //   unlink(base_path($old_file_location));
        // }
        $uploaded_file = $request->file('category_photo');
        $new_photo_name = $get_id . '.' . $uploaded_file->getClientOriginalExtension();
        $new_file_location = 'public/uploads/category_photos/' . $new_photo_name;
        Image::make($uploaded_file)->save(base_path($new_file_location));
        Category::find($get_id)->update([
          'category_photo' => $new_photo_name,
        ]);
      }
      return back()->with('success_status', $request->category_name . 'Category added successfully.');
      // echo $request->category_name . "<br>";
      // echo $request->category_description;
    }
    function deleteCategory($category_id){
      // delete category
      Category::find($category_id)->delete();
      // delete products
      // Product::where('product_category_id', $category_id)->delete();
      return back()->with('delete_status', 'Category Item deleted');
    }
    function editCategory($category_id){
      // echo Category::find($category_id);
      return view('admin.categories.edit', [
        'category_info' => Category::find($category_id)
        // 'category_info' => Category::where('id','=',$category_id)->first()
        // 'category_info' => Category::where('id','=',$category_id)->first()
      ]);
    }
    function editCategoryPost(Request $request){
      // echo Category::find($category_id);
      // return view('admin.categories.edit', [
      //   'category_info' => Category::find($category_id)
      // ]);
      // print_r($request->all());
      $request->validate([
        'category_name' => 'required|unique:categories,category_name,' .$request->category_id,
        'category_photo' => 'required|image',
      ]);
      Category::find($request->category_id)->update([
        'category_name' => $request->category_name,
        'category_description' => $request->category_description
      ]);
      if($request->hasFile('category_photo')){
        if(Category::find($request->category_id)->category_photo != 'default.png'){
          $old_file_location = 'public/uploads/category_photos/' . Category::find($request->category_id)->category_photo;
          unlink(base_path($old_file_location));
        }
        $uploaded_photo = $request->file('category_photo');
        $new_image_name = $request->category_id . '.' . $uploaded_photo->getClientOriginalExtension();
        $new_file_location = 'public/uploads/category_photos/' . $new_image_name;
        Image::make($uploaded_photo)->save(base_path($new_file_location));
        Category::find($request->category_id)->update([
          'category_photo' => $new_image_name,
        ]);
      }
      return back()->with('edit_status', 'category edited successfully');
      return redirect('/add/category')->with('edit_status', 'category edited successfully');
    }
    function restoreCategory($category_id){
      Category::withTrashed()->find($category_id)->restore();
      // echo $category_id;
      return back();
    }
    function forceDeleteCategory($category_id){
      $category_id;
      Category::withTrashed()->find($category_id)->forceDelete();
      return back()->with('force_delete', 'Permanently Deleted');
    }
    function markTheDelete(Request $request){
      // print_r($request->all());
      if(isset($request->category_id)){
        foreach($request->category_id as $cad_id){
          Category::find($cad_id)->delete();
        }
      }else{
        return back()->with('no_marked', 'no items selected');
      }
      return back()->with('marked_deleted', 'Marked Items has been deleted');
    }
    function markRestoreCategory(Request $request){
      if(isset($request->category_id)){
        foreach($request->category_id as $cad_id){
          Category::withTrashed()->find($cad_id)->restore();
        }
      }
      return back()->with('marked_restore', 'Marked items successfully restored');
    }
}
