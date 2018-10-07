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

<script>
 serverData = [
	@foreach($data['positionBreakdown'] as $p )
		@if($p->type == 'server')
		{
		"title" : "{{$p->rank}}", 
		"count" : "{{$p->count}}",
		},
		@endif
	@endforeach 
];
 serverChart = AmCharts.makeChart('serverChart',{
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

cookData = [
	@foreach($data['positionBreakdown'] as $p )
		@if($p->type == 'cook')
		{
		"title" : "{{$p->rank}}", 
		"count" : "{{$p->count}}",
		},
		@endif
	@endforeach 
];
 cookChart = AmCharts.makeChart('cookChart',{
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

 noodleData = [
	@foreach($data['positionBreakdown'] as $p )
		@if($p->type == 'noodle')
		{
		"title" : "{{$p->rank}}", 
		"count" : "{{$p->count}}",
		},
		@endif
	@endforeach 
];
 noodleChart = AmCharts.makeChart('noodleChart',{
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

</script>