

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
	$.post(
		'/employee/edit/personal/update',
		{
			_token: $("input[name=_token]").val(),
			employee: employee,
			firstName: $('#firstName').val(),
			lastName: $('#lastName').val(),
			cName: $('#cName').val(),
			email: $('#email').val(),
			gender: $('#gender').val(),
			dob: $('#dob').val(),
			hometown: $('#hometown').val(),
			canada_status: $('#canada_status').val(),
			married: $('#married').val()
		},
		function(data,status){
			if(status == 'success'){
				$('#personalDetails').html(data);
			}
		}
		);
}
