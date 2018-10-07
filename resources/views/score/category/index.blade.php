@extends('layouts.master')
@section('content')
@include('score.nav')
<div class="container">
<h1>Performance Categories</h1>
<table class="table table-sm">
	<thead><tr><th>Category</th><th>created at</th><th>updated at</th><th>Edit</th></tr></thead>
	<tbody>
	@foreach($categories as $c)
	<tr>
		<td><a href="/score/category/{{ $c->id }}/show">{{ $c->name }}</a></td>
		<td>{{ $c->created_at }}</td>
		<td>{{ $c->updated_at }}</td>
		<td><a href="/score/category/{{$c->id}}/delete" class="btn btn-sm btn-danger" role="button">Delete</a>
			<a href="/score/category/{{$c->id}}/edit" class="btn btn-sm btn-warning" role="button">Edit</a>
			</td>

	</tr>
	@endforeach
	</tbody>
</table>

<a class="btn btn-primary" href="/score/category/create">New Category</a>




</div>


@endsection