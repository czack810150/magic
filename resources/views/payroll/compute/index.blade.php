@extends('layouts.timeclock.master')
@section('content')
<div class="container">
<h1>Compute Payroll</h1>

<form class="form-inline" method="POST" action="/payroll/compute">

	
		<div class="form-group">

		<div class="form-group mx-sm-3">
			{{ Form::label('dateRange','Date range',['class'=>'mx-sm-3'])}}
			{{ Form::select('dateRange',$dates,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder'=>'Choose date range']) }}
		</div>
		{{ Form::submit('Compute!',['class'=>'btn btn-primary']) }}
		{{csrf_field()}}
	</div>

</form>


@include('payroll.buttons')


</div>



@endsection