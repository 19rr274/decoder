
@extends('layouts.appedit')




<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
<link href="{{ asset('css/editcm.css') }}" rel="stylesheet">
@section('content')
     
                    
CODE
<div >                        
<textarea style="magrin-left:5%;" id="code" name="code">{{$code}}</textarea>
</div>

<br>    
           
OUTPUT
<textarea class="ioo" name="output"style="width:100%;height:40vh; " >{{$response}}</textarea>


<div class="input" id="input" > 
<!-- <div class="textOnInput"> -->
<label ><b>INPUT</b></label>  
<textarea name="input" style="width:100%;height:40vh;"  class="form-control" >{{$input}}</textarea>
<!-- </div> -->
<br>
<input type="submit" value="RUN" class="btn btn-primary" style="margin-top:-11vh; margin-left:65vh;" />
<button  type="button" onclick="hideinput();" class="btn btn-primary" style="margin-top:-51vh; margin-left:73vh;border-radius:50px;" > X </button>
</div>
















<div class="debugbar" id="debugbar"> 
<div style="text-align:center">
<b>DEBUGBAR</b>

</div>
<br>
<div class="textOnInput">
    <label >Variable</label>
    <input type="text" name="val" class="form-control"  style="width:20vw;height:50px;" value="{{$val}}" requied >
    </div><br>

<div class="textOnInput">
  <label >Line</label>  
     <input type="number" name="line" class="form-control"  style="height:50px;background-color:white;"  value="{{$line}}" requied>
     </div>
     <br>
     
     <input type="submit" value="FIND VALUE"  formaction="/{{$id}}/find" class="btn btn-primary" />
     
     <button  type="button" onclick="hidedebug();" class="btn btn-primary" style="float:right;"> HIDE</button>
     <br><br>
     <div class="textOnInput">
             
             @if($val != null and $line != null)
                <label >
                Value of {{$val}} at Line {{$line}}
                </label>
            @endif
              
             <input type="test" name="value" style="width:20vw;height:50px;"  class="form-control"  value={{$value}} > 
     </div>

</div>



    

  
   
    
    <link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/theme/monokai.min.css">
<script src="{{ asset('js/editcm.js') }}" ></script>

<script>
   var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
    lineNumbers: true,
    theme: 'monokai'
});
</script>

<link href="{{ asset('css/edit.css') }}" rel="stylesheet">



<link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/codemirror.min.css">
</link>

<script type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/codemirror.min.js">
</script>
<link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/theme/monokai.min.css">















 



@endsection