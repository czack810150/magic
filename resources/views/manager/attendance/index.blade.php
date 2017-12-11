


@extends('layouts.master')
@section('content')

<div class="row">



		@foreach($locations as $location)
		<div class="col-lg-3">
		<!--begin::Portlet-->
   		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							{{ $location->name}} <small>{{ $location->shortName}}</small>
						</h3>
					</div>			
				</div>
			</div>
			<div class="m-portlet__body">	
				
				
					
				
					
					<div class="row mb-3">
					<div class="col-7 col-sm-7">
					<img src="/img/{{ $location->manager->employee_profile->img }}" alt="manager picture" class="img-fluid">
					</div>

					<div class="col-5 col-sm-5">
					<h6>{{ $location->manager->cName }}</h6>
					<p>{{ $location->manager->employeeNumber }}</p>
					</div>
					</div>

					<div class="row">
					<div class="col-12">
					<p>总计时间 <span>{{ $currentWeek }}</span></p>
					<p>开早 <span>{{ $location->manager->id }}</span></p>
					<p>收夜 <span></span></p>
					<p>午餐高峰 <span></span></p>
					<p>晚餐高峰 <span></span></p>
					</div>
					</div>


				
				
					
				
			

		
			</div>
		</div>	
		<!--end::Portlet-->
		</div>
		@endforeach



</div>

@endsection
