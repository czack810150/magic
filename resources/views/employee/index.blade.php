@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
<div class="m-portlet" id="root">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<span class="m-portlet__head-icon">
					<i class="flaticon-users"></i>
				</span>
				<h3 class="m-portlet__head-text">
					View and manage your staff. Click on any employee name to go to their profile.
				</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				@can('create-employee')
				<li class="m-portlet__nav-item">
					<button type="button" class="btn btn-success"
					data-toggle="modal" data-target="#create-user"
					>Create User</button>
				</li>
				@endcan
			</ul>
		</div>
	</div>

<!--begin::Form-->
	<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
		<div class="m-portlet__body">
			<div class="form-group m-form__group row">
				<div class="col-lg-3">
					<div class="form-group m-form__group">
					{{ Form::select('location',$locations,-1,['class'=>'custom-select m-input','v-on:change'=>'locationSelect','v-model'=>'selectedLocation'])}}
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

<table class="table table-hover">
	<thead>
		<tr>
			<th>Employee</th><th>Username</th><th>Role</th><th>Date Hired</th>
		</tr>
	</thead>
	<tbody>


<tr v-for="employee in employees" @click="viewEmployee(employee.id)">
	<td>@{{employee.name}} @{{employee.alias}} 
		<span v-if="(employee.job_group =='trial' && employee.effectiveHours >= 180)" class="m-badge m-badge--warning m-badge--wide m-badge--rounded">试用期满</span>
	<br>@{{employee.employeeNumber}}<br>@{{employee.job_title}}</td>
	
	<td>@{{ employee.username }}</td>
	<td>@{{ employee.job_group }}</td>
	
	
	<td>@{{ employee.hired_date}}  <span class="m--font-danger">@{{employee.termination_date}}</span></td>
</tr>
	</tbody>
</table>

	</div>
</div>
<!--end::Portlet-->




@can('create-employee')
<!-- Modal -->
<div class="modal fade" id="create-user" tabindex="-1" role="dialog" aria-labelledby="create-userLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="create-userLabel"><i class="flaticon-user-add"></i> Create User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!--begin::Form-->
			<form class="m-form m-form--fit m-form--label-align-right" method="POST" action="/employee/store">
				{{ csrf_field() }}
      <div class="modal-body">	

			
			
				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<label for="employeeLocation" class="col-4 col-form-label">Location</label>
						<div class="col-8">
							{{ Form::select('employeeLocation',$employeeLocations,1,['class'=>'form-control m-input','id'=>'employeeLocation'])}}
						</div>
					</div>
					
					<div class="form-group m-form__group row">
						<label for="employeeRole" class="col-4 col-form-label">Role</label>
						<div class="col-8">
							<select class="form-control m-input" id="employeeRole" name="employeeRole">
								<option value="2" selected>Employee</option>
								<option value="20">Manager</option>
							</select>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label for="firstName" class="col-4 col-form-label">First Name</label>
						<div class="col-8">
							<input class="form-control m-input" type="text" placeholder="First Name" ="" id="firstName" name="firstName" required>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label for="lastName" class="col-4 col-form-label">Last Name</label>
						<div class="col-8">
							<input class="form-control m-input" type="text" placeholder="Last Name" ="" id="lastName" name="lastName" required>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label for="cName" class="col-4 col-form-label">中文名</label>
						<div class="col-8">
							<input class="form-control m-input" type="text" placeholder="Chinese Name" ="" id="cName" name="cName">
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label for="job" class="col-4 col-form-label">Job Title</label>
						<div class="col-8">
							{{Form::select('job',$jobs,null,['class'=>'form-control m-input','id'=>'job'])}}
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label for="employeeNumber" class="col-4 col-form-label">Employee ID</label>
						<div class="col-8">
							<input class="form-control m-input" type="text" placeholder="Employee Number" id="employeeNumber" name="employeeNumber" required>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label for="hireDate" class="col-4 col-form-label">Date Hired</label>
						<div class="col-8">
							<input class="form-control m-input" type="text" placeholder="Pick a Date" id="hireDate" name="hireDate" required>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label for="email" class="col-4 col-form-label">Email</label>
						<div class="col-8">
							<input class="form-control m-input" type="email" placeholder="Email Address" id="email" name="email" required>
							<span class="m-form__help">The email must be unique among all users.</span>
						</div>
					</div>
				</div>
			
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endcan		
						
@endsection
@section('pageJS')

<script>

var app = new Vue({
	el:'#root',
	data:{
		searchString:'',
		token:'{{csrf_token()}}',
		selectedLocation:{{ Auth::user()->authorization->location_id }},
		selectedStatus:'active',
		selectedGroup:'%',
		employees: [
			@foreach($employees as $e)
			{
				id: {{$e->id}},
				name: '{{$e->name}}',
				@if($e->employee_profile)
				alias: '{{$e->employee_profile->alias}}',
				@endif
				job_title: '{{$e->job->rank}}',
				employeeNumber: '{{$e->employeeNumber}}',
				job_group: '{{$e->job_group}}',
				@if(isset($e->authorization->user->name))
				username:'{{ $e->authorization->user->name }}',
				type:'{{ $e->authorization->type }}',
				@endif
				hired_date: '{{$e->hired->toFormattedDateString()}}',
				termination_date: '{{$e->termination}}',
			},
			@endforeach
		]
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
		}
	}
})

</script>
@endsection