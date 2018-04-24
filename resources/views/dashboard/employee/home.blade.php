@extends('layouts.master')

@section('content')
<div class="row">
    @if(count($promotions))
    <div class="col-8">
<!--begin::Portlet Promotions-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-up-arrow-1"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            My promotion <small>我的晋级申请</small>
                        </h3>
                    </div>          
                </div>
            </div>
            <div class="m-portlet__body">
<table class="table  m-table">
                            <thead>
                                <tr>
                                    <th>Location</th>
                                    <th>Staff</th>
                                    <th>Current Position</th>
                                    <th>New Position</th>
                                    <th>Status</th>
                                    <th>Date applied</th>
                                    <th>Action Taken</th>
                                    <th>Action By</th>

                                    <th>Comment</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($promotions as $p)
                                @if(Carbon\Carbon::now()->diffInDays($p->created_at)<=30)
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
                                   
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
</table>
            </div>
        </div>  
<!--end::Portlet Promotions-->
</div>
@endif
</div>

<div class="row">
    
    <div class="col-12">
<!--begin::Portlet Promotions-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-up-arrow-1"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            Upcoming Shifts <small>近期排班安排</small>
                        </h3>
                    </div>          
                </div>
            </div>

            <div class="m-portlet__body">
                 @if(count($shifts))
<table class="table  m-table">
                            <thead>
                                <tr>
                                    <th>Location</th>
                                    <th>Position</th>
                                    <th>Day</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Duration (hours)</th>
                                    <th>Duty</th>
                                   
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shifts as $s)
                                
                                <tr>
                                    <td>{{ $s->location->name }}</td>
                                     <td>{{ $s->role->c_name }}</td>
                                     <td>{{ $s->start->format('l') }}</td>
                                    <td>{{ $s->start->toDateTimeString() }}</td>
                                     <td>{{ $s->end->toDateTimeString() }}</td>
                                     <td>{{ round($s->start->diffInSeconds($s->end)/3600,2) }}</td>
                                    
                                    @if($s->duty)
                                    @switch($s->duty->name)
                                    @case('Opening')
                                    <td><span class="m-badge m-badge--primary m-badge--wide">{{ $s->duty->cName }}</span></td>
                                    @break
                                    @case('Closing')
                                    <td><span class="m-badge m-badge--success m-badge--wide">{{ $s->duty->cName }}</span></td>
                                    @break
                                    @case('PreClose')
                                    <td><span class="m-badge m-badge--danger m-badge--wide">{{ $s->duty->cName }}</span></td>
                                    @break
                                     @case('Clean')
                                    <td><span class="m-badge m-badge--danger m-badge--wide">{{ $s->duty->cName }}</span></td>
                                    @break
                                     @case('Deep clean')
                                    <td><span class="m-badge m-badge--danger m-badge--wide">{{ $s->duty->cName }}</span></td>
                                    @break
                                     @case('Training')
                                    <td><span class="m-badge m-badge--danger m-badge--wide">{{ $s->duty->cName }}</span></td>
                                    @break
                                     @case('Shift manager')
                                    <td><span class="m-badge m-badge--danger m-badge--wide">{{ $s->duty->cName }}</span></td>
                                    @break
                                    @default
                                    <td><span class="m-badge m-badge--secondary m-badge--wide">{{ $s->duty->cName }}</span></td>
                                    @endswitch
                                    @else
                                    <td></td>
                                    @endif
                                   
                                </tr>
                               
                                @endforeach
                            </tbody>
</table>
@else
No upcoming shifts.
@endif
            </div>
        </div>  
<!--end::Portlet Promotions-->
</div>

</div>

@endsection
