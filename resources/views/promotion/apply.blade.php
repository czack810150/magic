@extends('layouts.master')
@section('content')

<div class="row">
<div class="col-xl-6">
	    <!--begin:: Widgets/Company Summary-->
<div class="m-portlet m-portlet--full-height ">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					My Current Position
				</h3>
			</div>
		</div>
		
	</div>
	<div class="m-portlet__body">
		<div class="m-widget13">
			<div class="m-widget13__item">
				<span class="m-widget13__desc m--align-right">
				Employee Name
				</span>
				<span class="m-widget13__text m-widget13__text-bolder">
						{{ $employee->cName}} {{$employee->firstName}} {{$employee->lastName}}		 
				</span>
			</div>
			<div class="m-widget13__item">
				<span class="m-widget13__desc m--align-right">
				Employee Card	
				</span>
				<span class="m-widget13__text m-widget13__text-bolder">
				{{$employee->employeeNumber}}						 
				</span>
			</div>
			<div class="m-widget13__item">
				<span class="m-widget13__desc m--align-right">
				Joined since
				</span>
				<span class="m-widget13__text">
				{{$employee->hired->toFormattedDateString()}}						 
				</span>
			</div>
			<div class="m-widget13__item">
				<span class="m-widget13__desc m--align-right">
				Job Title
				</span>
				<span class="m-widget13__text m-widget13__text-bolder">
				{{$employee->job->rank}}					 
				</span>
			</div>
			<div class="m-widget13__item">
				<span class="m-widget13__desc m--align-right">
				Hourly rate
				</span>
				<span class="m-widget13__text m-widget13__text-bolder">
				$ {{$pay->minimumPay/100}}/hour		 
				</span>
			</div>
			
			<div class="m-widget13__item">
				<span class="m-widget13__desc m--align-right">
				岗位津贴
				</span>
				<span class="m-widget13__text m-widget13__number-bolder m--font-brand">
				@if($employee->job->hour)
				$ {{$employee->job->rate/100}}/hour
				@else
				N/A
				@endif							 
				</span>
			</div>
			<div class="m-widget13__item">
				<span class="m-widget13__desc m--align-right">
				小费率
				</span>
				<span class="m-widget13__text m-widget13__number-bolder m--font-brand">
				@if($employee->job->tip)
				$ {{$employee->job->tip*100}}%
				@else
				N/A
				@endif							 
				</span>
			</div>
			
		</div>		 
	</div>
</div>
<!--end:: Widgets/Company Summary-->  
</div>


<div class="m-portlet m-portlet--mobile col-sm-12 col-md-10 col-lg-6">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Request Promotion
				</h3>
			</div>
		</div>
	
	</div>
@if($nextJob)
<div class="m-portlet__body" >
				
<div class="m-widget13">
			<div class="m-widget13__item">
				<span class="m-widget13__desc m--align-right">
				Next Job Title
				</span>
				<span class="m-widget13__text m-widget13__text-bolder">
						{{ $nextJob->rank }} @if($nextJob->top) (最高级) @endif
				</span>
			</div>
			<div class="m-widget13__item">
				<span class="m-widget13__desc m--align-right">
				Hourly rate
				</span>
				<span class="m-widget13__text m-widget13__text-bolder">
						$ {{$pay->minimumPay/100}}/hour	
				</span>
			</div>
			<div class="m-widget13__item">
				<span class="m-widget13__desc m--align-right">
				岗位津贴
				</span>
				<span class="m-widget13__text m-widget13__number-bolder m--font-brand">
				@if($nextJob->hour)
				$ {{$nextJob->rate/100}}/hour
				@else
				N/A
				@endif							 
				</span>
			</div>
			<div class="m-widget13__item">
				<span class="m-widget13__desc m--align-right">
				小费率
				</span>
				<span class="m-widget13__text m-widget13__number-bolder m--font-brand">
				@if($nextJob->tip)
				$ {{$nextJob->tip*100}}%
				@else
				N/A
				@endif							 
				</span>
			</div>
</div>
	
</div>

	<!--begin::Form-->
			<form class="m-form" method="POST" action="{{url('promotion/apply')}}">
				{{csrf_field()}}
				<div class="m-portlet__body" >
<input name="newJob" type="text" value="{{$nextJob->id}}" hidden>
					<div class="m-form__section m-form__section--first">
								
						<div class="m-form__group form-group">
							<label for="">Supportive Comment</label>
							<textarea class="form-control m-input" rows="3" name="comment"></textarea>
		                </div>
		            </div>

	            </div>
	            <div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<button type="submit" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-secondary">Cancel</button>
					</div>
				</div>
			</form>
			<!--end::Form-->
@else
You have reached top level for current job type.
@endif	
</div>

</div>	        

@endsection
@section('pageJS')
<script>

</script>
@endsection