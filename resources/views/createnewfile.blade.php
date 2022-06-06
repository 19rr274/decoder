@extends('layouts.app')

<style>
    a:link,a:visited , a:hover, a:focus, a:active {
      color: inherit;
      text-decoration: none;
  
}
</style>




@section('content')

<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
                    <div class="card-header">
                        <div  style="text-align:center; font-size: 18px;" >
                            FILES
                        </div>
                    </div>
                        @foreach($todos as $todo)
                        @if ($todo->user_id==$user_id)
                        <div class="card-header"  >
                            <div  style="text-align:left;" >
                            <a  href="{{asset('/' . $todo->id . '/edit')}}" >{{$todo->title}}.cpp</a>
                            <span style="float:right;">
                                <a href="{{asset('/' . $todo->id . '/delete')}}" >
                                <img src="https://www.freeiconspng.com/uploads/trash-can-icon-28.png" style="width:20px;height:20px;" alt="delete">
                                </a>
                            </span>
                            </div>
                        </div>
                        @endif
                        @endforeach

                    <div class="card-header">
                        <div  style="text-align:left; font-size: 16px;" >
                                        <form action="/upload" method="post">
                                        @csrf

                                        <input type="test" name="title"  placeholder="File Name" style="height:25px;width: 300px;font-size: 16px;" required/>
                                       .cpp
                                    <span style="float:right;">
                                        <input type="image" 
                                        src="https://icon2.cleanpng.com/20180506/qfw/kisspng-computer-icons-plus-and-minus-signs-symbol-downloa-blue-cross-5aeeca1f889178.5269997215255987515594.jpg" 
                                        style="width:20px;height:20px;left:300px;"  />
                                    
                                    </span>
                                    </form>
                            
                        </div>
                    </div>

</div>
</div>
</div>
</div>
@endsection
