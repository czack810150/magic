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
				
	<div class="m-alert m-alert--icon m-alert--outline alert alert-success alert-dismissible fade show" role="alert">
					<div class="m-alert__icon">
						<i class="la la-check"></i>
					</div>
					<div class="m-alert__text">
					  	<strong>Success!</strong> You successfully withdrew your leave request.		
					</div>	
					<div class="m-alert__close">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						</button>	
					</div>			  	
				</div>

</div>			
</div>		        

@endsection
