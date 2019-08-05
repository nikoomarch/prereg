<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="rtl">
    <div class="se-pre-con"></div>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                        @if(Auth::user()->role == 'groupManager')
                            <li class="nav-item {{request()->routeIs('user.index')? 'active':''}}">
                                <a class="nav-link" href="{{route('user.index')}}">
                                    دانشجویان
                                </a>
                            </li>
                            <li class="nav-item {{request()->routeIs('course.index')? 'active':''}}">
                                <a class="nav-link" href="{{route('course.index')}}">
                                    دروس
                                </a>
                            </li>
                            <li class="nav-item {{request()->routeIs('selection.index')? 'active':''}}">
                                <a class="nav-link" href="{{route('selection.index')}}">
                                    تعریف انتخاب واحد
                                </a>
                            </li>
                        @elseif(Auth::user()->role == 'admin')
                                <li class="nav-item {{request()->routeIs('user.index')? 'active':''}}">
                                    <a class="nav-link" href="{{route('user.index')}}">
                                        مدیران گروه
                                    </a>
                                </li>
                                <li class="nav-item {{request()->routeIs('field.index')? 'active':''}}">
                                    <a class="nav-link" href="{{route('field.index')}}">
                                        رشته ها
                                    </a>
                                </li>
                                <li class="nav-item {{request()->routeIs('term.index')? 'active':''}}">
                                    <a class="nav-link" href="{{route('term.index')}}">
                                        سر ترم ها
                                    </a>
                                </li>
                        @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @auth
                            <li class="nav-link"> {{Auth::user()->name . ' ' . Auth::user()->family}}</li>
                            <li class="nav-item">
                                <a class="nav-link" href=""
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    خروج
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(window).on('load',function() {
            $(".se-pre-con").fadeOut("slow");
        });
    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    @yield('script')
</body>
</html>
