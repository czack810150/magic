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
				
			</div>
			<div class="m-portlet__body">

<div id="calendar"></div>
			</div>
		</div>	
		<!--end::Portlet-->


@include('layouts.magicshift.modifyShift')

@endsection

@section('pageJS')
<script>


$(document).ready(function() {

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
var currentEvent = {};



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
            _token:'{{csrf_token()}}',
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
$( "#shiftDialog" ).dialog(options);




    // page is now ready, initialize the calendar...

    let cal = $('#calendar').fullCalendar({
    	schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
    	events: {
    	
    			type:'post',
    			url: '/shifts/fetchWeek',
    			dataType:'json',
    			data:{
    				_token: '{{csrf_token()}}',
    				location:1,
    				// start:'2018-02-14',
    				// end:'2018-02-14'
    			},
    			success: function(result){
    				console.log(result);
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
    	resources: function(callback){
    		$.post(
    			'/employee/get',
    			{
    				_token: '{{csrf_token()}}',
    				location:1,
    			},
    			function(data,status){
    				if(status == 'success'){
    					callback(data);
    				}
    			},
    			'json'
    		);
    	},
        filterResourcesWithEvents: true,

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
            
            console.log(event);
          

    		// let str = event.employee.job.type + '<br>' + event.start.format('h:mma') + ' - ' + event.end.format('h:mma');
    		// element.html(str);
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
            $('#shiftDialog').dialog('option','title',event.title);
            $('#shiftDialog').dialog('open');

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
    
    	
    	firstDay:1,
    	isRTL:false,
    	weekends:true,
    	hiddenDays:[],
    	columnHeader:true,
    	fixedWeekCount:false,
    	weekNumbers:true,
    	weekNumbersWithinDays:true,
    	navLinks:true,
    	selectable:true,
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

    
       

        dayClick: function(date,jsEvent,view) {
        	alert('a days has been clicked '+ date.format());
        },

        views:{
        	timelineWorkWeek: {
        		buttonText:'Week',
        		type:'timeline',
        		// visibleRange: function(currentDate){
        		// 	console.log(currentDate);
        		// 	return {
        		// 		start: currentDate.clone().day(1),
          //          		end: currentDate.clone().day(8) 
        		// 	};
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
       

    });

    //cal.fullCalendar('gotoDate','2018-01-01');


});


</script>
@endsection