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
					<button type="button" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" @click="addMissing">
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
		<button type="button" class="btn btn-danger" data-dismiss="modal" @click="deleteClock(editClock.id)">Remove</button>
        <button type="button" class="btn btn-success" @click="updateClock(editClock)">Save</button>
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


					<div class="m-form__group form-group">
						<label for="">For Location</label>
						<div class="m-radio-inline">
							<label class="m-radio">
							<input type="radio" :value="false" v-model="otherLocation" @click="updateEmployeeList"> 本店员工
							<span></span>
							</label>
							<label class="m-radio">
							<input type="radio" :value="true" v-model="otherLocation"  @click="updateEmployeeList"> 借用员工
							<span></span>
							</label>
						</div>
						<span class="m-form__help">用于添加借用员工在本店的工时</span>
					</div>

					<div class="form-group m-form__group" v-if="otherLocation">
						<label>Location</label>

						<select class="form-control m-input" v-model="otherLocationSelected" @change="updateEmployeeList">
							<option value="null" disabled>Choose location</option>
							<option v-for="(text,key) in locations" :value="key "v-text="text"></option>
						</select>
					</div>

					<div class="form-group m-form__group">
						<label for="missingEmployee">Member</label>

						<select class="form-control m-input" id="missingList" v-model="add.selectedEmployee">
							<option value="null" disabled>Choose an employee</option>
							<option v-for="(employee,key) in employees" :value="key" v-text="employee"></option>
						</select>
					</div>

		
	<div class="d-md-none m--margin-bottom-10"></div>
					<div class="form-group m-form__group">
						<label for="missingClockInTime">
							Clock-in Time
						</label>
						<input type="text" class="form-control m-input datetimepicker" v-model="add.in" id="missingClockInTime" aria-describedby="missingClockInTime">
					</div>
					<div class="form-group m-form__group">
						<label for="missingClockOutTime">
							Clock-out Time
						</label>
						<input type="text" class="form-control m-input datetimepicker" v-model="add.out" id="missingClockOutTime" aria-describedby="missingClockOutTime">
					</div>
					
					
					
					<div class="form-group m-form__group">
						<label for="missingComment">
							Message
						</label>
						<textarea class="form-control m-input" id="missingComment" v-model="add.comment" rows="3" placeholder="Enter the reason for adding this clock record" required></textarea>
					</div>
				</div>
				
			</form>
			<!--end::Form-->
		</div>
		<!--end::Portlet-->


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" @click="close">Close</button>
        <button type="button" class="btn btn-primary" @click="saveMissing">Add</button>
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
		otherLocationSelected:null,
		isManager:@can('manage-managers') false @else true @endcan,
		employees:[],
		
		otherLocation:false,
		editClock:{
			id:null,
			in:null,
			out:null,
			comment:null,
		},
		add:{
			selectedEmployee:null,
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
				notify('Updated!','primary');
			}).catch(e => {
				console.log(e);
				alert(e);
			});
		},
		updateEmployeeList(){
			var listLocation = null;
			if(this.otherLocation){
				listLocation = this.otherLocationSelected;
			} else {
				listLocation = this.selectedLocation;
			}
			axios.post('/api/employeeBylocation',{
				location: listLocation
			}).then(res => {
				this.employees = res.data;
			}).catch(e => {
				console.log(e);
				alert(e);
			});
		},
		addMissing(){
			this.updateEmployeeList();

			$('#addModal').modal('show');
		},
		saveMissing(){
			axios.post('/clock/add',{
				location: this.selectedLocation,
				employee: this.add.selectedEmployee,
				clockIn: this.add.in,
				clockOut: this.add.out,
				comment: this.add.comment
			}).then(res => {
				if(res.data.success){
					this.close();
					this.selectedDateString = moment(res.data.data.clockIn).format('YYYY-MM-DD');
					this.updateList();
					notify(res.data.message,'primary');

				} else {
					this.close();
					notify(res.data.message,'danger');
				}
				
			}).catch(e => {
				alert(e);
				console.log(e);
			});
		},
		close(){
			$('#addModal').modal('hide');
			this.otherLocation = false;
			this.otherLocationSelected = null;
			this.add = { selectedEmployee:null };
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

		$('#clockInTime').on('changeDate', function(e){
			app.editClock.in = $('#clockInTime').val();
		});
		$('#clockOutTime').on('changeDate', function(e){
			app.editClock.out = $('#clockOutTime').val();
		});
		$('#missingClockInTime').on('changeDate', function(e){
			app.add.in = $('#missingClockInTime').val();
		});
		$('#missingClockOutTime').on('changeDate', function(e){
			app.add.out = $('#missingClockOutTime').val();
		});

	}
});

</script>
@endsection