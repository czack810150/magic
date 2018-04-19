<!--begin::Portlet-->
		<div class="m-portlet m-portlet--primary m-portlet--head-solid-bg">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-line-graph"></i>
						</span>
						<h3 class="m-portlet__head-text">
							Performance
						</h3>
					</div>			
				</div>
				<div class="m-portlet__head-tools">
					<ul class="m-portlet__nav">
						<li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover">
	                        <a href="#" class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn-sm  btn-light m-btn m-btn--pill">
	                          	All
	                        </a>
	                        <div class="m-dropdown__wrapper">
	                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
	                            <div class="m-dropdown__inner">
	                                    <div class="m-dropdown__body">              
	                                        <div class="m-dropdown__content">
	                                            <ul class="m-nav">
	                                                <li class="m-nav__section m-nav__section--first">
	                                                    <span class="m-nav__section-text">Quick Actions</span>
	                                                </li>
	                                                <li class="m-nav__item">
	                                                    <a href="" class="m-nav__link">
	                                                        <i class="m-nav__link-icon flaticon-share"></i>
	                                                        <span class="m-nav__link-text">Activity</span>
	                                                    </a>
	                                                </li>
	                                                <li class="m-nav__item">
	                                                    <a href="" class="m-nav__link">
	                                                        <i class="m-nav__link-icon flaticon-chat-1"></i>
	                                                        <span class="m-nav__link-text">Messages</span>
	                                                    </a>
	                                                </li>
	                                                <li class="m-nav__item">
	                                                    <a href="" class="m-nav__link">
	                                                        <i class="m-nav__link-icon flaticon-info"></i>
	                                                        <span class="m-nav__link-text">FAQ</span>
	                                                    </a>
	                                                </li>
	                                                <li class="m-nav__item">
	                                                    <a href="" class="m-nav__link">
	                                                        <i class="m-nav__link-icon flaticon-lifebuoy"></i>
	                                                        <span class="m-nav__link-text">Support</span>
	                                                    </a>
	                                                </li>
	                                                <li class="m-nav__separator m-nav__separator--fit">
	                                                </li>
	                                                <li class="m-nav__item">
	                                                    <a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Cancel</a>
	                                                </li>
	                                            </ul>
	                                        </div>
	                                    </div>
	                            </div>
	                        </div>
						</li>
					</ul>
				</div>
			</div>
<div class="m-portlet__body"> 
	<div id="scoreChart" style="height:400px;"> 
{{$scores}}	
</div>
<div id="performanceLogs"></div>

	
</div>
</div><!--end::Portlet-->


<script>
	var jString = '{!! $logs !!}';
	var dataJSONArray = JSON.parse(jString);

	var options = {
		data: {
			type:'local',
			source: dataJSONArray,
			pageSize: 10
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
        		field: "date",
        		title: "Date",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "location_name",
        		title: "location",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "event",
        		title: "Event",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "value",
        		title: "Result",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        ]
	}


	
	$('#performanceLogs').mDatatable(options);


var scoreString = '{!! $scores !!}';
var chartData = JSON.parse(scoreString);

var chart = AmCharts.makeChart("scoreChart", {
    "type": "serial",
    "theme": "light",
    "marginRight": 80,
    "autoMarginOffset": 20,
    "marginTop": 7,
    "dataProvider": chartData,
    "valueAxes": [{
        "axisAlpha": 0.2,
        "dashLength": 1,
        "position": "left"
    }],
    "mouseWheelZoomEnabled": true,
    "graphs": [{
        "id": "g1",
        "balloonText": "[[value]]",
        "bullet": "round",
        "bulletBorderAlpha": 1,
        "bulletColor": "#FFFFFF",
        "hideBulletsCount": 50,
        "title": "red line",
        "valueField": "performance",
        "useLineColorForBulletBorder": true,
        "balloon":{
            "drop":true
        }
    }],
    "chartScrollbar": {
        "autoGridCount": true,
        "graph": "g1",
        "scrollbarHeight": 40
    },
    "chartCursor": {
       "limitToGraph":"g1"
    },
    "categoryField": "startDate",
    "categoryAxis": {
        "parseDates": true,
        "axisColor": "#DADADA",
        "dashLength": 1,
        "minorGridEnabled": true
    },
    "export": {
        "enabled": true
    }
});

</script>