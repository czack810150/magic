@extends('layouts.master')
@section('content')

<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Current Users
				</h3>
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
							<div class="m-input-icon m-input-icon--left">
								<input type="text" class="form-control m-input m-input--solid" placeholder="Search..." id="generalSearch">
								<span class="m-input-icon__icon m-input-icon__icon--left">
									<span><i class="la la-search"></i></span>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 order-1 order-xl-2 m--align-right">
					<a href="/users/new" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
						<span>
							<i class="la la-plus"></i>
							<span>New User</span>
						</span>
					</a>
					<div class="m-separator m-separator--dashed d-xl-none"></div>
				</div>
			</div>
		</div>
		<!--end: Search Form -->

		<!--begin: Datatable -->
		<table class="table table-hover"  width="100%">
			<thead>
			<tr>
				<th title="Field #1">User ID</th>
				<th title="Field #2">User Name</th>
				<th title="Field #3">Email</th>
				<th>Employee</th>
				<th title="Field #4">Type</th>
				<th title="Field #5">Location</th>
				<th title="Field #6">Level</th>
				<th title="Field #7">Created at</th>
				<th title="Field #8">Updated at</th>
			</tr>
			</thead>
			<tbody>
				@foreach($users as $u)
			<tr>
				<td>{{ $u->id }}</td>
				<td>{{ $u->name }}</td>
				<td>{{ $u->email }}</td>
				@if(isset($u->authorization->employee->cName))
				<td>{{ $u->authorization->employee->cName}}</td>
				@else
				<td>Not a person</td>
				@endif
				<td>{{ $u->authorization->type }}</td>
				<td>{{ $u->authorization->location->name }}</td>
				<td>{{ $u->authorization->level }}</td>
				<td>{{ $u->created_at }}</td>
				<td>{{ $u->authorization->updated_at }}</td>
			</tr>
			@endforeach
			</tbody>
		</table>
		<!--end: Datatable -->
	</div>
</div>		        

@endsection