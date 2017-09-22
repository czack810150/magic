<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>Timeclock</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <!-- Custom styles for this template -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{asset('css/timeclock.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" />
  </head>

  <body>

  @yield('content')




  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <!-- Include Date Range Picker -->
<script src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{URL::asset('js/magic.js')}}"></script>
  
<script>
(function(){

  var start = moment().startOf('week').subtract(13,'days');
  var end = moment().startOf('week');

  $('input[name="dateRange"]').daterangepicker({
    autoUpdateInput:false,
    startDate: start,
    endDate: end,
    format:'YYYY-MM-DD',
  });

  $('input[name="dateRange"]').on('apply.daterangepicker',function(ev,picker){
    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    
    sessionStorage.start = picker.startDate.format('YYYY-MM-DD');
    sessionStorage.end = picker.endDate.format('YYYY-MM-DD');
    viewScheduledShift(sessionStorage.start,sessionStorage.end);
  });


  function viewScheduledShift(start,end){
    $.post(
      '/shift/getShift',
      {
        start: start,
        end: end,
        location: $("#locationPicker").val(),
        _token: $('input[name="_token"]').val(),
      },
      function(data,status){
        $("#shiftTable").html(data);
      }
      );
  }

  $("#locationPicker").select2({
    minimumResultsForSearch: Infinity,
  });
  var $eventSelect = $("#locationPicker");
  $eventSelect.on('change',function(e){
    sessionStorage.location = $("#locationPicker").val();
    viewScheduledShift(sessionStorage.start,sessionStorage.end);
  });


})(); 
  
</script>

  </body>
</html>