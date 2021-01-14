@extends('layouts.auth')

@section('content')
<div class="card card-success">
    <div class="card-header"><h4>Login</h4></div>

    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- TAMPILKAN NOTIF JIKA GAGAL LOGIN  -->
            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="form-group">
                <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                    <i class="fas fa-user"></i>
                    </div>
                </div>
                <input aria-describedby="emailHelpBlock" id="nip" type="text" class="form-control{{ $errors->has('nip') ? ' is-invalid' : '' }}" name="nip" placeholder="Input NIP atau Email" tabindex="1" value="{{ old('nip') }}" autofocus>
                </div>
                <div class="invalid-feedback">
                {{ $errors->first('nip') }}
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                    <i class="fas fa-lock"></i>
                    </div>
                </div>
                <input aria-describedby="passwordHelpBlock" id="password" type="password" placeholder="Your account password" class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" name="password" tabindex="2">
                </div>
                <div class="invalid-feedback">
                {{ $errors->first('password') }}
                </div>
            </div>

            <div class="form-group" >
                <div class="custom-control custom-checkbox">
                <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember"{{ old('remember') ? ' checked': '' }}>
                <label class="custom-control-label" for="remember" style="color: black">Remember Me</label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success btn-lg btn-block" tabindex="4">
                Login
                </button>
            </div>
        </form>
    </div>
</div>
<div class="mt-5 text-muted text-center">
  Don't have an account? <a href="{{ route('register') }}">Create One</a>
</div>
@endsection
