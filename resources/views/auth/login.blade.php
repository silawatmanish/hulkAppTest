@extends('layouts.login_layout')

@section('content')


<div class="auth-form-light text-left p-5">
    <div class="brand-logo">
      <img src="{{ asset('assets/images/logo.svg') }}">
    </div>
    <h4>Hello! let's get started</h4>
    <h6 class="font-weight-light">Sign in to continue.</h6>

    <form method="POST" action="{{ route('login') }}">
            @csrf

      <div class="form-group">
        
        <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Username" autofocus>

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror


      </div>
      <div class="form-group">

        <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror


      </div>
      <div class="mt-3">

        <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" >SIGN IN</button>
      </div>
      <div class="my-2 d-flex justify-content-between align-items-center">
        
        <div class="form-check">
          <label class="form-check-label text-muted">

            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Keep me signed in <i class="input-helper"></i>
        </label>

        </div>



        @if (Route::has('password.request'))
            {{-- <a class="auth-link text-black" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a> --}}
        @endif

      </div>
      {{-- <div class="mb-2">
        <button type="button" class="btn btn-block btn-facebook auth-form-btn">
          <i class="mdi mdi-facebook me-2"></i>Connect using facebook </button>
      </div> --}}
      <div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="{{ route('register') }}" class="text-primary">Create</a>
      </div>
    </form>

  </div>




@endsection
