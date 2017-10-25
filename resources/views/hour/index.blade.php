@extends('layouts.master')
@section('content')

@include('hour.nav')
<div class="container-fluid">




<form class="form-inline my-2" method="POST" action="/hours/">

	
		<div class="form-group">
		<label class="mr-sm-2" for="location">Location</label>
{{ Form::select('location',$locations,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder' => 'Choose a location','id'=>'location'])}}
		</div>

		<div class="form-group mx-sm-3">
			{{ Form::label('dateRange','Date range',['class'=>'mx-sm-3'])}}
			{{ Form::select('dateRange',$dates,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder'=>'Choose date range']) }}
		</div>
		{{ Form::submit('Submit',['class'=>'btn btn-primary']) }}
		{{csrf_field()}}

</form>
@if($hours)
<main id="hours">
<h2>hours</h2>

<table class="table table-sm">
<thead>
	<tr><th>employee</th><th>wk1Scheduled</th><th>wk2Scheduled</th><th>wk1Clocked</th><th>wk2Clocked</th><th>wk1Effective</th><th>wk2Effective</th><th>wk1Overtime</th><th>wk2Overtime</th><th>wk1Night</th><th>wk2Night</th></tr>
</thead>
<tbody>
	@foreach($hours as $h)
	<tr>
		<td>{{ $h->employee->cName }}</td>
		<td>{{ $h->wk1Scheduled }}</td>
		<td>{{ $h->wk2Scheduled }}</td>
		<td>{{ $h->wk1Clocked }}</td>
		<td>{{ $h->wk2Clocked }}</td>
		<td>{{ $h->wk1Effective }}</td>
		<td>{{ $h->wk2Effective }}</td>
		<td>{{ $h->wk1Overtime }}</td>
		<td>{{ $h->wk2Overtime }}</td>
		<td>{{ $h->wk1Night }}</td>
		<td>{{ $h->wk2Night }}</td>
	</tr>
	@endforeach
</tbody>
</table>






</main>
@endif





</div>




@endsection