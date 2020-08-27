@extends('layouts.auth_app')
@section('auth_content')
    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">

      <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">{{ env('APP_NAME') }}</div>
        <div class="tx-center mg-b-60">Web Application {{ __('LOGIN') }}</div>
        {{-- @if($errors->any())
          <div class="alert alert-danger">
            @foreach($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
        @endif --}}
        <form action="{{ route('login') }}" method="POST">
          @csrf
          <div class="form-group row">
            <label for="email" class="col-md-12 col-form-label">{{ __('E-Mail Address') }}</label>

            <div class="col-md-12">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
          </div>
          <div class="form-group row">
            <label for="password" class="col-md-12 col-form-label">{{ __('Password') }}</label>

            <div class="col-md-12">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="ckbox" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
          </div>
          <div class="form-group row mb-0">
            <div class="col-md-12 offset-md-4">
                <button type="submit" class="btn btn-info btn-block">
                    {{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
          </div>
        </form>

      <a href = "{{ url('login/github') }}" class = "btn btn-block btn-secondary text-white" style = "cursor: pointer"><i class = "fa fa-github"></i> LogIn with GutHub</a>
        <button class = "btn btn-block btn-danger" type = "button"><i class = "fa fa-google"></i> LogIn with Google</button>
        <div class="mg-t-60 tx-center">Not yet a member? <a href="{{ route('register') }}" class="tx-info">{{ __('Register') }}</a></div>
      </div><!-- login-wrapper -->
    </div><!-- d-flex -->
@endsection
