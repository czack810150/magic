<!--begin::Portlet-->
<div class="m-portlet">
<div id="employmentReviews">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												
												<h3 class="m-portlet__head-text">
													考核记录 <small>Review Records</small>
												</h3>
											</div>
										</div>
										
									</div>
<div class="m-portlet__body">


<div class="row">
	<div class="col-12">
	@if($employee->review)
	<table class="table">
		<tr><th>Review Date</th><th>Next Review</th><th>Exam</th><th>Reviewed By</th><th>Performance</th><th>Manager Score</th><th>Self Score</th><th>Result</th><th>Outcome</th></tr>
		@foreach($employee->review as $r)
		<tr>
			<td>{{$r->reviewDate}}</td>
			<td>{{$r->nextReview}}</td>
			<td>{{$r->exam_id}}</td>
			<td>{{$r->manager->name}}</td>
			<td>{{$r->performance}}</td>
			<td>{{ $r->manager_score }}</td>
			<td>{{ $r->self_score }}</td>
			<td>{{ $r->result? 'Pass':'Fail' }}</td>
			<td>{{ $r->description }}</td>
		</tr>
		@endforeach
	</table>
	@else
		<p>There is no review records.</p>
	@endif
	</div>
</div> <!-- end of row -->

</div><!-- m-portlet__body -->

</div><!-- end of employment reviews -->																	
</div>
<!--end::Portlet-->