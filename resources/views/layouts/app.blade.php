<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} @hasSection('title') - @yield('title') @endif</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body @class(['rtl', 'full-bg' => request()->path() == 'login']) @if(request()->path() == 'login') style="background-image: url('{{asset('background.jpg')}}')" @endif>
    <div class="se-pre-con"></div>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light" style="background-color: @if(request()->path() == 'login') rgba(255, 255, 255, 0.88) @else #e3f2fd @endif">
            @guest
            <a class="navbar-brand" href="#">سامانه انتخاب واحد</a>
            @endguest

            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @role('group_manager')
                            <li class="nav-item {{request()->routeIs('admin.user.index')? 'active':''}}">
                                <a class="nav-link" href="{{route('group-manager.user.index')}}">
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
                                <li class="nav-item {{request()->routeIs('report.index')? 'active':''}}">
                                    <a class="nav-link" href="{{route('report.index')}}">
                                        گزارش
                                    </a>
                                </li>
                        @endrole
                        @role('admin')
                                <li class="nav-item {{request()->routeIs('admin.user.index')? 'active':''}}">
                                    <a class="nav-link" href="{{route('admin.user.index')}}">
                                        مدیران گروه
                                    </a>
                                </li>
                                <li class="nav-item {{request()->routeIs('term.index')? 'active':''}}">
                                    <a class="nav-link" href="{{route('term.index')}}">
                                        سر ترم ها
                                    </a>
                                </li>
                        @endrole
                    </ul>

                    <!-- Right Side Of Navbar -->

                </div>
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @auth
                        <li class="nav-link"> {{auth()->user()->name . ' ' . auth()->user()->family}}</li>
                        <li class="nav-item">
                            <button class="btn pointer"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();" data-toggle="tooltip" data-placement="top" title="خروج">
                                <i class="fa fa-sign-out-alt fa-lg"></i>
                            </button>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                        @role(['group_manager','admin'])
                            <li class="nav-item">
                                <a href="{{route('auth.reset-password')}}" data-toggle="tooltip" data-placement="top" title="تغییر رمز عبور">
                                    <i class="fa fa-user mt-2 fa-lg"></i>
                                </a>
                            </li>
                        @endrole
                    @endauth
                </ul>
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
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $(document).ready(function () {
            @if(session()->has('alert'))
            Swal.fire({
                title: "{{session('alert')['title']}}",
                text: "{{session('alert')['message']}}",
                type: "{{session('alert')['icon']}}",
            });
            @endif
            $('*').persiaNumber();
        })
    </script>
    @yield('script')
</body>
</html>
