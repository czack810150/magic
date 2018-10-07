@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
<div class="m-portlet">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<span class="m-portlet__head-icon">
					<i class="flaticon-time-2"></i>
				</span>
				<h3 class="m-portlet__head-text">
					我的考核记录
				</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				
				
		
			</ul>
		</div>
	</div>
	<div class="m-portlet__body">
		<main id="hours">
@if(count($reviews))
<table class="table table-striped">
<thead>
	<tr>
		<th>Review Date</th><th>Next Review</th><th>Manager Score</th><th>Self Score</th><th>performance</th><th>Result</th>
	</tr>
</thead>
  <tbody>
  	@foreach($reviews as $r)
  	<tr>
  		<td>{{$r->reviewDate}}</td>
  		<td>{{$r->nextReview}}</td>
		<td>{{$r->manager_score}}</td>
		<td>{{$r->self_score}}</td>
		<td>{{$r->performance}}</td>
		<td>{{$r->description}}</td>
  	</tr>
  	@endforeach
  </tbody>

</table> 
@else
<p>No reviews data</p>
@endif
										</main>
									</div>
								</div>
								<!--end::Portlet-->

@endsection