@extends('layouts.timeclock.master')
@section('content')
<div class="container">
<h1>Payroll</h1>

@if($employees)
<table class="table table-sm">
	<thead>
		<tr><th>id</th><th>card</th><th>name</th></tr>
	</thead>
	<tbody>
		@foreach($employees as $e)
			<tr>
				<td>{{$e->id}}</td>
				<td>{{$e->employeeNumber}}</td>
				<td>{{$e->cName}}</td>
			</tr>
		@endforeach
	</tbody>
</table>
@endif



<div class="form-group">
<a href="/payroll/basic" class="btn btn-secondary">Basic Pay</a>
</div>
<div class="form-group">
<a href="/payroll/variable" class="btn btn-secondary">Variable Pay</a>
</div>




</div>



@endsection