@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
		<div class="m-portlet m-portlet--responsive-mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-users m--font-brand"></i>
						</span>
						<h3 class="m-portlet__head-text m--font-brand">
						Applicants
						</h3>
					</div>			
				</div>
				
			</div>
			<div class="m-portlet__body">	
                @include('layouts.errors')
                <div id="applicants"></div>
			</div>
		</div>	
		<!--end::Portlet-->
{{ $applicants }}



<!-- Modal -->
<div class="modal fade" id="hire-applicant" tabindex="-1" role="dialog" aria-labelledby="hire-applicantLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="hire-applicantLabel"><i class="flaticon-user-add"></i> Hire Applicant</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!--begin::Form-->
            <form class="m-form m-form--fit m-form--label-align-right" method="POST" action="/employee/hireApplicant">
                {{ csrf_field() }}
                <input type="text" name="applicantId" id="applicantId" value="" hidden>
      <div class="modal-body">  

            
            
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <label for="employeeLocation" class="col-4 col-form-label">Location</label>
                        <div class="col-8">
                            {{ Form::select('employeeLocation',$employeeLocations,1,['class'=>'form-control m-input','id'=>'employeeLocation'])}}
                        </div>
                    </div>
                    
                    <div class="form-group m-form__group row">
                        <label for="employeeRole" class="col-4 col-form-label">Role</label>
                        <div class="col-8">
                            <select class="form-control m-input" id="employeeRole" name="employeeRole">
                                <option value="2" selected>Employee</option>
                                <option value="20">Manager</option>
                            </select>
                        </div>
                    </div>
                  
                    <div class="form-group m-form__group row">
                        <label for="cName" class="col-4 col-form-label">中文名</label>
                        <div class="col-8">
                            <input class="form-control m-input" type="text" placeholder="Chinese Name" ="" id="cName" name="cName">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="job" class="col-4 col-form-label">Job Title</label>
                        <div class="col-8">
                            {{Form::select('job',$jobs,null,['class'=>'form-control m-input','id'=>'job'])}}
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="sin" class="col-4 col-form-label">SIN</label>
                        <div class="col-8">
                            <input class="form-control m-input" type="text" placeholder="Social Insurance Number" id="sin" name="sin" required>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="employeeNumber" class="col-4 col-form-label">Employee ID</label>
                        <div class="col-8">
                            <input class="form-control m-input" type="text" placeholder="Employee Number" id="employeeNumber" name="employeeNumber" required>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="hireDate" class="col-4 col-form-label">Date Hired</label>
                        <div class="col-8">
                            <input class="form-control m-input" type="text" placeholder="Pick a Date" id="hireDate" name="hireDate" required>
                        </div>
                    </div>
                    
                </div>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success">Hire</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="applicant-note" tabindex="-1" role="dialog" aria-labelledby="applicant-noteLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="hire-applicantLabel"><i class="flaticon-note"></i>Applicant Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="row">
        <div class="col-12">
            <div class="m-portlet m-portlet--tab">
            
            <!--begin::Form-->
            <form class="m-form m-form--fit m-form--label-align-right">
                <div class="m-portlet__body">
            <div class="form-group m-form__group">
                        <textarea class="form-control m-input" id="noteTextarea" rows="4" autofocus></textarea>
                    </div>
                </div>
            </form>
        </div>
</div>
</div>
            
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success" onclick="saveNote()">Save</button>
      </div>
      </div>
  </div>
</div>


@endsection
@section('pageJS')
<script>
    $('#hireDate').datepicker({
        format:'yyyy-mm-dd',
    });
	var jString = '{!! $applicants !!}';
	
    let dataJSONArray = @json($applicants);

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
        		field: "created_at",
        		title: "Date Applied",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
            {
                field: "applicant_status",
                title: "Status",
                width: 100,
                sortable:true,
                overflow:'visible',
                template: function(row){
                    var selection = '';
                    

                    selection = '<select id="status'+row.id+'" name="status" class="custom-select m-input" onchange="updateApplicantStatus('+ row.id +')">';
                   
                    switch(row.applicant_status){
                        case 'applied':
                            selection += '<option value="applied" selected>Applied</option><option value="reviewed">Reviewed</option><option value="phoned">Phoned</option><option value="scheduled">Scheduled</option><option value="interviewed">Interviewed</option><option value="offered">Offered</option><option value="rejected">Rejected</option>';
                            break;
                        case 'reviewed':
                            selection += '<option value="applied">Applied</option><option value="reviewed" selected>Reviewed</option><option value="phoned">Phoned</option><option value="scheduled">Scheduled</option><option value="interviewed">Interviewed</option><option value="offered">Offered</option><option value="rejected">Rejected</option>';
                            break;
                        case 'phoned':
                            selection += '<option value="applied">Applied</option><option value="reviewed">Reviewed</option><option value="phoned" selected>Phoned</option><option value="scheduled">Scheduled</option><option value="interviewed">Interviewed</option><option value="offered">Offered</option><option value="rejected">Rejected</option>';
                            break;
                        case 'interviewed':
                            selection += '<option value="applied">Applied</option><option value="reviewed">Reviewed</option><option value="phoned">Phoned</option><option value="scheduled">Scheduled</option><option value="interviewed" selected>Interviewed</option><option value="offered">Offered</option><option value="rejected">Rejected</option>';
                            break;
                        case 'offered':
                            selection += '<option value="applied">Applied</option><option value="reviewed">Reviewed</option><option value="phoned">Phoned</option><option value="scheduled">Scheduled</option><option value="interviewed">Interviewed</option><option value="offered" selected>Offered</option><option value="rejected">Rejected</option>';
                            break;
                        case 'rejected':
                            selection += '<option value="applied">Applied</option><option value="reviewed">Reviewed</option><option value="phoned">Phoned</option><option value="scheduled">cheduled</option><option value="interviewed">Interviewed</option><option value="offered">Offered</option><option value="rejected" selected>Rejected</option>';
                            break;
                        case 'scheduled':
                            selection += '<option value="applied">Applied</option><option value="reviewed">Reviewed</option><option value="phoned">Phoned</option><option value="scheduled" selected>Scheduled</option><option value="interviewed">Interviewed</option><option value="offered">Offered</option><option value="rejected">Rejected</option>';
                            break;
                        default:
                            selection += '<option value="applied" selected>Applied</option><option value="reviewed">Reviewed</option><option value="phoned">Phoned</option><option value="scheduled">Scheduled</option><option value="interviewed">Interviewed</option><option value="offered">Offered</option><option value="rejected">Rejected</option>';
                    }
                    selection += '</select>';       
                    return selection;
                }
            },

        	{
        		field: "cName",
        		title: "Chinese",
        		width: 100,
        		sortable: false,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "lastName",
        		title: "Last Name",
        		width: 100,
        		sortable: false,
        		selector: false,
        		taxtAlign: 'center'
        	},

        	{
        		field: "firstName",
        		title: "First Name",
        		width: 100,
        		sortable: false,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "location",
        		title: "Location",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "job",
        		title: "Job",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "city",
        		title: "City",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "phone",
        		title: "Phone",
        		width: 100,
        		sortable: false,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field: "status",
        		title: "Immigration",
        		width: 100,
        		sortable: true,
        		selector: false,
        		taxtAlign: 'center'
        	},
        	{
        		field:'Actions',
        		width:100,
        		title:'Actions',
        		sortable:false,
        		overflow:'visible',
        		template: function(row){
        			let button = '<a class="btn btn-sm btn-primary applicantDetails" href="/applicant/' + row.id + '/view">Details</a>';
                    button += '<button type="button" class="btn btn-sm btn-success" onclick="hire(' + row.id + ')">Hire</button>';
                    button +='<a class="btn btn-sm btn-danger" href="/applicant/'+ row.id +'/remove">Remove</a>';
                    button += '<button type="button" class="btn btn-sm btn-warning" onclick="note(' + row.id +')">Note</button>';
        			return button;
        		}
        	}
        ]
	}	
	$('#applicants').mDatatable(options);

function hire(applicant){
    
    getApplicant(applicant);
    
}
function getApplicant(applicant){
   $.post(
            '/applicant/' + applicant + '/get',
            {
                _token: '{{ csrf_token() }}',
            },
            function(data,status){
                if(status == 'success'){
                    $('#cName').val(data.cName);
                    $('#employeeLocation').val(data.location);
                    $('#job').val(data.role);
                    $('#hireDate').val(data.hireDate);
                    $('#applicantId').val(applicant);
                    $('#hire-applicant').modal();
                }
            },
            'json'
            );

}
function updateApplicantStatus(applicant)
{
    let applicantStatus = $('#status'+applicant).val();
    $.post(
        '/applicant/updateStatus',
        {
            _token: '{{ csrf_token() }}',
            applicant: applicant,
            applicantStatus: applicantStatus
        },
        function(data,status){
             if(status == 'success'){
                if(data == 'success'){

                    swal('Update Success!',
                            'Applicant status changed!',
                         'success'
                        );
                } else {
                    swal('Something went wrong!',
                            'Contact Hiro',
                         'danger'
                        );
                }
  
            }
        },
        );
}
var currentApplicant = 0;
function note(applicant){
    currentApplicant = applicant;
    axios.get('/applicant/'+applicant+'/getNote').then(response => {
        $('#noteTextarea').val(response.data);
    });
    
    $('#applicant-note').modal('show');
}
function saveNote(){
    axios.post('/applicant/saveNote',{
        _token: '{{ csrf_token() }}',
        applicant: currentApplicant,
        note: $('#noteTextarea').val()
    }).then(response => {
        $('#applicant-note').modal('hide');
        // if(response.data.status === 'success'){
        //     alert('Sucess');
        // } else {
        //     alert('Failed');
        // }
    });

   // $('#noteTextarea').val('');
}

 </script>
@endsection