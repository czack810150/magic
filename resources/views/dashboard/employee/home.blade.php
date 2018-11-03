@extends('layouts.master')

@section('content')
@if(auth()->user()->authorization->employee->currentReview)
<div class="row">
<div class="col-12">
<div class="m-alert m-alert--icon m-alert--outline alert alert-primary" role="alert">
    <div class="m-alert__icon">
        <i class="la la-warning"></i>
    </div>
    <div class="m-alert__text">
        <strong>Attention!</strong> You are now being reviewed. 你已达到考核标准，正被考核中。请提供自我评价。 
    </div>  
    <div class="m-alert__actions" style="width: 200px;">
        <a href="{{ route('self',['employeeReview' => auth()->user()->authorization->employee->currentReview]) }}" class="btn btn-brand" >自我评价
        </a>
         
    </div>              
</div>
</div>
</div>
@endif
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
