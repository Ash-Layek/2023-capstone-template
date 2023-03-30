@extends('common') 

@section('pagetitle')
Item List
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')
	
	
	

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<p> {{session()->get('ip')}}</p>
			
		<table class="table">
       
	
        <tr>
		
		<td> 
         {{$ID}}
        </td>
      
		<td> 

		{{session()->getId()}}

</td>
		
		<td> 
         {{session()->get('ip')}}
        </td>

		<td>
			
		Quantity  :  1</td>
		 
		  
		  
		  
        </tr> 

    </table>
		</div> <!-- end of .col-md-8 -->
	</div>

@endsection