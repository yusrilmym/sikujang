<div class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        @can('isSuperAdmin')
        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
        @endcan
    </ul>

    @can('isSuperAdmin')
    <div class="search-element">
        <input class="form-control" name="query" type="search" @keyup="searchit" @keyup.enter="searchit" v-model="search" placeholder="Search" aria-label="Search" data-width="250"
        aria-autocomplete="both" aria-haspopup="false" autocomplete="off">
        <button class="btn" @click="searchit">
            <i class="fas fa-search"></i>
        </button>
        <div class="search-backdrop"></div>
        <search-comp/>
        {{-- @include('partials.searchhistory') --}}
    </div>
    @endcan
</div>
<ul class="navbar-nav navbar-right">
    <li class="dropdown">
        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user align-middle">
            {{-- <div class="d-sm-none d-lg-inline-block mr-2"> Hi, {{ Auth::user()->nickname }}</div>
            <i class="far fa-user-circle" style="font-size: 18pt; margin-right: 5px;"></i> --}}
            <user-avatar></user-avatar>
            {{-- <img alt="image" id="avatar" src='{{ asset('img/avatar/'.Auth::user()->photo ) }}' class=""> --}}
            {{-- <img alt="image" :src="getProfilePhoto()" class="rounded-circle border mr-1"> --}}
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-title">Akses : {{ Auth::user()->role }}</div>
            <router-link to="/profile" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
            </router-link>
            <router-link to="/activities" class="dropdown-item has-icon">
                <i class="fas fa-bolt"></i> My Activities
            </router-link>
            <router-link to="/settings" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
            </router-link>
            <div class="dropdown-divider"></div>

            <a class="dropdown-item has-icon text-danger" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>{{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </li>
</ul>
