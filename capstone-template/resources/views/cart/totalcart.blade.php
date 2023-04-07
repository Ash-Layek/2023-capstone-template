@extends('common')

@section('pagetitle')
Item List
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')

    <div class="row">
        <div class="col-md-4 col-md-offset-2">
            <p>{{ session()->get('ip') }}</p>
			<p>{{ session()->getId() }}</p>

            <table class="table">
                <tr>
                    <td>Title</td>
                    
                    <td>Price</td>
                   
                    <td>Quantity</td>
                    
                    <td>........</td>

                    <td>.......</td>
                  
                </tr>
            </table>
            @php

            $totalPrice = 0;
            @endphp

            <form method="post" action="{{ route('update_cart') }}">
				<input type="hidden" name="sessionid" value={{session()->getId()}}/>
                @csrf
                <table class="table">
                    @foreach($listofitems as $item)
                        <tr>
                            <td>{{ Form::label('title', $item->title) }}</td>
                            <td>{{ Form::label('price', $item->price) }}</td>
							<td>{{ Form::number("quantity_{$item->id}", $item->quantity, ['min' => 1]) }}</td>
							<input type="hidden" name="itemID" value={{$item->id}}>
                            <td>{{ Form::submit('Update', ['class' => 'btn btn-primary']) }}</td>
                            <td><a class="btn btn-primary">Delete</a></td>
                        </tr>

                       @php

                       $totalPrice += $item->price

                       @endphp
                    @endforeach
                </table>

            </form>

            <p> Total Price is : {{$totalPrice}} $</p>




            {!! Form::open(['route' => 'check_order', 'data-parsley-validate' => '', 'files' => true]) !!}

{{ Form::label('first_name', 'First Name:') }}
{{ Form::text('first_name', null, ['class'=>'form-control', 'style'=>'', 'required'=>'required', 'data-parsley-maxlength'=>'100']) }}

{{ Form::label('last_name', 'Last Name:') }}
{{ Form::text('last_name', null, ['class'=>'form-control', 'style'=>'', 'required'=>'required', 'data-parsley-maxlength'=>'100']) }}

{{ Form::label('phone', 'Phone:') }}
{{ Form::text('phone', null, ['class'=>'form-control', 'style'=>'', 'required'=>'required', 'data-parsley-type'=>'digits']) }}

{{ Form::label('email', 'Email:') }}
{{ Form::email('email', null, ['class'=>'form-control', 'style'=>'', 'required'=>'required', 'data-parsley-type'=>'email']) }}

{{ Form::submit('Submit', ['class'=>'btn btn-success btn-lg btn-block', 'style'=>'margin-top:20px']) }}

{!! Form::close() !!}



        </div> <!-- end of .col-md-8 -->
    </div>

@endsection
