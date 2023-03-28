@extends('common') 

@section('pagetitle')
product list
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')
	



<div class="row">
  <div class="col-md-8 col-md-offset-0 ">
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
		
		<td><a href="{{ route('product.details', ['id' => $item->id]) }}">{{ $item->title }}</a></td>

		  <td>{{$item->price}}</td>
		  <td>
            @if (Storage::disk('public')->exists('images/items/' . $item->picture))
             <a href="{{ route('product.details', ['id' => $item->id]) }}"><img  src="{{ asset('storage/images/items/' . $item->picture) }}" alt="{{ $item->title }} " width="100" /></a>
            @else
                No image available
            @endif

            </td>
			<td><button> Buy now </button></td>
        </td>
		 
		  
		  
		  
        </tr> 
      @endforeach
    </table>
  </div>
</div>


@endsection