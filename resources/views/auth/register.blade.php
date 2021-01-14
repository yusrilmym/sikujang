@extends('layouts.auth')

@section('content')
<div class="card card-primary">
  <div class="card-header"><h4>Register</h4></div>

  <div class="card-body">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="nickname">Nama Panggilan</label>
            <input id="nickname" type="text" class="form-control{{ $errors->has('nickname') ? ' is-invalid' : '' }}" name="nickname" tabindex="1" placeholder="Nama Panggilan" value="{{ old('nickname') }}" autofocus>
            <div class="invalid-feedback">
                {{ $errors->first('nickname') }}
            </div>
        </div>
        <div class="form-group">
            <label for="fullname">Nama Lengkap</label>
            <input id="fullname" type="text" class="form-control{{ $errors->has('fullname') ? ' is-invalid' : '' }}" name="fullname" tabindex="1" placeholder="Nama lengkap beserta gelar" value="{{ old('fullname') }}" autofocus>
            <div class="invalid-feedback">
                {{ $errors->first('fullname') }}
            </div>
        </div>
        <div class="form-group">
            <label for="nip">NIP</label>
            <input id="nip" type="number" class="form-control{{ $errors->has('nip') ? ' is-invalid' : '' }}" name="nip" tabindex="1" placeholder="Nomor Induk Pegawai" value="{{ old('nip') }}" autofocus>
            <div class="invalid-feedback">
                {{ $errors->first('nip') }}
            </div>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email address" name="email" tabindex="1" value="{{ old('email') }}" autofocus>
            <div class="invalid-feedback">
            {{ $errors->first('email') }}
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="control-label">Password</label>
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" placeholder="Set account password" name="password" tabindex="2">
            <div class="invalid-feedback">
            {{ $errors->first('password') }}
            </div>
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="control-label">Confirm Password</label>
            <input id="password_confirmation" type="password" placeholder="Confirm account password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}" name="password_confirmation" tabindex="2">
            <div class="invalid-feedback">
            {{ $errors->first('password_confirmation') }}
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
            Register
            </button>
        </div>
    </form>
  </div>
</div>
<div class="mt-5 text-muted text-center">
 Already have an account? <a href="{{ route('login') }}">Sign In</a>
</div>
@endsection
