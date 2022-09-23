<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>  {{$compilerName}} Compiler</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel = "icon" href = "{{ asset('img/logoblack.png') }}" type = "image/x-icon">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link href="{{ asset('css/editcm.css') }}" rel="stylesheet">
    <link href="{{ asset('css/editor.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


</head>
<body>

      
        <div  style=" background-color: #222222;display:flex; justify-content: space-between; margin-top:20px;margin-bottom:10px; width:95vw;">
       
            <div>
                        {{-- <div class="navbar-brand"  style="color: white;">
                        {{$compilerName}}
                        </div> --}}

                        <button id="saveb" type="button" onclick="savefun();" class="gbutton runb" >SAVE </button>   
                        @if ( $compilerId==1)
                        <button  type="button" onclick="showdebug()" class="gbutton"  > DEBUG </button>
                        @endif
                        
                        <button  type="button" onclick="showinput();" class="gbutton" > RUN </button> 
            </div>

            <div class="navbar-brand"  style="color: white;">
                <img src="{{ asset('img/logo.png') }}" style="width:1.5rem;height:1.5rem;margin-top:-.5rem;">CODER
            </div>

            <div style="display:inline;min-width:150px;">
               
                    <a  style="color: white; text-decoration: none;float:right;"  class=" dropdown-toggle" href="#"  data-bs-toggle="dropdown">
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
                           
                       
            </div>

</div>

  
                    
CODE
<textarea style="magrin-left:5%;" id="code" name="code">{{$code}}</textarea><br>    
   
<div style="display:none;" id="outputdiv" >

OUTPUT
<textarea class="ioo" id=output name="output" style="width:100%;height:40vh;color:white; background-color:#2b2b2b;" >{{$response}}</textarea><br><br>

</div>


<div class="inputdiv" id="inputdiv" > 
      <b>INPUT</b>
      <span style="float:right;margin-top:-1vw;margin-right:-1vw;">
      <button  type="button" class="gbutton closeb" onclick="hideinput();"> X </button>
      </span>
      <br>
      <textarea name="input" id="inputarea" style="width:100%;height:40vh;resize:none;"  class="form-control" > {{$input}} </textarea>
      <span style="float:right;margin-top:-3.5vw;margin-right:1vw;">
      <button  type="button" onclick="runproedit();" class="gbutton runb" >RUN </button>
      </span>
</div>



<div class="debugbar" id="debugbar"> 
          <div style="text-align:center">
          <b>DEBUG</b>

          </div>
          <br>
          <div class="textOnInput">
              <label >Variable</label>
              <input type="text" id="val" name="val" class="form-control"  style="width:20vw;height:50px;"  requied >
              </div><br>

          <div class="textOnInput">
            <label >Line</label>  
              <input  type="number" id="line" name="line" class="form-control"  style="height:50px;background-color:white;"   requied>
            </div>
              <br>

              <input type="button"  style="width:45%;" value="FIND VALUE" onclick="rundebug();"  class="gbutton" />
              
              <button  type="button" onclick="hidedebug();" class="gbutton" style="width:45%;float:right;" > HIDE</button>
              <br><br>
              <div class="textOnInput">
                      
                   
                          <label id="val_label" >
                                
                          </label>
                        
                      <input type="text" id="valbox" name="value" style="width:20vw;height:50px;color:black;"  class="form-control"  > 
            </div>

</div>


    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/theme/monokai.min.css">
<script src="{{ asset('js/editcm.js') }}" ></script>
<link href="{{ asset('css/edit.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/codemirror.min.css"> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/codemirror.min.js">
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/theme/monokai.min.css">


<script src="{{ asset('js/editor.js') }}" ></script>

<script >
$.ajaxSetup({   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}    });
    
function savefun() 
{
    document.getElementById("saveb").innerHTML = "Saving...";
    
    var data = {
      'code': editor.getValue(),
      'id': {{$id}}
    };
    $.ajax({
        url: '/save',
        type: 'POST',
        data: data,
        success: function(response) {   document.getElementById("saveb").innerHTML = "SAVE";  }
    })
}

function runproedit() 
        {
            document.getElementById("inputdiv").style.display = "none";
            document.getElementById("output").innerHTML = "Running...";
            document.getElementById("outputdiv").style.display = "inline";
            var data = {
            'code': editor.getValue(),
            'input': document.getElementById("inputarea").value,
            'compilerId' : {{$compilerId}},
            };
    
            $.ajax({
                url: '/runpro',
                type: 'POST',
                data: data,
                success: function(response) {
                document.getElementById("output").innerHTML = response;
                }
            })
        }

</script>
{{-- <script src="{{ asset('js/clike.js') }}" ></script> --}}

</body>
</html>












































 