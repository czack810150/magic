// app level variables
var currentView;

// get clicked shift start and end time, parse to moment obj
function parseShift(){
    const startStr = $('#startDate').val() + ' ' + $('#startTime').val();
    const endStr = $('#endDate').val() + ' ' + $('#endTime').val();
    const start = moment(startStr,'MMM D, YYYY h:ma');
    const end = moment(endStr,'MMM D, YYYY h:ma');
    if(start >= end){
        alert('End time must be greater than start time!');
        return false;
    } else {
        return {
        start:start,
        end:end
    };
    }   
}


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


document.getElementById("shiftTime").addEventListener("keypress", function(event){
    if(event.keyCode == 13 ) {
            newShift.role = $('#shiftRole').val();
            newShift.note = $('#newShiftNote').val();
            newShift.duty = $('#dutyCreate').val();
            newShift.special = $('#createSpecial').prop('checked');
            const shift = parseShiftTimeString($('#shiftTime').val());
            if(shift.error == null){
                newShift.start = currentDate.clone().hour(shift.start.hour).minute(shift.start.minute).format('YYYY-MM-DD HH:mm:ss');
                if(shift.addDay){
                    newShift.end = currentDate.clone().add(1,'d').hour(shift.end.hour).minute(shift.end.minute).format('YYYY-MM-DD HH:mm:ss'); 
                } else {
                        newShift.end = currentDate.clone().hour(shift.end.hour).minute(shift.end.minute).format('YYYY-MM-DD HH:mm:ss'); 
                    }
                 submitShift(); 
            } else {
                switch(shift.error){
                    case 0:
                        console.log(shift.msg);
                        formControlFeedback(shift.msg);
                        break;
                    case 1:
                        console.log(shift.msg);
                        formControlFeedback(shift.msg);
                        break;
                    case 2:
                        console.log(shift.msg);
                        formControlFeedback(shift.msg);
                        break;
                    case 3:
                        console.log(shift.msg);
                        formControlFeedback(shift.msg);
                        break;
                    case 4:
                        console.log(shift.msg);
                        formControlFeedback(shift.msg);
                        break;    
                    default:
                        console.log('unknown error');
                        formControlFeedback(shift.msg);
              }
            }
    }
    
},false);
// end of shift time parser
// role list
function getRoleList(defaultRole){
    $.post(
        '/role/get',
        {
            _token:csrf_token,
            defaultRole: defaultRole
        },
        function(data,status){
            $('#roleOptions').html(data);
        }
    );        
}
// end of role list



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
	const view = $('#calendar').fullCalendar('getView');
    $.post(
        '/shift/'+shift.id+'/remove',
        {
            _token: csrf_token,
            periodStart: view.start.format('YYYY-MM-DD'),
            periodEnd: view.end.format('YYYY-MM-DD'),
        },
        function(data,status){
            if(status == 'success'){
                if(data){
                    $('#modifyShiftDialog').dialog('close');
                    $('#calendar').fullCalendar('refetchEvents');
                
                    	 updateWeekTotal(data);
                   
                    currentShift.clear();
                    scheduleStats(view);
                }
            }
        }
    );
}
// end remove shift


//copy schedule
const copyOptions = {
    dialogClass: 'noTitleStuff',
    modal:true,
    autoOpen:false,
    position: { my: "center", at: "center", of: window },
    resizable: false,
    width:500,
};
var copyFrom,copyTo,dFrom,dTo;
$('#copyScheduleDialog').dialog(copyOptions);
$('#copyScheduleBtn').click(function(){
	const view = $('#calendar').fullCalendar('getView');
	currentView = view;
	console.log(currentView.name);
	$('#currentTimeline').text(view.intervalStart.format('MMM D, YYYY')+ ' - ' + view.intervalEnd.clone().add(-1,'day').format('MMM D, YYYY'));
	dFrom = view.intervalStart.format('YYYY-MM-DD');
	dTo = view.intervalEnd.clone().format('YYYY-MM-DD');
	copyFrom = view.intervalStart.clone().add(-7,'days');
	copyTo = view.intervalEnd.clone().add(-6,'day');
	$('#copyFrom').val(copyFrom.format('MMM D, YYYY'));
	$('#copyTo').val(copyTo.add(-1,'day').format('MMM D, YYYY'))
	$('#copyScheduleDialog').dialog('open');
	$('#copyFrom').blur();
	shiftCount();
});
$('#copyCancel').click(function(){
	$('#copyScheduleDialog').dialog('close');
});
 $('#copyFrom').daterangepicker({
                locale: {
                    format:'MMM D, YYYY',
                },
                singleDatePicker:true,
});
$('#copyFrom').on('apply.daterangepicker',function(ev,pk){
	copyFrom = pk.startDate;
	if(currentView.name == 'timelineWorkWeek'){
		copyTo = pk.startDate.clone().add(7,'days');
	} else if( currentView.name == 'timelineDay'){
		copyTo = pk.startDate.clone().add(1,'day');
	}
	$('#copyFrom').val(copyFrom.format('MMM D, YYYY'));
	$('#copyTo').val(copyTo.clone().add(-1,'day').format('MMM D, YYYY'));
	shiftCount();
});
// get # of total shifts for selected period 
function shiftCount(){
	$.post(
		'shift/count',
		{
			_token: csrf_token,
			from: copyFrom.format('YYYY-MM-DD'),
			to: copyTo.format('YYYY-MM-DD'),
			location:currentLocation,
		},
		function(data,status){
			if(status == 'success'){
				$('#shiftsCount').text(data + ' shifts to copy');
			}
		}
		);
}

var copyBtn = document.getElementById('copyBtn');
copyBtn.addEventListener('click',function(){
	copyShifts();
},false);
function copyShifts(){
	var clear = 0;
	if(document.getElementById('clearCurrent').checked){
		clear = 1;
	} else {
		clear = 0;
	}
	console.log('clear: '+clear);
	$.post(
		'/shift/copy',
		{
			_token: csrf_token,
			location: currentLocation,
			from: copyFrom.format('YYYY-MM-DD'),
			to: copyTo.format('YYYY-MM-DD'),
			dFrom: dFrom,
			dTo: dTo,
			clear: clear
		},
		function(data,status){
			if(status == 'success'){
				console.log(data);
				$('#calendar').fullCalendar('refetchEvents');
				$('#copyScheduleDialog').dialog('close');

				$.notify({
					title: 'Success',
					message: data,
				},
				{
					type:'success',
					allow_dismiss:false,
					newest_on_top:true,
					placement:{from:'top',align:'center'},

				});
			}
		}
		);
}


//statistics
var totalHours = 0.0;
function getTotalHours(hour){
    totalHours += Number(hour);
    $('#totalHour').text(totalHours.toFixed(2));
}
function clearStats()
{
	//totalHours = 0.0;
}
function hideStats(){
	 $('.hourCount').text('');
}
function showStats(){
	 $('.hourCount').show();
}



// function updateWeekTotal(shift){
//     var resource = $('#calendar').fullCalendar('getResourceById',shift.employee_id);
//     var total = $('#weekTotal'+shift.employee_id);
//     var oldWeekTotal = Number(total.text());
//     const newEventTotal = (moment(shift.end).format('X') - moment(shift.start).format('X'))/3600;
//     if(Object.keys(currentEvent).length){
//         const oldEventTotal = (currentEvent.end.format('X') - currentEvent.start.format('X'))/3600;
//         resource.weekTotal = oldWeekTotal - oldEventTotal + newEventTotal;
//     } else {
//         resource.weekTotal = oldWeekTotal + newEventTotal;
//     }
    
//     const newWeekTotal = Math.round(resource.weekTotal *100)/100;

//     total.text(newWeekTotal);
//     if(newWeekTotal <= 44.0){
//         total.removeClass('badge badge-danger');
//         total.addClass('badge badge-success');
//     } else {
//         total.removeClass('badge badge-success');
//         total.addClass('badge badge-danger');
//     }
    
//     //currentEvent = {};
// }

function scheduleStats(view){ 
    $.post(
        '/scheduler/stats/fetch',
        {
            _token: csrf_token,
            location: currentLocation,
            from:view.start.format('YYYY-MM-DD'),
            to:view.end.format('YYYY-MM-DD'),
        },
        function(data,status){
            if(status == 'success'){
                $('#stats').html(data);
            }
        }
        );
}

// end of statistics

//modify dialog date time pickers
const drpOptions = {
    locale: {
        format:'MMM D, YYYY',
    },
    singleDatePicker:true,
};
$('#startDate').daterangepicker(drpOptions);
$('#endDate').daterangepicker(drpOptions);
$('#startTime').timepicker();
$("#endTime").timepicker();
$("#startDate").on('apply.daterangepicker',function(e,p){
    if(currentEvent.start.format('YYYY-MM-DD') == currentEvent.end.format('YYYY-MM-DD')){
        $('#endDate').val(p.startDate.format('MMM D, YYYY'));
    } else {
        const diff = currentEvent.end.clone().startOf('date').diff(currentEvent.start.clone().startOf('date'),'days');
        $('#endDate').val(p.startDate.clone().add(diff,'days').format('MMM D, YYYY'));
    }
    $('#endDate').daterangepicker({
        minDate:p.startDate,
        locale: {
        format:'MMM D, YYYY',
        },
        singleDatePicker:true,
    });
});
//modify dialog date time pickers  End
// refresh btn
var refreshBtn = document.getElementById('refreshBtn');
refreshBtn.addEventListener('click',function(){
	$('#calendar').fullCalendar('refetchResources');
	$('#calendar').fullCalendar('refetchEvents');
},false);
//refresh btn end


//borrow employee



$('#otherLocation').on('changed.bs.select',function(e){
    getBorrowList()
});
$('#borrowPosition').on('changed.bs.select',function(e){
    getBorrowList()
});

function getBorrowList(){
    const location = $('#otherLocation').val();
    const position = $('#borrowPosition').val();

    if(location != '' && position != '' ){
        $.post(
            '/employees/positionFilter',
            {
                _token: csrf_token,
                location: location,
                position: position
            },
            function(data,status){
                if(status == 'success'){
                    $('#availables').html(data);
                }
            }
            );
    }
}
//borrow end

var allResources = [];
function resourceToggle(){
    console.log('resource toggle');
    var resources = cal.fullCalendar('getResources');
    allResources = resources;
    for(i in resources){
        resources[i].events = $('#calendar').fullCalendar('getResourceEvents',resources[i]);
        if(!resources[i].events.length)
        $('#calendar').fullCalendar('removeResource',resources[i]);
    }
    return 1;
}

$("[name='resourceToggle']").bootstrapSwitch({
   
    onSwitchChange: function(event,state){
        event.preventDefault()
        if(state){
            resourceToggle()
        } else {
           // $('#calendar').fullCalendar('refetchResources');
            for(i in allResources){
                 $('#calendar').fullCalendar('addResource',allResources[i]);
            }
        }
    }
});