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
                            <span style="float:right;">
                                <a href="/create"  > 
                                <img src="https://icons.iconarchive.com/icons/iconsmind/outline/512/Add-File-icon.png" style="width:20px;height:20px;" alt="Create New File">
                                </a> 
                            </span>
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
                

</div>
</div>
</div>
</div>
@endsection
