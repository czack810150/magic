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
                        <button id="printBtn" type="button" class="m-btn btn btn-secondary"><i class="la la-print"></i></button>
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

<form id="printForm" action="/scheduler/schedule/print" method="POST">
{{ csrf_field() }}
<input name="printLocation" id="printLocation">
<input name="printStart" id="printStart">
<input name="printEnd" id="printEnd">
</form>

</div>

@endsection

@section('pageJS')
<script>
const csrf_token = '{{csrf_token()}}';
var currentEvent = {};
var currentDate = moment();
var currentLocation = {{ $defaultLocation }};



class Shift {
    constructor(){
        this.id = null;
        this.title = null;
        this.start = null;
        this.end = null;
        this.startStr = null;
        this.endStr = null;
        this.role = null;
        this.duty = null;
        this.role_id = null;
        this.duty_id = null;
        this.employee = null;
        this.published = false;
        this.special = false;
        this.note = null;
        $('#form-control-feedback').html('');
        $('#createSpecial').prop('checked',false);
    };
    clear(){
        this.id = null;
        this.title = null;
        this.start = null;
        this.end = null;
        this.startStr = null;
        this.endStr = null;
        this.role = null;
        this.duty = null;
        this.role_id = null;
        this.duty_id = null;
        this.employee = null;
        this.published = false;
        this.special = false;
        this.note = null;
        $('#form-control-feedback').html('');
        $('#createSpecial').prop('checked',false);
    }

}

var currentShift = new Shift();
var newShift = new Shift();
var dragEvent = {};


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
        //resourceOrder: 'job_id',
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

            if(eventData.role){
                 eventData.title = eventData.role.c_name;
             } else {
                eventData.title = 'unassigned';
             }
           
            if(eventData.duty){
                eventData.color = eventData.duty.color;
            } else {
                eventData.color = '#d3eefd';
            }
            
            return eventData;
        },

        eventRender: function(event,element){
            const duration = (event.end.format('X') - event.start.format('X'))/3600;
           
            if(event.published == "1"){
                element.find(".fc-time").append(' <i class="fa  fa-check-circle m--font-info"></i>&nbsp;');
            }
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
      
        },
        eventDragStop: function(event,jsEvent,ui,view){
            
        },
        eventDrop: function(event,delta,revertFunc,jsEvent,ui,view){
            currentEvent = event;
            dragEvent = event;
            dragEvent.duration = (event.end.format('X') - event.start.format('X'))/3600;
            currentShift.id = event.id;
            currentShift.employee = event.resourceId;
            currentShift.role_id = event.role_id;
            currentShift.role = event.role;
            currentShift.duty_id = event.duty_id;
            currentShift.startStr = event.start.format('YYYY-MM-DD HH:mm');
            currentShift.endStr = event.end.format('YYYY-MM-DD HH:mm');
            currentShift.start = event.start;
            currentShift.end = event.end;
            currentShift.special = event.special;
            currentShift.note =  event.comment;
            updateShift(currentShift);
            showStats();
        },
        eventResizeStart: function(event,jsEvent,ui,view){
            
        },
        eventResizeStop: function(event,jsEvent,ui,view){
            
        },
        eventResize: function(event,delta,revertFunc,jsEvent,ui,view){
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
            showStats();
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

        // scheduler resource settings
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
                slotLabelFormat:[
                'MMMM',
                'ddd DD'
                ],
                slotLabelInterval: '24:00',
                duration:{weeks: 1},
                resourceOrder:'job_id',
            },
            timelineDay: {
                buttonText:'Day',
                type:'timeline',
                resourceOrder: 'firstStart',
                resourceLabelText:'Employees',
                resourceGroupField:'job_type',
               

            },
        },

        defaultView: 'timelineWorkWeek',
        customButtons:{
            publish: {
                text:'Publish',
                click: function(){
                    var events = $('#calendar').fullCalendar('clientEvents');
                    const view = $('#calendar').fullCalendar('getView');
                    var updateEvents = [];
                   events.forEach(function(event){
                       updateEvents.push(event.id);
                       
                   })
                   
                   axios.post('/shift/publish',{
                       _token:csrf_token,
                      events:updateEvents,
                      start: view.start.format('YYYY-MM-DD'),
                      end:view.end.format('YYYY-MM-DD'),
                      location:currentLocation
                   }).then(response=>{
                       console.log(response.data)
                       if(response.data > 0){
                        $.notify({
                           message:response.data+' shifts have been published!'
                       },{
                           type:'success',
                           placement:{from:'top',align:'center'},
                       });
                       } else {
                        $.notify({
                           message:'All shifts are currently published!'
                       },{
                           type:'info',
                           placement:{from:'top',align:'center'},
                       });
                       }
                       $('#calendar').fullCalendar('refetchEvents');
                       
                   }).catch(error=>{
                       console.log(error)
                   })
                }
            },
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
            right:  'publish, borrow',
        },
        viewRender: function(view,element)
        {
            scheduleStats($('#calendar').fullCalendar('getView'));
        }

    };


function submitShift(){
    const view = $('#calendar').fullCalendar('getView');
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
            periodStart: view.start.format('YYYY-MM-DD'),
            periodEnd: view.end.format('YYYY-MM-DD'),
        },
        function(data,status){
            if(status == 'success'){
                $('#createShiftDialog').dialog('close');
                $('#calendar').fullCalendar('refetchEvents');
                updateWeekTotal(data);
                scheduleStats($('#calendar').fullCalendar('getView'));
                newShift.clear();
            }
        }
        );
}

function getWeekTotal(event)
{
    const view = $('#calendar').fullCalendar('getView');
    $.post(
        '/shift/getOldTotal',
        {
            _token: csrf_token,
            shift: event.id,
            location: event.location_id,
            employee: event.resourceId,
            periodStart: view.start.format('YYYY-MM-DD'),
            periodEnd: view.end.format('YYYY-MM-DD'),
        },
        function(data,status){
            if(status == 'success'){
                
                console.log(data);
             
            }
        }
        );
}

function updateWeekTotal(shift)
{
    
    const newWeekTotal = shift.periodTotal;
    var total = $('#weekTotal'+shift.employee_id);
    total.text(newWeekTotal);
    if(newWeekTotal <= 44.0){
        total.removeClass('badge badge-danger');
        total.addClass('badge badge-success');
        if(newWeekTotal == 0){
            total.text('');
        }
    } else {
        total.removeClass('badge badge-success');
        total.addClass('badge badge-danger');
    }
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
    close:function(event,ui){
        console.log('dialog closed');
    },    
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
    const view = $('#calendar').fullCalendar('getView');
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
            periodStart: view.start.format('YYYY-MM-DD'),
            periodEnd: view.end.format('YYYY-MM-DD'),
        },
        function(data,status){
            if(status == 'success'){
               
                updateWeekTotal(data);

                scheduleStats(view);
                currentEvent.duty_id = shift.duty_id;
                if(data.duty){
                    currentEvent.duty = data.duty;
                    currentEvent.color = data.duty.color;
                } else {
                    currentEvent.duty = null;
                    currentEvent.color = null;
                }
                
                
                currentEvent.start = shift.start;
                currentEvent.end = shift.end;
                currentEvent.duration = data.duration;
                currentEvent.title = shift.title;
                currentEvent.role_id = shift.role_id;
                currentEvent.role = shift.role;
                currentEvent.special = shift.special;
                currentEvent.comment = shift.note;
             
                $('#calendar').fullCalendar('updateEvent',currentEvent);

             
                if(dragEvent != 'undefined' && data.employee_id != dragEvent.employee_id ){
                    var resourceWeekTotal = $('#weekTotal'+dragEvent.employee_id);
                    const oldWeekTotal = resourceWeekTotal.text();
                    const newWeekTotal = oldWeekTotal -  data.duration;
                    resourceWeekTotal.text(newWeekTotal);
                    if(newWeekTotal <= 44.0){
                    resourceWeekTotal.removeClass('badge badge-danger');
                    resourceWeekTotal.addClass('badge badge-success');
                    if(newWeekTotal == 0){
                    resourceWeekTotal.text('');
                 }
                } else {
                    resourceWeekTotal.removeClass('badge badge-success');
                    resourceWeekTotal.addClass('badge badge-danger');
                }

                } 
                dragEvent.employee = data.employee;
                dragEvent.employee_id = data.employee_id;
                $('#calendar').fullCalendar('updateEvent',dragEvent);
                dragEvent = {};
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
$('.selectpicker').selectpicker();
$('#location').on('changed.bs.select',function(e){
    currentLocation = $('#location').val();
    window.location.replace('{{ url("/scheduler") }}/'+currentLocation);
});


// print btn
var printBtn = document.getElementById('printBtn');
printBtn.addEventListener('click',function(){
    const view = $('#calendar').fullCalendar('getView');
   
    $('#printLocation').val(currentLocation);
    $('#printStart').val(view.start.format('YYYY-MM-DD'));
    $('#printEnd').val(view.end.format('YYYY-MM-DD'));
    $('#printForm').submit();  

},false);
//print btn end


</script>
@endsection