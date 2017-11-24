@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
								<div class="m-portlet">
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
												<div class="col-lg-4">
													
													{{ Form::select('location',$locations,-1,['class'=>'form-control m-input','id'=>'locationSelect'])}}
													
												</div>
												<div class="col-lg-4">
													
													{{ Form::select('status',$status,'active',['class'=>'form-control m-input','id'=>'statusSelect'])}}
													
												</div>
												<div class="col-lg-4">
													
													<div class="input-group m-input-group m-input-group--square">
														<span class="input-group-addon">
															<i class="la la-user"></i>
														</span>
														<input type="text" class="form-control m-input" placeholder="">
													</div>
												
												</div>
											</div>
											
										</div>
										
									</form>
									<!--end::Form-->

<div class="m-portlet__body" id="staffList">



<table class="table table-hover">
	<thead>
		<tr>
			<th>Employee</th><th>Username</th><th>Role</th><th>Date Hired</th>
		</tr>
	</thead>
	<tbody>
@foreach($employees as $e)

<tr onclick="viewEmployee('{{ $e->id }}')">
	<td>{{$e->cName}}<br>{{$e->employeeNumber}}<br>{{$e->job->rank}}</td>
	@if(isset($e->authorization->user->name))
	<td>{{ $e->authorization->user->name }}</td>
	<td>{{ $e->authorization->type }}</td>
	@else
	<td></td>
	<td></td>
	@endif
	<td>{{$e->hired->toFormattedDateString()}}</td>
</tr>

@endforeach
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
      <div class="modal-body">	

			
			<!--begin::Form-->
			<form class="m-form m-form--fit m-form--label-align-right">
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
							<input class="form-control m-input" type="text" placeholder="Chinese Name" ="" id="cName" name="cName" required>
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
							<input class="form-control m-input" type="text" placeholder="Pick a Date" id="hireDate" required>
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
				
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>
@endcan		
						
@endsection
@section('pageJS')

<script>
		function viewEmployee(employee){
		window.location.href='/staff/profile/' + employee + '/show';
	}
	$('#locationSelect').on('change',function(){
		filterEmployees();
	});
	$('#statusSelect').on('change',function(){
		filterEmployees();
	});

function filterEmployees(){
	$.post(
			'/filter/employee/list',
			{
				_token: '{{ csrf_token() }}',
				location: $('#locationSelect').val(),
				status: $('#statusSelect').val(),
			},
			function(data,status){
				if(status == 'success'){
					$('#staffList').html(data);
				}
			}
			);
}
</script>
@endsection