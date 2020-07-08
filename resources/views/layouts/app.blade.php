<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar fixed-top navbar-expand-md navbar-light bg-white shadow-sm">

            <a class="navbar-brand" href="/">
                <svg class="gUZ lZJ U9O kVc" height="24" width="24" viewBox="0 0 24 24" aria-hidden="true" aria-label="" role="img">
                    <path d="M0 12c0 5.123 3.211 9.497 7.73 11.218-.11-.937-.227-2.482.025-3.566.217-.932 1.401-5.938 1.401-5.938s-.357-.715-.357-1.774c0-1.66.962-2.9 2.161-2.9 1.02 0 1.512.765 1.512 1.682 0 1.025-.653 2.557-.99 3.978-.281 1.189.597 2.159 1.769 2.159 2.123 0 3.756-2.239 3.756-5.471 0-2.861-2.056-4.86-4.991-4.86-3.398 0-5.393 2.549-5.393 5.184 0 1.027.395 2.127.889 2.726a.36.36 0 0 1 .083.343c-.091.378-.293 1.189-.332 1.355-.053.218-.173.265-.4.159-1.492-.694-2.424-2.875-2.424-4.627 0-3.769 2.737-7.229 7.892-7.229 4.144 0 7.365 2.953 7.365 6.899 0 4.117-2.595 7.431-6.199 7.431-1.211 0-2.348-.63-2.738-1.373 0 0-.599 2.282-.744 2.84-.282 1.084-1.064 2.456-1.549 3.235C9.584 23.815 10.77 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0 0 5.373 0 12"></path>
                </svg>
            </a>            

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-3">
                    <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item {{ Request::is('today') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('today') }}">Today</a>
                    </li>
                    <li class="nav-item {{ Request::is('my-feed') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('my-feed') }}">My feed</a>
                    </li>
                    <li class="nav-item {{ Request::is('followings') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('followings') }}">Followings</a>
                    </li>
                </ul>
                @if ( get_class(\Request::route()->getController()) == "App\Http\Controllers\ImageController" || get_class(\Request::route()->getController()) == "App\Http\Controllers\SearchController" )
                <form class="form-inline my-2 my-lg-0" action="{{ route('search') }}" method="POST" role="search">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input class="form-control mr-sm-2" type="text" class="form-control" name="q" placeholder="Search images"> <span class="input-group-btn">
                            <button type="submit" class="btn btn-outline-success my-2 my-sm-0">
                                <span class="glyphicon glyphicon-search">Search</span>
                            </button>
                        </span>
                    </div>
                </form>
                @endif

                <ul class="navbar-nav ml-3 nav-flex-icons">
                    @if (!empty(Auth::user()))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i>{{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
                            <a class="dropdown-item" href="{{ route('user.show', Auth::user()->name) }}">My account</a>
                            <div class="dropdown-item">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    @endif
                </ul>
            </div>

        </nav>

        <main class="py-4">
            @yield('content')
            @yield('script')
        </main>
    </div>
</body>

</html>