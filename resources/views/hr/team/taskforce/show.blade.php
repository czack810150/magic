@extends('layouts.master')
@section('content')

<div class="m-portlet m-portlet--full-height" id="vm">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					{{$team->name}} <small>专项团队</small> 
				</h3>
			</div>
		</div>
        @can('create-team')
        <div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <button class="btn btn-success" v-on:click="addMember">
                     添加成员</button>
				</li>
				<li class="m-portlet__nav-item">
                    <a href="{{url("team/taskforce/$team->id/destroy")}}" class="btn btn-info">
                     解散团队</a>
				</li>
			</ul>
		</div>
        @endcan
      
		
	</div>
	<div class="m-portlet__body">
 

    
    <ul>
     <li v-for="member in members">@{{member.name}} @{{member.location}} @{{member.position}}
     @{{member.img}}
     @{{member.alias}}
     
     </li>
    </ul>

<!-- <div class="row">
    <member-card v-for="member in members" v-bind:member="member" v-bind:key="member.id"></member-card>
</div> -->






    </div>


<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">添加成员</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul>
        <li v-for="member in selectedMembers" v-on:click="removeMember(member)">@{{member.name}}</li>
        </ul>

      <div class="form-group">
      <label for="location">Location</label>
        {{Form::select('location',$locations,null,['class'=>'custom-select','v-on:change'=>'locationSelect','v-model'=>'selectedLocation','placeholder'=>'Choose location'])}}
        </div>
        <div class="form-group">
        <label for="employee">Employee</label>
<select class="custom-select" multiple required>
<option v-for="employee in employees" v-bind:value="employee.id" v-on:click="selectedMember(employee)">@{{employee.name}}</option>
</select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" v-on:click="resetForm">取消</button>
        <button type="button" class="btn btn-primary" v-on:click="submitMembers">添加完成</button>
      </div>
    </div>
  </div>
</div>


</div>
		<!--End of Portlet  -->
<script>
// Vue.component('member-card',{
//     props:['member'],
//     template:'<div class="col-md-4 col-sm-6 m-widget4"><a :href="member.link"><div class="m-widget4__item mb-5 employee-tag">@{{member.name}}<div class="m-widget4__img m-widget4__img--pic"><img src:="member.img" alt=""></div></div></a></div>'
// })

var vm = new Vue({
    el: '#vm',
    data:{
        token: '{{csrf_token()}}',
        team: '{{$team->id}}',
        employees:[],
        selectedLocation:null,
        selectedMembers:[],
        members:[
            @foreach($team->teamMember as $m)
               { 
                   'name': '{{$m->employee->name}}',
                   'location':'{{$m->employee->location->name}}',
                   'position': '{{$m->employee->job->rank}}',
                   'id':  '{{$m->employee->id}}',
                   'img': '{{$m->employee->employee_profile->img}}',
                   'alias': '{{$m->employee->employee_profile->alias}}',
                   'sex': '{{$m->employee->employee_profile->sex}}',
                   'link': '{{url("/staff/profile/$m->employee->id/show")}}'
                   },
            @endforeach
        ],
        superior: '{{$team->team?$team->team->name:''}}'

    },
    methods: {
        addMember: function(){
            console.log('add member')
            $('#addModal').modal('show')
        },
        locationSelect: function()
        {
            console.log('location change')
            $.post(
                '{{url('employeeByLocation')}}',
                {
                    _token: this.token,
                    location: this.selectedLocation,
                },
                function(data,status){
                    if(status == 'success'){
                        vm.employees = data
                    } else {
                        console.log('fail')
                    }
                }
            )
        },
        selectedMember: function(e)
        {
            console.log('selected member:'+e.name)
            if(this.selectedMembers.indexOf(e) == -1){
                this.selectedMembers.push(e);
            } else {
                console.log(e.name + ' is already selected')
            }
            
        },
        resetForm: function()
        {
            this.selectedMembers = []
            this.selectedLocation = null
            this.employees = []
            $('#addModal').modal('hide')
        },
        removeMember: function(e)
        {
            const index = this.selectedMembers.indexOf(e)
            console.log(index)
            this.selectedMembers.splice(index,1)

        },
        submitMembers: function()
        {
            console.log('submitted: '+ this.selectedMembers.length)
            if(this.selectedMembers.length){

            for(member in this.selectedMembers){
                console.log(this.selectedMembers[member].name)
            }
            $.post(
                '{{url('team/taskforce/addMember')}}',
                {
                    _token:vm.token,
                    members:vm.selectedMembers,
                    team:vm.team
                },
                function(data,status){
                    if(status == 'success'){
                        console.log(data);
                         vm.members = data;
                        $('#addModal').modal('hide')
                    }
                }
            );
            }
        }
    }
})

</script>
@endsection