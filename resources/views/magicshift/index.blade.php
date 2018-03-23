@extends('layouts.magicshift.magicshift')
@section('content')

<!--begin::Portlet-->
		<div class="m-portlet m-portlet--responsive-mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-squares-1 m--font-brand"></i>
						</span>
						<h3 class="m-portlet__head-text m--font-brand">
							Magic Shift 
						</h3>
					</div>			
				</div>
                <div class="m-portlet__head-tools">
                    <input type="checkbox" name="resourceToggle">
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        
                        <button id="refreshBtn" type="button" class="m-btn btn btn-secondary"><i class="la la-refresh"></i></button>
                        <button type="button" class="m-btn btn btn-secondary"><i class="la la-floppy-o"></i></button>
                        <button type="button" class="m-btn btn btn-secondary"><i class="la la-header"></i></button>
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="la la-navicon"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <button class="dropdown-item" type="button" id="copyScheduleBtn">Copy Schedule</button>
                          
                        </div>
                      </div>
                     
                      {{Form::select('location',$locations,$defaultLocation,['class'=>'selectpicker','id'=>'location'])}}
                        
                    </div>
                </div>
				
			</div>
			<div class="m-portlet__body">
           
                    <span id="status_bar"></span>
                     <div class="row">
                <div class="col-12" id="stats"></div>
            </div>
            <div class="row">
                <div class="col-12" id="calendar"></div>
            </div>
           
			</div>
		</div>	
		<!--end::Portlet-->
<div hidden>
@include('layouts.magicshift.createShift')
@include('layouts.magicshift.modifyShift')
@include('layouts.magicshift.borrowEmployee')
@include('layouts.magicshift.copySchedule')
</div>

@endsection

@section('pageJS')
<script>
const csrf_token = '{{csrf_token()}}';



var currentEvent = {};
var currentDate = moment();
var currentLocation = {{ $defaultLocation }};


var currentShift = {
    id:0,
    start:{},
    end:{},
    startStr:'',
    endStr:'',
    title:'',
    role:0,
    duty: null,
    employee:0,
    published:false,
    special:false,
    note:'',
    clear:function(){
        this.id = 0;
        this.start = {};
        this.end = {};
        this.startStr = '',
        this.endStr = '',
        this.title = '',
        this.role = 0;
        this.duty = null;
        this.employee = 0;
        this.published = false;
        this.special = false;
        this.note = '';
        $('#createSpecial').prop('checked',false);
    },
};
var newShift = {
    start:null,
    end:null,
    role:null,
    duty:null,
    employee:null,
    published:false,
    special:false,
    note:null,
    clear:function(){
        this.start = null;
        this.end = null;
        this.role = null;
        this.duty = null;
        this.employee = null;
        this.published = false;
        this.special = false;
        this.note = null;
        $('#form-control-feedback').html('');
        $('#createSpecial').prop('checked',false);
    },
};




function udpateWeekTotalOnRemoval(shift){
    var resource = $('#calendar').fullCalendar('getResourceById',shift.employee_id);
    var total = $('#weekTotal'+shift.employee_id);
    var oldWeekTotal = Number(total.text());
    const removedEventTotal = (moment(shift.end).format('X') - moment(shift.start).format('X'))/3600;
    resource.weekTotal = oldWeekTotal - removedEventTotal;
    const newWeekTotal = Math.round(resource.weekTotal *100)/100;
    total.text(newWeekTotal);
    if(newWeekTotal <= 44.0 && newWeekTotal != 0.0){
        total.removeClass('badge badge-danger');
        total.addClass('badge badge-success');
    } else  if(newWeekTotal > 44.0) {
        total.removeClass('badge badge-success');
        total.addClass('badge badge-danger');
    } else {
        total.hide();
    }
    
    currentEvent = {};
}


function updateWeekTotal(shift){
    var resource = $('#calendar').fullCalendar('getResourceById',shift.employee_id);
    var total = $('#weekTotal'+shift.employee_id);
    var oldWeekTotal = Number(total.text());
    const newEventTotal = (moment(shift.end).format('X') - moment(shift.start).format('X'))/3600;
    if(Object.keys(currentEvent).length){
        const oldEventTotal = (currentEvent.end.format('X') - currentEvent.start.format('X'))/3600;
        resource.weekTotal = oldWeekTotal - oldEventTotal + newEventTotal;
    } else {
        resource.weekTotal = oldWeekTotal + newEventTotal;
    }
    
    const newWeekTotal = Math.round(resource.weekTotal *100)/100;

    total.text(newWeekTotal);
    if(newWeekTotal <= 44.0){
        total.removeClass('badge badge-danger');
        total.addClass('badge badge-success');
    } else {
        total.removeClass('badge badge-success');
        total.addClass('badge badge-danger');
    }
    
    //currentEvent = {};
}
var shiftCounter = 0;

var fullCalOptions = {
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        events: {
        
                type:'post',
                url: '/shifts/fetchWeek',
                dataType:'json',
                data:{
                    _token: csrf_token,
                    location:currentLocation,
                },
                success: function(result){
                },
                error: function(){
                    alert('there was an error while fetching events!');
                },
                color:'#d3eefd',
                textColor: 'black',
            
                },
        slotLabelInterval:'01:00',
        resourceColumns:[
            {
            labelText:'name',
            field:'cName',
            },
        ],
        resourceOrder: 'firstStart',
        filterResourcesWithEvents: false,
        refetchResourcesOnNavigate: true,
        resources: function(callback,start,end,timezone){
            $.post(
                '/sr/get',
                {
                    _token: '{{csrf_token()}}',
                    location:currentLocation,
                    start: start.format('YYYY-MM-DD'),
                    end: end.format('YYYY-MM-DD')
                },
                function(data,status){
                    if(status == 'success'){
                        callback(data);
                    }
                },
                'json'
            );
        },
        resourceRender: function(resourceObj,labelTds,bodyTds){
            var weekTotalStr = '';
            if(resourceObj.weekTotal) {
                if(Number(resourceObj.weekTotal) <= 44.0){
                    weekTotalStr = '<span class="float-right badge badge-success" id="weekTotal'+resourceObj.id+'">' + resourceObj.weekTotal +'</span>';
                } else {
                    weekTotalStr = '<span class="float-right badge badge-danger" id="weekTotal'+resourceObj.id+'">' + resourceObj.weekTotal +'</span>';
                }
                
            } else {
                weekTotalStr = '<span class="float-right" id="weekTotal'+ resourceObj.id + '"></span>';
            }

             labelTds.eq(0).find('.fc-cell-content').append(weekTotalStr);

             // check if employee is from another location
             if(resourceObj.location_id != currentLocation){
                labelTds.eq(0).find('.fc-cell-text').append(' (借)');
             }
             
           
        },




        // loading: function(isLoading,view){
        //     if(isLoading)
        //     {
        //         $('#status_bar').html('<div class="alert alert-info" role="alert">Loading..</div>');
        //     }
        //     else
        //     {
        //         $('#status_bar').html('');
        //     }
            
        // },
        
        eventDataTransform: function(eventData){
            eventData.title = eventData.role.c_name;
            if(eventData.duty){
                eventData.color = eventData.duty.color;
            } else {
                eventData.color = '#d3eefd';
            }
            
            return eventData;
        },

        eventRender: function(event,element){
            const duration = (event.end.format('X') - event.start.format('X'))/3600;
            getTotalHours(duration);
            if(event.special == "1"){
                element.find(".fc-time").append(' <i class="fa  fa-usd m--font-warning"></i>&nbsp;');
            }
            if(event.comment){
                element.find(".fc-time").append(' <i class="fa  fa-commenting"></i>&nbsp;');
            }
            if(event.end.isAfter(event.start,'day')){
                 element.find(".fc-time").append(' <i class="fa  fa-moon-o"></i>&nbsp;');
            }


            element.find(".fc-time").append(' <span class="float-right badge badge-secondary">'+ Number(duration.toFixed(2)) + '</span>');
            if(event.duty){
                element.find(".fc-time").append('<br><strong>' + event.duty.cName + '</strong>');
            } else {
                element.find(".fc-time").append('<br>');
            }

        },
        eventClick: function(event,element){
            currentEvent = event;
            //console.log(currentEvent);
            currentShift.id = event.id;
            currentShift.employee = event.resourceId;
            currentShift.role_id = event.role_id;
            currentShift.duty_id = event.duty_id;
            currentShift.special = event.special;
            currentShift.note = event.comment;
            $('#modifyRole').val(event.role_id);
            $('#modifyDuty').val(event.duty_id);
            $('#startDate').val(event.start.format('MMM D, YYYY'));
            $('#endDate').val(event.end.format('MMM D, YYYY'));
            $('#startTime').val(event.start.format('h:mma'));
            $('#endTime').val(event.end.format('h:mma'));
            $('#shiftNote').val(event.comment);
            if(event.special){
                $('#modifySpecial').prop('checked',true);
            } else {
                $('#modifySpecial').prop('checked',false);
            }
            $('#modifyShiftDialog').dialog('open');
            $('#endDate').daterangepicker({minDate:event.start,locale: {format:'MMM D, YYYY'},singleDatePicker:true,}); // to disable prior dates

        },
        eventDragStart: function(event,jsEvent,ui,view){
            // currentEvent = event;
            clearStats();
            hideStats();
        },
        eventDragStop: function(event,jsEvent,ui,view){
            clearStats();
            showStats();
        },
        eventDrop: function(event,delta,revertFunc,jsEvent,ui,view){
            currentShift.id = event.id;
            currentShift.employee = event.resourceId;
            currentShift.role_id = event.role_id;
            currentShift.duty_id = event.duty_id;
            currentShift.startStr = event.start.format('YYYY-MM-DD HH:mm');
            currentShift.endStr = event.end.format('YYYY-MM-DD HH:mm');
            currentShift.start = event.start;
            currentShift.end = event.end;
            currentShift.special = event.special;
            currentShift.note =  event.comment;
            updateShift(currentShift);
        },
        eventResizeStart: function(event,jsEvent,ui,view){
            clearStats();
            hideStats();
        },
        eventResizeStop: function(event,jsEvent,ui,view){
            clearStats();
            showStats();
        },
        eventResize: function(event,delta,revertFunc,jsEvent,ui,view){
            clearStats();
            console.log('resized: ' + event);
         
            currentShift.id = event.id;
            currentShift.employee = event.resourceId;
            currentShift.role_id = event.role_id;
            currentShift.duty_id = event.duty_id;
            currentShift.startStr = event.start.format('YYYY-MM-DD HH:mm');
            currentShift.endStr = event.end.format('YYYY-MM-DD HH:mm');
            currentShift.start = event.start;
            currentShift.end = event.end;
            currentShift.note = event.comment;
            currentShift.special = event.special;
            updateShift(currentShift);
        },
    
        height:'auto',
        contentHeight:'600',
        firstDay:1,
        isRTL:false,
        weekends:true,
        hiddenDays:[],
        columnHeader:true,
        fixedWeekCount:false,
        weekNumbers:true,
        weekNumbersWithinDays:true,
        navLinks:true,
        selectable:false,
        unselectAuto:true,
        editable:true,
        droppable:true,
        displayEventEnd: true,
        timeFormat:'h(:mm)t',
        nextDayThreshold:'12:30:00',

        businessHours: {
            dow:[1,2,3,4,5,6,0],
            start:'00:00',
            end:'24:00',
        },
        buttonText: {
            today: 'Today',
            month: 'Month',
            week: 'Week',
            day: 'Day',
            list: 'List'
        },
        showNonCurrentDates:true,
       
        now:'{{Carbon\Carbon::now()->toIso8601String() }}',
        allDaySlot:true,
        noEventsMessage:'No scheduled shifts',
        listDayFormat:true,
        nowIndicator:true,

        // scheduler settings
        resourceAreaWidth:'10%',
        resourceLabelText:'Employees',

    
       

        dayClick: function(date,jsEvent,view,resource) {
            $('#shiftTime').val('');
            $('#form-control-feedback').html(''); 
            getRoleList();
            currentDate = date;
            $('#shiftDate').text(date.format('dddd, MMM D, YYYY'));
            $('#newShiftEmployee').text(resource.cName);
            $('#dutyCreate option[selected="selected"]').prop('selected','selected');
            $('#createSpecial').prop('checked',false);
            $('#createShiftDialog').dialog('open');
            newShift.employee = resource.id;
        },

        views:{
            timelineWorkWeek: {
                buttonText:'Week',
                type:'timeline',
                // visibleRange: function(currentDate){
                //  console.log(currentDate);
                //  return {
                //      start: currentDate.clone().day(1),
          //                end: currentDate.clone().day(8) 
                //  };
                // },

                slotLabelFormat:[
                'MMMM',
                'ddd DD'
                ],
                slotLabelInterval: '24:00',
                duration:{weeks: 1},
                //start:'2018-01-01',
            }
        },

        defaultView: 'timelineWorkWeek',
        customButtons:{
            borrow: {
                text:'借用他店员工',
                click: function(){
                    $('#borrowDialog').dialog('open');
                }
            }
        },

        header: {
            left:   'title  ',
            //center: 'timelineDay,timelineWorkWeek,month,listWeek prev,today,next',
            center: 'timelineDay,timelineWorkWeek, prev,today,next',
            right:  'borrow',
        },
        viewRender: function(view,element)
        {
            scheduleStats($('#calendar').fullCalendar('getView'));
        }

    };




$('.selectpicker').selectpicker();
$('#location').on('changed.bs.select',function(e){
    currentLocation = $('#location').val();
    window.location.replace('{{ url("/scheduler") }}/'+currentLocation);
});

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
    
})

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


function submitShift(){
    clearStats();
    $.post(
        '/shift/create',
        {
            _token: csrf_token,
            location: currentLocation,
            start: newShift.start,
            end: newShift.end,
            role: newShift.role,
            duty: newShift.duty,
            special: newShift.special,
            employee: newShift.employee,
            note: newShift.note,
        },
        function(data,status){
            if(status == 'success'){
                newShift.clear();
                $('#createShiftDialog').dialog('close');
                $('#calendar').fullCalendar('refetchEvents');
                updateWeekTotal(data);
                scheduleStats($('#calendar').fullCalendar('getView'));
            }
        }
        );
}







moment.lang('en', {
     meridiem : function (hours, minutes, isLower) {
        if (hours > 11) {
            return isLower ? 'p' : 'P';
        } else {
            return isLower ? 'a' : 'A';
        }
    }
});
var dpOptions =  {
    dateFormat: 'M d, yy',
    firstDay: 1,
    defaultDate: null,
};
//$.dateragnepicker.setDefaults( dpOptions );

var modifyShiftOptions = {
    dialogClass:'noTitleStuff',
    modal:true,
    autoOpen:false,
    position: { my: "center", at: "center", of: window },
    resizable: false,
    width:600,
    height:680,
    // close:function(event,ui){
    //     currentEvent = {};
    //     currentShift.clear();
    // },    
};

var newShiftDialogOptions = {
    dialogClass:'noTitleStuff',
    'position': { my: "center", at: "center", of: window },
    modal:false,
    autoOpen:false,
    resizable: false,
    width:400,
    closeOnEscape:true,
};
var borrowOptions = {
    dialogClass: 'noTitleStuff',
    modal:true,
    autoOpen:false,
    position: { my: "center", at: "center", of: window },
    resizable: false,
    width:500,
};
$( "#modifyShiftDialog" ).dialog(modifyShiftOptions);
$( "#createShiftDialog" ).dialog(newShiftDialogOptions);
$("#borrowDialog").dialog(borrowOptions);

var modifyCancel = document.getElementById('modifyCancel');
modifyCancel.addEventListener('click',function(){
    $("#modifyShiftDialog").dialog('close');
},false);

var modifyBtn = document.getElementById('modifyBtn');
modifyBtn.addEventListener('click',function(){
    modifyShift();
},false);
function modifyShift(){
    const shift = parseShift();
                 currentShift.startStr = shift.start.format('YYYY-MM-DD HH:mm');
                 currentShift.endStr = shift.end.format('YYYY-MM-DD HH:mm');
                 currentShift.start = shift.start;
                 currentShift.end = shift.end;
                 currentShift.title = $('#modifyRole option:selected').text();
                 currentShift.note = $('#shiftNote').val();
                 currentShift.role = $('#modifyRole').val();
                 currentShift.role_id = $('#modifyRole').val();
                 currentShift.duty = $('#modifyDuty').val();
                 currentShift.duty_id = $('#modifyDuty').val();
                 currentShift.special = $('#modifySpecial').prop('checked');
                 updateShift(currentShift);
                 $('#modifyShiftDialog').dialog('close');
}
function updateShift(shift){
    $.post(
        '/shift/' + shift.id +'/update',
        {
            _token:csrf_token,
            employee: shift.employee,
            role: shift.role_id,
            duty: shift.duty_id,
            special: shift.special, // true/false
            start: shift.startStr,
            end: shift.endStr,
            note: shift.note,
        },
        function(data,status){
            if(status == 'success'){
               
                clearStats();
                updateWeekTotal(data);

                scheduleStats($('#calendar').fullCalendar('getView'));
                currentEvent.duty_id = shift.duty_id;
                if(data.duty){
                    currentEvent.duty = data.duty;
                    currentEvent.color = data.duty.color;
                } else {
                    currentEvent.duty = null;
                    currentEvent.color = null;
                }
                currentEvent.role = data.role;
                
                currentEvent.start = shift.start;
                currentEvent.end = shift.end;
                currentEvent.title = shift.title;
                currentEvent.role_id = shift.role;
              
                currentEvent.special = shift.special;
                currentEvent.comment = shift.note;
             
                $('#calendar').fullCalendar('updateEvent',currentEvent);
                currentEvent = {};
                currentShift.clear();
               
            } 
        }
        );
}

var bCancel = document.getElementById('borrowCancel');
bCancel.addEventListener('click',function(){
    $("#borrowDialog").dialog('close');
},false);
var bBtn = document.getElementById('borrowBtn');
bBtn.addEventListener('click',function(){
    if($('#borrowedEmployee').val() != ''){
        $('#calendar').fullCalendar('addResource',{
            id: $('#borrowedEmployee').val(),
            cName:$('#borrowedEmployee option:selected').text(),
        },true);
    }
    $("#borrowDialog").dialog('close');
},false);

var createCancel = document.getElementById('createCancel');
createCancel.addEventListener('click',function(){
    $("#createShiftDialog").dialog('close');
    $('#createSpecial').prop('checked',false);
},false);
var createBtn = document.getElementById('createBtn');
createBtn.addEventListener('click',function(){
            newShift.role = $('#shiftRole').val();
            newShift.duty = $('#dutyCreate').val();
            newShift.note = $('#newShiftNote').val();
            newShift.special = $('#createSpecial').prop('checked');
            const shift = parseShiftTimeString($('#shiftTime').val());
            console.log(shift);
            if(shift.error == null){
                newShift.start = currentDate.clone().hour(shift.start.hour).minute(shift.start.minute).format('YYYY-MM-DD HH:mm:ss');
                if(shift.addDay){
                    newShift.end = currentDate.clone().add(1,'d').hour(shift.end.hour).minute(shift.end.minute).format('YYYY-MM-DD HH:mm:ss'); 
                } else {
                        newShift.end = currentDate.clone().hour(shift.end.hour).minute(shift.end.minute).format('YYYY-MM-DD HH:mm:ss'); 
                    }
                 submitShift();
                 $("#createShiftDialog").dialog('close'); 
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
    
},false);    


let cal = $('#calendar').fullCalendar(fullCalOptions);

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





</script>
@endsection