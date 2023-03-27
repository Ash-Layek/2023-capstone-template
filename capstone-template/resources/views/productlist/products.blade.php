@extends('common') 

@section('pagetitle')
product list
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')
	



<div class="row">
  <div class="col-md-4 col-md-offset-0 ">
    <table class="table">
      @foreach ($categories as $item)    
        <tr>
          <td><a href="">{{ $item->name }}</a></td>
        </tr> 
      @endforeach
    </table>
  </div>
  <div class="col-md-4 col-md-offset-0 ">
    <table class="table">
      @foreach ($items as $item)    
        <tr>
          <td><a href="">{{ $item->title }}</a></td>
        </tr> 
      @endforeach
    </table>
  </div>
</div>


@endsection