@extends('common') 

@section('pagetitle')
Item List
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')
	
	<div class="text-center">
		<div class="col-md-10 col-md-offset-2 mx-auto">

        
@if (Storage::disk('public')->exists('images/items/' . $items->picture))
               <img  src="{{ asset('storage/images/items/' . $items->picture) }}" alt="{{ $items->title }} " width="80%" />
            @else
                No image available
            @endif
          
            <br>


           <h1>Title :  {{$items->title}} 
<br>

           ID :  {{$items->id}} 

        
            <br>
          Price :  {{$items->price}}

            <br>
           Quantity :  {{$items->quantity}}

            <br>
           Sku :  {{$items->sku}}

            <br>
           </h1>
		</div> <!-- end of .col-md-8 -->
	</div>

@endsection