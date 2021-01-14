<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  {{-- <title>@yield('title') &mdash; {{ env('APP_NAME') }}</title> --}}
  <title>{{ env('APP_NAME') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" href='{{ asset('img/favicon.png') }}'>
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  @stack('stylesheet')
</head>

<body>
<div id="app">
    @yield('app')
</div>


@auth
<script>
window.user = @json(auth()->user())
</script>
@endauth
<script>
    window.asset = '{{ asset('') }}';
</script>

<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
@stack('javascript')

</body>
</html>
