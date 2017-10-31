@extends('layouts.master')
@section('content')
<div class="container-fluid">
<h1>Employee Performance </h1>
<form class="form-inline">

	
		<div class="form-group">
		<label class="mr-sm-2" for="location">Location</label>
{{ Form::select('location',$locations,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0',
'placeholder' => 'Choose a location','id'=>'location','onchange'=>'locationEmployees()'
])}}
		</div>

		<div class="form-group">
		<label class="mr-sm-2" for="period">Period</label>
{{ Form::select('period',$dates,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','id'=>'period','onchange'=>'locationEmployees()'
])}}
		</div>

		
		

</form>

<main id="employees">

</main>





</div>

@endsection
@section('pageJS')
<script>


//var list = $('#location');
    let transition = '<div class="row"><div class="col-md-4 offset-md-5"><h1><i class="fa fa-spinner fa-pulse fa-3x"></i></h1></div></div>';

//list.on('change',locationEmployees());
	function locationEmployees(){
		if($("#location").val() == '' ){
			alert('You must choose a location.');
		} else{
			$("#employees").html(transition);
			$.post(
				'/employee/reviewable',
				{
					period: $("#period").val(),
					location: $("#location").val(),
					_token: '{{ csrf_token() }}'
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