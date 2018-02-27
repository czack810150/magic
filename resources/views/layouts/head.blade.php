<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <!--begin::Web font -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <script>
          WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>
        <!--end::Web font -->

    <title>MagicShift</title>
     <!--begin::Base Styles -->  
        <!--begin::Page Vendors -->
        <link href="{{asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('css/jquery-ui.min.css')}}" rel="stylesheet"/>
        <link href="{{asset('css/jquery.timepicker.min.css')}}" rel="stylesheet"/>
        <link href="{{asset('css/scheduler.min.css')}}" rel="stylesheet"/>
        <link href="{{asset('css/magicshift.css')}}" rel="stylesheet"/>
        <!--end::Page Vendors -->
        <link href="{{asset('/assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/assets/demo/default/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <!--end::Base Styles -->
        <link rel="shortcut icon" href="{{asset('/assets/demo/default/media/img/logo/favicon.ico')}}" />

  
        <!-- Custom styles for this template -->
 
    <link href="{{asset('css/timeclock.css')}}" rel="stylesheet">
    <link href="{{asset('css/hr.css')}}" rel="stylesheet">
    <script src="{{URL::asset('js/vue.js')}}"></script>
  </head>