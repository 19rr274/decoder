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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link href="{{ asset('css/editcm.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    
</head>
<body>


<form  method="post" action="/find" >
@csrf
    <div id="app" style=" background-color: #222222;">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
             <div class="container"  style="color: white;margin-right:0vw;">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                

                <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
                    <!-- Left Side Of Navbar -->   
                   
                        <a class="navbar-brand gbutton" href="/"  style="color: white;margin-left:-10vw;">BACK</a>
                        <select name="compiler" id="compiler"  class="navbar-brand gbutton compiler" style="color:white;">
                                @foreach($complierTable as $complierTable)
                                    <option value="{{$complierTable->compilerId}}">{{$complierTable->name}}</option>
                                @endforeach
                        </select>

                        <div class="navbar-brand"  style="color: white; margin-left:30vw">
                        <img src="{{ asset('img/logo.png') }}" style="width:1.5rem;height:1.5rem;margin-top:-.5rem;">CODER
                        </div>


                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto" >
                        <!-- Authentication Links -->
                        <button  type="button" onclick="showinput();" class="gbutton" > RUN </button> &nbsp;&nbsp;&nbsp;&nbsp;
                        <button  type="button" onclick="showdebug()" class="gbutton" id="debugButton" style="display:none;" > DEBUG </button>&nbsp;&nbsp;&nbsp;&nbsp;
                       
                    </ul>
                <!-- </div> -->

            </div>
        </nav>
    </div>

  
                    
CODE
<textarea style="magrin-left:5%;" id="code" name="code">{{$code}}</textarea>
<br>    
   

OUTPUT
<textarea class="ioo" id=output name="output" style="width:100%;height:40vh;color:white; " >{{$response}}</textarea>



<div class="inputdiv" id="inputdiv" > 
      <b>INPUT</b>
      <span style="float:right;margin-top:-1vw;margin-right:-1vw;">
      <button  type="button" class="gbutton closeb" onclick="hideinput();"> X </button>
      </span>
      <br>
      <textarea name="input" id="inputarea" style="width:100%;height:40vh;resize:none;"  class="form-control" > {{$input}} </textarea>
      <span style="float:right;margin-top:-3.5vw;margin-right:1vw;">
      <button  type="button" onclick="runpro();" class="gbutton runb" >RUN </button>
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

              <input type="button"   value="FIND VALUE" onclick="rundebug();"  class="gbutton" />
              
              <button  type="button" onclick="hidedebug();" class="gbutton" style="float:right;"> HIDE</button>
              <br><br>
              <div class="textOnInput">
                      
                   
                          <label id="val_label" >
                                
                          </label>
                        
                      <input type="text" id="valbox" name="value" style="width:20vw;height:50px;color:black;"  class="form-control"  > 
            </div>

</div>

</form>
    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/theme/monokai.min.css">
<script src="{{ asset('js/editcm.js') }}" ></script>
<script>

   var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
    lineNumbers: true,
    theme: 'monokai'
});
</script>
<link href="{{ asset('css/edit.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/codemirror.min.css">
</link>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/codemirror.min.js">
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/theme/monokai.min.css">

<script>
    
$.ajaxSetup({   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}    });
  
function runpro() 
{
    document.getElementById("inputdiv").style.display = "none";
    document.getElementById("output").innerHTML = "Running...";
    
    var data = {
      'code': editor.getValue(),
      'input': document.getElementById("inputarea").value,
      'compilerId' : document.getElementById("compiler").value,
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


function rundebug() 
{
    const val_box = document.getElementById("valbox");
    val_box.setAttribute("value", "Calculating...");
    var val_label= "Value of " + document.getElementById("val").value + " at line " +document.getElementById("line").value;
    var data = {
        'code': editor.getValue(),
        'input': document.getElementById("inputarea").value,
        'line': document.getElementById("line").value,
        'val' :document.getElementById("val").value
    };
    console.log(data);
    $.ajax({
        url: '/find',
        type: 'POST',
        data: data,
        success: function(response) {   
            document.getElementById("val_label").innerHTML = val_label; 
            val_box.setAttribute("value", response);
        }
    })


}

$( ".compiler" ).change(function() {
   

    var val_compilerId = document.getElementById("compiler").value;
    console.log(val_compilerId);
  if(val_compilerId=='1')
  {
    document.getElementById("debugButton").style.display = "block"; 
  }
  else{
    document.getElementById("debugButton").style.display = "none"; 
  }
});

function hidedebug()    { document.getElementById("debugbar").style.display = "none";   }
function showdebug()    { document.getElementById("debugbar").style.display = "block";  }
function hideinput()    { document.getElementById("inputdiv").style.display = "none";   }
function showinput()    { document.getElementById("inputdiv").style.display = "block";  }

</script>
    


</body>
</html>












































 