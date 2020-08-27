@extends('layouts.dashboard_app')
@section('testimonial')
  active
@endsection
@section('dashboard_content')
  <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
      <a class="breadcrumb-item" href="{{ route('testimonial.index') }}">Testimonial</a>
      <span class="breadcrumb-item active">Create New</span>
    </nav>

    <div class="sl-pagebody">
      <div class="sl-page-title">
        <h5>Add Testimonial</h5>
        <p>Add new Testimonial item</p>
      </div><!-- sl-page-title -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card mt-5">
              <div class="card-header">Testimonial Insert</div>
              <div class="card-body">
                <form action = "{{ route('testimonial.store') }}" method = "post" enctype = "multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="exampleInputEmail1">Testimnial Title</label>
                    <input type="text" class="form-control" name = "testimonial_title" placeholder="testimonial title" value = "{{ old('testimonial_title') }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Testimonial Designation</label>
                    <input type="text" class="form-control" name = "testimonial_designation" value = "{{ old('testimonial_designation') }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Testimonial Description</label>
                    <textarea class="form-control" name="testimonial_description">{{ old('testimonial_description') }}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Testimonial Image</label>
                    <input type="file" class="form-control" name = "testimonial_image">
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
              </div>
            </div>

          </div>
        </div>
      </div>
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
@endsection
