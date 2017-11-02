<!DOCTYPE html>
<html lang="en">
  @include('layouts.head')

  <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
 <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
    @include('layouts.header')

    <!-- begin::Body -->
      <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
    
        
@include('layouts.aside')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
@include('layouts.subheader')

<div class="m-content">
   @yield('content')
  </div>


 <!-- begin::Scroll Top -->
    <div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
      <i class="la la-arrow-up"></i>
    </div>
    <!-- end::Scroll Top -->

  @include('layouts.quickSideBar')


</div>
</div>
</div>
      <!-- end:: Body -->
    @include('layouts.footer')
  </div>
  <!-- end:: Page -->

@include('layouts.sticky')


      <!--begin::Base Scripts -->
    <script src="{{asset('/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>
    <!--end::Base Scripts -->   
        <!--begin::Page Vendors -->
    <script src="{{asset('/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
    <!--end::Page Vendors -->  
        <!--begin::Page Snippets -->
    <script src="{{asset('/assets/app/js/dashboard.js')}}" type="text/javascript"></script>
    <!--end::Page Snippets -->




 @yield('pageJS')

<script>

  // get current URL path and assign 'active' class
  var pathname = window.location.pathname;
  $('li.nav-item > a[href="'+pathname+'"]').parent().addClass('active');

</script>

</body>
</html>