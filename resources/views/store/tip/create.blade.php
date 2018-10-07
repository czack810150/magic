@extends('layouts.master')
@section('content')
<div class="container">
<h1>Add Tip</h1>

<form class="form-inline">

	
		<div class="form-group">
		<label class="mr-sm-2" for="location">Location</label>
{{ Form::select('location',$locations,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder' => 'Choose a location','id'=>'location'])}}
		</div>

		<div class="form-group mx-sm-3">
			{{ Form::label('dateRange','Date range',['class'=>'mx-sm-3'])}}
			{{ Form::select('dateRange',$dates,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder'=>'Choose date range']) }}
		</div>


		<div class="form-group mx-sm-3">
			{{ Form::label('hourlyTip','Hourly Tips',['class'=>'mx-sm-3']) }}
			{{ Form::number('hourlyTip','0.00',['min'=>'0.00','step' => '0.01']) }}
		</div>


		{{ Form::button('Add',['class'=>'btn btn-success','onclick'=>'addTip()']) }}
		{{csrf_field()}}

</form>


<div class="input-group">
<a href="/tips">Back</a>
</div>
</div>

<script>

function addTip(){
		if($("#location").val() == '' || $("#dateRange").val()== ''){
			alert('You must choose a location and a date range.');
		} else{
			console.log('addTip()');
			$.post(
				'/tips/store',
				{
					location: $("#location").val(),
					startDate: $("#dateRange").val(),
					tip: $("#hourlyTip").val(),
					_token: $("input[name=_token]").val()
				},
				function(data,status){                    
					if(status == 'success'){
						$("#hourlyTip").val('0.00');
						console.log(data);	
					}
				}
				);
		}
		
	}


</script>

@endsection