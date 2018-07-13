<!--begin::Portlet-->
<div class="m-portlet">

<div class="m-portlet__head">
    <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
            
            <h3 class="m-portlet__head-text">
                Skills <small>业务技能</small>
            </h3>
        </div>
    </div>

    
</div>

<div class="m-portlet__body" id="employeeSkills">
    
                           
    <div class="m-list__content">
        <div class="m-list-badge m--margin-bottom-20">
            
            <div class="m-list-badge__items">                                            
               
                <span class="m-list-badge__item" :class="classObject" v-for="skill in skills"  v-text="skill.skill.cName + ' ' + skill.level"></span>                                      
            </div>
        </div>
       
    </div>    
                          
    
</div>
<!-- end of employee skills -->





<div id="employeeTraining">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												
												<h3 class="m-portlet__head-text">
													Training <small>Details</small>
												</h3>
											</div>
										</div>
                                        @can('assign-skill')
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
													
                                                        <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#skillModal">
Assign New Skill
</button>
														
													</a>
												</li>
											</ul>
										</div>
                                        @endcan
										
									</div>

<div class="m-portlet__body" id="employeeTrainingLog"></div>


</div><!-- end of employeeTraining -->																	
</div>
<!--end::Portlet-->

@can('assign-skill')
<!-- Modal -->
<div class="modal fade" id="skillModal" tabindex="-1" role="dialog" aria-labelledby="skillModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
         <!--begin::Portlet-->
        <div class="m-portlet m-portlet--tab modal-content">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon m--hide">
                        <i class="la la-gear"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            Assign a new skill   
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <form class="m-form m-form--fit m-form--label-align-right">
                <div class="m-portlet__body">
                  
                    <div class="form-group m-form__group row">
                        <label class="col-6 col-form-label">员工</label>
                         <div class="col-6">
                            <span class="form-control">{{ $employee->cName }}</span>
                        </div>

                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-6 col-form-label">卡号</label>
                         <div class="col-6">
                            <span class="form-control">{{ $employee->employeeNumber }}</span>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <label for="category" class="col-6 col-form-label">技能类别</label>
                         <div class="col-6">
{{ Form::select('category',$categories,null,['class'=>'form-control','id'=>'category','placeholder'=>'Choose category']) }}
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <label for="skills" class="col-6 col-form-label">技能项目</label>
                         <div class="col-6" id="skills">
                           
                        </div>
                    </div>
                    
                    <div class="form-group m-form__group row">
                        <label for="finishDate" class="col-6 col-form-label">培训日期时间</label>
                        <div class="col-6">
                            <input class="form-control m-input" type="text" placeholder="Pick a date and time" id="finishDate">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="trainer" class="col-6 col-form-label">培训人</label>
                        <div class="col-6">
{{ Form::select('trainer',$locationEmployees,$employee->location->manager_id,['class'=>'form-control','id'=>'trainer']) }}
                        </div>
                    </div>
                    
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions">
                        <div class="row">
                            <div class="col-2">
                            </div>
                            <div class="col-10">
                                <button type="button" class="btn btn-success" id="submitBtn">Submit</button>
                                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!--end::Portlet-->
   
  </div>
</div>

@endcan



<script>
	var jString = '{!! $logs !!}';
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
        		field: "date_trained",
        		title: "Date",
        		width: 200,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "category",
        		title: "Category",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "stage",
        		title: "Stage",
        		width: 50,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},

        	{
        		field: "itemName",
        		title: "Name",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "trainer_name",
        		title: "Trainer",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        ]
	}	
	$('#employeeTrainingLog').mDatatable(options);


function updateSkillList(){
    var category = $('#category').val();
    $.post(
        '/skill/category/' + category + '/get',
        {
            _token: '{{ csrf_token() }}',
        },
        function(data,status){
            if(status == 'success'){
                $('#skills').html(data);
            }
        }
    );
}

function assignSkillValidation(){
    if( $('#category').val() == ''){
        alert('Please select a category');
        return 0;
    } 

    if( $('#skillList').val() == '' ) {
         alert('Please select a skill');
         return 0;
    }

    if( $('#finishDate').val() == '' ) {
         alert('Please provide training date!');
         return 0;
    }
    return true;
}

function assignSkill(){
    
    if( assignSkillValidation() ){
        
        $.post(
            '/skill/assign',
            {
                _token: '{{ csrf_token() }}',
                employee : '{{ $employee->id }}',
                category : $('#category').val(),
                skill : $('#skillList').val(),
                date : $('#finishDate').val(),
                trainer : $('#trainer').val()
            },
            function(data,status){
                if(status == 'success'){
                    
                    $('#skillModal').modal('hide');
                    
                    notify('New skill ' + data.item.name + ' have been saved!','success');
                } 
                if(status == 'error'){
                    console.log('assign failed');
                }
            },
            'json'
            );
    }    
}

    var category = document.getElementById('category');
    category.addEventListener('change',function(){
      updateSkillList();
    },false);
    var submitBtn = document.getElementById('submitBtn');
    submitBtn.addEventListener('click',function(){
        assignSkill();
    },false);
    $('#finishDate').datetimepicker();

var app = new Vue({
    el:'#employeeSkills',
    data:{
        skills:[
        ],
        classObject:'m-list-badge__item--danger',
        
    },
    methods:{
        getEmployeeSkills(){
            axios.post('/employee_skill/get_skills',{
                employee:'{{ $employee->id }}',
            }).then(function(response){
               
                app.skills = response.data;
            });
        },

    },
    mounted(){
        this.getEmployeeSkills();
    }
})

</script>