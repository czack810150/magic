@extends('layouts.master')
@section('content')

<section class="hr-header">
<div class="row">
<div class="col-12 col-md-2">
<div class="avatar-wrapper ml-3">
	@if(isset($staff->employee_profile))
	<img class="img-fluid" 
	src="{{asset('/img/'.$staff->employee_profile->img)}}" alt="{{$staff->firstName}}" height="200" width="200">
	@endif
</div>
</div>
<div class="col-12 col-md-3">
	<h2>{{ $staff->firstName }} {{ $staff->lastName }} {{ $staff->cName }}</h2>
	<div>{{ $staff->job->rank }} | {{ $staff->location->name }} </div>
	<div>Joined since {{ $staff->hired->toFormattedDateString() }}   ({{ $staff->hired->diffForHumans() }})</div>
</div>

<div class="hr-contact-list col-md-7">

@if(isset($staff->employee_profile))
<div><i class="fa fa-phone"></i> <span class="text-white">{{ $staff->employee_profile->phone }}</span></div>
@endif
<div><i class="fa fa-envelope"></i> <a href="mailto:{{ $staff->email }}"><span class="text-white">{{ $staff->email }}</span></a></div>
</div>

</div>
</section>
<!--begin::Portlet-->
<div class="m-portlet">

<div class="m-portlet__body">


</div>
</div>
<!--end::Portlet-->
						
@endsection