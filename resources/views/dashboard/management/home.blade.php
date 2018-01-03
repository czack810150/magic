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

                    <div class="m-widget4__item" onclick="employeeTrace('{{ $e->id }}')">
                        <div class="m-widget4__img m-widget4__img--pic">
                            @if($e->employee_profile)
                            <img src="/img/{{ $e->employee_profile->img }}" alt="employee avatar">
                            @else
                            <img src="/img/system/avatar.png" alt="employee avatar">
                            @endif
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



<!-- Modal -->
<div class="modal fade" id="traceModal" tabindex="-1" role="dialog" aria-labelledby="traceModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
      
        <!--begin::Portlet-->
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon m--hide">
                        <i class="la la-gear"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            新员工追踪   
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <form class="m-form m-form--fit m-form--label-align-right">
                <div class="m-portlet__body">
                  
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-6 col-form-label">员工</label>
                         <div class="col-6">
                            <span class="form-control"   id="employeeName"></span>
                        </div>

                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-6 col-form-label">卡号</label>
                         <div class="col-6">
                            <span class="form-control"   id="employeeNumber"></span>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-search-input" class="col-6 col-form-label">面试通过日期</label>
                        <div class="col-6">
                            <span class="form-control" id="interviewDate"></span>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-search-input" class="col-6 col-form-label">门店报到日期</label>
                        <div class="col-6">
                            <input class="form-control m-input" type="text" value="" id="enlistDate">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-search-input" class="col-6 col-form-label">培训结束日期</label>
                        <div class="col-6">
                            <input class="form-control m-input" type="text" value="" id="finishTrainingDate">
                        </div>
                    </div>
                  
                   
                   
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions">
                        <div class="row">
                            <div class="col-2">
                            </div>
                            <div class="col-10">
                                <button type="button" class="btn btn-success" id="submitBtn" value="">提交</button>
                                <button type="reset" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!--end::Portlet-->


    
    </div>
  </div>
</div>

@endsection

@section('pageJS')
<script>
    function employeeTrace(employee){
       
        $.post(
            '/hr/employee/trace',
            {
                _token:'{{csrf_token()}}',
                employee: employee
            },
            function(data,status){
                if( status  == 'success' ){
                    $('#employeeName').html(data.cName);
                    $('#employeeNumber').html(data.employeeNumber);
                    $('#interviewDate').html(data.employee_trace.interview);
                    $('#enlistDate').val(data.employee_trace.enlist);
                    $('#finishTrainingDate').val(data.employee_trace.pass_training);
                    $('#submitBtn').val(data.id);
                    $('#traceModal').modal();

                    $('#enlistDate').datepicker({
                        format: 'yyyy-mm-dd',
                        defaultViewDate: data.employee_trace.enlist,
                    });
                    // $('#enlistDate').datepicker().on('changeDate',function(e){
                    //     validateEnlistDate(e,data.employee_trace.enlist);
                    // });

                    $('#finishTrainingDate').datepicker({
                        format: 'yyyy-mm-dd',
                        defaultViewDate: data.employee_trace.pass_training,
                    });
                }
            },
            'json'
            );
    }

// function validateEnlistDate(e,enlistDate){
//     var newDate = moment(e.date.getTime());
//     if( enlistDate != null){
        
//         alert('validation ' + newDate.format('YYYY-MM-DD') + ' setDate '+ enlistDate);
//     } else {
//         alert('validation ' + newDate.format('YYYY-MM-DD'));
//     }

    
// }

 
var submitBtn = document.getElementById('submitBtn');
submitBtn.addEventListener('click',function(e){
    submitTrace();
},false);

function submitTrace(){
    $.post(
        '/hr/employee/trace/update',
        {
            _token:'{{csrf_token()}}',
            employee: $('#submitBtn').val(),
            enlist: $('#enlistDate').val(),
            pass_training: $('#finishTrainingDate').val()

        },
        function(data,status){
            if( status == 'success'){
                alert(data);
            }
        }

        );
}

</script>
@endsection
