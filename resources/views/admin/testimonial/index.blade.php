@extends('layouts.dashboard_app')
@section('testimonial')
  active
@endsection
@section('dashboard_content')
  <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
      <a class="breadcrumb-item" href="{{ route('testimonial.index') }}">Testimonial</a>
    </nav>

    <div class="sl-pagebody">
      <div class="sl-page-title">
        <h5>Testimonial</h5>
        <p>This is Testimonial Index Page</p>
      </div><!-- sl-page-title -->
      <div class="container-fluid"
        <div class="row">
          <div class="col-md-12">
            <a href="{{ route('testimonial.create') }}" class = "btn btn-info">Add Testimonial</a>
            <div class="card mt-5">
              <div class="card-header">Testimonial Table</div>
              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Id</th>
                      <th scope="col">Title</th>
                      <th scope="col">Designation</th>
                      <th scope="col">Description</th>
                      <th scope="col">Image</th>
                      <th scope="col">Edit</th>
                      <th scope="col">Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($active_testimonials as $testimonial)
                    <tr>
                      <th scope="row">{{ $testimonial->id }}</th>
                      <td>{{ $testimonial->testimonial_title }}</td>
                      <td>{{ $testimonial->testimonial_designation }}</td>
                      <td>{{ $testimonial->testimonial_description }}</td>
                      <td><img width = "80px" height = "80px" src="{{ asset('uploads/testimonial_images') }}/{{ $testimonial->testimonial_image }}" alt="{{ $testimonial->testimonial_image }}"></td>
                      <td><a href="{{route('testimonial.edit', $testimonial->id) }}" class = "btn btn-info">Edit</a></td>
                      <td>
                        <form action="{{ route('testimonial.destroy', $testimonial->id) }}" method="post">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class = "btn btn-danger">Delete</button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="50" class = "text-center text-red">No Items</td>
                    </tr>
                  @endforelse
                  </tbody>
                </table>

              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="card mt-5">
              <div class="card-header">Deleted Testimonial Table</div>
              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Id</th>
                      <th scope="col">Title</th>
                      <th scope="col">Designation</th>
                      <th scope="col">Description</th>
                      <th scope="col">Image</th>
                      <th scope="col">Edit</th>
                      <th scope="col">Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($deleted_testimonial as $testimonial)
                    <tr>
                      <th scope="row">{{ $testimonial->id }}</th>
                      <td>{{ $testimonial->testimonial_title }}</td>
                      <td>{{ $testimonial->testimonial_designation }}</td>
                      <td>{{ $testimonial->testimonial_description }}</td>
                      <td><img width = "80px" height = "80px" src="{{ asset('uploads/testimonial_images') }}/{{ $testimonial->testimonial_image }}" alt="{{ $testimonial->testimonial_image }}"></td>
                      <td><a href="{{ route('restoreTesti', $testimonial->id) }}" class = "btn btn-success">Restore</a></td>
                      <td><a href="{{ route('forceDel', $testimonial->id) }}" class = "btn btn-danger">F.D.</a></td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="50" class = "text-center text-red">No Items</td>
                    </tr>
                  @endforelse
                  </tbody>
                </table>

              </div>
            </div>
          </div>
        </div>
      </div>
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
@endsection
