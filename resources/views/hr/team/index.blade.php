@extends('layouts.master')
@section('content')

<div class="m-portlet m-portlet--full-height" id="vm">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Team 
				</h3>
			</div>
		</div>
        @can('view-hr')
        <div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
{{ Form::select('location',$locations,$currentTeam->id,['class'=>'custom-select','id'=>'location','v-model'=>'selectedLocation','@change'=>'changeLocation'])}}											
												</li>
											</ul>
		</div>
        @endcan
		
	</div>
	<div class="m-portlet__body" id="chart">

    <div class="row justify-content-md-center">
        <div class="col-4 m-widget4">
    
        <div class="m-widget4__item employee-tag">
						<div class="m-widget4__img m-widget4__img--pic">							 
							<img src="{{url($currentTeam->manager->employee_profile->img)}}" alt="">   
						</div>
						<div class="m-widget4__info">
							<span class="m-widget4__title">
							{{$currentTeam->manager->name}} {{$currentTeam->manager->employee_profile->alias}}
							</span><br> 
							<span class="m-widget4__sub">
							{{$currentTeam->manager->job->rank}} 
							</span>							 		 
						</div>
						<!-- <div class="m-widget4__ext">
							<a href="#"  class="m-btn m-btn--pill m-btn--hover-brand btn btn-sm btn-secondary">Follow</a>
						</div> -->
					</div>
        </div>
    </div>
    

    <div class="row">
        @foreach($currentTeam->employee as $e)
        @if($currentTeam->manager_id != $e->id)
            @if($e->status != 'terminated')
        <div class="col-4 m-widget4">
        <a href="{{url("staff/profile/$e->id/show")}}">
        <!--begin::Widget 14 Item-->  
					<div class="m-widget4__item mb-5 employee-tag {{$e->employee_profile->sex=='male'?'employee-m-tag':'employee-f-tag'}}">
						<div class="m-widget4__img m-widget4__img--pic">							 
							<img src="{{url("storage/".$e->employee_profile->img)}}" alt="">   
						</div>
						<div class="m-widget4__info">
							<span class="m-widget4__title">
							{{$e->name}} {{$e->employee_profile->alias}}
							</span><br> 
							<span class="m-widget4__sub">
							{{$e->job->rank}} 
							</span>							 		 
						</div>
						<!-- <div class="m-widget4__ext">
							<a href="#"  class="m-btn m-btn--pill m-btn--hover-brand btn btn-sm btn-secondary">Follow</a>
						</div> -->
					</div>
					<!--end::Widget 14 Item-->  
        </a>
        </div>
            @endif
        

        @endif
        @endforeach
    </div>

    </div>
</div>
		
		
<script>
 var vm = new Vue({
     el:'#vm',
     data:{
         selectedLocation:'{{$currentTeam->id}}',
         token: '{{csrf_token()}}',
     },
     methods: {
         changeLocation: function(){ 
             $.post(
                 '{{url('team/chart')}}',
                 {
                     _token: this.token,
                     location: this.selectedLocation
                 },
                 function(data,status){
                     if(status == 'success'){
                        $('#chart').html(data);
                     }
                 }
             );
         }
     }
 })

</script>
@endsection