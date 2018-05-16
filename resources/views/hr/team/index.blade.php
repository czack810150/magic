@extends('layouts.master')
@section('content')

<div class="m-portlet m-portlet--full-height" id="vm">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					@{{team}}<small>团队</small>
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
    
    	<a :href="manager.link">
        <div class="m-widget4__item employee-tag mb-5" :class="genderClass(manager)">


						<div class="m-widget4__img m-widget4__img--pic">							 
							<img :src="manager.img" alt="">   
						</div>
						<div class="m-widget4__info">
							<span class="m-widget4__title">
							@{{manager.name}} @{{manager.alias}}
							</span><br> 
							<span class="m-widget4__sub">
							@{{manager.title}}
							</span>							 		 
						</div>
					</div>
			</a>
        </div>
    </div>
    

    <div class="row">

        <div class="col-md-4 col-sm-6 m-widget4" v-for="employee in employees">
        	<a :href="employee.link">
        		<div class="m-widget4__item mb-5 employee-tag" :class="genderClass(employee)">
        			<div class="m-widget4__img m-widget4__img--pic">							 
							<img :src="employee.img" alt="">   
						</div>
				<div class="m-widget4__info">
							<span class="m-widget4__title">
							@{{employee.name}} @{{employee.alias}}
							</span><br> 
							<span class="m-widget4__sub">
							@{{employee.title}} 
							</span>							 		 
						</div>
        		</div>
        	</a>
        </div>

    </div>

    </div>
</div>
		
		
<script>
 var vm = new Vue({
     el:'#vm',
     data:{
         selectedLocation:'{{$currentTeam->id}}',
         token: '{{csrf_token()}}',
         team: '{{$currentTeam->name}}',
         male: 'employee-m-tag',
         manager: {
         	'name': '{{$currentTeam->manager->name}}',
         	'alias': '{{$currentTeam->manager->employee_profile->alias}}',
         	'title': '{{$currentTeam->manager->job->rank}}',
         	'img': '/storage/'+'{{$currentTeam->manager->employee_profile->img}}',
         	'gender': '{{$currentTeam->manager->employee_profile->sex}}',
         	'link': '/staff/profile/'+'{{$currentTeam->manager->id}}'+'/show',
         },
         employees: [
         @foreach($currentTeam->employee->sortBy('job_id') as $e)
       		 @if($currentTeam->manager_id != $e->id)
            	@if($e->status != 'terminated')
         	{
         		id: {{ $e->id}},
         		name: '{{$e->name}}',
         		alias: '{{$e->employee_profile->alias}}',
         		title: '{{$e->job->rank}}',
         		img: '/storage/'+'{{$e->employee_profile->img}}',
         		gender: '{{$e->employee_profile->sex}}',
         		link: '/staff/profile/'+'{{$e->id}}'+'/show',
         	},	
         	@endif
         	@endif
         @endforeach
     	]
      
     },
  
     methods: {
        
        changeLocation(){
        	axios.post('{{url('team/chart')}}',{
        		_token: vm.token,
                location: vm.selectedLocation
        	}).then(function(response){
        		vm.manager = response.data.manager
        		vm.team = response.data.team.name
        		vm.employees = response.data.employees
        		
        	}).catch(function(error){
        		console.log(error)
        	})
        
         },
       genderClass: function(member){
     		if(member.gender == 'male'){
     			return 'employee-m-tag'
     		} else {
     			return 'employee-f-tag'
     		}
     	}
        
     },
     mounted(){
     	console.log(this.employees)
     }
 })

</script>
@endsection