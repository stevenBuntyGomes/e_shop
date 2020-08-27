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
        <h5>Products</h5>
        <p>Product Items</p>
      </div><!-- sl-page-title -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">Product Table</div>
              <div class="card-body">
                <table class="table table-responsive" id = "data_table">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">product_name</th>
                      <th scope="col">Quantity</th>
                      <th scope="col">ALert Q</th>
                      <th scope="col">Product Category</th>
                      <th scope="col">product_short_description</th>
                      <th scope="col">product_price</th>
                      <th scope="col">Full View</th>
                      <th scope="col">Edit</th>
                      <th scope="col">Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($products as $product)
                    <tr class = "{{ ($product->product_quantity <= $product->alert_quantity ) ? 'bg-warning' : '' }}">

                        <td>{{ $product->id }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->product_quantity }}</td>
                        <td>{{ $product->alert_quantity }}</td>
                        <td>
                          @php
                            if(isset($product->oneToOneRelationCategory->id)){
                              echo $product->oneToOneRelationCategory->category_name;
                            }else{
                              echo "Category Deleted";
                            }
                          @endphp
                        </td>
                        <td><img width = "80px" height = "80px" src="{{ asset('uploads/product_photos/product_thumbnail_photos') }}/{{ $product->product_thumbnail_photo }}" alt=""></td>
                        <td>{{ $product->product_price }}</td>
                        <td><a class = "btn btn-sm btn-success" href="{{ route('product.show', $product->id) }}">Full View</a></td>
                        <td><a class = "btn btn-sm btn-info" href="{{ route('product.edit', $product->id) }}">Edit</a></td>
                        <td>
                          <form action="{{ route('product.destroy', $product->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class = "btn btn-sm btn-danger">Delete</button>
                          </form>
                        </td>

                    </tr>
                    @empty
                      <tr>
                        <td colspan="50">no items</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">Insert Data</div>
              <div class="card-body">
                <form action = "{{ route('product.store') }}" method = "post" enctype = "multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Name</label>
                    <input type="text" class="form-control" placeholder = "product name" name="product_name" value = "{{ old('product_name') }}">
                    @error('product_name')
                      <span class = "text text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Short Description</label>
                    <textarea id = "ckEditor" class = "form-control" name="product_short_description" cols="80">{{ old('product_short_description') }}</textarea>
                    @error('product_short_description')
                      <span class = "text text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Long Description</label>
                    <textarea id = "ckEditor" class = "form-control" name="product_long_description" cols="80">{{ old('product_long_description') }}</textarea>
                    @error('product_long_description')
                      <span class = "text text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Price</label>
                    <input type="number" class="form-control" placeholder = "product price" name="product_price" value = "{{ old('product_price') }}">
                    @error('product_price')
                      <span class = "text text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Quantity</label>
                    <input type="number" class="form-control" placeholder = "product Quantity" name="product_quantity" value = "{{ old('product_quantity') }}">
                    @error('product_quantity')
                      <span class = "text text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Alert Quantity</label>
                    <input type="text" class="form-control" placeholder = "Alert quantity" name="alert_quantity" value = "{{ old('alert_quantity') }}">
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
                    <label for="exampleInputEmail1">Product Multiple Photo</label>
                    <input type="file" class="form-control" name="product_multiple_photo[]" value = "{{ old('product_photo') }}" multiple>
                    @error('product_photo')
                      <span class = "text text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Category</label>
                    <select class="form-control" name = "product_category_id">
                      <option value="no_category">-Select One-</option>
                      @forelse($active_categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
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
        </div>
      </div>
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
@endsection
@section('footer_script')
  <script type="text/javascript">
  $(document).ready(function() {
  $('#data_table').DataTable({
    "lengthMenu": [4, 5]
  });
  } );
  </script>
@endsection
@section('ckEditor')
  <script>
        ClassicEditor
            .create( document.querySelector( '#ckEditor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endsection
