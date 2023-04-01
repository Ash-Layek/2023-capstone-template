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
                    <td></td>
                    <td></td>
                </tr>
            </table>

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
                    @endforeach
                </table>
            </form>

        </div> <!-- end of .col-md-8 -->
    </div>

@endsection
