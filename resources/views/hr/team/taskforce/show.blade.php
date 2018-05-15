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
            <button class="btn btn-success" v-on:click="addMember">添加成员</button>
				</li>
        <li class="m-portlet__nav-item">
            <button class="btn btn-metal" v-on:click="editTeam">编辑团队</button>
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
 
    <div class="row justify-content-md-center mb-5">
      <div class="col-4 m-widget4">
        <div class="form-group m-form__group">
          <label>上级团队</label>
          <p class="form-control-static">
            @if($team->team)
            {{$team->team->name}}
            @else
            无上级团队
            @endif
          </p>
        </div>
      </div>
    </div>

<div class="row">
<member v-for="member in members" v-bind="member" v-bind:key="member.id"></member>
</div>



    </div>


<!-- Modal Add Member -->
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
        <div class="m-demo">
        <div class="m-demo__preview m-demo__preview--badge mb-5">
<span class="m-badge m-badge--accent m-badge--wide" v-for="member in selectedMembers" v-bind:key="member.id" @click="removeMember(member)">@{{member.name}}</span>
        
        </div>
      </div>

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
<!-- Modal Edit Team -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">编辑团队</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      

      <div class="form-group">
      <label for="superiorTeam">上级团队</label>
        {{Form::select('superiorTeam',$teams,$team->team_id,['class'=>'custom-select','v-on:change'=>'superiorSelect','v-model'=>'superior','placeholder'=>'Choose team'])}}
        </div>
        <div class="form-group">
        <label for="teamMembers">团队成员</label>
       
         <ul class="list-unstyled">
          <li v-for="member in teamMembers" class="mb-2" ><button class="btn btn-primary btn-sm" @click="removeTeamMember(member)">@{{member.name}} <i class="fa fa-close"></i></button></li>
         </ul>
      

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" v-on:click="resetEdit">取消</button>
        <button type="button" class="btn btn-primary" v-on:click="submitEdit">完成编辑</button>
      </div>
    </div>
  </div>
</div>


</div>
		<!--End of Portlet  -->
        
<script>
Vue.component('member-badge',{
  template:'<span class="m-badge m-badge--accent m-badge--wide"><slot></slot></span>',
})




Vue.component('member',{
    props:['name','id','position','sex','img','alias','link'],
    template:`<div class="col-4 m-widget4">
              <a v-bind:href="link">
                <div class="m-widget4__item mb-5 employee-tag">
                <div class="m-widget4__img m-widget4__img--pic">               
                  <img v-bind:src="img" alt="">   
                </div>
                <div class="m-widget4__info">
                <span class="m-widget4__title">
                    @{{name}} @{{alias}}
                </span><br>
                <span class="m-widget4__sub">
                  @{{position}}
                </span>
                </div>
                </div>
                </a>
            </div>`
})

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
                   'img': '{{"/storage/".$m->employee->employee_profile->img}}',
                   'alias': '{{$m->employee->employee_profile->alias}}',
                   'sex': '{{$m->employee->employee_profile->sex}}',
                   'link': '/staff/profile/'+{{$m->employee->id}}+'/show',
                   'member_id':{{$m->id}}
                   },
            @endforeach
        ],
        teamMembers:[
            @foreach($team->teamMember as $m)
               { 
                   'name': '{{$m->employee->name}}',
                   'location':'{{$m->employee->location->name}}',
                   'position': '{{$m->employee->job->rank}}',
                   'id':  '{{$m->employee->id}}',
                   'img': '{{"/storage/".$m->employee->employee_profile->img}}',
                   'alias': '{{$m->employee->employee_profile->alias}}',
                   'sex': '{{$m->employee->employee_profile->sex}}',
                   'link': '/staff/profile/'+{{$m->employee->id}}+'/show',
                   'member_id':{{$m->id}}
                   },
            @endforeach
        ],
        removedMembers:[],
        superior: '{{$team->team?$team->team_id:null}}',
    },
    methods: {
        addMember: function(){
            $('#addModal').modal('show')
        },
        locationSelect: function()
        {
            
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
            console.log('remove member:')
            const index = this.selectedMembers.indexOf(e)
            
            this.selectedMembers.splice(index,1)

        },
         removeTeamMember: function(m)
        {
           
            const index = this.teamMembers.indexOf(m)
            
            this.teamMembers.splice(index,1)
            this.removedMembers.push(m)

        },
        submitMembers: function()
        {
           
            if(this.selectedMembers.length){

           
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
                        vm.resetForm()

                    }
                }
            );
            }
        },
        editTeam(){
          $('#editModal').modal('show')

        },
        resetEdit: function()
        {
          $('#editModal').modal('hide')
            this.selectedMembers = []
            this.selectedLocation = null
            this.employees = []
            this.removedMembers = []
            this.teamMembers = this.members.slice(0)
            
        },
        submitEdit(){
          $.post(
            '/team/taskforce/'+ this.team + '/update',
            {
              _token:vm.token,
               members: vm.removedMembers,
               superior: vm.superior 
            },
            function(data,status){
              if(status == 'success'){
                console.log(data)
                vm.resetEdit()
                vm.members = data;
              }
            }
            )

        },
        superiorSelect(){
          console.log('superior selected')
        },
      },

    
})

</script>
@endsection