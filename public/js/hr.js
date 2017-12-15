function notify(message,type){
	$.notify({
					message:message
				},
				{
					type:type,
					placement:{
						from:'top',
						align:'center',
					},
					animate: {
					enter: 'animated bounce',
					exit: 'animated fadeOutUp'
				},

				}
				);
}

//hr
function editPersonal(employee) {
	$.post(
		'/employee/edit/personal',
		{
			_token: $("input[name=_token]").val(),
			employee: employee
		},
		function(data,status){
			if(status == 'success'){
				$('#personalDetails').html(data);
			}
		}
		);
}
function cancelPersonal(employee){
	$.post(
		'/employee/edit/personal/cancel',
		{
			_token: $("input[name=_token]").val(),
			employee: employee
		},
		function(data,status){
			if(status == 'success'){
				$('#personalDetails').html(data);
			}
		}
		);
}
function updatePersonal(employee){
	
	var english,chinese,cantonese,french;
	if($('#english').is(':checked')){
		english = 1;
	} else {
		english = 0;
	}
	if($('#chinese').is(':checked')){
		chinese = 1;
	} else {
		chinese = 0;
	}
	if($('#cantonese').is(':checked')){
		cantonese = 1;
	} else {
		cantonese = 0;
	}
	if($('#french').is(':checked')){
		french = 1;
	} else {
		french = 0;
	}

	$.post(
		'/employee/edit/personal/update',
		{
			_token: $("input[name=_token]").val(),
			employee: employee,
			firstName: $('#firstName').val(),
			lastName: $('#lastName').val(),
			cName: $('#cName').val(),
			alias: $('#alias').val(),
			email: $('#email').val(),
			gender: $('#gender').val(),
			dob: $('#dob').val(),
			hometown: $('#hometown').val(),
			canada_status: $('#canada_status').val(),
			status_expiry: $('#status_expiry').val(),
			married: $('#married').val(),
			english: english,
			chinese: chinese,
			cantonese: cantonese,
			french: french,
		},
		function(data,status){
			if(status == 'success'){
				notify('Personal details have been saved!','primary');
				cancelPersonal(employee);

			}
		}
		);
}
function editContact(employee) {
	$.post(
		'/employee/edit/contact',
		{
			_token: $("input[name=_token]").val(),
			employee: employee
		},
		function(data,status){
			if(status == 'success'){
				$('#contactDetails').html(data);
			}
		}
		);
}
function cancelContact(employee){
	$.post(
		'/employee/edit/contact/cancel',
		{
			_token: $("input[name=_token]").val(),
			employee: employee
		},
		function(data,status){
			if(status == 'success'){
				$('#contactDetails').html(data);
			}
		}
		);
}
function updateContact(employee){
	$.post(
		'/employee/edit/contact/update',
		{
			_token: $("input[name=_token]").val(),
			employee: employee,
			phone: $('#phone').val(),
			emergency_person: $('#emergency_person').val(),
			emergency_phone: $('#emergency_phone').val(),
			emergency_relation: $('#emergency_relation').val(),
		},
		function(data,status){
			if(status == 'success'){
				notify('Contact details have been saved!','primary');
				cancelContact(employee);
			}
		}
		);
}
function editAddress(employee) {
	$.post(
		'/employee/edit/address',
		{
			_token: $("input[name=_token]").val(),
			employee: employee
		},
		function(data,status){
			if(status == 'success'){
				$('#addressDetails').html(data);
			}
		}
		);
}
function cancelAddress(employee){
	$.post(
		'/employee/edit/address/cancel',
		{
			_token: $("input[name=_token]").val(),
			employee: employee
		},
		function(data,status){
			if(status == 'success'){
				$('#addressDetails').html(data);
			}
		}
		);
}
function updateAddress(employee){
	$.post(
		'/employee/edit/address/update',
		{
			_token: $("input[name=_token]").val(),
			employee: employee,
			address: $('#address').val(),
			city: $('#city').val(),
			state: $('#state').val(),
			zip: $('#zip').val(),
		},
		function(data,status){
			if(status == 'success'){
				notify('Address details have been saved!','primary');
				cancelAddress(employee);
			}
		}
		);
}



function employment(employee)
{
	$.post(
		'/employee/employment',
		{
			_token: $("input[name=_token]").val(),
			employee: employee
		},
		function(data,status){
			if(status == 'success'){
				$('#employee').html(data);
			}
		}
		);	
}
function editEmployment(employee) {
	$.post(
		'/employee/employment/edit',
		{
			_token: $("input[name=_token]").val(),
			employee: employee
		},
		function(data,status){
			if(status == 'success'){
				$('#employmentDetails').html(data);
			}
		}
		);
}
function updateEmployment(employee){
	$.post(
		'/employee/employment/update',
		{
			_token: $("input[name=_token]").val(),
			employee: employee,
			job: $('select[name=job]').val(),
			employeeNumber: $('input[name=employeeNumber]').val(),
			hired: $('input[name=hired]').val(),
			termination: $('input[name=termination]').val(),
			type: $('select[name=type]').val(),
			location: $('select[name=location]').val(),
			sin: $('input[name=sin]').val(),
		},
		function(data,status){
			if(status == 'success'){
				console.log(data);
				notify('Employment details have been saved!','primary');
				employment(employee);
			}
		}
		);
}
function employeeNote(employee)
{
	$.post(
		'/employee/note',
		{
			_token: $("input[name=_token]").val(),
			employee: employee,
		},
		function(data,status){
			if(status == 'success'){
				$('#employee').html(data);
			}
		}
		);
}
function saveNote(employee)
{
	$.post(
		'/employee/note/save',
		{
			_token: $("input[name=_token]").val(),
			employee: employee,
			note: $("textarea[name=note]").val(),
			visibility: $("input[name=visibility]:checked").val(),
		},
		function(data,status){
			if(status == 'success'){
				$('.modal-backdrop').remove();
				employeeNote(data);
			}
		}
		);
}
function editNote(noteId)
{
	$.post(
		'/employee/note/'+noteId+'/edit',
		{
			_token: $("input[name=_token]").val(),
		},
		function(data,status){
			if(status == 'success'){
				$('#editNote').val(data.note);
				$('#editNoteModal').modal('show');
			}
		},
		'json'
		);
}
function updateNote(noteId)
{
	$.post(
		'/employee/note/'+noteId+'/update',
		{
			_token: $("input[name=_token]").val(),
			note: $("textarea[name=editNote]").val(),
			visibility: $("input[name=editVisibility]:checked").val()
		},
		function(data,status){
			if(status == 'success'){
				$('#editNoteModal').modal('hide');
				$('.modal-backdrop').remove();
				employeeNote(data);

			}
		}
		);
}
var noteID = 0;
function tryRemoveNote(noteId){
	noteID = noteId;
	$('#removeNoteConfirmationModal').modal();
}
function deleteNote(){
	$.post(
		'/employee/note/'+noteID+'/delete',
		{
			_token: $("input[name=_token]").val(),
		},
		function(data,status){
			if(status == 'success'){
				$('#removeNoteConfirmationModal').modal('hide');
				$('.modal-backdrop').remove();
				employeeNote(data);

			}
		}
		);
}
function employeePerformance(employee)
{
	$.post(
		'/employee/performance',
		{
			_token: $("input[name=_token]").val(),
			employee: employee
		},
		function(data,status){
			if(status == 'success'){
				$('#employee').html(data);
			}
		}
		);
}

function employeeCompensation(employee)
{
	$.post(
		'/employee/compensation',
		{
			_token: $("input[name=_token]").val(),
			employee: employee,
		},
		function(data,status){
			if(status == 'success'){
				$('#employee').html(data);
			}
		}
		);
}
function employeeAccount(employee)
{
	$.post(
		'/employee/account',
		{
			_token: $("input[name=_token]").val(),
			employee: employee,
		},
		function(data,status){
			if(status == 'success'){
				$('#employee').html(data);
			}
		}
		);
}
function editEmployeeAccount(employee)
{
	$.post(
		'/employee/account/'+employee+'/edit',
		{
			_token: $("input[name=_token]").val(),
		},
		function(data,status){
			if(status == 'success'){
				$('#employee').html(data);
			}
		}
		);
}
function updateEmployeeAccount(employee){
	$.post(
		'/employee/account/' + employee + '/update',
		{
			_token: $("input[name=_token]").val(),
			username: $('input[name=username]').val(),
			email: $('input[name=username]').val(),
			password: $('input[name=password]').val(),
			password_confirmation: $('input[name=password_confirmation]').val(),
		},
		function(data,status){
			if(status == 'success'){
				if(data == 'updated'){
					notify('New account details have been saved!','success');
					employeeAccount(employee);
				} else if (data == 'created') {
					notify('New account has been created!','success');
					employeeAccount(employee);
				}
				
			} 
		}
		).fail(function(response){
			if(response.status == 422){
				var errors = '';
				if(response.responseJSON.errors.email != null){
					errors += '<p>' + response.responseJSON.errors.email + '</p>';
				}
				
				for(e in response.responseJSON.errors.password){
					errors += '<p>' + response.responseJSON.errors.password[e] + '</p>';
				}
				notify(errors,'danger');
				
			} else {
				console.log(response);
			}
		});
}
function employeeTraining(employee)
{
	$.post(
		'/employee/training',
		{
			_token: $("input[name=_token]").val(),
			employee: employee,
		},
		function(data,status){
			if(status == 'success'){
				$('#employee').html(data);
			}
		}
		);
}
function employeeBackground(employee)
{
	$.post(
		'/employee/background/'+ employee + '/show',
		{
			_token: $("input[name=_token]").val(),
			employee: employee,
		},
		function(data,status){
			if(status == 'success'){
				$('#employee').html(data);
			}
		}
		);
}
function editEducation(employee)
{
	$.post(
		'/employee/education/'+employee+'/edit',
		{
			_token: $("input[name=_token]").val(),
		},
		function(data,status){
			if(status == 'success'){
				$('#educationDetails').html(data);
			}
		}
		);
}
function updateEducation(employee){
	$.post(
		'/employee/education/' + employee + '/update',
		{
			_token: $("input[name=_token]").val(),
			education: $('#education').val(),
			school: $('input[name=school]').val(),
			major: $('input[name=major]').val(),
		},
		function(data,status){
			if(status == 'success'){
				if(data == 'updated'){
					notify('Education details have been saved!','success');
					employeeBackground(employee);
				} 
			} 
		}
		);
	}
function editWorkHistory(employee)
{
	$.post(
		'/employee/workhistory/'+employee+'/edit',
		{
			_token: $("input[name=_token]").val(),
		},
		function(data,status){
			if(status == 'success'){
				$('#previousWorkDetails').html(data);
			}
		}
		);
}
function updateWorkHistory(employee){
	var check;
	if($('#check').is(':checked')){
		check = 1;
	} else {
		check = 0;
	}
	$.post(
		'/employee/workhistory/' + employee + '/update',
		{
			_token: $("input[name=_token]").val(),
			job: $('#job').val(),
			company: $('input[name=company]').val(),
			location: $('input[name=location]').val(),
			start: $('input[name=start]').val(),
			end: $('input[name=end]').val(),
			quit_reason: $('input[name=quit_reason]').val(),
			supervisor: $('input[name=supervisor]').val(),
			contact: $('input[name=contact]').val(),
			check: check,
			check_reason: $('input[name=check_reason]').val(),
		},
		function(data,status){
			if(status == 'success'){
				if(data == 'updated'){
					notify('Work history have been saved!','success');
					employeeBackground(employee);
				} 
			} 
		}
		);
}