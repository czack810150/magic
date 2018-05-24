@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
<div class="m-portlet m-portlet--full-height" id="root">
						
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-clipboard"></i>
												</span>
												<h3 class="m-portlet__head-text">
													<span v-text="exam.name"></span>
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
										
												<li class="m-portlet__nav-item">
												<a href="/exam/learn/" class="btn btn-metal">返回</a>
														
												
												</li>
								
											</ul>
										</div>
									</div>
<div class="m-portlet__body">

<ul>
@foreach($questions as $q)
<li>{{$q}}</li>
@endforeach
</ul>

</div>
</div>
<!--end::Portlet-->
@endsection
@section('pageJS')
<script>

var vm = new Vue({
    el: '#root',
    data: {
        exam: @json($exam),
        questions: @json($questions)
    },
    mounted(){
        
    }
})

</script>
@endsection