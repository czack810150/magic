@extends('layouts.master')
@section('content')
@if(count($promotions))

<div class="m-portlet">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Employee Promotions
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
                                    <th>Current Position</th>
                                    <th>New Position</th>
                                    <th>Status</th>
                                    <th>Date applied</th>
                                    <th>Action Date</th>
                                    <th>Action By</th>
                                    <th>Comment</th>
                                   <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($promotions as $p)
                                <tr>
                                    <td>{{ $p->newLocation->name }}</td>
                                     <td>{{ $p->employee->cName }}</td>
                                    <td>{{ $p->oldJob->rank }}</td>
                                     <td>{{ $p->newJob->rank }}</td>
                                    
                                    
                                    @switch($p->status)
                                    @case('pending')
                                    <td><span class="m-badge m-badge--primary m-badge--wide">{{ $p->status }}</span></td>
                                    @break
                                    @case('approved')
                                    <td><span class="m-badge m-badge--success m-badge--wide">{{ $p->status }}</span></td>
                                    @break
                                    @case('rejected')
                                    <td><span class="m-badge m-badge--danger m-badge--wide">{{ $p->status }}</span></td>
                                    @break
                                    @default
                                    <td><span class="m-badge m-badge--secondary m-badge--wide">{{ $p->status }}</span></td>
                                    @endswitch
                                     <td>{{ $p->created_at->toFormattedDateString() }}</td>
                                      <td>{{ $p->updated_at->toFormattedDateString() }}</td>
                                    <td>{{ $p->modifiedBy? $p->modifiedBy->cName:'' }}</td>
                                    <td>{{ $p->comment }}</td>
                                    <td>
							      		
							      			<a href="{{ url("promotion/$p->id/approve") }}" class="btn btn-success btn-sm">Approve</a>
							      			
							      			<a href="{{ url("promotion/$p->id/deny") }}" class="btn btn-danger btn-sm">Reject</a>

							      		
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
@else
no data	

@endif



@endsection
