@extends('layouts.skeleton')


@section('app')

<div class="main-wrapper">
    <div class="navbar-bg"></div>
    <nav class="navbar navbar-expand-lg main-navbar">
      @include('partials.topnav')
    </nav>
    <div class="main-sidebar">
      {{-- @include('partials.sidebar') --}}
      <sidebar-menu></sidebar-menu>
    </div>

    {{-- style="height: auto !important" --}}
    <!-- Main Content -->
    <div class="main-content" style="height: auto !important; min-heigt: 700px !important">

            {{-- @yield('content') --}}
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>

    </div>
    <footer class="main-footer">
      @include('partials.footer')
    </footer>
  </div>
@endsection
