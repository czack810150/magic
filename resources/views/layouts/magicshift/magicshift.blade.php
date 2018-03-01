<!DOCTYPE html>
<html lang="en">
  @include('layouts.head')

  <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
 <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
     
    @include('layouts.header')
  

    <!-- begin::Body -->
      <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
    


<div class="m-grid__item m-grid__item--fluid m-wrapper">


<div class="m-content">
   @yield('content')
  </div>



</div>
</div>
      <!-- end:: Body -->
 
 <!-- begin::Scroll Top -->
    <div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
      <i class="la la-arrow-up"></i>
    </div>
    <!-- end::Scroll Top -->


   </div>
  </div>
  <!-- end:: Page -->

      <!--begin::Base Scripts -->
    <script src="{{asset('/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/demo/default/custom/components/forms/widgets/bootstrap-datepicker.js')}}"></script>

    <script src="{{asset('/js/moment.min.js')}}"></script>

    
    <script src="{{asset('js/fullcalendar.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/scheduler.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.timepicker.min.js')}}" type="text/javascript"></script>
    <!--end::Page Vendors -->  
        <!--begin::Page Snippets -->
    <script src="{{asset('/assets/app/js/dashboard.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/ms.js')}}"></script>

 @yield('pageJS')


</body>
</html>