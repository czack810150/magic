

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
