<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Sigma') }}</title>

    <!-- Scripts -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="{{asset('assets/css/theme.css')}}" rel="stylesheet">
    <link href="{{asset('assets/lib/toastr/toastr.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/lib/choices/choices.min.css')}}" rel="stylesheet">

    @yield('header')
</head>
<body data-bs-spy="scroll" data-bs-target="#terms-sidebar" data-bs-offset="100" tabindex="0">
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{url("/")}}">
                Sigma
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('contact'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('contact') }}">Start now !</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{url("/home")}}">My courses</a>
                        </li>
                        @if(Auth::user()->role == 'admin')
                            <li class="nav-item">
                            </li>
                            <div class="dropdown font-sans-serif d-inline-block mb-2">
                                <a class="nav-link dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</a>
                                <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{url('/admin')}}">Courses</a>
                                    <a class="dropdown-item" href="{{url('/manage')}}">Manage</a>

                                </div>
                            </div>
                        @endif
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}">Profile
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
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

    <main class="py-4 ">
        @yield('content')
    </main>
</div>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
@if(session()->has('error'))
    <script>$(function (){ warning('{{session()->get('error')}}')})</script>
@endif
@if($errors->any())
    @foreach($errors->all() as $error)
        <script>$(function (){ warning('{{$error}}')})</script>
    @endforeach
@endif
@if(session()->has('success'))
    <script>$(function (){ success('{{session()->get('success')}}')})</script>
@endif

<script>
    function warning(message) {
        console.log("je passe la")
        toastr.warning('<b>'+message+'</b>','',{"positionClass":"toast-bottom-right"});
    }
    function success(message) {
        toastr.success('<b>'+message+'</b>','',{"positionClass":"toast-bottom-right"});
    }
</script>

<script  src="{{asset('assets/lib/toastr/toastr.min.js')}}"></script>
<script  src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script  src="{{asset('assets/bootstrap/bootstrap.min.js')}}"></script>
<script  src="{{asset('assets/lib/@fortawesome/all.min.js')}}"></script>

</body>
</html>
