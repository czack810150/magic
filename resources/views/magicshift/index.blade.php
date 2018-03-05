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
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <button type="button" class="m-btn btn btn-secondary"><i class="la la-file-text-o"></i></button>
                        <button type="button" class="m-btn btn btn-secondary"><i class="la la-floppy-o"></i></button>
                        <button type="button" class="m-btn btn btn-secondary"><i class="la la-header"></i></button>
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dropdown
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="#">Dropdown link</a>
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

@include('layouts.magicshift.createShift')
@include('layouts.magicshift.modifyShift')

@endsection

@section('pageJS')
<script>
var currentEvent = {};
var currentDate = moment();
var currentLocation = {{ $defaultLocation }};
const csrf_token = '{{csrf_token()}}';
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






$(document).ready(function() {






$('.selectpicker').selectpicker();
$('#location').on('changed.bs.select',function(e){
    currentLocation = $('#location').val();
    window.location.replace('{{ url("/scheduler") }}/'+currentLocation);
});




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

function getRoleList(){
    $.get(
        '/role/get',
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
                console.log(data);
                newShift.clear();

                $('#createShiftDialog').dialog('close');
                $('#calendar').fullCalendar('refetchEvents');

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
                console.log(data);
                shift.clear();     
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

var options = {
    dialogClass:'no-close',
    modal:true,
    autoOpen:false,
    position: { my: "center", at: "center", of: window },
    resizable: false,
    width:500,
    height:400,
    title: 'Role',
    buttons: [
        {
            text: 'Cancel',
            click: function(){
                $(this).dialog('close');
            }
        },
        {
            text: 'Save & Close',
            click: function(){
                  ///console.log('start '+ start.format('YYYY-MM-DD HH:mm') + ' ' + 'end: '+end.format('YYYY-MM-DD HH:mm'));
                const shift = parseShift();
                // console.log(shift.start.format('YYYY-MM-DD HH:mm'));
                 currentShift.start = shift.start.format('YYYY-MM-DD HH:mm');
                 currentShift.end = shift.end.format('YYYY-MM-DD HH:mm');
                 currentShift.note = $('#shiftNote').val();
                 console.log(currentShift);
                 updateShift(currentShift);
                $(this).dialog('close');
                $('#calendar').fullCalendar('refetchEvents');

            }
        },

    ],
    
};

var newShiftDialogOptions = {
    dialogClass:'no-close alert',
    'position': { my: "center", at: "center", of: window },
    modal:false,
    autoOpen:false,
    title:'New Shift',
    resizable: false,
    width:400,
    height:300,
    closeOnEscape:true,
   
    
};
$( "#modifyShiftDialog" ).dialog(options);
$( "#createShiftDialog" ).dialog(newShiftDialogOptions);




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
                '/employee/get',
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
            
            labelTds.eq(0).find('.fc-cell-content')
        .append(
          '<small class="float-right"> <i class="fa fa-clock-o fa-sm"></i>&nbsp;<span>88</span></small>'
        );
        },




        loading: function(isLoading,view){
            if(isLoading)
            {
                $('#status_bar').html('<div class="alert alert-info" role="alert">Loading..</div>');
            }
            else
            {
                $('#status_bar').html('');
            }
            
        },
        
        eventDataTransform: function(eventData){
            eventData.title = eventData.role.c_name;
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
      
        },
        eventClick: function(event,element){
            currentEvent = event;
            currentShift.id = event.id;
            currentShift.employee = event.resourceId;
            currentShift.role = event.role_id;

            var defaultStartDate = event.start;
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
            $('#modifyShiftDialog').dialog('option','title',event.title);
            $('#modifyShiftDialog').dialog('open');

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
            $('#createShiftDialog').dialog('option','title','New Shift for ' + resource.cName);
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
            lang: {
                text:'Language',
                click: function(){
                    $("#calendar").fullCalendar('locale','en');
                }
            }
        },

       
        header: {
            left:   'title  ',
            center: 'timelineDay,timelineWorkWeek,month,listWeek prev,today,next',
            right:  'lang',
        },
       

    };
    let cal = $('#calendar').fullCalendar(fullCalOptions);

    //cal.fullCalendar('gotoDate','2018-01-01');


});


</script>
@endsection