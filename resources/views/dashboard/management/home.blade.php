@extends('layouts.master')

@section('content')
<!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-user-ok"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            New Employees <small>新员工追踪</small>
                        </h3>
                    </div>          
                </div>
            </div>
            <div class="m-portlet__body">
             
            <div class="row">
              @foreach($locations as $location)
        <div class="col-md-6 col-lg-3">
        <!--begin::Portlet-->
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{ $location->name}} <small>{{ $location->type}}</small>
                        </h3>
                    </div>          
                </div>
            </div>
            <div class="m-portlet__body">   
                <div class="m-widget4 m-widget4--progress">
                @foreach($location->employee as $e)
                    @if($e->employee_trace)

                    <div class="m-widget4__item">
                        <div class="m-widget4__img m-widget4__img--pic">
                            <img src="/assets/app/media/img/users/100_4.jpg">
                        </div>
                        <div class="m-widget4__info">
                            <span class="m-widget4__title">{{ $e->cName }}</span>
                            <br>
                            <span class="m-widget4__sub">{{ $e->employee_profile?$e->employee_profile->alias:'' }}</span>
                        </div>
                        <div class="m-widget4__info">
                        @if($e->employee_trace->pass_interview)
                         
                            <span class="m--font-accent">面试通过</span>
                            <br>
                            <span class="m-widget4__sub">{{ Carbon\Carbon::createFromFormat('Y-m-d',$e->employee_trace->interview)->diffForHumans() }}</span>
                            @if($e->employee_trace->enlist)
                            <br>
                            <span class="m--font-info">门店报到</span>
                            <br>
                            <span class="m-widget4__sub">{{ Carbon\Carbon::createFromFormat('Y-m-d',$e->employee_trace->enlist)->diffForHumans() }}</span>

                                @if($e->employee_trace->pass_training)
                                <br>
                                <span class="m--font-primary">培训结束</span>
                                <br>
                                 <span class="m-widget4__sub">{{ Carbon\Carbon::createFromFormat('Y-m-d',$e->employee_trace->pass_training)->diffForHumans() }}</span>
                                 <br>
                                 @switch($e->employee_trace->result)
                                    @case('qualified')
                                        <span class="m--font-success">完成</span>
                                    @break
                                    @case('unqualified')
                                        <span class="m--font-danger">不合格</span>
                                    @break
                                    @case('personal')
                                        <span class="m--font-danger">本人退出</span>
                                    @break
                                @endswitch    
                                @endif

                        @else
                            <br>
                            <span class="m--font-warning">等待报到</span>
                        @endif

                        @endif
                       
                        
                        </div>
                    </div>

            
                    @endif
                @endforeach
            </div>

            
            </div>
        </div>  
        <!--end::Portlet-->
        </div>
        @endforeach
        </div>


            </div>
          
        </div>  
        <!--end::Portlet-->
@endsection
