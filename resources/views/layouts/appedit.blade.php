<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DeCODER</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts --> 
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">



</head>
<body>
<form action="/{{$id}}/run" method="post">
    @csrf
    <div id="app" style=" background-color: #222222;">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            
            <div class="container">
            <a class="navbar-brand" href="/home"  style="color: white;">
            < HOME
            </a>
            <a href="/home"  class="navbar-brand"  >  </a> 
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <button  type="button" onclick="showinput();" class="btn btn-primary" > RUN </button> &nbsp;
                <input type="submit" formaction="/{{$id}}/save" class="btn btn-primary" value="SAVE"/> &nbsp;      
                <button  type="button" onclick="showdebug()" class="btn btn-primary"  > DEBUG</button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->   
                    <ul class="navbar-nav me-auto">

                    </ul>
                    <div class="navbar-brand"  style="text-align:right;color: white;">
                    <img src="{{ asset('img/logo.png') }}" style="width:3vh;height:3vh;margin-top:-1vh;">eCODER
                    </div>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}" style="color: white;">>{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}"  style="color: white;">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown" >
                                <a  style="color: white;"id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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

        <main class="py-4">
            @yield('content')
        </main>
    </div>


<script>
function hidedebug() 
{
  document.getElementById("debugbar").style.zIndex  = "-1";
}
function showdebug() 
{
  document.getElementById("debugbar").style.zIndex = "1";
}


function hideinput() 
{
  document.getElementById("input").style.zIndex  = "-1";
}
function showinput() 
{
  document.getElementById("input").style.zIndex = "1";
}
</script>
    


</form>
</body>
</html>
