{{-- @php
  error_reporting(0);
@endphp --}}
@extends('layouts.dashboard_app')
@section('my_title')
  Edit Profile
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
  <div class="container">
    <div class="row">
      <div class="col-md-8 m-auto">
        <div class="card">
          <div class="card-header card-header-default">Profile Edit</div>
          <div class="card-body">
            {{-- @if($errors->all())
              @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                  <p>{{ $error }}</p>
                </div>
              @endforeach
            @endif --}}
            @if(session('name_change_status'))
              <div class="alert alert-success">
                <p>{{ session('name_change_status') }}</p>
              </div>
            @endif
            <form action = "{{ url('/edit/profile/post') }}" method = "post">
              @csrf
              <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" name = "profile_name" value = "{{ Auth::user()->name }}">
                @error('profile_name')
                  <span class = "text text-danger">{{ $message }}</span>
                @enderror
              </div>
              <button type = "submit" class = "btn btn-primary">Change Name</button>
            </form>
          </div>
        </div>
        <div class="card mt-5">
          <div class="card-header card-header-default bg-info">Change Photo</div>
          <div class="card-body">
            @if(session('photo_changed'))
              <p class = "text text-success">{{ session('photo_changed') }}</p>
            @endif
            @if(session('no_photos_selected'))
              <p class = "text text-warning">{{ session('no_photos_selected') }}</p>
            @endif
            <form action = "{{ url('change/profile/photo') }}" method = "post" enctype = "multipart/form-data">
              @csrf
              <div class="form-group">
                <label for="exampleInputPassword1">Chang Photo</label>
                <input type="file" class="form-control" name = "change_photo" onchange = "readURL(this);">
                @error('change_photo')
                  <p class = "text text-danger">{{ $message }}</p>
                @enderror
              </div>
              <div class="form-group">
                {{-- <img src="{{ asset('uploads/profile_photos') }}/{{ $profile_photo }}" alt="{{ $profile_photo }}"><br> --}}
                <img class = "hidden" src="#" alt="#" id = "tenant_photo_viewer">
                <style media="screen">
                  .hidden{
                    display: none;
                  }
                </style>
                <script>
                  function readURL(input) {
                    if (input.files && input.files[0]) {
                      var reader = new FileReader();
                      reader.onload = function (e) {
                        $('#tenant_photo_viewer').attr('src', e.target.result).width(150).height(195);
                      };
                      $('#tenant_photo_viewer').removeClass('hidden');
                      reader.readAsDataURL(input.files[0]);
                    }
                  }
                </script>
              </div>
              <button type="submit" class="btn btn-primary">Chang Photo</button>
            </form>
          </div>
        </div>
        <div class="card mt-5">
          <div class="card-header card-header-default bg-purple">Change Password</div>
          <div class="card-body">
            {{-- @if($errors->all())
              @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                  <p>{{ $error }}</p>
                </div>
              @endforeach
            @endif
            @if(session('name_change_status'))
              <div class="alert alert-success">
                <p>{{ session('name_change_status') }}</p>
              </div>
            @endif --}}
            @if(session('matching'))
              <p class = "text text-danger">{{ session('matching') }}</p>
            @endif
            @if(session('mismatch'))
              <p class = "text text-danger">{{ session('mismatch') }}</p>
            @endif
            @if(session('password_changed'))
              <p class = "text text-success">{{ session('password_changed') }}</p>
            @endif
            <form action = "{{ url('/edit/password/post') }}" method = "post">
              @csrf
              <div class="form-group">
                <label for="exampleInputEmail1">Old Password</label>
                <input type = "password" class="form-control" name = "old_password">
                {{-- @error('old_password')
                  <span class = "text text-danger">{{ $message }}</span>
                @enderror --}}
                @if(session('old_pass_error'))
                  <p class = "text text-danger">{{ session('old_pass_error') }}</p>
                @endif
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">New Password</label>
                <input type="password" class="form-control" name = "password" id = "showPass">
                @error('password')
                  <span class = "text text-danger">{{ $message }}</span>
                @enderror
                <br>
                <a onclick = "showPassword()" class = "btn btn-info btn-sm text-white" >show</a>
                <script type="text/javascript">
                  function showPassword() {
                    var x = document.getElementById("showPass");
                    if (x.type === "password") {
                      x.type = "text";
                    } else {
                      x.type = "password";
                    }
                  }
                </script>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Confirm Password</label>
                <input type="password" class="form-control" name = "password_confirmation" id = "showPass">
                {{-- @error('confirm_password')
                  <span class = "text text-danger">{{ $message }}</span>
                @enderror --}}
              </div>
              <button type = "submit" class = "btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
@endsection
