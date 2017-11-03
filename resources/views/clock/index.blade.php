@extends('layouts.master')
@section('content')
<div class="m-portlet m-portlet--bordered m-portlet--rounded m-portlet--unair">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">Recorded Employee Clocks</h3>
			</div>
		</div>
	</div>

	<div class="m-portlet__body">
				<!--begin: Search Form -->
		<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
			<div class="row align-items-center">
				<div class="col-xl-8 order-2 order-xl-1">
					<div class="form-group m-form__group row align-items-center">
						<div class="col-md-4">
							<div class="m-form__group m-form__group--inline">
								<div class="m-form__label">
									<labe for="location">Store:</label>
								</div>
								<div class="m-form__control">
									{{ Form::select('location',$locations,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder' => 'Choose a location','id'=>'location','onchange'=>'changeLocation()'])}}
								</div>
							</div>
							<div class="d-md-none m--margin-bottom-10"></div>
						</div>
						<div class="col-md-4">
							<div class="m-form__group m-form__group--inline">
								<div class="m-form__label">
									<label class="m-label m-label--single">Period:</label>
								</div>
								<div class="m-form__control">
								
			<input type="text" class="form-control m-input m-input--solid" placeholder="Pick a date..." id="clockDatePikcer">
								</div>
							</div>
							<div class="d-md-none m--margin-bottom-10"></div>
						</div>
						<div class="col-md-4">
						
						</div>
					</div>
				</div>
				<div class="col-xl-4 order-1 order-xl-2 m--align-right">
					<a href="#" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
						<span>
							<i class="la la-plus"></i>
							<span>Missing Clock</span>
						</span>
					</a>					
					<div class="m-separator m-separator--dashed d-xl-none"></div>
				</div>
			</div>
		</div>
		<!--end: Search Form -->
		<section id="clockTable">
		</section>			
	</div>
</div>


@endsection

@section('pageJS')

<script>

var dateStringx = '';

	$('#clockDatePikcer').datepicker({
		todayHighlight: true,
		orientation: "bottom left",
		 templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
	});


$('#clockDatePikcer').on('hide',function(e){
	var location = $('#location').val();
	if(location > 0 ){
		dateStringx = e.format('yyyy-mm-dd');
		updateTable();
	} else {
		alert('Must provide a locatiion.');
	}
});

function changeLocation(){
	var location = $('#location').val();
	if(location > 0 && $('#clockDatePikcer').val() != ''){
		updateTable();
	}
}

function updateTable(){
	$.post(
			'/clock/clocksByLocationDate',
			{
				_token:'{{csrf_token()}}',
				location: $('#location').val(),
				date: dateStringx,
			},
			function(data,status){
				if(status == 'success'){
					$('#clockTable').html(data);
				}
			},
			
			);
}

</script>
@endsection