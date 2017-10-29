@extends('layouts.master')
@section('content')
<div class="container-fluid">
<h1>Employee Performance</h1>
<form class="form-inline">

	
		<div class="form-group">
		<label class="mr-sm-2" for="location">Location</label>
{{ Form::select('location',$locations,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder' => 'Choose a location','id'=>'location'])}}
		</div>

		<div class="form-group mx-sm-3">
			{{ Form::label('dateRange','Date range',['class'=>'mx-sm-3'])}}
			{{ Form::select('dateRange',$dates,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder'=>'Choose date range']) }}
		</div>
		{{ Form::button('Review',['class'=>'btn btn-primary','onclick'=>'viewLocationDate()']) }}
		{{csrf_field()}}

</form>

<main id="employees">

</main>





</div>


<script>



    let transition = '<div class="row"><div class="col-md-4 offset-md-5"><h1><i class="fa fa-spinner fa-pulse fa-3x"></i></h1></div></div>';

	function viewLocationDate(){
		if($("#location").val() == '' || $("#dateRange").val()== ''){
			alert('You must choose a location and a date range.');
		} else{
			$("#employees").html(transition);
			$.post(
				'/employee/reviewable',
				{
					location: $("#location").val(),
					startDate: $("#dateRange").val(),
					_token: $("input[name=_token]").val()
				},
				function(data,status){                    
					if(status == 'success'){
						$("#employees").html(data);	
					}
				}
				);
		}
		
	}
	
</script>

@endsection