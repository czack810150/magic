@extends('layouts.master')
@section('content')

<div class="row">


	@if(!empty($inShiftEmployees))

		@foreach($locations as $location)
		<div class="col-lg-3">
		<!--begin::Portlet-->
   		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							{{ $location->name}} <small>{{ $location->type}}</small>
						</h3>
					</div>			
				</div>
			</div>
			<div class="m-portlet__body">	
				
			@foreach($inShiftEmployees as $e)
				@if(!is_null($e->shift->clock))
				@if( $location->id == $e->shift->clock->location_id)
			<p><span>{{ $e->cName}}</span> 
				<span class="float-right mr-3" >
			{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$e->shift->clock->clockIn)->toDateTimeString()}}
				</span>
			</p>
				@endif
				@endif

			@endforeach

		
			</div>
		</div>	
		<!--end::Portlet-->
		</div>
		@endforeach
	@else
	<p>No employees are currently on duty.</p>
	@endif

</div>

@endsection