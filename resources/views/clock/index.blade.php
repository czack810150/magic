@extends('layouts.master')
@section('content')
<div id="root">
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
									<label for="location">Store:</label>
								</div>
								<div class="m-form__control">
									<select v-model="selectedLocation" class="custom-select mb-2 mr-sm-2 mb-sm-0" placeholder="Choose a location" :disabled="isManager">
										<option value="" disabled>Choose a location</option>
										<option v-for="(text,key) in locations" :value="key "v-text="text"></option>
									</select>
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
								
			<input type="text" class="form-control m-input m-input--solid" placeholder="Pick a date..." id="clockDatePikcer" v-model="selectedDate" @change="updateList">
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
			<table class="table" v-if="clocks.length">
				<thead><tr><th>Employee</th><th>Location</th><th>ClockIn</th><th>ClockOut</th><th>Comment<th>Edit</th></tr></thead>
				<tbody>
					<tr v-for="clock in clocks">
						<td>@{{ clock.employee.name }}</td>
						<td>@{{ clock.location.name }}</td>
						<td>@{{ clock.clockIn }}</td>
						<td>@{{ clock.clockOut }}</td>
						<td>@{{ clock.comment }}</td>
						<td><button type="button" class="btn btn-primary" @click="edit(clock)">Edit</button></td>
					</tr>
				</tbody>
			</table>
			<div class="alert alert-default" role="alert" v-else>
				Please choose a location and pick a date.
			</div>
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
												<input type="text" class="form-control m-input datetimepicker" v-model="editClock.in" id="clockInTime" aria-describedby="clockInTime">
											</div>
											<div class="form-group m-form__group">
												<label for="clockOutTime">
													Clock-out Time
												</label>
												<input type="text" class="form-control m-input  datetimepicker" v-model="editClock.out" id="clockOutTime" aria-describedby="clockOutTime" >
											</div>
											
											
											
											<div class="form-group m-form__group">
												<label for="comment">
													Comment
												</label>
												<textarea class="form-control m-input" id="comment" rows="3" v-model="editClock.comment"></textarea>
											</div>
										</div>
										
									</form>
									<!--end::Form-->
								</div>
								<!--end::Portlet-->


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal" @click="deleteClock(editClock.id)">删除</button>
        <button type="button" class="btn btn-success" @click="updateClock(editClock)">保存</button>
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
												<label for="missingEmployee">Employee:</label>
						
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


</div>
@endsection

@section('pageJS')

<script>
let app = new Vue({
	el:'#root',
	data:{
		selectedLocation:@can('manage-managers') '' @else {{ auth()->user()->authorization->location_id }} @endcan,
		selectedDate:null,
		selectedDateString:null,
		clocks:[],
		locations: @json($locations),
		isManager:@can('manage-managers') false @else true @endcan,
		editClock:{
			id:null,
			in:null,
			out:null,
			comment:null,
		}
	},
	methods:{
		updateList(){
			axios.post('/clock/clocksByLocationDate',
			{
				location: this.selectedLocation,
				date: this.selectedDateString,
			}).then(res => {
				this.clocks = res.data;
			}).catch(e => {
				console.log(e);
				alert(e);
			});
		},
		edit(clock){
			this.editClock.id = clock.id;
			this.editClock.in = clock.clockIn;
			this.editClock.out = clock.clockOut;
			this.editClock.comment = clock.comment;
			$('#clockModal').modal('show');
		},
		deleteClock(id){
			axios.post('/clock/'+id+'/delete',{
			}).then(res => {
				$('#clockModal').modal('hide');
				this.updateList();
			}).catch(e => {
				alert(e);
				console.log(e);
			})
		},
		updateClock(clock){
			console.log(clock);
			axios.post('/clock/update',{
				clockId: clock.id,
				clockIn: clock.in,
				clockOut: clock.out,
				comment: clock.comment,
			}).then(res => {
				$('#clockModal').modal('hide');
				this.updateList();
			}).catch(e => {
				console.log(e);
				alert(e);
			});
		}
	},
	mounted(){

		$('#clockDatePikcer').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
		 	templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
		});

		$('#clockDatePikcer').on('hide',function(e){
			var location = this.selectedLocation;
			if(location != '' ){
				app.selectedDateString = e.format('yyyy-mm-dd');
				app.updateList();
			} else {
				alert('Must provide a location.');
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

		$('#clockInTime').on('hide', function(e){
			console.log(e);
			console.log(moment(e.date).format('YYYY-MM-DD HH:mm'));
			app.editClock.in = moment(e.date).format('YYYY-MM-DD HH:mm');
		});

	}
});





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