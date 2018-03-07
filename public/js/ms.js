function formControlFeedback(str){
	$('#form-control-feedback').html(str);
}


function parseShiftTimeString(ts){
	const str = ts.trim().toLowerCase();
	const separator = '-';
	var shift = {
		addDay : false,
		error: null,
		msg: null,
	};	
	if(!str.length) {
		shift.error = 0;
		shift.msg = 'must provide a shift time';
		return shift;
	}
	
	if( str.match(/-/g) == null){
		shift.error = 1;
		shift.msg = 'Invalid format: no separator \'-\'';
		return shift;
	}

	if( str.match(/-/g).length == 1){
		const data = str.split(separator,2);

		if(data[0].length > 0 && data[0].length <= 7){
			shift.start = parseTime(data[0]);
		} else {
			console.log('Wrong start time format');
			shift.error = 2;
			shift.msg = 'Wrong start time format';
			return shift;
		}
		if(data[1].length > 0 && data[0].length <= 7){
			shift.end = parseTime(data[1]);
		} else {
			console.log('Wrong end time format');
			shift.error = 3;
			shift.msg = 'Wrong end time format';
			return shift;
		}


		if(shift.start.hour > shift.end.hour) {
			shift.addDay = true;
		} else if(shift.start.hour == shift.end.hour){
			if(shift.start.minute > shift.end.minute){
				shift.addDay = true;
			} else if(shift.start.minute == shift.end.minute){
				//shift.error = 'Invalid time range: start time and end time must be different.';
				shift.addDay = true;
			}
		}

		return shift;
		
	} else {
		console.log('Invalid format: must use one \'-\' as separator');
		shift.error = 4;
		shift.msg = 'Invalid format: must use one \'-\' as separator';
		return shift;
	}
}


function parseTime(ts){
	var time = {
		error: null,
	};
	var i = 0;
	var data = [];
	if(ts.match(/a|am/i)){    // case for am

		i = ts.search(/a/i);
		ts = ts.substring(0,i);

		if(ts.match(/:/g) && ts.match(/:/g).length <= 1){
			data = ts.split(':',2);
			time.hour = parseInt(data[0]);
			time.minute = parseInt(data[1]);
			if(time.hour >= 0 && time.hour <24) {
				
			} else if(time.hour == 24){
				time.hour = 0;
			
			} else {
				time.hour = null;
				time.minute = null;
				time.error = 'Hour is out of range';
			}
			if(time.minute >= 0 && time.minute < 60) {

			
			} else {
				time.hour = null;
				time.minute = null;
				time.error = 'Minute is out of range';
			}

		} else {
			if(ts >= 0 && ts < 24 ){
			time.hour = parseInt(ts);
			time.minute = 0;
			} else if( ts == 24){
				time.hour = 0;
				time.minute = 0;
			} else {
				time.hour = null;
				time.minute = null;
				time.error = 'Hour is out of range';
			}
		}
		
	} else if(ts.match(/p|pm/i)){ // case for pm
		
		i = ts.search(/p/i);
		ts = ts.substring(0,i);

		if(ts.match(/:/g) && ts.match(/:/g).length <= 1){
			data = ts.split(':',2);
			time.hour = parseInt(data[0]);
			time.minute = parseInt(data[1]);
			if(time.hour >= 0 && time.hour <= 12) {
				time.hour += 12;
			} else if( time.hour > 12 && time.hour < 24){

			} else if(time.hour == 24){
				time.hour = 0;
			
			} else {
				time.hour = null;
				time.minute = null;
				time.error = 'Hour is out of range';
			}
			if(time.minute >= 0 && time.minute < 60) {

			
			} else {
				time.hour = null;
				time.minute = null;
				time.error = 'Minute is out of range';
			}

		} else {
			if(ts >= 0 && ts <= 12  ){
			time.hour = parseInt(ts) + 12;
			time.minute = 0;
			} else if(ts >= 12 && ts < 24) {
				time.hour = parseInt(ts);
				time.minute = 0;
			} else if( ts == 24){
				time.hour = 0;
				time.minute = 0;
			} else {
				time.hour = null;
				time.minute = null;
				time.error = 'Hour is out of range';
			}
		}



	} else { // case for no am or pm mark
		if(ts.match(/:/g) && ts.match(/:/g).length <= 1){
			data = ts.split(':',2);
			time.hour = parseInt(data[0]);
			time.minute = parseInt(data[1]);
			if(time.hour >= 0 && time.hour <24) {
				
			} else if(time.hour == 24){
				time.hour = 0;
			
			} else {
				time.hour = null;
				time.minute = null;
				time.error = 'Hour is out of range';
			}
			if(time.minute >= 0 && time.minute < 60) {

			
			} else {
				time.hour = null;
				time.minute = null;
				time.error = 'Minute is out of range';
			}
		} else {
			if(ts >= 0 && ts < 24 ){
			time.hour = parseInt(ts);
			time.minute = 0;
			} else if( ts == 24){
				time.hour = 0;
				time.minute = 0;
			} else {
				time.hour = null;
				time.minute = null;
				time.error = 'Hour is out of range';
			}
		}
	}

	return time;
}

// remove shift
var slider = document.getElementById('removeSlider');

noUiSlider.create(slider, {
    start: 0,
    step: 0.1,
    connect: false,
    range: {
        'min': 0,
        'max': 100
    }
});
slider.noUiSlider.on('change',function(){
    sliderConfirm();
});
function sliderConfirm(){
    const v = slider.noUiSlider.get();
    if(Number(v) === 100) {
        removeShift(currentEvent);
    } 
        slider.noUiSlider.reset();
}
function removeShift(shift){
    $.post(
        '/shift/'+shift.id+'/remove',
        {
            _token: csrf_token,
        },
        function(data,status){
            if(status == 'success'){
                if(data){
                    $('#modifyShiftDialog').dialog('close');
                    $('#calendar').fullCalendar('refetchEvents');
                    udpateWeekTotalOnRemoval(data);
                    currentShift.clear();
                }
            }
        }
    );
}
// end remove shift
