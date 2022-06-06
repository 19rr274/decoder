@extends('layouts.app101')

<link href="{{ asset('css/editcm.css') }}" rel="stylesheet">
@section('content')
<br>
                    <form action="/{{$id}}/run" method="post">
                             @csrf

                            <div class="split left">   CODE :<br>                                     
                                                <textarea id="code" name="code" rows="22" cols="60">{{$code}}</textarea>
                                                <br><input type="submit" value="RUN" class="btn btn-primary" />
                                                <button type="submit" formaction="/{{$id}}/save" class="btn btn-primary">SAVE</button>       
                            </div>
                           

                            <div class="split right">  INPUT :<br>
                                <textarea name="input" rows="8" cols="70" >{{$input}}</textarea>
                                <br/> <br/> OUTPUT :<br>
                                <textarea name="output" rows="9" cols="70" >{{$response}}</textarea>
                                <br><br>
                                    Variable: 
                                    <input type="test" name="val"   value={{$val}}>
                                    Line:     
                                    <input type="number" name="line"   value={{$line}}>
                                    <br><br>
                                    <input type="submit" value="FIND VALUE"  formaction="/{{$id}}/find" class="btn btn-primary" />
                                    <input type="test" name="value"  value={{$value}} >

                            </div>
        
               </form>
  
   
     
<script src="{{ asset('js/editcm.js') }}" ></script>

<script>
   var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
    lineNumbers: true,
   
    
});
</script>

<link href="{{ asset('css/edit.css') }}" rel="stylesheet">

@endsection