<!--begin::Portlet-->
<div class="m-portlet">
<div id="timeoffDetails">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												
												<h3 class="m-portlet__head-text">
													Timeoff <small>Details</small>
												</h3>
											</div>
										</div>
										
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
													<a href="javascript:;" class="m-portlet__nav-link m-portlet__nav-link--icon">
														<i class="la la-edit"></i>
													</a>
												</li>
											</ul>
										</div>
										
									</div>
<div class="m-portlet__body">

<div class="row">
	<div class="col-12">
		@if(count($employee->leave))
		<table class="table table-sm">
			<thead>
				<tr><th>Category</th><th>From</th><th>To</th><th>Duration</th><th>Status</th><th>Approved by</th><th>Comment</th></tr>
			</thead>
			<tbody>

			@foreach($employee->leave as $l)
				<tr>
					<td>{{ $l->type->cName }}</td>
					<td>{{ $l->from->toDateString() }}</td>
					<td>{{ $l->to->toDateString() }}</td>
					<td>{{ $l->from->diffInDays($l->to)+1 }} days</td>
					@switch($l->status)
							      	@case('pending')
							      	<td><span class="m-badge m-badge--primary m-badge--wide">{{ $l->status }}</span></td>
							      	@break
							      	@case('approved')
							      	<td><span class="m-badge m-badge--success m-badge--wide">{{ $l->status }}</span></td>
							      	@break
							      	@case('rejected')
							      	<td><span class="m-badge m-badge--danger m-badge--wide">{{ $l->status }}</span></td>
							      	@break
							      	@default
							      	<td><span class="m-badge m-badge--secondary m-badge--wide">{{ $l->status }}</span></td>
							      	@endswitch
					<td>{{ $l->approvedBy?$l->approvedBy->cName:'' }}</td>
					<td>{{ $l->comment }}</td>

				</tr>
			@endforeach
		</tbody>
		</table>
		@else
		<p>No officially recored leaves
		@endif
	</div>
</div> <!-- end of row -->


</div><!-- m-portlet__body -->

</div><!-- end of timeoff detailes -->																	
</div>
<!--end::Portlet-->