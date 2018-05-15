<div class="row justify-content-md-center">
        <div class="col-4 m-widget4">
    
        <div class="m-widget4__item employee-tag">
						<div class="m-widget4__img m-widget4__img--pic">							 
							<img src="{{url('storage/'.$currentTeam->manager->employee_profile->img)}}" alt="">   
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
	@foreach($currentTeam->employee->sortBy('job_id') as $e)
        @if($currentTeam->manager_id != $e->id)
            @if($e->status != 'terminated')
        <div class="col-md-4 col-sm-6 m-widget4">
        <a href="{{url("staff/profile/$e->id/show")}}">
        <!--begin::Widget 14 Item-->  
		
		<div class="m-widget4__item mb-5 employee-tag
		
					@if($e->employee_profile->sex=='male')
					employee-m-tag
					@elseif($e->employee_profile->sex == 'female')
					employee-f-tag
					@else
					@endif
					">
						<div class="m-widget4__img m-widget4__img--pic">							 
							<img src="{{url("storage/".$e->employee_profile->img)}}" alt="">   
						</div>
		
						<div class="m-widget4__info">
							<span class="m-widget4__title">
							{{$e->name}} @if(count($e->employee_profile)){{$e->employee_profile->alias}} @endif
							</span><br> 
							<span class="m-widget4__sub">
							@if(count($e->job))  {{$e->job->rank}} @endif 
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