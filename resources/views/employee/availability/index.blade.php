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

<!--begin::Form-->
	<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
		<div class="m-portlet__body">
			<div class="form-group m-form__group row">
				<div class="col-lg-3">
					<div class="form-group m-form__group">
					{{ Form::select('location',$locations,-1,['class'=>'custom-select m-input','v-on:click'=>'locationSelect','v-model'=>'selectedLocation'])}}
				</div>
					
				</div>
				<div class="col-lg-3">
					<div class="form-group m-form__group">
					{{ Form::select('status',$status,'active',['class'=>'custom-select m-input','@change'=>'statusSelect','v-model'=>'selectedStatus'])}}
				</div>
				</div>
				<div class="col-lg-3">
					<div class="form-group m-form__group">
					{{ Form::select('job_group',$groups,'all',['class'=>'custom-select m-input','@change'=>'groupSelect','v-model'=>'selectedGroup'])}}
					</div>
				</div>
				<div class="col-lg-3">
					
					<div class="form-group m-form__group">
						
						<div class="m-input-icon m-input-icon--left">
						<input type="text" class="form-control m-input" placeholder="Search" v-on:keyup="searchEmployee" v-model="searchString">
						<span class="m-input-icon__icon m-input-icon__icon--left">
						<span>
							<i class="la la-user"></i>
						</span>
						</span>
						</div>
					</div>
				
				</div>
			</div>
			
		</div>
		
	</form>
<!--end::Form-->

<div class="m-portlet__body" id="staffList">

@include('layouts.errors')

<table class="table">
	<thead>
		<tr>
			<th>Employee</th>
			<th>Action</th>
			<th>Mon</th>
			<th>Tue</th>
			<th>Wed</th>
			<th>Thu</th>
			<th>Fri</th>
			<th>Sat</th>
			<th>Sun</th>
			<th>Hour Limit</th>
			<th>Holiday</th>
		</tr>
	</thead>
	<tbody>


<tr v-for="employee in employees" >
	<td>@{{employee.name}} @{{employee.alias}}<br>@{{employee.employeeNumber}}<br>@{{employee.job_title}}</td>
	<td>
	<button v-if="employee.availability == null" v-on:click="addAvailability(employee.id)" type="button" class="btn m-btn--pill btn-secondary m-btn--custom m-btn--label-metal m-btn--border btn-sm">Add</button>
	<button v-else type="button" @click="editAvailability(employee.id)" class="btn m-btn--pill btn-secondary m-btn--custom m-btn--label-metal m-btn--border btn-sm">Edit</button>
	</td>
	<template v-if="employee.availability != null">
	<td>
		<p>@{{formattedTime(employee.availability.monFrom)}}</p>
		<p>@{{formattedTime(employee.availability.monTo)}}</p>
	</td>

	<td>
		<p>@{{formattedTime(employee.availability.tueFrom)}}</p>
		<p>@{{formattedTime(employee.availability.tueTo)}}</p>
	</td>
	<td>
		<p>@{{formattedTime(employee.availability.wedFrom)}}</p>
		<p>@{{formattedTime(employee.availability.wedTo)}}</p>
	</td>
	<td>
		<p>@{{formattedTime(employee.availability.thuFrom)}}</p>
		<p>@{{formattedTime(employee.availability.thuTo)}}</p>
	</td>
	<td>
		<p>@{{formattedTime(employee.availability.friFrom)}}</p>
		<p>@{{formattedTime(employee.availability.friTo)}}</p>
	</td>
	<td>
		<p>@{{formattedTime(employee.availability.satFrom)}}</p>
		<p>@{{formattedTime(employee.availability.satTo)}}</p>
	</td>
	<td>
		<p>@{{formattedTime(employee.availability.sunFrom)}}</p>
		<p>@{{formattedTime(employee.availability.sunTo)}}</p>
	</td>
	<td>
		@{{employee.availability.hours}}
	</td>
	<td v-if="employee.availability.holiday === 1" class="m--font-success">
		Ok to work
	</td>
	<td v-else class="m--font-danger">
		Unavailable
	</td>
	</template>
	<template v-else>
		<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
	</template>
</tr>
	</tbody>
</table>

	</div> <!--end::Portlet body-->





@can('assign-skill')
<!-- Modal -->
<div class="modal fade" id="add-availability" tabindex="-1" role="dialog" aria-labelledby="addAvailabilityLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addAvailabilityLabel"><i class="flaticon-user-add"></i> Add Availability</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      
      <div class="modal-body">	

				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<label  class="col-4 col-form-label">Hour</label>
						<div class="col-8">
							<select v-model="newSkill" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
							</select>
						</div>
					</div>
					
					<div class="form-group m-form__group row">
						<label for="skillLevel" class="col-4 col-form-label">Level</label>
						<div class="col-8">
							<select class="form-control m-input" id="skillLevel" v-model="skillLevel">
		
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
								<option value="D">D</option>
								<option value="E">E</option>
								<option value="F">F</option>
							</select>
						</div>
					</div>
					
					
					<div class="form-group m-form__group row">
						<label for="assignedBy" class="col-4 col-form-label">Assigned By</label>
						<div class="col-8">
							<input class="form-control m-input m-input--solid" disabled :placeholder="user.name"></input>
						</div>
					</div>
					
					
				</div>
			
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" v-on:click="submitSkill">Save</button>
      </div>
    
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="edit-availability" tabindex="-1" role="dialog" aria-labelledby="editAvailabilityLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="assign-skillLabel"><i class="flaticon-user-add"></i> Change Availability</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      
      <div class="modal-body">	

			
			
				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<label for="currentSkill" class="col-4 col-form-label">Skill</label>
						<div class="col-8">
							<input class="form-control m-input m-input--solid" disabled :placeholder="currentSkill.name"></input>
						</div>
					</div>
					
					<div class="form-group m-form__group row">
						<label for="skillLevelUpdate" class="col-4 col-form-label">Level</label>
						<div class="col-8">
							<select class="form-control m-input" id="skillLevel" v-model="skillLevelUpdate">
		
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
								<option value="D">D</option>
								<option value="E">E</option>
								<option value="F">F</option>
							</select>
						</div>
					</div>
					
					
					<div class="form-group m-form__group row">
						<label for="assignedBy" class="col-4 col-form-label">By</label>
						<div class="col-8">
							<input class="form-control m-input m-input--solid" disabled :placeholder="user.name"></input>
						</div>
					</div>
					
					
				</div>
			
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-danger" v-on:click="removeSkill">Remove</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" v-on:click="submitEditSkill">Update</button>
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
		searchString:'',
		token:'{{csrf_token()}}',
		currentEmployee:null,
		currentSkill: {id:null,name:'',level:null},
		newSkill:null,
		skillLevel:'F',
		skillLevelUpdate:'',
		selectedLocation:-1,
		selectedStatus:'active',
		selectedGroup:'%',
		hours:[
			@foreach($hours as $h)
				'{{$h}}',
			@endforeach
		],

		employees: [],
		availability:{
			monFrom:null,
			monTo:null,
			tueFrom:null,
			tueTo:null,
			wedFrom:null,
			wedTo:null,
			thuFrom:null,
			thuTo:null,
			friFrom:null,
			friTo:null,
			satFrom:null,
			satTo:null,
			sunTo:null,
			sunFrom:null,
			limit:null,
			holiday:null,
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
		submitSkill(){
			
			if(this.newSkill != null){
				axios.post('/employee_skill/assign',{
				employee: this.currentEmployee,
				skill: this.newSkill,
				level: this.skillLevel,
				assignedBy: this.user.id
				}).then(function(response){
					if(response.data.status == 'success'){
						app.assignSkillReset();
						$('#assign-skill').modal('hide');
						$.notify({
							title: 'Success!',
							message: response.data.message
						},{
							type:'success',
							placement: { from:'top',align:'center'}
						});
						app.updateEmployeeSkillView();
					} else {
						app.assignSkillReset();
						$('#assign-skill').modal('hide');
						$.notify({
							title: 'Failed!',
							message: response.data.message
						},{
							type:'danger',
							placement: { from:'top',align:'center'}
						});
					}
				});
				
			} else {
				alert('You must choose a skill to submit.')
			}
			
		},
		assignSkillReset(){
			this.currentEmployee = null;
			this.newSkill = null;
			this.skillLevel = 'F';
		},
		updateEmployeeSkillView(){
			this.filterEmployees();
		},
		editAvailability(employee){
			$('#edit-availability').modal('show');
			this.currentEmployee = employee;
		},
		removeSkill(){
			axios.post('/employee_skill/' + app.currentSkill.id + '/destroy',{

			}).then(function(response){
				if(response.data){
					
					$('#change-skill').modal('hide');
					app.assignSkillReset()
					app.currentSkill = {id:null,name:'',level:null}
					app.skillLevelUpdate = '',
					$.notify({
							title: 'Skill Removed!',
							message: 'The Skill has been successfully removed.'
						},{
							type:'warning',
							placement: { from:'top',align:'center'}
						});
					app.updateEmployeeSkillView();

				}
			});
		},
		submitEditSkill(){
			axios.post('/employee_skill/' + app.currentSkill.id + '/update',{
				level: app.skillLevelUpdate
			}).then(function(response){
				if(response.data){
					$('#change-skill').modal('hide');
					app.assignSkillReset()
					app.currentSkill = {id:null,name:'',level:null}
					app.skillLevelUpdate = '',
					$.notify({
							title: 'Success!',
							message: 'The Skill Level has been successfully updated!'
						},{
							type:'info',
							placement: { from:'top',align:'center'}
						});
					app.updateEmployeeSkillView();
				}
			});
		},
		formattedTime(tm){
			if(tm != null){
				return moment(tm,'HH:mm:ss').format('HH:mm');
			} else {
				return null;
			}
			
		}
	},
	mounted(){
		this.filterEmployees();
	}
})

</script>
@endsection