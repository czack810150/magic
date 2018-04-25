@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
<div class="m-portlet m-portlet--full-height ">
						
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-clipboard"></i>
												</span>
												<h3 class="m-portlet__head-text">
													View All Skills <small>现有技能</small>
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
										<a href="/skills" class="btn btn-secondary">All Skills</a>
												</li>
										
												
												<li class="m-portlet__nav-item">
												<a href="/skills/create" class="btn btn-success">Create new skill</a>
														
												
												</li>
												
											</ul>
										</div>
									</div>
					

<div class="m-portlet__body">
@if(count($skills))

<table class="table table-sm table-hover">
	<thead><tr><th>Name</th><th>中文名</th><th>Description</th><th>created at</th><th>updated at</th><th>Action</th></tr></thead>
	<tbody>
	@foreach($skills as $s)
	<tr>
		
		<td>{{ $s->name }}</td>
		<td>{{ $s->cName }}</td>
	<td>{{ $s->description }}</td>
		<td>{{ $s->created_at }}</td>
		<td>{{ $s->updated_at }}</td>
	
		<td>
			<a class="btn btn-warning btn-sm" href="/skills/{{$s->id}}/edit">Edit</a>
			<a class="btn btn-danger btn-sm" href="/skills/{{$s->id}}/delete">Remove</a>

		</td>

	</tr>
	@endforeach
	</tbody>
</table>
@else
<div class="m-alert m-alert--icon m-alert--outline alert alert-info alert-dismissible fade show" role="alert">
<div class="m-alert__icon"><i class="la la-warning"></i></div>
<div class="m-alert__text">
<strong>No defined skills.</strong> You can create one by clicking "Create new skill" button.		
</div>									  	
</div>
@endif				 

</div>
</div>
<!--end::Portlet-->
@endsection