@extends('layouts.magicshift.magicshift')
@section('content')
{{Carbon\Carbon::now()->toIso8601String() }}
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
    	locale:'en',
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

    
       

        // dayClick: function() {
        // 	alert('a days has been clicked '+ $("#calendar").fullCalendar('getView').start.format('YYYY-MM-DD'));
        // },
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