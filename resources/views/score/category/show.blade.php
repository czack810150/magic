@extends('layouts.master')
@section('content')
@include('score.nav')
<div class="container">
<h1>{{$category->name}}</h1>
<table class="table table-sm">
	<thead><tr><th>Item</th><th>Points<th>created at</th><th>updated at</th><th>Edit</th></tr></thead>
	<tbody>
	@foreach($category->items as $i)
	<tr>
		<td>{{ $i->name }}</td>
		<td>{{ $i->value }}</td>
		<td>{{ $i->created_at }}</td>
		<td>{{ $i->updated_at }}</td>
		<td><a href="/score/item/{{$i->id}}/delete" class="btn btn-sm btn-danger" role="button">Delete</a>
			<a href="/score/item/{{$i->id}}/edit" class="btn btn-sm btn-warning" role="button">Edit</a>
			</td>
	</tr>
	@endforeach
	</tbody>
</table>

</div>


@endsection