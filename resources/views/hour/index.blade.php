@extends('layouts.master')
@section('content')

@include('hour.nav')
<div class="container-fluid" id="hours">


<form class="form-inline my-2" method="POST" action="/hours">

	
		<div class="form-group">
		<label class="mr-sm-2" for="location">Location</label>
{{ Form::select('location',$locations,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder' => 'Choose a location','id'=>'location'])}}
		</div>

		<div class="form-group mx-sm-3">
			{{ Form::label('dateRange','Date range',['class'=>'mx-sm-3'])}}
			{{ Form::select('dateRange',$dates,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder'=>'Choose date range']) }}
		</div>
		{{ Form::submit('Submit',['class'=>'btn btn-primary']) }}
		{{csrf_field()}}

</form>
@if(count($hours))
<main >
<div class="row">
   	<div class="col-lg-8 col-md-12">	
		<!--begin::Portlet-->
		<div class="m-portlet">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-list"></i>
						</span>
						<h3 class="m-portlet__head-text">
							Store Statistics
						</h3>
					</div>			
				</div>
			</div>
			<div class="m-portlet__body">
<table class="table table-sm table-hover">
<thead>
	<tr><th>排班人数</th><th>工时人数</th><th>排班</th><th>有效</th><th>排班Cash</th><th>有效Cash</th><th>Total 排班</th><th>Total 有效</th></tr>
</thead>
<tbody>
	
	<tr>
		<th>{{ count($scheduledEmployees) }}</th>
		<th>{{ count($hours) }}</th>
		<th>{{ round($stats['scheduled'],2) }}</th>
		<th>{{ round($stats['effective'],2) }}</th>
		<th>{{ round($stats['scheduledCash'],2) }}</th>
		<th>{{ round($stats['effectiveCash'],2) }}</th>
		<th>{{ round($stats['scheduled'] + $stats['scheduledCash'],2)}}</th>
		<th>{{ round($stats['effective'] + $stats['effectiveCash'],2)}}</th>
		
	</tr>
	
</tbody>
</table>
			</div>
		</div>	
		<!--end::Portlet-->
	</div>
</div>



{{ Form::button('Download CSV',['class'=>'btn btn-warning','onclick'=>'exportTableToCSV("hours.csv")']) }}

<table class="table table-sm table-hover">
<thead>
	<tr><th>Employee</th><th>Position</th><th>Scheduled</th><th>Effective</th><th>Diff</th><th>Days</th><th>wk1Scheduled</th><th>wk2Scheduled</th><th>wk1Clocked</th><th>wk2Clocked</th><th>wk1Effective</th><th>wk2Effective</th><th>wk1OT</th><th>wk2OT</th><th>wk1Night</th><th>wk2Night</th></tr>
</thead>
<tbody>
	@foreach($hours as $h)
	<tr v-on:click="hoursBreakDown({{ $h->employee_id }})">
		@if(isset($h->employee->cName))
		<td>{{ $h->employee->cName }}</td>

		@else
		<td>{{ $h->employee_id }}</td>
		@endif
		<td>{{ $h->employee->job->rank }}</td>
		<td class="alert alert-primary">
			{{ $h->wk1Scheduled +$h->wk2Scheduled  }} 
			{{ ($h->wk1ScheduledCash + $h->wk2ScheduledCash) > 0? '('.($h->wk1ScheduledCash + $h->wk2ScheduledCash).')':''  }}
		</td>

		<td class="alert alert-success">
			{{ $h->wk1Effective +$h->wk2Effective  }}
			{{ ($h->wk1EffectiveCash + $h->wk2EffectiveCash) > 0? '('.($h->wk1EffectiveCash + $h->wk2EffectiveCash).')':''  }}
		</td>
		<td class="alert alert-danger">
			{{ round($h->wk1Scheduled +$h->wk2Scheduled - $h->wk1Effective - $h->wk2Effective,2)  }}
			{{ ($h->wk1ScheduledCash + $h->wk2ScheduledCash) > 0? '('.round($h->wk1ScheduledCash +$h->wk2ScheduledCash - $h->wk1EffectiveCash - $h->wk2EffectiveCash,2).')':''  }}
		</td>
		<td class="alert alert-warning">{{ $h->days   }}</td>
		<td>{{ $h->wk1Scheduled }} {{ $h->wk1ScheduledCash? "("."$h->wk1ScheduledCash".")":'' }}</td>
		<td>{{ $h->wk2Scheduled }} {{ $h->wk2ScheduledCash? "("."$h->wk2ScheduledCash".")":'' }}</td>
		<td>{{ round($h->wk1Clocked,2) }}</td>
		<td>{{ round($h->wk2Clocked,2) }}</td>
		<td class="alert alert-primary">{{ $h->wk1Effective }} {{$h->wk1EffectiveCash? "("."$h->wk1EffectiveCash".")":''}}</td>
		<td class="alert alert-primary">{{ $h->wk2Effective }} {{$h->wk2EffectiveCash? "("."$h->wk2EffectiveCash".")":''}}</td>
		
		<td class="alert alert-danger">{{ $h->wk1Overtime }}</td>
		<td class="alert alert-danger">{{ $h->wk2Overtime }}</td>
		<td class="alert alert-dark">{{ $h->wk1Night }} {{$h->wk1NightCash? "("."$h->wk1NightCash".")":''}}</td>
		<td class="alert alert-dark">{{ $h->wk2Night }} {{$h->wk2NightCash? "("."$h->wk2NightCash".")":''}}</td>
	</tr>
	@endforeach
</tbody>
</table>



<!-- Modal -->
<div class="modal fade" id="breakdownModal" tabindex="-1" role="dialog" aria-labelledby="breakdownModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="breakdownModalLabel">Employee Shifts Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-sm">
        	<thead><tr><th>Date</th><th>ScheduleIn</th><th>ScheduleOut</th><th>Scheduled</th><th>Effective</th><th>Clocks</th></tr></thead>
        	<tbody id="data"></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


</main>
@else
	@if($index)
<div class="m-alert m-alert--icon m-alert--outline alert alert-info alert-dismissible fade show" role="alert">
					<div class="m-alert__icon">
						<i class="la la-warning"></i>
					</div>
					<div class="m-alert__text">
					  	<strong>No data!</strong> Please choose a different period or compute employee hours.		
					</div>									  	
</div>
	@endif			
@endif



</div>

<script>
	var app = new Vue({
		el: '#hours',
		data: {
			shifts: [
			]
		},
		methods: {
			hoursBreakDown: function(e) {
				$.post(
					'/hours/breakdown',
					{
						employee: e,
						location: $('#location').val(),
						startDate: $('#dateRange').val(),
						_token: '{{csrf_token()}}',
					},
					function(data,status){
						if(status == 'success'){
							html = '';
							for(i in data){
								html += '<tr><td>' + data[i]['shiftDate'] + '</td>';
								html += '<td>' + data[i]['scheduleIn'] + '</td>';
								html += '<td>' + data[i]['scheduleOut'] + '</td>';
								html += '<td>' + data[i]['scheduledHour'] + '</td>';
								html += '<td>' + data[i]['effectiveHours']['hours'] + '</td><td class="text-muted">';

								for(j in data[i]['clocks']){
									var clockIn = moment(data[i]['clocks'][j]['clockIn']);
									var clockOut = moment(data[i]['clocks'][j]['clockOut']);
									html += clockIn.format('H:mm:ss') + ' - ' + clockOut.format('H:mm:ss') + '<br>';
								}

								html += '</td></tr>';
							}
							$('#data').html(html);
						}
					},
					'json'
					);

				$('#breakdownModal').modal();
			}
		}
	});


</script>


@endsection