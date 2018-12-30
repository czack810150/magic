@extends('layouts.master')
@section('content')
<style>
.chartdiv {
  width: 100%;
  height: 500px;
}
</style>

@include('hr.locationTab')

@include('hr.new_gone')

  <!--begin:: Widgets/Finance Summary-->
<div class="m-portlet m-portlet--full-height ">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					人力配置 Overview
				</h3>
			</div>
		</div>
		
	</div>
	<div class="m-portlet__body">
		<div class="row">
			<div class="col-4">
				<div id="overviewChart" class="chartdiv"></div>
			</div>
			<div class="col-8">
		<div class="m-widget12">
			<div class="m-widget12__item">					 	 
				<span class="m-widget12__text1">服务员 Servers<br><span>{{ $data['types']['server'] }}</span></span> 			 		 
				<span class="m-widget12__text2">厨工 Line cooks<br><span>{{ $data['types']['cook'] }}</span></span>  

			</div>
			<div class="m-widget12__item">					 	 
				<span class="m-widget12__text1">拉面师 Noodle<br><span>{{ $data['types']['noodle'] }}</span></span> 			 		 
				<span class="m-widget12__text2">管理人员 Management<br><span>{{ $data['types']['manager'] }}</span></span> 		 	 
			</div>
			<div class="m-widget12__item">					 	 
				<span class="m-widget12__text1">厨房工人 Central Kitchen<br><span>{{ $data['types']['kitchen'] }}</span></span> 			 		 
				<span class="m-widget12__text2">Offce + HQ<br><span>{{ $data['types']['office'] }}</span></span> 		 	 
			</div>
		</div>
		</div>
			
		</div>
		<script>
			let overviewData = [
			{
				'type' : 'server',
				'count' : '{{ $data['types']['server'] }}',
			},
			{
				'type' : 'cook',
				'count' : '{{ $data['types']['cook'] }}',
			},
			{
				'type' : 'noodle',
				'count' : '{{ $data['types']['noodle'] }}',

			},
			{
				'type' : 'manager',
				'count' : '{{ $data['types']['manager'] }}',
			},
			{
				'type' : 'kitchen',
				'count' : '{{ $data['types']['kitchen'] }}',
			},
			{
				'type' : 'office',
				'count' : '{{ $data['types']['office'] }}',
			},
			];
let overviewChart = AmCharts.makeChart('overviewChart',{
	'type' : 'pie',
	'theme' : 'light',
	'percentPrecision': 0,
	'dataProvider': overviewData,
	'valueField' : 'count',
	'titleField' : 'type',
	"balloonText": "[[title]]:[[value]] ",
	'balloon' : {
		'fixedPosition':true
	},
});
		</script>


	</div>
</div>
<!--end:: Widgets/Finance Summary--> 

<!--begin::Portlet-->
		<div class="m-portlet m-portlet--responsive-mobile" id="root">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
					
						<h3 class="m-portlet__head-text m--font-brand">
							职位细分 Breakdown
						</h3>
					</div>			
				</div>
				<div class="m-portlet__head-tools">


											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
{{ Form::select('location',$locations,999,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','id'=>'location','onchange'=>'storeRefresh()'])}}											
												</li>								
											</ul>
			</div>
			</div>
			<div class="m-portlet__body" >				
				<div id="details">

					<div id="storeStaffs">
					<div class="row">
							<div class="col-6">
								<h4>服务员 Servers</h4>
							<div id="serverChart" class="chartdiv"></div>
							</div>
							<div class="col-6">
								<h4>厨工 Line cooks</h4>
							<div id="cookChart" class="chartdiv"></div>
							</div>
					</div>

					<div class="row">
							<div class="col-6">
								<h4>拉面师 Noodle</h4>
							<div id="noodleChart" class="chartdiv"></div>
							</div>
						
					</div>
					</div>



					<div class="row">
							<div class="col-6">
								<h4>管理人员 Management</h4>
							<div id="managerChart" class="chartdiv"></div>
							</div>

						<div class="col-3">
							<h6>厨房工人 Central Kitchen</h6>
							<ul>
							@foreach($data['positionBreakdown'] as $p )
								@if(in_array($p->type,['pantry','driver','chef']))
									<li>{{$p->rank}} : {{$p->count}}</li>
								@endif
							@endforeach
							</ul>
						</div>

						<div class="col-3">
							<h6>Offce + HQ</h6>
							<ul>
							@foreach($data['positionBreakdown'] as $p )
								@if(in_array($p->type,['office','hq']))
									<li>{{$p->rank}} : {{$p->count}}</li>
								@endif
							@endforeach
							</ul>
						</div>
					</div>

				<ul class="list-unstyled">
					<li>Active: {{ $data['activeEmployees'] }}</li>
					<li>Terminated: {{ $data['terminatedEmployees'] }}</li>
					
				</ul>
				</div>
			</div>
		</div>	
		<!--end::Portlet-->

  





<script>
	let transition = '<div class="row"><div class="col-md-4 offset-md-5"><h1><i class="fa fa-spinner fa-pulse fa-3x"></i></h1></div></div>';
	function viewLocationPerformance(){
		if($("#location").val() == '' || $("#dateRange").val()== ''){
			alert('You must choose a location and a year.');
		} else{
			$("#scheduleReport").html(transition);
			$.post(
				'/store/report/schedule',
				{
					location: $("#location").val(),
					year: $("#year").val(),
					frequency: $('#frequency').val(),
					_token: '{{csrf_token()}}'
				},
				function(data,status){                    
					if(status == 'success'){
						$("#scheduleReport").html(data);	
					}
				}
				);
		}
	}

let serverData = [
	@foreach($data['positionBreakdown'] as $p )
		@if($p->type == 'server')
		{
		"title" : "{{$p->rank}}", 
		"count" : "{{$p->count}}",
		},
		@endif
	@endforeach 
];
let serverChart = AmCharts.makeChart('serverChart',{
	'type' : 'pie',
	'theme' : 'light',
	'percentPrecision': 0,
	"legend": {
    "markerType": "circle",
    "position": "right",
    "marginRight": 80,
    "autoMargins": true
  },
	'dataProvider': serverData,
	'valueField' : 'count',
	'titleField' : 'title',
	"balloonText": "[[title]]:[[value]] ",
	'balloon' : {
		'fixedPosition':true
	},
});

let cookData = [
	@foreach($data['positionBreakdown'] as $p )
		@if($p->type == 'cook')
		{
		"title" : "{{$p->rank}}", 
		"count" : "{{$p->count}}",
		},
		@endif
	@endforeach 
];
let cookChart = AmCharts.makeChart('cookChart',{
	'type' : 'pie',
	'theme' : 'light',
	'percentPrecision': 0,
	"legend": {
    "markerType": "circle",
    "position": "right",
    "marginRight": 80,
    "autoMargins": true
  },
	'dataProvider': cookData,
	'valueField' : 'count',
	'titleField' : 'title',
	"balloonText": "[[title]]:[[value]] ",
	'balloon' : {
		'fixedPosition':true
	},
});

let noodleData = [
	@foreach($data['positionBreakdown'] as $p )
		@if($p->type == 'noodle')
		{
		"title" : "{{$p->rank}}", 
		"count" : "{{$p->count}}",
		},
		@endif
	@endforeach 
];
let noodleChart = AmCharts.makeChart('noodleChart',{
	'type' : 'pie',
	'theme' : 'light',
	'percentPrecision': 0,
	"legend": {
    "markerType": "circle",
    "position": "right",
    "marginRight": 80,
    "autoMargins": true
  },
	'dataProvider': noodleData,
	'valueField' : 'count',
	'titleField' : 'title',
	"balloonText": "[[title]]:[[value]] ",
	'balloon' : {
		'fixedPosition':true
	},
});

let managerData = [
	@foreach($data['positionBreakdown'] as $p )
		@if($p->type == 'management')
		{
		"title" : "{{$p->rank}}", 
		"count" : "{{$p->count}}",
		},
		@endif
	@endforeach 
];
let managerChart = AmCharts.makeChart('managerChart',{
	'type' : 'pie',
	'theme' : 'light',
	'percentPrecision': 0,
	"legend": {
    "markerType": "circle",
    "position": "right",
    "marginRight": 80,
    "autoMargins": true
  },
	'dataProvider': managerData,
	'valueField' : 'count',
	'titleField' : 'title',
	"balloonText": "[[title]]:[[value]] ",
	'balloon' : {
		'fixedPosition':true
	},
});



function storeRefresh(){
	$('#storeStaffs').html($('#location').val());
	axios.post('/hr/location/breakdown',{
		_token: '{{csrf_token()}}',
		location: $('#location').val(),	
	}).then(function(response){
		$('#storeStaffs').html(response.data);
	})
}

</script>	



@endsection