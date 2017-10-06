console.log('loaded magic.js');

function locationEmployees(){
	$.post(
      '/employee/location',
      {
        location: $("#locationFilter").val(),
        _token: $('input[name="_token"]').val(),
      },
      function(data,status){
      	var selection = '<select class="custom-select" id="selectedEmployee" name="selectedEmployee" placeholder="Choose employee">';
        for(i in data){
        	selection += '<option value="' + data[i].id +'">' + data[i].cName + '</option>';
        }
        selection += '</select>';
        $("#employeeList").html(selection);
      },
      'json'
      );
}



// Exam module
function questionsByCategory(c){
	$.post(
      '/question/categoryQuestions',
      {
        category_id: c,
        _token: $('input[name="_token"]').val(),
      },
      function(data,status){

      	var options = '';
        for(i in data){
        	options += '<li onclick="selectQuestion($(this))" data-id="'+ data[i].id +'">' + data[i].body;
        	if(data[i].mc){
        		options += ' (选择题)';
        	} else {
        		options += ' (简答题)';
        	}
        	
        	options += '</li>';
        }
        $("#questions").html(options);
      },
      'json'
      );
}
var selectedQuestions = [];
function selectQuestion(e){
			const id = e.data('id');
			const body = e.text();

			var question = {"id":id,"body":body};


			if(containsObject(question,selectedQuestions)){

				selectedQuestions.pop(question);
				e.removeClass("alert-success");
				
			} else {
				e.addClass("alert-success");
				selectedQuestions.push(question);
				
			}
			updateSelectedQuestionsConsole();
			console.log(selectedQuestions);
		}
function updateSelectedQuestionsConsole(){
	$("#selectedQuestions").html('');
	for(i in selectedQuestions){
		$("#selectedQuestions").append('<li>'+ selectedQuestions[i].body +'</li>');
	}
}

function attemptSubmit(){
	const employee = $("#selectedEmployee").val();
	const name = $("#exam_name").val();
	if(name != '' && selectedQuestions.length > 0 && employee != 'undefined'){
		const exam = {"name":name,"employee":employee,"questions":selectedQuestions};
		const json = JSON.stringify(exam);
		$.post(
			 '/exam/store',
      {
        json:json,
        _token: $('input[name="_token"]').val(),
      },function(data,status){
 			if(status = 'success'){
 				window.location.href="/exam/";
 			}
      });

	} else {
		alert('Exam name cannot be empty and exam questions cannot be empty');
	}
	
}

// End of Exam module

function containsObject(obj, list) {
    var i;
    for (i = 0; i < list.length; i++) {
        if (list[i].id === obj.id) {
            return true;
        }
    }

    return false;
}