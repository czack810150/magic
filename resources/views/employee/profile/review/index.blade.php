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
		<tr><th>考核日期</th><th>下次考核</th><th>考试</th><th>考核人</th><th>表现得分</th><th>店长评分</th><th>员工自评</th><th>考核结果</th><th>考核成绩</th><th>状态</th><th>功能</th></tr>
		@foreach($employee->review as $r)
		<tr>
			<td>{{$r->reviewDate}}</td>
			<td>{{$r->nextReview}}</td>
			<td><a href="/exam/{{ $r->exam->id }}/mark">{{$r->exam->name}} ({{ $r->exam->score }}/{{ $r->exam->question->count() }})</a></td>
			<td>{{$r->manager->name}}</td>
			<td>{{$r->performance}}</td>
			<td>{{ $r->manager_score }}</td>
			<td>{{ $r->self_score }}</td>
			@if($r->result)
			<td><span class="m--font-success">通过</span></td>
			@else
			<td><span class="m--font-danger">未通过</span></td>
			@endif
			<td>{{ $r->description }}</td>
			@if($r->verified)
			<td><span class="m--font-success">生效</span></td>
			@else
			<td><span class="m--font-info">提交</span></td>
			@endif
			<td><a class="btn btn-warning btn-sm" href="/employeeReview/{{ $r->id }}/view/view">查看</a></td>
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