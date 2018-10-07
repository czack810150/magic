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
					<button type="button" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" onclick="addMissing()">
						<span>
							<i class="la la-plus"></i>
							<span>Missing Clock</span>
						</span>
					</button>					
					<div class="m-separator m-separator--dashed d-xl-none"></div>
				</div>
			</div>
		</div>
		<!--end: Search Form -->
		<section id="clockTable">
		</section>			
	</div>
</div>



<!-- Modal update -->
<div class="modal fade" id="clockModal" tabindex="-1" role="dialog" aria-labelledby="clockModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="clockModalLabel">Edit Clock Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
      	<!--begin::Portlet-->
								<div class="m-portlet m-portlet--tab">
					
									<!--begin::Form-->
									<form class="m-form m-form--fit m-form--label-align-right">
										<div class="m-portlet__body">
											<div class="form-group m-form__group m--margin-top-10">
												<div class="alert m-alert m-alert--default" role="alert">
													Be sure to leave a comment.
												</div>
											</div>
											<div class="form-group m-form__group">
												<label for="clockInTime">
													Clock-in Time
												</label>
												<input type="text" class="form-control m-input datetimepicker" id="clockInTime"" aria-describedby="clockInTime" value="">
											</div>
											<div class="form-group m-form__group">
												<label for="clockOutTime">
													Clock-out Time
												</label>
												<input type="text" class="form-control m-input  datetimepicker" id="clockOutTime"" aria-describedby="clockOutTime" value="">
											</div>
											
											
											
											<div class="form-group m-form__group">
												<label for="comment">
													Comment
												</label>
												<textarea class="form-control m-input" id="comment" rows="3"></textarea>
											</div>
										</div>
										
									</form>
									<!--end::Form-->
								</div>
								<!--end::Portlet-->


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="deleteClock()">删除</button>
        <button type="button" class="btn btn-success" onclick="updateClock()">保存</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal add missing -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add Missing Clock Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
      	<!--begin::Portlet-->
								<div class="m-portlet m-portlet--tab">
					
									<!--begin::Form-->
									<form class="m-form m-form--fit m-form--label-align-right">
										<div class="m-portlet__body">
											<div class="form-group m-form__group m--margin-top-10">
												<div class="alert m-alert m-alert--default" role="alert">
													Make sure it is a valid clock time.
												</div>
											</div>


											<div class="form-group m-form__group">
												<labe for="missingEmployee">Employee:</label>
						
												<select class="form-control m-input" id="missingList">
												
												</select>
											</div>

								
							<div class="d-md-none m--margin-bottom-10"></div>
											<div class="form-group m-form__group">
												<label for="missingClockInTime">
													Clock-in Time
												</label>
												<input type="text" class="form-control m-input datetimepicker" id="missingClockInTime"" aria-describedby="missingClockInTime" value="">
											</div>
											<div class="form-group m-form__group">
												<label for="missingClockOutTime">
													Clock-out Time
												</label>
												<input type="text" class="form-control m-input datetimepicker" id="missingClockOutTime"" aria-describedby="missingClockOutTime" value="">
											</div>
											
											
											
											<div class="form-group m-form__group">
												<label for="missingComment">
													Comment
												</label>
												<textarea class="form-control m-input" id="missingComment" rows="3"></textarea>
											</div>
										</div>
										
									</form>
									<!--end::Form-->
								</div>
								<!--end::Portlet-->


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveMissing()">Save changes</button>
      </div>
    </div>
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
	$('.datetimepicker').datetimepicker({
		todayHighlight: false,
		orientation: "bottom left",
		 templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
	});


$('#clockDatePikcer').on('hide',function(e){
	var location = $('#location').val();
	if(location != '' ){
		dateStringx = e.format('yyyy-mm-dd');
		updateTable();
	} else {
		alert('Must provide a location.');
	}
});

function changeLocation(){
	var location = $('#location').val();
	if( $('#clockDatePikcer').val() != ''){
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
var clockID = 0;
function editClock(clockId){
	clockID = clockId;
	$.post(
		'/clock/edit',
		{
			_token:'{{ csrf_token() }}',
			clockId: clockId,
		},
		function(data,status){
			if(status == 'success'){
				$('#clockInTime').val(data.clockIn);
				$('#clockOutTime').val(data.clockOut);
				$('#comment').val(data.comment);
				
			}
		},
		'json'
		);
	$('#clockModal').modal();
}
function updateClock(){
	$.post(
		'/clock/update',
		{
			_token:'{{ csrf_token() }}',
			clockId: clockID,
			clockIn: $('#clockInTime').val(),
			clockOut: $('#clockOutTime').val(),
			comment: $('#comment').val(),
		},
		function(data,status){
			if(status == 'success'){
				$('#clockModal').modal('hide');
				updateTable();
			}
		}
		);
}
function deleteClock(){
	$.post(
		'/clock/'+clockID+'/delete',
		{
			_token:'{{ csrf_token() }}',
		},
		function(data,status){
			if(status == 'success'){
				$('#clockModal').modal('hide');
				updateTable();
				console.log(data);
			}
		}
		);
}
function addMissing(){
	$.post(
	'/api/employeeBylocation',
	{
		location: $('#location').val()
	},
	function(data,status){
		if(status == 'success'){
			var html = '';
			for(i in data){
				html += '<option value="'+ i +'">' + data[i] + '</option>';
			}

			$('#missingList').html(html);
			$('#addModal').modal();
		}
	},'json'
);	
}
function saveMissing(){
	$.post(
	'/clock/add',
	{
		location: $('#location').val(),
		employee: $('#missingList').val(),
		_token:'{{ csrf_token() }}',
			clockIn: $('#missingClockInTime').val(),
			clockOut: $('#missingClockOutTime').val(),
			comment: $('#missingComment').val(),
	},
	function(data,status){
		if(status == 'success'){
			$('#addModal').modal('hide');
		}
	}
);
}

</script>
@endsection