@extends('layouts.master')
@section('content')
<div class="container">
<h1>Tips Management</h1>

@if($locations)
@foreach($locations as $l)
<caption>{{$l->name}}</caption>
<table class="table table-sm table-hover">
	<thead><tr><th>start</th><th>end</th><th>Total Tips</th><th>Tip Hours</th><th>hourly tip</th><th>edit</th></tr></thead>
	<tbody>
@foreach($l->tips as $t)


		<tr><td>{{$t->start}}</td>
			<td>{{$t->end}}</td>
			<td>{{$t->tips/100}}</td>
			<td>{{$t->hours}}</td>
			<td>{{$t->hourlyTip}}</td>

			<td><a href="/tips/{{ $t->id }}/update" class="btn btn-sm btn-warning">Edit</a>
				<a href="/tips/{{ $t->id }}/delete" class="btn btn-sm btn-danger">Delete</a>
			</td>
		</tr>




@endforeach
	</tbody>
</table>

@endforeach
@endif


<div class="input-group">
<a href="/tips/create">Add</a>
</div>
</div>
@endsection