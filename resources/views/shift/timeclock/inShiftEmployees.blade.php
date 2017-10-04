@extends('layouts.timeclock.master')
@section('content')
<div class="container">
<div class="row justify-content-center" >
<div class="col-md-6">

	@if(!empty($inShiftEmployees))

	<table class="table">
		<thead><tr><th>Employee</th><th>Location</th><th>ClockIn</th></thead>
		<tbody>
			@foreach($inShiftEmployees as $e)
			<tr><td>{{ $e->cName}}</td>
			<td>{{ $e->shift->clock->location->shortName}}</td>
			<td>{{ $e->shift->clock->clockIn}}</td></tr>
			@endforeach

		</tbody>
	</table>
	@endif

</div>
</div>
</div>
@endsection