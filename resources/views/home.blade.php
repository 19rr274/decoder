<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DCODER</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts --> 
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100&family=Open+Sans:wght@300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" crossorigin="anonymous">


<link rel = "icon" href = "{{ asset('img/logoblack.png') }}" type = "image/x-icon">

<link href="{{ asset('css/home.css') }}" rel="stylesheet">


</head>
<body>
    
<div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            
            <div class="container">
                
         
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->   
                    <button  type="button" onclick="showcreate();" class="createbutton">
                            Create File
                    </button>
                    <ul class="navbar-nav me-auto">

                    </ul>
                    
                    <div class="navbar-brand"  style="text-align:right;color:azure;" >
                    <img src="{{ asset('img/logo.png') }}" style="width:1.5rem;height:1.5rem;margin-top:-.5rem;">CODER
                     </div>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}" style="color:azure">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}"style="color:azure">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a style="color:azure" id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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






<div class="container" >
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card" style="border:0px">
                    <div class="card-header"  style="text-align:center; font-size: 18px;" >
                        <h2> MY FILES </h2>  
                    </div>
                        @foreach($todos as $todo)
                        @if ($todo->user_id==$user_id)
                        <div class="card-header cardbody" >
                            <a  href="{{asset('/' . $todo->id . '/edit')}}" >{{$todo->title}}.cpp</a>
                            <span style="float:right;">
                                <a href="{{asset('/' . $todo->id . '/delete')}}" >
                                <img src="{{ asset('img/can.jpg') }}" style="width:2rem;height:2rem;" alt="delete">
                                </a>
                            </span>
                        </div>
                        @endif
                        @endforeach
                

</div>
</div>
</div>
</div>






<form action="/upload" method="post">
        @csrf                
        <div class="create" id="create" > 
        <div class="textOnInput">
            <label ><h4>Create New File</h4></label>
            <input type="text" name="title" class="form-control"  style="width:20vw;height:50px;" placeholder="File Name" requied >
        </div><br>
        <input type="submit" value="Create File" class="btn btn-primary" style="width:45%;height:20%;"/>
        <button  type="button" onclick="hidecreate();" class="btn btn-primary"style="width:45%;height:20%;float:right;" > Cancel </button>
        </div>
</form>




<script>
        function hidecreate() 
        {
        document.getElementById("create").style.display  = "none";
        }
        function showcreate() 
        {
        document.getElementById("create").style.display = "block";
        }
</script>
    
</body>
</html>


























