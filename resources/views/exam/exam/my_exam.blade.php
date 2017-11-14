@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
		<div class="m-portlet m-portlet--success m-portlet--head-solid-bg">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-list-1"></i>
						</span>
						<h3 class="m-portlet__head-text">
							My Pending Exam
						</h3>
					</div>			
				</div>
				
			</div>
			<div class="m-portlet__body">
				@if($exam)
				<div class="card" style="width: 20rem;">
  <div class="card-body">
    <h4 class="card-title">{{ $exam->name }}</h4>
    <p class="card-text"></p>
  </div>
 
  <div class="card-body">
    <a href="exam/{{ $exam->access }}/take" class="card-link">Take Exam</a>
    
  </div>
</div>
				@else
				No pending exam at this time.
				@endif


			</div>
		</div>	
		<!--end::Portlet-->



@endsection
