@extends('layouts.dashboard_app')
@section('slider')
  active
@endsection
@section('dashboard_content')
  <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
      <a class="breadcrumb-item" href="{{ route('slider.index') }}">Slider</a>
    </nav>

    <div class="sl-pagebody">
      <div class="sl-page-title">
        <h5>Slider</h5>
        <p>Slider Dashboard Contents</p>
      </div><!-- sl-page-title -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <a href="{{ route('slider.create') }}" class = "btn btn-info">Add New Slider</a>
            <div class="card mt-5">

              <div class="card-header">Slider Table</div>
              <div class="card-body">
                <form action="{{ route('markDelSlider') }}" method="post">
                  <table class="table table-dark" id = "data_table">
                    <thead>
                      <tr>
                        <th scope="col">Mark</th>
                        <th scope="col">ID</th>
                        <th scope="col">Header</th>
                        <th scope="col">Description</th>
                        <th scope="col">Button</th>
                        <th scope="col">Link</th>
                        <th scope="col">image</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($active_sliders as $slider)
                        <tr>
                          <th scope="row">
                            <input type="checkbox" name="slider_id[]" value="{{ $slider->id }}">
                          </th>
                          <th scope="row">{{ $slider->id }}</th>
                          <td>{{ $slider->slider_header }}</td>
                          <td>{{ $slider->slider_description }}</td>
                          <td>{{ $slider->slider_button }}</td>
                          <td>{{ $slider->slider_link }}</td>
                          <td><img width = "100px" height = "80px" src="{{ asset('uploads/slider_images/') }}/{{ $slider->slider_image }}" alt="{{ $slider->slider_image }}"></td>
                          <td><a href="{{ route('slider.edit', $slider->id) }}" class = "btn btn-info">Edit</a></td>
                          <td>
                            <form action="{{ route('slider.destroy', $slider->id) }}" method="post">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class = "btn btn-danger">Delete</button>
                            </form>
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan = "50" class = "text-center">no files in the directory</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                  @if($active_sliders->count() > 0)
                    <button type="submit" class="btn btn-danger">Mark Delete</button>
                  @endif
                </form>

              </div>
            </div>
            <div class="card mt-5">
              <div class="card-header">Deleted Slider Table</div>
              <div class="card-body">
                <table class="table table-dark">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Header</th>
                      <th scope="col">Description</th>
                      <th scope="col">Button</th>
                      <th scope="col">Link</th>
                      <th scope="col">image</th>
                      <th scope="col">Edit</th>
                      <th scope="col">Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($deleted_sliders as $slider)
                      <tr>
                        <th scope="row">{{ $slider->id }}</th>
                        <td>{{ $slider->slider_header }}</td>
                        <td>{{ $slider->slider_description }}</td>
                        <td>{{ $slider->slider_button }}</td>
                        <td>{{ $slider->slider_link }}</td>
                        <td><img width = "100px" height = "80px" src="{{ asset('uploads/slider_images/') }}/{{ $slider->slider_image }}" alt="{{ $slider->slider_image }}"></td>
                        <td><a class = "btn btn-success" href="{{ route('sliderRestore', $slider->id) }}">Restore</a></td>
                        <td><a class = "btn btn-danger" href="{{ route('permDel', $slider->id) }}">F.D.</a></td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan = "50" class = "text-center">no files in the directory</td>
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
@section('footer_script')
  <script type="text/javascript">
  $(document).ready(function() {
  $('#data_table').DataTable({
    "lengthMenu": [2, 3, 4, 5]
  });
  } );
  </script>
@endsection
