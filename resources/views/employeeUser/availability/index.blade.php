@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
<div class="m-portlet" id="root">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<span class="m-portlet__head-icon">
					<i class="flaticon-clock"></i>
				</span>
				<h3 class="m-portlet__head-text">
					Available Hours for Work
				</h3>
			</div>
		</div>
		
	</div>



<div class="m-portlet__body">

{{$availability}}

</div> <!--end::Portlet body-->





@can('assign-skill')
<!-- Modal -->
<div class="modal fade" id="add-availability" tabindex="-1" role="dialog" aria-labelledby="addAvailabilityLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addAvailabilityLabel">Availability</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      
      <div class="modal-body">	

				<div class="m-portlet__body">

					<table class="table">
						<thead>
						<tr><th>Day</th><th style="width:30%">From</th><th style="width:30%">To</th></tr>
					</thead>
					<tbody>
						<tr>
							<th>Monday</th>
							<td>
								<select v-model="availability.mon.from" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							<td>
								<select v-model="availability.mon.to" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
						</tr>
						<tr>
							<th>Tuesday</th>
							<td>
								<select v-model="availability.tue.from" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							<td>
								<select v-model="availability.tue.to" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
						</tr>
							<tr>
							<th>Wednesday</th>
							<td>
								<select v-model="availability.wed.from" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							<td>
								<select v-model="availability.wed.to" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
						</tr>
						<tr>
							<th>Thursday</th>
							<td>
								<select v-model="availability.thu.from" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							<td>
								<select v-model="availability.thu.to" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							</tr>
							<tr>
							<th>Friday</th>
							<td>
								<select v-model="availability.fri.from" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							<td>
								<select v-model="availability.fri.to" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							<tr>
							<th>Saturday</th>
							<td>
								<select v-model="availability.sat.from" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							<td>
								<select v-model="availability.sat.to" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							</tr>
							<tr>
							<th>Sunday</th>
							<td>
								<select v-model="availability.sun.from" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							<td>
								<select v-model="availability.sun.to" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							</tr>
							<tr>
								<th>Hour Limit</th>
								<td>
									<select class="form-control m-input" v-model="availability.hourLimit">
		
								<option value="10">10 Hours</option>
								<option value="20">20 Hours</option>
								<option value="44">44 Hours</option>
								<option value="44+">More than 44 Hours</option>
								
							</select>
								</td>
							</tr>

							<tr>
								<th>Holiday</th>
								<td>
									<div class="m-checkbox-list">
												<label class="m-checkbox">
												<input type="checkbox" v-model="availability.holiday"> Ok to work on holidays
												<span></span>
												</label>
												
											</div>
								</td>
							</tr>
						
					</tbody>
					</table>
				</div>
			
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" v-on:click="submitAvailability">Save</button>
      </div>
    
    </div>
  </div>
</div>


@endcan		
				



</div>
<!--end::Portlet-->						
@endsection
@section('pageJS')

<script>

var app = new Vue({
	el:'#root',
	data:{
		user:{
			id:{{Auth::user()->authorization->employee_id}},
			name:'{{Auth::user()->authorization->employee->name}}',
			location:{{Auth::user()->authorization->location_id}},
		},
	
		token:'{{csrf_token()}}',
		currentEmployee:null,
		hours:[
			@foreach($hours as $h)
				'{{$h}}',
			@endforeach
		],

		availability:{
			mon:{
				from:null,
				to:null,
			},
			tue:{
				from:null,
				to:null,
			},
			wed:{
				from:null,
				to:null,
			},
			thu:{
				from:null,
				to:null,
			},
			fri:{
				from:null,
				to:null,
			},
			sat:{
				from:null,
				to:null,
			},
			sun:{
				from:null,
				to:null,
			},
			hourLimit:44,
			holiday:true,
		},
	},
	methods:{
		viewEmployee: function (employee){
		window.location.href='/staff/profile/' + employee + '/show';
		},
		locationSelect(){
			
			this.filterEmployees();
		},
		statusSelect(){
			
			this.filterEmployees();
		},
		groupSelect(){
			
			this.filterEmployees();
		},
		filterEmployees(){
			axios.post('/filter/employee/list',{
				_token: this.token,
				location: this.selectedLocation,
				status: this.selectedStatus,
				group: this.selectedGroup,
			}).then(function(response){
				app.employees = response.data;
			})
		},
		searchEmployee(){
			axios.post('/employee/search',{
				_token: this.token,
				location: this.selectedLocation,
				status: this.selectedStatus,
				searchStr: this.searchString,
			}).then(function(response){
				app.employees = response.data;
			})
		},
		addAvailability(e){
			this.currentEmployee = e;
			$('#add-availability').modal('show');
		},
		
		availabilityReset(){
			this.availability = {
			mon:{
				from:null,
				to:null,
			},
			tue:{
				from:null,
				to:null,
			},
			wed:{
				from:null,
				to:null,
			},
			thu:{
				from:null,
				to:null,
			},
			fri:{
				from:null,
				to:null,
			},
			sat:{
				from:null,
				to:null,
			},
			sun:{
				from:null,
				to:null,
			},
			hourLimit:44,
			holiday:true,
			}
		},
		updateEmployeeSkillView(){
			this.filterEmployees();
		},
		editAvailability(employee){
			
			this.currentEmployee = employee;
			this.availability = {
			mon:{
				from:employee.availability.monFrom,
				to:employee.availability.monTo,
			},
			tue:{
				from:employee.availability.tueFrom,
				to:employee.availability.tueTo,
			},
			wed:{
				from:employee.availability.wedFrom,
				to:employee.availability.wedTo,
			},
			thu:{
				from:employee.availability.thuFrom,
				to:employee.availability.thuTo,
			},
			fri:{
				from:employee.availability.friFrom,
				to:employee.availability.friTo,
			},
			sat:{
				from:employee.availability.satFrom,
				to:employee.availability.satTo,
			},
			sun:{
				from:employee.availability.sunFrom,
				to:employee.availability.sunTo,
			},
			hourLimit:employee.availability.hours,
			holiday:employee.availability.holiday,
			}
			$('#add-availability').modal('show');
		},
		
		submitAvailability(){
			axios.post('/employee_availability/add',{
				employee:app.currentEmployee,
				availability: app.availability
			}).then(function(response){
				if(response.data == 'success'){
					$.notify({
							title: 'Success!',
							message: 'Availability has been updated!'
						},{
							type:'success',
							placement: { from:'top',align:'center'}
						});
				}

				
			});

			this.filterEmployees();
			this.availabilityReset();
			$('#add-availability').modal('hide');

		},
		formattedTime(tm){
			if(tm != null){
				return moment(tm,'HH:mm:ss').format('HH:mm');
			} else {
				return null;
			}
			
		}
	},

	}
})

</script>
@endsection