@extends('layouts.magicshift.print')
@section('content')
<div id="printCal" style="width:900px;"></div>
@endsection

@section('pageJS')
<script>
const csrf_token = '{{csrf_token()}}';
const currentLocation = '{{$data["printLocation"]}}';

var printOptions = {
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
                color:'#ffffff',
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
        filterResourcesWithEvents: true,
        refetchResourcesOnNavigate: true,
        resources: function(callback,start,end,timezone){
            $.post(
                '/sr/get',
                {
                    _token: '{{csrf_token()}}',
                    location:currentLocation,
                    start: '{{ $data["printStart"] }}',
                    end: '{{ $data["printEnd"] }}',
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

             // check if employee is from another location
             if(resourceObj.location_id != currentLocation){
                labelTds.eq(0).find('.fc-cell-text').append(' (借)');
             }
             
           
        },


        
        eventDataTransform: function(eventData){
            if(eventData.role){
                 eventData.title = eventData.role.c_name;
             } else {
                eventData.title = 'unassigned';
             }
           
            if(eventData.duty){
                eventData.color = eventData.duty.color;
            } else {
                eventData.color = '#ffffff';
            }
            
            return eventData;
        },

        eventRender: function(event,element){
           // const duration = (event.end.format('X') - event.start.format('X'))/3600;
           
           
            if(event.end.isAfter(event.start,'day')){
                 element.find(".fc-time").append(' <i class="fa  fa-moon-o"></i>&nbsp;');
            }


           // element.find(".fc-time").append(' <span class="float-right badge badge-secondary">'+ Number(duration.toFixed(2)) + '</span>');
            if(event.duty){
                element.find(".fc-time").append('<br><strong>' + event.duty.cName + '</strong>');
            } else {
                element.find(".fc-time").append('<br>');
            }

        },
      
    	defaultDate: '{{ $data["printStart"] }}', 
        height:'auto',
        contentHeight:'auto',
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
        editable:false,
        droppable:false,
        displayEventEnd: true,
        timeFormat:'h(:mm)t',
        nextDayThreshold:'12:30:00',

      
        showNonCurrentDates:true,
       
        now:'{{Carbon\Carbon::now()->toIso8601String() }}',
        allDaySlot:true,
        noEventsMessage:'No scheduled shifts',
        listDayFormat:true,
        nowIndicator:true,

        // scheduler settings
        resourceAreaWidth:'10%',
        resourceLabelText:'Employees',

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
                //start:'2018-01-01',
            }
        },

        defaultView: 'timelineWorkWeek',
        

        header: {
            left:   'title  ',
        },
       
            

    };



let cal = $('#printCal').fullCalendar(printOptions);
</script>
@endsection