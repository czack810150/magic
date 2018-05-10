@extends('layouts.master')
@section('content')

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
            @foreach($teams as $t)
			<div class="col-lg-4 mb-3">
				<div class="card" style="width:18rem;">
					<div class="card-body">
						<h5 class="card-title">{{$t->name}}</h5>
						<h6 class="card-subtitle mb-2 text-muted">{{$t->employee->name}}</h6>
						<p class="card-text">{{$t->teamMember->count()}}名成员</p>
						<p class="card-text">{{$t->description}}</p>
						<a href="{{url("team/taskforce/$t->id/view")}}" class="card-link">View</a>
					</div>
				</div>
			</div>
			@endforeach
        @else
            <p>No taskforce teams.</p>
        @endif
   
    

    

    </div>
</div>
		
		
<script>

</script>
@endsection