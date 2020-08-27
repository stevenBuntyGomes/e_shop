@extends('layouts.dashboard_app')
@section('slider')
  active
@endsection
@section('dashboard_content')
  <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
      <a class="breadcrumb-item" href="{{ route('slider.index') }}">Slider</a>
      <span class="breadcrumb-item active">Slider Edit</span>
    </nav>

    <div class="sl-pagebody">
      <div class="sl-page-title">
        <h5>Slider</h5>
        <p>Slider Dashboard Contents</p>
      </div><!-- sl-page-title -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card mt-5">
              <div class="card-header">Slider Form</div>
              <div class="card-body">
                <form action = "{{ route('slider.update', $active_slider->id) }}" method = "post" enctype = "multipart/form-data">
                  @csrf
                  @method('PATCH')
                  {{-- <div class="form-group">
                    <label for="exampleInputEmail1">Slider ID</label>
                    <input type="text" class="form-control" name = "slider_id" placeholder = "slider header" value = "{{ $active_slider->id }}">
                  </div> --}}
                  <div class="form-group">
                    <label for="exampleInputEmail1">Slider Header</label>
                    <input type="text" class="form-control" name = "slider_header" placeholder = "slider header" value = "{{ $active_slider->slider_header }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Slider Description</label>
                    <textarea class = "form-control" name = "slider_description" rows="8" cols="80">{{ $active_slider->slider_description }}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Slider Button</label>
                    <input class="form-control" type="text" name = "slider_button" placeholder="slider Button" value = "{{ $active_slider->slider_button }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Slider Link</label>
                    <input class="form-control" type="text" name = "slider_link" placeholder="slider Link" value = "{{ $active_slider->slider_link }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Slider Image</label>
                    <input class="form-control" type="file" name = "slider_image" placeholder="slider Image">
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
