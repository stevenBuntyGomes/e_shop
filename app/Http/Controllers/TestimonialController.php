<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Testimonial;
use Carbon\Carbon;
use Image;

class TestimonialController extends Controller
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
        return view('admin.testimonial.index', [
          'active_testimonials' => Testimonial::all(),
          'deleted_testimonial' => Testimonial::onlyTrashed()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $testimonial_id = Testimonial::insertGetId($request->except('_token', 'testimonial_image') + [
        'created_at' => Carbon::now(),
      ]);
      if($request->hasFile('testimonial_image')){
        if(Testimonial::find($testimonial_id)->testimonial_image != 'default.png'){
          $old_file_location = 'pbulic/uploads/testimonial_images/' . Testimonial::find($testimonial_id)->testimonial_image;
          unlink(base_path($old_file_location));
        }
        $uploaded_file = $request->file('testimonial_image');
        $new_image_name = $testimonial_id . '.' . $uploaded_file->getClientOriginalExtension();
        $new_file_location = 'public/uploads/testimonial_images/' . $new_image_name;
        Image::make($uploaded_file)->save(base_path($new_file_location));
        Testimonial::find($testimonial_id)->update([
          'testimonial_image' => $new_image_name,
        ]);
      }
      return redirect('testimonial');
    }

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
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonial.edit', [
          'testimonial_edit' => $testimonial,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $testimonial->update($request->except('_token', '_method', 'testimonial_image'));
        if($request->hasFile('testimonial_image')){
          if($testimonial->testimonial_image != 'default.png'){
            $old_file_location = 'public/uploads/testimonial_images/' . $testimonial->testimonial_image;
            unlink(base_path($old_file_location));
          }
          $uploaded_file = $request->file('testimonial_image');
          $new_image_name = $testimonial->id . '.' . $uploaded_file->getClientOriginalExtension();
          $new_file_location = 'public/uploads/testimonial_images/' . $new_image_name;
          Image::make($uploaded_file)->save(base_path($new_file_location));
          $testimonial->update([
            'testimonial_image' => $new_image_name,
          ]);
        }
        return redirect('testimonial');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Testimonial $testimonial)
    {
      $testimonial->delete();
      return back();
    }
    public function restoreTesti($testi_id){
      Testimonial::withTrashed()->find($testi_id)->restore();
      return back();
    }
    public function forceDelTesti($testi_id){
      Testimonial::withTrashed()->find($testi_id)->forceDelete();
      return back();
    }
}
