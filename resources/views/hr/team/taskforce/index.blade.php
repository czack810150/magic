@extends('layouts.master')
@section('content')


<script src="https://www.gstatic.com/charts/loader.js"></script>
<div class="m-portlet m-portlet--full-height" id="vm">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Taskforce Teams <small>专项团队</small> 
				</h3>
			</div>
		</div>
        @can('create-team')
        <div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				<li class="m-portlet__nav-item">
                    <a href="{{url('team/taskforce/create')}}" class="btn btn-info">Create Team</a>
				</li>
			</ul>
		</div>
        @endcan
      
		
	</div>
	<div class="m-portlet__body">
        @if(count($teams))
		<div id="chart_div"></div>
        @else
            <p>No taskforce teams.</p>
        @endif
   
    

   

    </div>
	
</div>
		
		
<script>

</script>
@endsection

@section('pageJS')
<style>
.teamBlock {
	height:40px;
	width:120px;

}
.selectedNode {
	border:none
}
</style>
    <script>
      google.charts.load('current', {packages:["orgchart"]});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
		
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');
		
		// data.setRowProperty(1,'style', 'border: 1px solid green');
        // For each orgchart box, provide the name, manager, and tooltip to show.
        data.addRows([
          
		  @foreach($teams as $t)
		  [ {v:'{{$t->name}}',
		  f:'<div><a class="text-info" href="/team/taskforce/{{$t->id}}/view"><h5>{{$t->name}}</h5><p>{{$t->employee->name}}</p><small>{{$t->teamMember->count()}}名成员</small></a></div>'},
		   '{{$t->team? $t->team->name:''}}','{{$t->description}}'  ],
		  @endforeach

        ]);

        // Create the chart.
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        // Draw the chart, setting the allowHtml option to true for the tooltips.
        chart.draw(data, {allowHtml:true,allowCollapse:true,nodeClass:'teamBlock',size:'large',selectedNodeClass:'selectedNode'});
	
      }
   </script>
@endsection