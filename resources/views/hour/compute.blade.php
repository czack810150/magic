@extends('layouts.master')
@section('content')

@include('hour.nav')
<div class="container">

 <main role="main">

        <div class="jumbotron">
          <h1 class="display-3">Employee hours compute engine</h1>
          <p class="lead">A place to compute employee scheduled hours, clocked hours, effective hours, overtime hours and night shift hours for a given payroll period.

        <section id="hours">
        <form class="form-inline my-2">
        	{{csrf_field()}}
		<div class="form-group">

		<div class="form-group mx-sm-3">
			{{ Form::label('dateRange','For payroll period',['class'=>'mx-sm-3'])}}
			{{ Form::select('dateRange',$dates,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder'=>'Choose date range']) }}
		</div>
		{{ Form::button('Compute!',['class'=>'btn btn-primary','onclick'=>'viewLocationDate()']) }}
		

		</form>
	    </section>

        </div>
      </main>


</div>


<script>



    let transition = '<div class="row justify-content-md-center"><div class="col-md-1"><h1><i class="fa fa-spinner fa-pulse fa"></i></h1></div></div>';

	function viewLocationDate(){
		console.log($("input[name=_token]").val());
		if($("#location").val() == '' || $("#dateRange").val()== ''){
			alert('You must choose a location and a date range.');
		} else{
			$("#hours").html(transition);
			$.post(
				'/hours/computeEngine',
				{
					startDate: $("#dateRange").val(),
					_token: $("input[name=_token]").val(),
				},
				function(data,status){                    
					if(status == 'success'){
						$("#hours").html(data);	
					}
				}
				);
		}
		
	}
	
</script>

@endsection