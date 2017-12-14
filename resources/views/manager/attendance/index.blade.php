


@extends('layouts.master')
@section('content')

<div class="row" id="stores">



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
					<p><span>{{ $periodStart->toDateString() }} ~ {{ $periodEnd->toDateString()}}</span></p>
					<p>总计时间 <span>{{ round($location->manager->totalClocked,2) }}</span></p>
					<p>开早 <span>{{ substr($location->openMorning,0,5) }} ~ {{ substr($location->endMorning,0,5) }}</span><span class="float-right">{{ $location->manager->attendance['openings'] }} 次</span></p>
					<p>收夜 <span>{{ substr($location->endClose,0,5) }} </span><span class="float-right">{{ $location->manager->attendance['endClose'] }} 次</span></p>
					<p>午餐高峰 <span>{{ substr($location->lunchStart,0,5) }} ~ {{ substr($location->lunchEnd,0,5) }}</span><span class="float-right">{{ $location->manager->attendance['lunch'] }} 次</span></p>
					<p>晚餐高峰 <span>{{ substr($location->dinnerStart,0,5) }} ~ {{ substr($location->dinnerEnd,0,5) }}</span><span class="float-right">{{ $location->manager->attendance['dinner'] }} 次</span></p>
					@if(!is_null($location->nightStart))
					<p>夜餐期 <span>{{ substr($location->nightStart,0,5) }} ~ {{ substr($location->nightEnd,0,5) }}</span><span class="float-right">{{ $location->manager->attendance['night'] }} 次</span></p>
					@endif
					</div>

					<div class="form-group">
					<button type="button" class="btn btn-secondary btn-sm detail-button" 
					from="{{ $periodStart->toDateString() }}"
					to="{{ $periodEnd->toDateString() }}"
					manager="{{ $location->manager->id }}">Details</button>
					</div>

					</div>


				
				
					
				
			

		
			</div>
		</div>	
		<!--end::Portlet-->
		</div>
		@endforeach
</div> <!-- end of row -->


<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel">Manager Attendance Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <section id="modal-body"></section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


@endsection
@section('pageJS')
<script>

function managerAttendance(from,to){
	console.log('from: '+ from + ' to: '+ to);
	$.post(
		'/manager/attendance',
		{
			_token: '{{ csrf_token() }}',
			from: from,
			to: to
		},
		function(data,status){
			if(status == 'success'){
				$('#stores').html(data);
			}
		}
		);
}

function managerAttendanceDetails(e){

	$.post(
		'/manager/attendance/detail',
		{
			_token: '{{ csrf_token() }}',
			employee: e.target.attributes.manager.value,
			from: e.target.attributes.from.value,
			to: e.target.attributes.to.value,
		},
		function(data,status){
			if(status == 'success'){
				$('#modal-body').html(data);
				$('#detailModal').modal();
			}
		}
		);
}


$('#m_dashboard_daterangepicker').on('apply.daterangepicker',function(ev,picker){
	managerAttendance(picker.startDate.format('YYYY-MM-DD'),picker.endDate.format('YYYY-MM-DD'));
});

$('.detail-button').on('click',function(e){
	managerAttendanceDetails(e);
});

</script>
@endsection