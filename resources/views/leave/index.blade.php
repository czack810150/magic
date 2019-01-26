@extends('layouts.master')
@section('content')
@if(isset($employeeLeaves) && count($employeeLeaves))

<div class="m-portlet">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Staff Leaves
				</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
					<ul class="m-portlet__nav">
						<li class="m-portlet__nav-item">
							
						</li>						
						
					</ul>
				</div>
	
	</div>
<div class="m-portlet__body">



				<!--begin::Section-->
				<div class="m-section">
					<div class="m-section__content">
						<table class="table  m-table">
						  	<thead>
						    	<tr>
						    		<th>Location</th>
						    		<th>Staff</th>
						      		<th>Type</th>
						      		<th>From</th>
						      		<th>To</th>
						      		<th>Duration</th>
						      		<th>Status</th>
						      		<th>Approved By</th>
						      		<th>Comment</th>
						      		<th>Actions</th>
						    	</tr>
						  	</thead>
						  	<tbody>
						  		@foreach($employeeLeaves as $l)
						    	<tr>
						    		<td>{{ $l->location->name }}</td>
						    		<td>{{ $l->employee?$l->employee->cName: $l->employee_id }}</td>
							      	<td>{{ $l->type->name }}</td>
							      	<td>{{ $l->from->toFormattedDateString() }}</td>
							      	<td>{{ $l->to->toFormattedDateString() }}</td>
							      	<td>{{ $l->from->diffInDays($l->to)+1 }} days</td>
							      	@switch($l->status)
							      	@case('pending')
							      	<td><span class="m-badge m-badge--primary m-badge--wide">{{ $l->status }}</span></td>
							      	@break
							      	@case('approved')
							      	<td><span class="m-badge m-badge--success m-badge--wide">{{ $l->status }}</span></td>
							      	@break
							      	@case('rejected')
							      	<td><span class="m-badge m-badge--danger m-badge--wide">{{ $l->status }}</span></td>
							      	@break
							      	@default
							      	<td><span class="m-badge m-badge--secondary m-badge--wide">{{ $l->status }}</span></td>
							      	@endswitch
							      	@if($l->approvedBy )
							      	<td>{{ $l->approvedBy->cName }}</td>
							      	@else
							      	<td></td>
							      	@endif
							      	<td>{{ $l->comment }}</td>
							      	<td>


							      	@switch($l->status)
							      	@case('pending')
							      	<a href="{{ url("leave/$l->id/approve") }}" class="btn btn-success btn-sm">Approve</a>
							      	<a href="{{ url("leave/$l->id/deny") }}" class="btn btn-danger btn-sm">Reject</a>
							      	@break
							      	@case('approved')
							      	
							      	@break
							      	@case('rejected')
							      	<a href="{{ url("leave/$l->id/approve") }}" class="btn btn-success btn-sm">Approve</a>
							      			<a href="{{ url("leave/$l->id/pending") }}" class="btn btn-info btn-sm">Pending</a>
							      	@break
							      	@default
							      	<a href="{{ url("leave/$l->id/approve") }}" class="btn btn-success btn-sm">Approve</a>
							      			<a href="{{ url("leave/$l->id/pending") }}" class="btn btn-info btn-sm">Pending</a>
							      			<a href="{{ url("leave/$l->id/deny") }}" class="btn btn-danger btn-sm">Reject</a>
							      	@endswitch
							      		
							      			

							      		
							      	</td>
						    	</tr>
						    	@endforeach
						  	</tbody>
						</table>
							{{ $employeeLeaves->links() }}
					</div>
				</div>
				<!--end::Section-->
			</div>
</div>
			

@endif


<div class="m-portlet">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					My Time off
				</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
					<ul class="m-portlet__nav">
						<li class="m-portlet__nav-item">
							<a href="{{url('request/leave')}}" class="btn btn-brand">Request Leave</a>	
						</li>						
						
					</ul>
				</div>
	
	</div>
<div class="m-portlet__body">



				<!--begin::Section-->
				<div class="m-section">
					<div class="m-section__content">
						<table class="table  m-table">
						  	<thead>
						    	<tr>
						      		<th>Type</th>
						      		<th>From</th>
						      		<th>To</th>
						      		<th>Duration</th>
						      		<th>Status</th>
						      		<th>Approved By</th>
						      		<th>Comment</th>
						      		<th>Action</th>
						    	</tr>
						  	</thead>
						  	<tbody>
						  		@foreach($leaves as $l)
						    	<tr>
							      	<td>{{ $l->type->cName }}</td>
							      	<td>{{ $l->from->toFormattedDateString() }}</td>
							      	<td>{{ $l->to->toFormattedDateString() }}</td>
							      	<td>{{ $l->from->diffInDays($l->to)+1 }} {{ str_plural('day',$l->from->diffInDays($l->to)+1) }}</td>
							      	@switch($l->status)
							      	@case('pending')
							      	<td><span class="m-badge m-badge--primary m-badge--wide">{{ $l->status }}</span></td>
							      	@break
							      	@case('approved')
							      	<td><span class="m-badge m-badge--success m-badge--wide">{{ $l->status }}</span></td>
							      	@break
							      	@case('rejected')
							      	<td><span class="m-badge m-badge--danger m-badge--wide">{{ $l->status }}</span></td>
							      	@break
							      	@default
							      	<td><span class="m-badge m-badge--secondary m-badge--wide">{{ $l->status }}</span></td>
							      	@endswitch
							      	<td>{{ $l->approvedBy?$l->approvedBy->cName:'' }}</td>
							      	<td>{{ $l->comment }}</td>
							      	<td>
							      		@if($l->status == 'pending')
							      			<a href="{{ url("leave/$l->id/withdraw") }}" class="btn btn-accent btn-sm">Withdraw</a>
							      		@else
							      		@endif
							      	</td>
						    	</tr>
						    	@endforeach
						  	</tbody>
						</table>
					</div>
				</div>
				<!--end::Section-->
</div>
			
</div>		        

@endsection
