@extends('layouts.timeclock.master')
@section('content')
<div class="container">
<h1>Personal</h1>
<form class="form-inline mb-5">


		<div class="form-group">
		<label class="mr-sm-2" for="year">Year</label>
{{ Form::select('year',[2017 => 2017],null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','id'=>'year'])}}
		</div>
	
		<div class="form-group">
		<label class="mr-sm-2" for="location">Location</label>
{{ Form::select('location',$locations,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder' => 'Choose a location','id'=>'locationFilter'])}}
		</div>

		<div class="form-group">
		<label class="mr-sm-2" for="employeeList">Employee</label>
		{{ Form::select('employeeList',[1,2,3],null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder' => 'Choose employee','id'=>'employeeList']) }}
		</div>

		{{ Form::button('View',['class'=>'btn btn-primary','id'=>'viewBtn']) }}

		{{csrf_field()}}

</form>


@include('payroll.buttons')




</div>

<script>
document.addEventListener("DOMContentLoaded", function(event) { 

    var locationSelect = $("#locationFilter");
	locationSelect.on('change',function(){
		  locationEmployees();
	});

	$("#employeeList").on('change',function(){
		
	});

	$('#viewBtn').on('click',function(){
		if($("#locationFilter").val() == '' || $("#employeeList").val()== ''){
			alert('You must choose a location and an employee');
		} else{
		window.location.replace('/payroll/employee/'+$("#employeeList").val()+'/'+$("#year").val());
		}
	});



});	
</script>



@endsection