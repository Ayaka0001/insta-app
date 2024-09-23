<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        {{-- search bar --}}
                        @if(!request()->is('admin/*')) <!-- if not admin -->
                            @auth <!-- if the user is logged in --> 
                                <form action="{{ route('home') }}" method="get">
                                    {{-- no csrf. set the page you want the search results to show. set to get to be able to see what you searched for --}}
                                    {{-- in controller set the variable for search,and for home page, we are going to only show the searched post w/title saying what we searched for, so make an if statement saying what to show --}}
                                    {{-- we dont need @csrf b/c we are not changing anything in the database --}}
                                    <input type="text" name="search" placeholder="Search..." class="form-control form-control-sm">
                                </form>
                            @endauth
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            {{-- HOME --}}
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link">
                                    <i class="fa-solid fa-house text-dark icon-sm"></i>
                                </a>
                            </li>
                            {{-- CREATE POST --}}
                            <li class="nav-item">
                                <a href="{{ route('post.create') }}" class="nav-link">
                                    <i class="fa-solid fa-circle-plus text-dark icon-sm"></i>
                                </a>
                            </li>

                            {{-- DROPDOWN --}}
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @if(Auth::user()->avatar)
                                        <img src="{{Auth::user()->avatar}}" alt="" class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-dark icon-sm"></i>
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    {{-- admin --}}
                                    {{-- to use the gate, we use @can('name of the gate') --}}
                                    @can('admin') {{--if the gate 'admin' returns true show the items below --}}
                                        <a href="{{route('admin.users')}}" class="dropdown-item">
                                            <i class="fa-solid fa-user-gear"></i> Admin
                                        </a>

                                    <hr class="dropdown-divider">
                                    @endcan

                                    {{-- profile --}}
                                    <a href="{{route('profile.show', Auth::user()->id)}}" class="dropdown-item">
                                        <i class="fa-solid fa-circle-user"></i> Profile
                                    </a>
                                    {{-- logout --}}
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa-solid fa-right-from-bracket"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    @if(request()->is('admin/*')) {{--if we are in the admin pages--}}
                        {{-- looks at the address and sees if the address starts with "admin/~~"" --}}
                        <div class="col-3">
                            <div class="list-group">
                                <a href="{{route('admin.users')}}" class="list-group-item {{request()->is('admin/users') ? 'active' : ''}}">
                                    {{-- <condition> ? <true> : <false> --}}
                                    <i class="fa-solid fa-users"></i> Users
                                </a>
                                <a href="{{route('admin.posts')}}" class="list-group-item {{request()->is('admin/posts') ? 'active' : ''}}">
                                    <i class="fa-solid fa-newspaper"></i> Posts
                                </a>
                                <a href="{{route('admin.categories')}}" class="list-group-item {{request()->is('admin/categories') ? 'active' : ''}}">
                                    <i class="fa-solid fa-tags"></i> Categories
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="col-9">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
