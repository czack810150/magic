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




@endsection

@section('pageJS')
<script>


$(document).ready(function() {







    // page is now ready, initialize the calendar...

    let cal = $('#calendar').fullCalendar({

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

    			
    			//callback(events);
    		
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
    	eventClick: function(event,element){
    		event.title = 'Clicked!';
    		$("#calendar").fullCalendar('updateEvent',event);

    	},
    	eventDataTransform: function(eventData){
    		eventData.title = eventData.role.c_name;
    		return eventData;
    	},
    	// events: [
    	// {
    	// 	id: 111,
    	// 	title: 'event title',
    	// 	allDay: false,
    	// 	start: '2018-02-14 10:00',
    	// 	end: '2018-02-14 13:00',
    	// 	editable: true,
    	// 	startEditable: true,
    	// 	durationEditable: true,
    	// 	description:'abc',

    	// },
    	// {
    	// 	id: 1112,
    	// 	title: 'event title',
    	// 	allDay: false,
    	// 	start: '2018-02-15 11:00',
    	// 	end: '2018-02-15 14:00',
    	// 	editable: true,
    	// 	startEditable: true,
    	// 	durationEditable: true,
    	// 	description:'cde',

    	// },
    	// ],
    	// eventRender: function(event,element){
    	// 	console.log(event.description);
    	// },
    	
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

    
       

        dayClick: function(date,jsEvent,view) {
        	alert('a days has been clicked '+ date.format());
        },
		defaultView: 'agendaWeek',
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
   			center: 'agendaDay,agendaWeek,month,listWeek prev,today,next',
   			right:  'lang',
        },
       

    });

    //cal.fullCalendar('gotoDate','2018-01-01');


});

</script>
@endsection