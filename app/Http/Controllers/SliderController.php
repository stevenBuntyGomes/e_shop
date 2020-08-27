<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use Carbon\Carbon;
use Image;

class SliderController extends Controller
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
        return view('admin.slider.index', [
          'active_sliders' => Slider::all(),
          'deleted_sliders' => Slider::onlyTrashed()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $slider_id = Slider::insertGetId($request->except('_token', 'slider_image') + [
        'created_at' => Carbon::now(),
      ]);
      if($request->hasFile('slider_image')){
        if(Slider::find($slider_id)->slider_image != 'default.png'){
          $old_image_location = 'public/uploads/slider_images/' . Slider::find($slider_id)->slider_image;
          unlink(base_path($old_image_location));
        }
        $uploaded_file = $request->file('slider_image');
        $new_image_name = $slider_id . '.' . $uploaded_file->getClientOriginalExtension();
        $new_file_location = 'public/uploads/slider_images/' . $new_image_name;
        Image::make($uploaded_file)->resize(1920, 1000)->save(base_path($new_file_location));
        Slider::find($slider_id)->update([
          'slider_image' => $new_image_name,
        ]);
      }
      return redirect('slider');
    }


//     'slider_header' => $request->slider_header,
//     'slider_description' => $request->slider_button,
//     'slider_link' => $request->slider_link,
//     'slider_link' => $request->slider_link,
//
// slider_image
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', [
          'active_slider' => $slider,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $slider->update($request->except('_token', '_method', 'slider_image'));
        if($request->hasFile('slider_image')){
          if($slider->slider_image != 'default.png'){
            $old_image_location = 'public/uploads/slider_images/' . $slider->slider_image;
            unlink(base_path($old_image_location));
          }
          $uploaded_file = $request->file('slider_image');
          $new_image_name = $slider->id . '.' . $uploaded_file->getClientOriginalExtension();
          $new_file_location = 'public/uploads/slider_images/' . $new_image_name;
          Image::make($uploaded_file)->resize(1920, 1000)->save(base_path($new_file_location));
          $slider->update([
            'slider_image' => $new_image_name,
          ]);
        }
        return redirect('slider');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
      $slider->delete();
      return back();
    }
    public function restore($slider_id){
      Slider::withTrashed()->find($slider_id)->restore();
      // Slider::withTrashed()->find($slider_id)->restore();
      return back();
    }
    public function forceDelete($slider_id){
      Slider::withTrashed()->find($slider_id)->forceDelete();
      return back();
    }
    public function markDelete(Request $request){
      if(isset($request->slider_id)){
        foreach($request->slider_id as $slider){
          echo $slider . '<br>';
        }
      }
    }
}
