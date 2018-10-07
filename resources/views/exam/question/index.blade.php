@extends('layouts.master')
@section('content')

@include('exam.question.nav')


<!--Begin::Main Portlet-->
<div class="m-portlet">
  <div class="m-portlet__body m-portlet__body--no-padding">
    <div class="row m-row--no-padding m-row--col-separator-xl">
      <div class="col-md-12 col-lg-12 col-xl-4">
        <!--begin:: Widgets/Stats2-1 -->
<div class="m-widget1">
<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">Category</h3>
				<span class="m-widget1__desc">题库类别</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-warning">{{ count($stats['categories']) }}</span>
			</div>
		</div>
	</div>
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">Total Questions</h3>
				<span class="m-widget1__desc">题库总量</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-info">{{ $stats['total'] }}</span>
			</div>
		</div>
	</div>
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">Multiple Choice</h3>
				<span class="m-widget1__desc">选择题</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-danger">{{ $stats['mc'] }}</span>
			</div>
		</div>
	</div>
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">Short Answer</h3>
				<span class="m-widget1__desc">简答题</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-success">{{ $stats['sa'] }}</span>
			</div>
		</div>
	</div>
	
</div>
<!--end:: Widgets/Stats2-1 -->      
		</div>
      <div class="col-md-12 col-lg-12 col-xl-4">

<!--begin::Section-->
				<div class="m-section">
					
					<div class="m-section__content">
						<table class="table table-sm m-table m-table--head-bg-brand">
						  	<thead class="thead-inverse">
						    	<tr>
						      		<th>Category</th>
						      		<th>Questions</th>
						    	</tr>
						  	</thead>
						  	<tbody>
						  		@foreach($stats['categories'] as $key => $val)
						    	<tr>
							      	<th scope="row">	{{ $key }}</th>
							      	<td>{{$val}}</td>
						    	</tr>
	@endforeach
						    
						  	</tbody>
						</table>
					</div>
				</div>
				<!--end::Section-->
       </div>
    </div>
  </div>
</div>
<!--End::Main Portlet-->

<table id="questionTable">

</table>

@endsection
@section('pageJS')
<script>
console.log('pageJS');
$(document).ready(function(){
	const jString = '{!! $questions !!}';
	const dataJSONArray = JSON.parse(jString);


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
        		field: "category",
        		title: "Category",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
			{
        		field: "type",
        		title: "Type",
        		width: 50,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
			{
        		field: "difficulty",
        		title: "Difficulty",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "body",
        		title: "Question",
        		width: 500,
        		sortable: false,
        		selector: false,
        		taxtAlign: 'center',
				template: function(row){
					return '<a href="/question/'+row.id+'/show">'+row.body+'</a>';
				}
        	},
			{
        		field: "created_by",
        		title: "Author",
        		width: 50,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
			{
        		field: "created",
        		title: "Created at",
        		width: 150,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center',
				
        	},
        	
        	
        ]
	}


	
	$('#questionTable').mDatatable(options);
})

</script>
@endsection