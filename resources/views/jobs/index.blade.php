@extends('layouts.master')
@section('content')

<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Current Positions
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
							<span>New Position</span>
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
				<th >Position ID</th>
				<th>Salary</th>
				<th >Type</th>
				<th >Name</th>
				<th>Short</th>
				<th>In use</th>
				<th >Rate</th>
				<th >Tip</th>
			
				<th >Created at</th>
				<th >Updated at</th>
			</tr>
			</thead>
			<tbody>
				@foreach($jobs as $j)
			<tr>
				<td>{{ $j->id }}</td>
				@if($j->hour)
				<td>Hourly</td>
				@else
				<td>Monthly</td>
				@endif

				<td>{{ $j->type }}</td>
				
		
				<td>{{ $j->rank }}</td>

				<td>{{ $j->short }}</td>
				@if($j->valid)
				<td>In service</td>
				@else
				<td>Not in service</td>
				@endif

				<td>{{ $j->rate/100 }}</td>
				<td>{{ $j->tip }}</td>
				<td>{{ $j->created_at }}</td>
				<td>{{ $j->updated_at }}</td>
			</tr>
			@endforeach
			</tbody>
		</table>
		<!--end: Datatable -->
	</div>
</div>		        

@endsection