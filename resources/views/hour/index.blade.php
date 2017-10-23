@extends('layouts.master')
@section('content')

@include('hour.nav')
<div class="container-fluid">




<form class="form-inline my-2">

	
		<div class="form-group">
		<label class="mr-sm-2" for="location">Location</label>
{{ Form::select('location',$locations,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder' => 'Choose a location','id'=>'location'])}}
		</div>

		<div class="form-group mx-sm-3">
			{{ Form::label('dateRange','Date range',['class'=>'mx-sm-3'])}}
			{{ Form::select('dateRange',$dates,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder'=>'Choose date range']) }}
		</div>
		{{ Form::button('View',['class'=>'btn btn-primary','onclick'=>'viewLocationDate()']) }}
		{{csrf_field()}}

</form>

<main id="payroll">

</main>





</div>


<script>



    let transition = '<div class="row"><div class="col-md-4 offset-md-5"><h1><i class="fa fa-spinner fa-pulse fa-3x"></i></h1></div></div>';

	function viewLocationDate(){
		if($("#location").val() == '' || $("#dateRange").val()== ''){
			alert('You must choose a location and a date range.');
		} else{
			$("#payroll").html(transition);
			$.post(
				'/payroll/fetch',
				{
					location: $("#location").val(),
					startDate: $("#dateRange").val(),
					_token: $("input[name=_token]").val()
				},
				function(data,status){                    
					if(status == 'success'){
						$("#payroll").html(data);	
					}
				}
				);
		}
		
	}
	
</script>

@endsection