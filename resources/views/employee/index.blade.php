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
												<li class="m-portlet__nav-item">
													<button type="button" class="btn btn-success"
													data-toggle="modal" data-target="#create-user"
													>Create User</button>
												</li>
											</ul>
										</div>
									</div>
									<div class="m-portlet__body">
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





<!-- Modal -->
<div class="modal fade" id="create-user" tabindex="-1" role="dialog" aria-labelledby="create-userLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="create-userLabel"><i class="flaticon-user-add"></i> Create User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>		
<script>
	function viewEmployee(employee){
		window.location.href='/staff/profile/' + employee + '/show';
	}
</script>						
@endsection