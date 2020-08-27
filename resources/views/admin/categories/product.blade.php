@extends('layouts.dashboard_app')
@section('category')
  active
@endsection
@section('dashboard_content')
  <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ url('/home') }}">Home</a>
      <span class="breadcrumb-item active">Category</span>
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
                <div class="card-header card-header-default bg-indigo">Category Table</div>
                <div class="card-body" style = "overflow-x: scroll;">
                  <form action = "{{ route('markTheDelete') }}" method="post">
                    @csrf
                    <table class="table display responsive nowrap dataTable no-footer dtr-inline" id = "data_table">
                      @if(session('delete_status'))
                        <div class = "alert alert-danger">
                          <p> {{ session('delete_status') }} </p>
                        </div>
                      @endif
                      @if(session('marked_deleted'))
                        <div class = "alert alert-danger">
                          <p> {{ session('marked_deleted') }} </p>
                        </div>
                      @endif
                      @if(session('no_marked'))
                        <div class = "alert alert-warning">
                          <p> {{ session('no_marked') }} </p>
                        </div>
                      @endif
                      <thead>
                        <tr>
                          <th scope="col">Mark</th>
                          <th scope="col">Category Serial</th>
                          <th scope="col">Category Id</th>
                          <th scope="col">Category Name</th>
                          <th scope="col">Description</th>
                          <th scope="col">Created By</th>
                          {{-- <th scope="col">Created At</th> --}}
                          <th scope="col">Last Update</th>
                          <th scope="col">Image</th>
                          <th scope="col">Edit</th>
                          <th scope="col">Delete</th>
                        </tr>
                      </thead>
                      <tbody>
                          @forelse($categories as $category)
                          <tr>
                            <td>
                              <input type="checkbox" name="category_id[]" value="{{ $category->id }}">
                            </td>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td>{{ $category->category_description }}</td>
                            <td>{{ App\User::find($category->user_id)->name }}</td>
                            <td><img src="{{ asset('uploads/category_photos') }}/{{ $category->category_photo }}" alt="" width = "50px" height = "50px"></td>
                            {{-- <td>{{ $category->created_at->timezone('Asia/Dhaka')->format('d/m/Y h:i:s A') }}</td> --}}
                            <td>
                              @isset($category->updated_at)
                                {{ $category->updated_at->diffForHumans() }}
                              @endisset
                            </td>
                            <td><a href = "{{  url('/edit/category') }}/{{ $category->id }}" class = "btn btn-info" name = "button">Edit</a></td>
                            <td><a href = "{{  route('deleteCategory', $category->id) }}" class = "btn btn-danger" name = "button">Delete</a></td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan = "50" class = "text-center text-danger">No data available</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>

                    @if($categories->count() > 0)
                      <button type="submit" class = "btn btn-danger btn-sm">Mark As Deleted</button>
                    @endif
                  </form>


                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-header">Header</div>
                <div class="card-body">
                  @if(session('success_status'))
                    <div class="alert alert-success">
                      <p>{{ session('success_status') }}</p>
                    </div>
                  @endif
                  @if(session('edit_status'))
                    <div class="alert alert-success">
                      <p>Category Edited Successfully</p>
                    </div>
                  @endif
                  @if($errors->all())
                    @foreach($errors->all() as $error)
                      <div class="alert alert-danger">
                        <p>{{
                          $error
                        }}</p>
                      </div>
                    @endforeach
                  @endif
                  <form method = "post" action = " {{ route('addcategoryPost') }}" enctype = "multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="exampleInputEmail1">Category Name</label>
                      <input type="text" class="form-control" placeholder = "category name" name="category_name" value = "{{ old('category_name') }}">
                      @error('category_name')
                        <span class = "text text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Category Image</label>
                      <input type="file" class="form-control" placeholder = "category name" name="category_photo" value = "{{ old('category_name') }}">
                      @error('category_photo')
                        <span class = "text text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Category Description</label>
                      <textarea class="form-control" placeholder = "category description" name="category_description">{{ old('category_description') }}</textarea>
                      @error('category_description')
                        <span class = "text text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <button type="submit" class = "btn btn-primary">Add Category</button>
                  </form>
                </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <div class="card mt-5">
            <div class="card-header card-header-default bg-indigo">Category Table</div>
            <div class="card-body">

              <form action="{{ route('markRestoreCategory') }}" method="post">
                @csrf
                <table class="table table-dark">
                  @if(session('force_delete'))
                    <div class="alert alert-danger">
                      <p>{{ session('force_delete') }}</p>
                    </div>
                  @endif
                  @if(session('marked_restore'))
                    <div class="alert alert-success">
                      <p>{{ session('marked_restore') }}</p>
                    </div>
                  @endif
                  <thead>
                    <tr>
                      <th>Mark</th>
                      <th scope="col">Category Serial</th>
                      <th scope="col">Category Id</th>
                      <th scope="col">Category Name</th>
                      <th scope="col">Description</th>
                      <th scope="col">Created By</th>
                      <th scope="col">Created At</th>
                      {{-- <th scope="col">Edit</th> --}}
                      <th scope="col">Restore</th>
                      <th scope="col">Force Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($deleted_categories as $soft_del)
                      <tr>
                        <td>
                          <input type="checkbox" name="category_id[]" value="{{ $soft_del->id }}">
                        </td>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $soft_del->id }}</td>
                        <td>{{ $soft_del->category_name }}</td>
                        <td>{{ $soft_del->category_description }}</td>
                        <td>{{ App\User::find($soft_del->user_id)->name }}</td>
                        <td>{{ $soft_del->created_at->timezone('Asia/Dhaka')->format('d/m/Y h:i:s A') }}</td>
                        {{-- <td><a href = "{{  url('/edit/category') }}/{{ $soft_del->id }}" class = "btn btn-info" name = "button">Edit</a></td> --}}
                        <td><a href = "{{  route('restoreCategory', $soft_del->id) }}" class = "btn btn-success" name = "button">Restore</a></td>
                        <td><a href = "{{  route('forceDeleteCategory', $soft_del->id) }}" class = "btn btn-danger" name = "button">F Delete</a></td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan = "50" class = "text-center text-danger">No data available</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
                @if($deleted_categories->count() > 0)
                  <button type="submit" class = "btn btn-success btn-sm">Mark Restore</button>
                @endif
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
    "lengthMenu": [2, 3, 4, 5]
  });
  } );
  </script>
@endsection
