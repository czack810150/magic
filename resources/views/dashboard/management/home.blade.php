@extends('layouts.master')

@section('content')
<section id="root">
<div class="m-portlet ">
<div class="m-portlet__body  m-portlet__body--no-padding">
<div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="col-md-12 col-lg-6 col-xl-3">
                <!--begin::Total Profit-->
                <div class="m-widget24">                     
                    <div class="m-widget24__item">
                        <h4 class="m-widget24__title">
                            MagicBeefs
                        </h4><br>
                        <span class="m-widget24__desc">
                            传统牛肉面
                        </span>
                        <span class="m-widget24__stats m--font-success">
                            {{$data['magicBeefs']}}碗
                        </span>     
                        <div class="m--space-10"></div>
                        <div class="progress m-progress--sm">
                            <div class="progress-bar m--bg-success" role="progressbar" style="width: 78%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="m-widget24__change">
                            指标完成度
                        </span>
                        <span class="m-widget24__number">
                            78%
                        </span>
                    </div>                    
                </div>
                <!--end::Total Profit-->
            </div>
</div>
</div>
</div>


<div class="row">
   
    <div class="col-12">
<!--begin::Portlet Promotions-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-up-arrow-1"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            Sales <small>销售情况</small>
                        </h3>
                    </div>
                </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                        <select class="custom-select" v-model="selectedLocation" @change="locationSelected">
                            <option v-for="location in locations" v-bind:value="location.id" v-text="location.name"></option>
                        </select>
                            </li>
                            <li class="m-portlet__nav-item">
                                <select class="custom-select" v-model="selectedCategory" @change="categorySelected">
                                    <option v-for="category in categories" v-bind:value="category.id" v-text="category.name"></option>
                                </select>
                            </li>
                             <li class="m-portlet__nav-item">
                                <select class="custom-select" v-model="selectedItem" @change="itemSelected">
                                    <option v-for="item in items" v-bind:value="item.id" v-text="item.name"></option>
                                </select>
                            </li>
                            <li class="m-portlet__nav-item">
                                <input type="text" name="datepicker" id="datepicker" class="form-control m-input m-input--solid" placeholder="Pick a date">
                            </li>
                        </ul>
                  
                </div>          
            
            </div>
            <div class="m-portlet__body">
              <table class="table">
                <thead>
                    <tr><th>from</th><th>to</th><th>qty sold</th></tr>
                </thead>
                <tbody>
                <tr v-for="sale in sales">
                    <td>@{{sale.from}}</td>
                    <td>@{{sale.to}}</td>
                    <td>@{{sale.qty}}</td>
                </tr>
                </tbody>
            </table>
            </div>
    </div>
</div>



</section>


<div class="row">
    @if(count($promotions))
    <div class="col-8">
<!--begin::Portlet Promotions-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-up-arrow-1"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            Recent Promotions <small>员工晋级</small>
                        </h3>
                    </div>          
                </div>
            </div>
            <div class="m-portlet__body">
<table class="table  m-table">
                            <thead>
                                <tr>
                                    <th>Location</th>
                                    <th>Staff</th>
                                    <th>Current Position</th>
                                    <th>New Position</th>
                                    <th>Status</th>
                                    <th>Date applied</th>
                                    <th>Action Taken</th>
                                    <th>Action By</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($promotions as $p)
                                @if(Carbon\Carbon::now()->diffInDays($p->created_at)<=7)
                                <tr>
                                    <td>{{ $p->newLocation->name }}</td>
                                     <td>{{ $p->employee->cName }}</td>
                                    <td>{{ $p->oldJob->rank }}</td>
                                     <td>{{ $p->newJob->rank }}</td>
                                    
                                    
                                    @switch($p->status)
                                    @case('pending')
                                    <td><span class="m-badge m-badge--primary m-badge--wide">{{ $p->status }}</span></td>
                                    @break
                                    @case('approved')
                                    <td><span class="m-badge m-badge--success m-badge--wide">{{ $p->status }}</span></td>
                                    @break
                                    @case('rejected')
                                    <td><span class="m-badge m-badge--danger m-badge--wide">{{ $p->status }}</span></td>
                                    @break
                                    @default
                                    <td><span class="m-badge m-badge--secondary m-badge--wide">{{ $p->status }}</span></td>
                                    @endswitch
                                     <td>{{ $p->created_at->toFormattedDateString() }}</td>
                                     <td>{{ $p->updated_at->toFormattedDateString() }}</td>
                                     <td>{{ $p->modifiedBy? $p->modifiedBy->cName:'' }}</td>
                                   
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
</table>
            </div>
        </div>  
<!--end::Portlet Promotions-->
</div>
@endif
</div>
   




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
                    @if($e->employee_trace && $e->employee_trace->pass_interview == true
                    && (Carbon\Carbon::now()->diffInDays(Carbon\Carbon::createFromFormat('Y-m-d',$e->employee_trace->interview))<=30 || is_null($e->employee_trace->pass_training) )  )

                    <div class="m-widget4__item employee-trace" onclick="employeeTrace('{{ $e->id }}')">
                        <div class="m-widget4__img m-widget4__img--pic">
                            @if($e->employee_profile)
                            <img src="/storage/{{ $e->employee_profile->img }}" alt="employee avatar">
                            @else
                            <img src="/storage/employee/avatar.png" alt="employee avatar">
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
                                    @case('pass')
                                        <span class="m--font-success">完成</span>
                                    @break
                                    @case('nopass')
                                        <span class="m--font-danger">不合格</span>
                                    @break
                                    @case('quit')
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
        <!--begin::Portlet-->
        <div class="m-portlet m-portlet--tab modal-content">
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

                     <div class="form-group m-form__group row">
                        <label for="example-search-input" class="col-6 col-form-label">培训结果</label>
                        <div class="col-6" id="training">
{{ Form::select('trainingResult',['before'=>'未开始','ip'=>'培训中' ,'pass'=>'合格','nopass'=>'不合格','quit'=>'本人退出'],null,['class'=>'form-control','id'=>'trainingResult','placeholder'=>'请选择']) }}
                          
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
                    $('#enlistDate').datepicker().on('changeDate',function(e){
                        validateEnlistDate(e,data.employee_trace.enlist);
                    });

                    $('#finishTrainingDate').datepicker({
                        format: 'yyyy-mm-dd',
                        defaultViewDate: data.employee_trace.pass_training,
                    });
                    $('#trainingResult').val(data.employee_trace.result);
                }
            },
            'json'
            );
    }
 
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
            pass_training: $('#finishTrainingDate').val(),
            result: $('#trainingResult').val(),

        },
        function(data,status){
            if( status == 'success'){
                $('#traceModal').modal('hide');
                clearEmployeeTraceData();
                location.reload(true);
            }
        }

        );
}

function clearEmployeeTraceData(){
            $('#submitBtn').val('');
            $('#enlistDate').val('');
            $('#finishTrainingDate').val('');
            $('#trainingResult').val('');
}

var app = new Vue({
    el: '#root',
    data:{
        token:'{{csrf_token()}}',
        selectedLocation : 999,
        selectedCategory:999,
        selectedItem:null,
        selectedDate:'',
        sales:[],
        items:[
        @foreach($items as $i)
        { 
            id: {{$i->id}},
            category: '{{$i->itemCategory_id}}',
            name: '{{$i->name}}',
            price: '{{$i->price}}',
        },
        @endforeach
        ],
        locations: [
        {
            id:999,
            'name':'Choose Location'
        },
        @foreach($locations as $location)
        { 
            id: {{$location->id}},
            name: '{{$location->name}}',
        },
        @endforeach
        ],
        categories: [
        {
            id:999,
            name:'Choose Category'
        },
        @foreach($categories as $category)
        { 
            id: {{$category->id}},
            name: '{{$category->cName}}',
        },
        @endforeach
        ]
    },
    methods:{
        locationSelected(){
            if(this.selectedItem != null && this.selectedDate != ''){
                this.getSalesData();
            }
            
        },
        categorySelected(){
            this.getItems();
        },
        itemSelected(){
            this.getSalesData();
        },
        getItems(){
            axios.post('/product/category/get',{
                _token:this.token,
                category:this.selectedCategory
            }).then(function(response){
                app.items = response.data;
            })
        },
        getSalesData(){
            axios.post('/sales/item',{
                _token:this.token,
                item:this.selectedItem,
                date:this.selectedDate,
                location:this.selectedLocation
            }).then(function(response){
               
                app.sales = response.data;
            })
        }
    },
    mounted(){
       
        $('#datepicker').daterangepicker({
            singleDatePicker:true,
            minYear:2018,
            maxYear:moment().format('YYYY'),
            startDate: moment().subtract(1,'days').format('YYYY-MM-DD'),
            locale: {
                format:'YYYY-MM-DD'
                    }
        });
$('#datepicker').on('apply.daterangepicker',function(ev,picker){
   
    app.selectedDate = picker.startDate.format('YYYY-MM-DD');
    app.getSalesData();
});
var drp = $('#datepicker').data('daterangepicker');
        this.selectedDate = drp.startDate.format('YYYY-MM-DD');
    }
});

</script>
@endsection
