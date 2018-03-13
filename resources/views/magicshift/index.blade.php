@extends('layouts.magicshift.magicshift')
@section('content')
{{Carbon\Carbon::now()->toIso8601String() }}
<span id="status_bar"></span>
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
                        
                        <button type="button" class="m-btn btn btn-secondary"><i class="la la-file-text-o"></i></button>
                        <button type="button" class="m-btn btn btn-secondary"><i class="la la-floppy-o"></i></button>
                        <button type="button" class="m-btn btn btn-secondary"><i class="la la-header"></i></button>
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="la la-navicon"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <button class="dropdown-item" type="button" id="copyScheduleBtn">Copy Schedule</button>
                            <a class="dropdown-item" href="#">Dropdown link</a>
                            <a class="dropdown-item" href="#">Dropdown link</a>
                            <a class="dropdown-item" href="#">Dropdown link</a>
                        </div>
                      </div>
                     
                      {{Form::select('location',$locations,$defaultLocation,['class'=>'selectpicker','id'=>'location'])}}
                        
                    </div>
                </div>
				
			</div>
			<div class="m-portlet__body">

<div id="calendar"></div>
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
    start:0,
    end:0,
    role:0,
    employee:0,
    note:'',
    clear:function(){
        this.id = 0;
        this.start = 0;
        this.end = 0;
        this.role = 0;
        this.employee = 0;
        this.note = '';
    },
};
var newShift = {
    start:null,
    end:null,
    role:null,
    employee:null,
    note:null,
    clear:function(){
        this.start = null;
        this.end = null;
        this.role = null;
        this.employee = null;
        this.note = null;
        $('#form-control-feedback').html('');
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
    
    currentEvent = {};
}


var fullCalOptions = {
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        events: {
        
                type:'post',
                url: '/shifts/fetchWeek',
                dataType:'json',
                data:{
                    _token: csrf_token,
                    location:currentLocation,
                    // start:'2018-02-14',
                    // end:'2018-02-14'
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
        resourceOrder: 'job_id',
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
            if(eventData.role_id == '2')
            eventData.backgroundColor = '#fa4377';
            return eventData;
        },

        eventRender: function(event,element){
            
            
           // console.log(element[0]);
            var end = '';
            if(event.end.minutes() == 0){
                end = event.end.format('ha');
            } else {
                end = event.end.format('h:mma');
            }
            element.find(".fc-time").append(' - ' + end);
            var duration = (event.end.format('X') - event.start.format('X'))/3600;
            element.find(".fc-title").append(' <span class="float-right badge badge-secondary">'+ Math.round(duration*100)/100 + '</span>');
            console.log(event);
      
        },
        eventClick: function(event,element){
            currentEvent = event;
            currentShift.id = event.id;
            currentShift.employee = event.resourceId;
            currentShift.role = event.role_id;
            var defaultStartDate = event.start;
            $('#modifyRole').val(event.role_id);
            $('#startDate').val(event.start.format('MMM D, YYYY'));
            $('#startDate').daterangepicker({
                locale: {
                    format:'MMM D, YYYY',
                },
                singleDatePicker:true,
                });

            $('#endDate').val(event.end.format('MMM D, YYYY'));
            $('#endDate').daterangepicker({
                locale: {
                    format:'MMM D, YYYY',
                },
                singleDatePicker:true,
                });
            $('#startTime').val(event.start.format('h:mma'));
            $('#startTime').timepicker();

            $('#endTime').val(event.end.format('h:mma'));
            $("#endTime").timepicker();
            $('#shiftNote').val(event.comment);
            $('#modifyShiftDialog').dialog('option','title',event.title);
            //$('#modifyShiftDialog').hide();
            $('#modifyShiftDialog').dialog('open');
            console.log(currentEvent);
            console.log($('#modifyRole').val());

        },
        eventDrop: function(event,delta,revertFunc,jsEvent,ui,view){
            console.log('dropped: ' + event.start.format('YYYY-MM-DD'));
            currentEvent = event;
            currentShift.id = event.id;
            currentShift.employee = event.resourceId;
            currentShift.role = event.role_id;
            currentShift.start = event.start.format('YYYY-MM-DD HH:mm');
            currentShift.end = event.end.format('YYYY-MM-DD HH:mm');
            updateShift(currentShift);
        },
        eventResize: function(event,delta,revertFunc,jsEvent,ui,view){
            console.log('resized: ' + event.start.format('YYYY-MM-DD'));
            currentEvent = event;
            currentShift.id = event.id;
            currentShift.employee = event.resourceId;
            currentShift.role = event.role_id;
            currentShift.start = event.start.format('YYYY-MM-DD HH:mm');
            currentShift.end = event.end.format('YYYY-MM-DD HH:mm');
            updateShift(currentShift);
        },
    
        height:'auto',
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
        contentHeight:'aspectRatio',
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
                start:'2018-01-01',
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
            center: 'timelineDay,timelineWorkWeek,month,listWeek prev,today,next',
            right:  'borrow',
        },
       

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
           
        console.log(newShift);
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

function getNewShiftTime(str){
    $.post(
        '/datetime/parseStr',
        {
            _token: csrf_token,
            str:str,
        },
        function(data,status){
            if(status == 'success'){
                console.log(data);
                const shift = {
                    start : currentDate.clone().hour(data.from.hour).minute(data.from.minute).format('YYYY-MM-DD HH:mm:ss'),
                    end : currentDate.clone().hour(data.to.hour).minute(data.to.minute).format('YYYY-MM-DD HH:mm:ss'),
                };
                newShift.role = $('#shiftRole').val();
                newShift.start = shift.start;
                newShift.end = shift.end;
                submitShift();
            }
        }
        );
}
function submitShift(){
    $.post(
        '/shift/create',
        {
            _token: csrf_token,
            location: currentLocation,
            start: newShift.start,
            end: newShift.end,
            role: newShift.role,
            employee: newShift.employee,
            note: newShift.note,
        },
        function(data,status){
            if(status == 'success'){
                newShift.clear();
                $('#createShiftDialog').dialog('close');
                $('#calendar').fullCalendar('refetchEvents');
                updateWeekTotal(data);

            }
        }
        );
}

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
function updateShift(shift){
    
    $.post(
        '/shift/' + shift.id +'/update',
        {
            _token:csrf_token,
            employee: shift.employee,
            role: shift.role,
            start: shift.start,
            end: shift.end,
            note: shift.note,
        },
        function(data,status){
            if(status == 'success'){
                updateWeekTotal(data);
                shift.clear(); 
                //$('#calendar').fullCalendar('refetchResources');  
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
    height:600,    
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
                 currentShift.start = shift.start.format('YYYY-MM-DD HH:mm');
                 currentShift.end = shift.end.format('YYYY-MM-DD HH:mm');
                 currentShift.note = $('#shiftNote').val();
                 currentShift.role = $('#modifyRole').val();
                 currentShift.role_id = $('#modifyRole').val();
                 console.log(currentShift);
                 updateShift(currentShift);
                 currentEvent.end = shift.end;
                 currentEvent.start = shift.start;
                 currentEvent.comment = currentShift.note;
                 currentEvent.title = $('#modifyRole option:selected').text();
                 $('#calendar').fullCalendar('updateEvent',currentEvent);
                 console.log(currentEvent);
                 $('#modifyShiftDialog').dialog('close');
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
},false);
var createBtn = document.getElementById('createBtn');
createBtn.addEventListener('click',function(){
     newShift.role = $('#shiftRole').val();
            newShift.note = $('#newShiftNote').val();
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


</script>
@endsection