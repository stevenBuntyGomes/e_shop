@extends('layouts.dashboard_app')
@section('category')
  active
@endsection
@section('dashboard_content')
  <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ url('/home') }}">Home</a>
      <a class="breadcrumb-item" href="{{ route('category') }}">Category</a>
      <span class="breadcrumb-item active">{{ $category_info->category_name }}</span>
    </nav>

    <div class="sl-pagebody">
      <div class="sl-page-title">
        <h5>Dashboard</h5>
        <p>This is a dynamic dashboard</p>
      </div><!-- sl-page-title -->
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <div class="card">

              <div class="card-header">Category Edit</div>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ url('/add/category') }}">{{ $category_info->category_name }}</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Library</li>
                </ol>
              </nav>
              <div class="card-body">
                @if($errors->all())
                  <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </div>
                @endif
                <form method = "post" action = "{{ route('editCategoryPost') }}" enctype = "multipart/form-data">
                  @csrf
                  <div class = "form-group">
                    <input type="hidden" class="form-control" placeholder = "category Id" name="category_id" value = "{{ $category_info->id }}">
                    @error('category_id')
                      <span class = "text text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class = "form-group">
                    <label for="exampleInputEmail1">Category Name</label>
                    <input type="text" class="form-control" placeholder = "category name" name="category_name" value = "{{ $category_info->category_name }}">
                    @error('category_name')
                      <span class = "text text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Category Description</label>
                    <textarea class="form-control" placeholder = "category description" name="category_description">{{ $category_info->category_description }}</textarea>
                    @error('category_description')
                      <span class = "text text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class = "form-group">
                    <label for="exampleInputEmail1">Category Photo</label>
                    <input type="file" class="form-control" placeholder = "category name" name="category_photo">
                    @error('category_name')
                      <span class = "text text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <button type="submit" class = "btn btn-primary">Add Category</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">Profile Image</div>
              <div class="card-body">
                <img class = "img-fluid" src="{{ asset('uploads/category_photos') }}/{{ $category_info->category_photo }}" alt="{{ $category_info->category_photo }}">
              </div>
            </div>
          </div>
        </div>
      </div>
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->

@endsection
