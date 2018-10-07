<head>
    <meta charset="utf-8">
 
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

    <title>MagicShift Print</title>
    <link href="{{asset('/assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/assets/demo/default/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />
   
        <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet"/>
        <!-- <link href="{{ asset('css/fullcalendar.print.css') }}" rel="stylesheet" media="print"/> -->
        <link href="{{ asset('css/scheduler.min.css') }}" rel="stylesheet"/>
        



  
  
  </head>