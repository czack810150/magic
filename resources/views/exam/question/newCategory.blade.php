@extends('layouts.master')
@section('content')

<!--begin::Portlet-->
<div class="m-portlet m-portlet--mobile" id="root">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
						Question Categories <small>问题类别 (<span v-text="categoryCount"></span>)</small>
						</h3>
					</div>			
				</div>
				<div class="m-portlet__head-tools">
					<ul class="m-portlet__nav">
						<li class="m-portlet__nav-item">
							<a href="/question" class="m-portlet__nav-link m-portlet__nav-link--icon">Back to questions</a>	
						</li>						
						
					</ul>
				</div>
			</div>
			<div class="m-portlet__body">
			@if(isset($categories))

<ul class="list-unstyled">
	
	<li class="mb-3" v-for="category in categories">@{{category.name}}     <a :href="category.delete" class="m-link m-link--state m-link--danger">delete</a></li>
	
</ul>
@else
<p>No categories currently.</p>
@endif

<form class="form-inline" method="POST" action="/question_category/store">
{{csrf_field()}}
<div class="form-group">
<label for="dateRange" class="mr-sm-2">New Category</label>
<div class="input-group">
<input type="text" name="category" class="form-control mb-2 mr-sm-2 mb-sm-0">
</div>
</div>

<button type="submit" class="btn btn-primary">Submit</button>


</form>
			</div>
		</div>	
		<!--end::Portlet-->
<h1></h1>








@endsection

@section('pageJS')
<script>
var vm = new Vue({
	el: '#root',
	data:{
		token: '{{csrf_token()}}',
		categories:[
			@foreach($categories as $c)
				{ 
					name: '{{$c->name}}',
					delete: "/question_category/{{$c->id}}/delete"
				},  
			@endforeach
		],

	},
	computed:{
		categoryCount() {
			return this.categories.length;
		}
	}
	
})
</script>
@endsection