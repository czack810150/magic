<!DOCTYPE html>
<html lang="en">
  @include('layouts.magicshift.head')
<body>

 


   @yield('content')

 <script src="{{asset('/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>

    <script src="{{asset('/js/moment.min.js')}}"></script>
    <script src="{{asset('js/fullcalendar.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/scheduler.min.js')}}" type="text/javascript"></script>


 @yield('pageJS')


</body>
</html>