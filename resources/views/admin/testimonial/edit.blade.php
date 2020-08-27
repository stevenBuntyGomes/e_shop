@extends('layouts.dashboard_app')
@section('testimonial')
  active
@endsection
@section('dashboard_content')
  <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
      <a class="breadcrumb-item" href="{{ route('testimonial.index') }}">Testimonial</a>
      <span class="breadcrumb-item active">Edit {{ $testimonial_edit->testimonial_title }}</span>
    </nav>

    <div class="sl-pagebody">
      <div class="sl-page-title">
        <h5>Dashboard</h5>
        <p>This is a dynamic dashboard</p>
      </div><!-- sl-page-title -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card mt-5">
              <div class="card-header">Testimonial Edit</div>
              <div class="card-body">
                <form action = "{{ route('testimonial.update', $testimonial_edit->id) }}" method = "post" enctype = "multipart/form-data">
                  @csrf
                  @method('PATCH')
                  <div class="form-group">
                    <label for="exampleInputEmail1">Testimnial Title</label>
                    <input type="text" class="form-control" name = "testimonial_title" placeholder="testimonial title" value = "{{ $testimonial_edit->testimonial_title }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Testimonial Designation</label>
                    <input type="text" class="form-control" name = "testimonial_designation" value = "{{ $testimonial_edit->testimonial_designation }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Testimonial Description</label>
                    <textarea class="form-control" name="testimonial_description">{{ $testimonial_edit->testimonial_description }}</textarea>
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
