@extends('layouts.master')
@section('content')

<div class="m-portlet">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Time off
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
						      		<th>Status</th>
						      		<th>Comment</th>
						    	</tr>
						  	</thead>
						  	<tbody>
						  		@foreach($leaves as $l)
						    	<tr>
							      	<td>{{ $l->type->cName }}</td>
							      	<td>{{ $l->from }}</td>
							      	<td>{{ $l->to }}</td>
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
							      	
							      	<td>{{ $l->comment }}</td>
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
