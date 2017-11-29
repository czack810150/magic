@extends('layouts.master')
@section('content')

<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Current Positions
				</h3>
			</div>
		</div>
	
	</div>
	<div class="m-portlet__body">
	

		<!--begin: Datatable -->
		<table class="table table-hover"  width="100%">
			<thead>
			<tr>
			
				<th>Salary</th>
				<th >Type</th>
				<th >职位名称</th>
				<th>简称</th>
				<th>基本工资</th>
				<th>岗位津贴</th>
				<th >Tip</th>
				<th>餐饮补助</th>
				<th>夜班补助</th>
			
			</tr>
			</thead>
			<tbody>
				@foreach($jobs as $j)
			<tr>
				@if($j->hour)
				<td>Hourly</td>
				@else
				<td>Monthly</td>
				@endif

				<td>{{ $j->type }}</td>
				<td>{{ $j->rank }}</td>
				<td>{{ $j->short }}</td>

				@if($j->rate > 1000)
				<td>${{ $j->rate/100 }} / hr</td>
				@else
				<td>$12 / hr</td>
				@endif
				

				@if($j->rate > 0 && $j->rate < 1000)
				<td>${{ $j->rate/100 }} / hr</td>
				@else
				<td></td>
				@endif
				
				@if($j->tip)
				<td>{{ $j->tip*100 }}%</td>
				@else
				<td></td>
				@endif

				@if(in_array($j->type,['server','cook','noodle','dish']))
				<td>$0.8 / hr</td>
				<td>$3 / hr</td>
				@else
				<td></td><td></td>
				@endif
			</tr>
			@endforeach
			</tbody>
		</table>
		<!--end: Datatable -->
	</div>
</div>		        

@endsection