@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
								<div class="m-portlet">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-list-2"></i>
												</span>
												<h3 class="m-portlet__head-text">
													培训记录
												</h3>
											</div>
										</div>
										
									</div>
									<div class="m-portlet__body" id="employeeTrainingLog"></div>
								</div>
								<!--end::Portlet-->


@endsection
@section('pageJS')
<script>

	var jString = '{!! $logs !!}';
	var dataJSONArray = JSON.parse(jString);

	var options = {
		data: {
			type:'local',
			source: dataJSONArray,
			pageSize: 30
		},
	  // layout definition
         layout: {
            theme: 'default',
                // datatable theme
            class: '',
                // custom wrapper class
            scroll: false,
                // enable/disable datatable scroll both horizontal and vertical when needed.
                // height: 450, // datatable's body's fixed height
            footer: false // display/hide footer
            },

            // column sorting
        sortable: true,
        pagination: true,

        columns: [
        	{
        		field: "date_trained",
        		title: "培训日期时间",
        		width: 200,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "category",
        		title: "技能类别",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "stage",
        		title: "阶段",
        		width: 50,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},

        	{
        		field: "itemName",
        		title: "技能",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "trainer_name",
        		title: "培训人",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        ]
	}


	
	$('#employeeTrainingLog').mDatatable(options);
</script>
@endsection