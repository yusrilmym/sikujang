<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  {{-- <title>Login &mdash; {{ env('APP_NAME') }}</title> --}}
  <link rel="icon" type="image/png" href='{{ asset('img/favicon.png') }}'>
  <title>Login &mdash; SiKujang</title>
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body>
    <div id="app">
        <section class="section">
        <div class="d-flex flex-wrap align-items-stretch" style="margin-top: 0 !important">
            <div class="row" >
            <div class="col-lg-4 col-md-12 col-sm-12 col-12 order-lg-1 order-1 bg-white" style="height: auto">
                <div class="p-4 m-3">
                    <!-- <img src="{{ asset('/img/sikujang-logo.svg') }}" alt="logo" width="110" class="mb-2 mt-3"> -->
                    <h4 class="text-dark font-weight-normal">Welcome to <span class="font-weight-bold">SiCepot</span></h4>
                    <p class="text-muted">Before you get started, you must login to continue.</p>
                    @if(session()->has('info'))
                    <div class="alert alert-success">
                        {{ session()->get('info') }}
                    </div>
                    @endif
                    @if(session()->has('status'))
                    <div class="alert alert-info">
                        {{ session()->get('status') }}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                    @csrf

                    @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="form-group">
                        <label for="email">Masukan NIP</label>
                        <input aria-describedby="emailHelpBlock" id="nip" type="text" class="form-control{{ $errors->has('nip') ? ' is-invalid' : '' }}" name="nip" placeholder="Input NIP" tabindex="1" value="{{ old('nip') }}" autofocus>
                        <div class="invalid-feedback">
                        {{ $errors->first('nip') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="d-block">
                        <label for="password" class="control-label">Masukan Password</label>
                        </div>
                        <input aria-describedby="passwordHelpBlock" id="password" type="password" placeholder="Your account password" class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" name="password" tabindex="2">
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

                    <div class="form-group text-right">
                        {{-- <a href="auth-forgot-password.html" class="float-left mt-3">
                        Forgot Password?
                        </a> --}}
                        <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                        Login
                        </button>
                    </div>

                    <div class="mt-5 text-muted text-center">
                        Klik disini untuk pertanyaan<br><a href="https://wa.me/6285785311433/?text=Saya%20ingin%20bertanya%20tentang%20Sicepot%20">Whatsapp</a>
                    </div>
                    </form>

                    <div class="text-center mt-3 mb-3 text-small">
                    Copyright &copy; IT System Development, {{ date('Y') }}
                    {{-- <div class="mt-2">
                        <a href="#">Privacy Policy</a>
                        <div class="bullet"></div>
                        <a href="#">Terms of Service</a>
                    </div> --}}
                    </div>
                </div>
            </div>
                <div class="col-lg-8 col-md-12 col-sm-12 order-lg-2 order-2 background-walk-x position-relative overlay-gradient-bottom" data-background="{{ asset('/img/login-bg.jpg') }}" style="height: 100vh; background-size: cover">
                    <div class="absolute-bottom-left index-2">
                        <div class="text-light p-5 pb-2">
                        <greeting-comp></greeting-comp>
                        {{-- Photo by <a class="text-light bb" target="_blank" href="https://unsplash.com/photos/a8lTjWJJgLA">Justin Kauffman</a> on <a class="text-light bb" target="_blank" href="https://unsplash.com">Unsplash</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
    </div>

    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        // $(function() {
        //     $("html").getNiceScroll().resize();
        //     $("html").niceScroll();
        // });
    </script>
</body>
</html>
<style>
  html{
      overflow-y: auto;
      overflow-x: hidden
  }
  /* body, html{
      height: 100vh !important;
  } */
</style>
