@extends('layouts.dashboard_app')
@section('products')
  active
@endsection
@section('dashboard_content')
  <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="index.html">Starlight</a>
      <a class="breadcrumb-item" href="index.html">Pages</a>
      <span class="breadcrumb-item active">Blank Page</span>
    </nav>

    <div class="sl-pagebody">
      <div class="sl-page-title">
        <h5>Dashboard</h5>
        <p>This is a dynamic dashboard</p>
      </div><!-- sl-page-title -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">Insert Data</div>
              <div class="card-body">
                <form action = "{{ route('product.update', $product_info->id) }}" method = "post" enctype = "multipart/form-data">
                  @csrf
                  @method('PATCH')
                  {{-- <div class="form-group">
                    <input type="hidden" class="form-control" placeholder = "category name" name="product_id" value = "{{ $product_info->id }}">
                    @error('product_name')
                      <span class = "text text-danger">{{ $message }}</span>
                    @enderror
                  </div> --}}
                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Name</label>
                    <input type="text" class="form-control" placeholder = "category name" name="product_name" value = "{{ $product_info->product_name }}">
                    @error('product_name')
                      <span class = "text text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Short Description</label>
                    <input type="text" class="form-control" placeholder = "product Short description" name="product_short_description" value = "{{ $product_info->product_short_description }}">
                    @error('product_short_description')
                      <span class = "text text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Long Description</label>
                    <input type="text" class="form-control" placeholder = "product Long description" name="product_long_description" value = "{{ $product_info->product_long_description }}">
                    @error('product_long_description')
                      <span class = "text text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Price</label>
                    <input type="number" class="form-control" placeholder = "product price" name="product_price" value = "{{ $product_info->product_price }}">
                    @error('product_price')
                      <span class = "text text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Quantity</label>
                    <input type="number" class="form-control" placeholder = "product Quantity" name="product_quantity" value = "{{ $product_info->product_quantity }}">
                    @error('product_quantity')
                      <span class = "text text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Alert Quantity</label>
                    <input type="text" class="form-control" placeholder = "Alert quantity" name="alert_quantity" value = "{{ $product_info->alert_quantity }}">
                    @error('alert_quantity')
                      <span class = "text text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Photo</label>
                    <input type="file" class="form-control" name="product_thumbnail_photo" value = "{{ old('product_photo') }}">
                    @error('product_photo')
                      <span class = "text text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Category</label>
                    <select class="form-control" name = "product_category_id">
                      <option value="no_category">-Select One-</option>
                      @forelse($active_categories as $category)
                        <option {{ ($category->id == $product_info->product_category_id) ? "selected":"" }} value="{{ $category->id }}">{{ $category->category_name }}</option>
                      @empty
                        <option value="No_category">No Items</option>
                      @endforelse
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
              </div>
            </div>

          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">Product Image</div>
              <div class="card-body">
                <img width = "200px" height = "300px" src="{{ asset('uploads/product_photos/product_thumbnail_photos') }}/{{ $product_info->product_thumbnail_photo }}" alt="{{ $product_info->product_thumbnail_photo }}">
              </div>
            </div>
          </div>
        </div>
      </div>
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
@endsection
