@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
		<div class="m-portlet m-portlet--responsive-mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-users m--font-brand"></i>
						</span>
						<h3 class="m-portlet__head-text m--font-brand">
							New Applicants
						</h3>
					</div>			
				</div>
				<div class="m-portlet__head-tools">
					<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
						<button type="button" class="m-btn btn btn-secondary"><i class="la la-file-text-o"></i></button>
					    <button type="button" class="m-btn btn btn-secondary"><i class="la la-floppy-o"></i></button>
					    <button type="button" class="m-btn btn btn-secondary"><i class="la la-header"></i></button>
					  	<div class="btn-group" role="group">
					    	<button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					      	Dropdown
					    </button>
					    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
					      	<a class="dropdown-item" href="#">Dropdown link</a>
					      	<a class="dropdown-item" href="#">Dropdown link</a>
					      	<a class="dropdown-item" href="#">Dropdown link</a>
					      	<a class="dropdown-item" href="#">Dropdown link</a>
					    </div>
					  </div>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<div id="applicantList"></div>
			</div>
		</div>	
		<!--end::Portlet-->




@endsection
@section('pageJS')
<script>
	var jString = '{!! $applicants !!}';
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
        		field: "created_at",
        		title: "Date Applied",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "cName",
        		title: "Chinese",
        		width: 100,
        		sortable: false,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "lastName",
        		title: "Last Name",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},

        	{
        		field: "firstName",
        		title: "First Name",
        		width: 100,
        		sortable: false,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "location",
        		title: "Location",
        		width: 100,
        		sortable: false,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "job",
        		title: "Job",
        		width: 100,
        		sortable: false,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "city",
        		title: "City",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "phone",
        		title: "Phone",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "status",
        		title: "Status",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field:'Actions',
        		width:100,
        		title:'View',
        		sortable:false,
        		overflow:'visible',
        		template: function(row){
        			let button = '<a class="btn btn-sm btn-primary applicantDetails" href="/applicant/' + row.id + '/view">Details</a>';
        			return button;
        		}
        	}
        ]
	}	
	$('#applicantList').mDatatable(options);



	</script>
@endsection