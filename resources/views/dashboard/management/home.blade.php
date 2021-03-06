@extends('layouts.master')
@section('content')
<ul class="nav nav-tabs m-tabs-line m-tabs-line--2x m-tabs-line--success" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#sales_tab" role="tab">SALES</a>
                    </li>
                   
            
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#hr_tab" role="tab">员工</a>
                    </li>
                </ul>                        
                <div class="tab-content">
                    <div class="tab-pane active" id="sales_tab" role="tabpanel">
<section id="root">
<div class="m-portlet ">
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
                        <select class="custom-select" v-model="monthlySalesLocation" @change="monthlyLocationSelected">
                            <option v-for="location in locations" v-bind:value="location.id" v-text="location.name"></option>
                        </select>
                            </li>
                           
                            
                        </ul>
                  
                </div>          
            
            </div>
<div class="m-portlet__body  m-portlet__body--no-padding">
<div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="col-md-12 col-lg-6 col-xl-3">
                <!--begin::Total Profit-->
                <div class="m-widget24">                     
                    <div class="m-widget24__item">
                        <h4 class="m-widget24__title">
                            Monthly Sales
                        </h4><br>
                        <span class="m-widget24__desc">
                            本月销售额度
                        </span>
                        <span class="m-widget24__stats m--font-success">
                            $ @{{monthlySales}}
                        </span>     
                        <div class="m--space-10"></div>
                        <div class="progress m-progress--sm">
                            <div class="progress-bar m--bg-success" role="progressbar" style="width: {{ round($data['monthlySales']/$data['preMonthlySales']*100,2) }}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="m-widget24__change">
                            对比上月
                        </span>
                        <span class="m-widget24__number">
                            @{{ monthlyCompare }}%
                        </span>
                    </div>                    
                </div>
                <!--end::Total Profit-->
            </div>
</div>
</div>
</div>


  <!--Begin::Section--> 
<div class="m-portlet">
    <div class="m-portlet__body  m-portlet__body--no-padding">
        <div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="col-xl-4">
                <!--begin:: Widgets/Daily Sales-->
<div class="m-widget14">
    <div class="m-widget14__header m--margin-bottom-30">
        <h3 class="m-widget14__title">
            Daily Sales              
        </h3>
        <span class="m-widget14__desc">
        Check out each collumn for more details
        </span>
    </div>
    <div class="m-widget14__chart" style="height:120px;">
        <canvas  id="two_week_daily_sales"></canvas>
    </div>
</div>
<!--end:: Widgets/Daily Sales-->            
</div>
            <div class="col-xl-4">
                <!--begin:: Widgets/Profit Share-->
<div class="m-widget14">
    <div class="m-widget14__header">
        <h3 class="m-widget14__title">
            Sales Share            
        </h3>
        <span class="m-widget14__desc">
        Sales by categories
        </span>
    </div>
    <div class="row  align-items-center">
        <div class="col">
            <div class="m-widget14__chart" style="height: 120px">
                <canvas id="sales_share"></canvas>
            </div>
        </div>
        <div class="col">
            <div class="m-widget14__legends">
                <m-widget14__legend v-for="legend in mWidget14Legends" v-bind:key="legend.id" :color="legend.color" :legend="legend.legend"></m-widget14__legend>
              
            </div>
        </div>
    </div>
</div>
<!--end:: Widgets/Profit Share-->           </div>
            <div class="col-xl-4">
                <!--begin:: Widgets/Revenue Change-->
<div class="m-widget14">
    <div class="m-widget14__header">
        <h3 class="m-widget14__title">
            Revenue Change            
        </h3>
        <span class="m-widget14__desc">
            Revenue change breakdown by cities
        </span>
    </div>
    <div class="row  align-items-center">
        <div class="col">
            <div id="m_chart_revenue_change" class="m-widget14__chart1" style="height: 180px">
            </div>
        </div>  
        <div class="col">
            <div class="m-widget14__legends">
                
                <div class="m-widget14__legend">
                    <span class="m-widget14__legend-bullet m--bg-accent"></span>
                    <span class="m-widget14__legend-text">+10% New York</span>
                </div>
                <div class="m-widget14__legend">
                    <span class="m-widget14__legend-bullet m--bg-warning"></span>
                    <span class="m-widget14__legend-text">-7% London</span>
                </div>
                <div class="m-widget14__legend">
                    <span class="m-widget14__legend-bullet m--bg-brand"></span>
                    <span class="m-widget14__legend-text">+20% California</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end:: Widgets/Revenue Change-->         </div>
        </div>
    </div>
</div>
<!--End::Section-->



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
                <div id="chartdiv" style="height:500px;">
                </div>

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
</div>
<div class="tab-pane" id="hr_tab" role="tabpanel">
    @foreach($stores as $s)
<div class="row">
    <div class="col-12">
<!--begin::Portlet hr-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-up-arrow-1"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            {{ $s->name }} <small>{{ $s->address }}, {{ $s->city }} {{ $s->phone }} 营业时间:@if($s->open) 自{{ $s->open->format('g:ia') }}至{{ $s->close->format('g:ia') }}@else 24小时 @endif 店长: <a href="{{ route('employee.profile',['id'=>$s->manager->id]) }}">{{ $s->manager->name }}</a></small>
                        </h3>
                    </div>          
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <h5>新员工<small>(点击更改)</small></h5>
                        <table class="table table-bordered table-hover m-table ">
                            <thead>
                                <tr>
                                    <th>员工</th>
                                    <th>追踪</th>  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($s->employee as $e)
                                    @if($e->employee_trace && $e->employee_trace->pass_interview
                    && Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($e->employee_trace->interview))<= 30 ) 
                                    <tr onclick="employeeTrace('{{ $e->id }}')">
                                        <td><a href="{{ route('employee.profile',['id'=>$e->id]) }}">{{ $e->name }} {{ $e->employee_profile?$e->employee_profile->alias:'' }}</a></td>
                                        <td>
                                            @if($e->employee_trace->pass_interview)
                         
                            <span class="m--font-accent">面试通过</span>
                            <span class="m-widget4__sub">{{ Carbon\Carbon::createFromFormat('Y-m-d',$e->employee_trace->interview)->toDateString() }}</span>
                            @if($e->employee_trace->enlist)
                            <br>
                            <span class="m--font-info">门店报到</span>
                        
                            <span class="m-widget4__sub">{{ Carbon\Carbon::createFromFormat('Y-m-d',$e->employee_trace->enlist)->toDateString() }}</span>
                            <br>
                                @if($e->employee_trace->pass_training)
                             
                                <span class="m--font-primary">培训结束</span>
                           
                                 <span class="m-widget4__sub">{{ Carbon\Carbon::createFromFormat('Y-m-d',$e->employee_trace->pass_training)->toDateString() }}</span>
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
                           
                            <span class="m--font-warning">等待报到</span>
                            @endif
                            @endif
                                         </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <h5>试用期完成</h5>
                        <table class="table table-bordered table-hover m-table ">
                            <thead>
                                <tr>
                                    <th>员工</th>
                                    <th>工时</th>
                                    <th>入职</th>  
                                </tr>
                            </thead>
                            <tbody>     
                            @foreach($s->employee->where('job_group','trial')->where('status','active') as $e)
                                @if($e->effectiveHours >= 180)
                                    <tr>
                                        <td><a href="{{ route('employee.profile',['id'=>$e->id]) }}">{{ $e->name }}</a></td>
                                        <td>{{ round($e->effectiveHours,1) }}</td>
                                        <td>{{ $e->hired->toDateString() }}</td>
                                    </tr>
                                @endif
                            @endforeach               
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <h5>达到考核标准员工</h5>
                        <table class="table table-bordered table-hover m-table ">
                            <thead>
                                <tr>
                                    <th>员工</th>
                                    <th>工时</th>
                                    <th>入职</th>  
                                </tr>
                            </thead>
                            <tbody>     
                            @foreach($s->employee as $e)
                                @if($e->reviewable()['result'])
                                    <tr>
                                        <td><a href="{{ route('employee.profile',['id'=>$e->id]) }}">{{ $e->name }}</a></td>
                                        <td>{{ round($e->effectiveHours,1) }}</td>
                                        <td>{{ $e->hired->toDateString() }}</td>
                                    </tr>
                                @endif
                            @endforeach               
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>  
<!--end::Portlet hr-->
</div>
</div>
    @endforeach
</div>
                    
</div>






   








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

Vue.component('m-widget14__legend',{
    props:['legend','color'],
    template:`
    <div class="m-widget14__legend">
        <span class="m-widget14__legend-bullet" :class="color"></span>
        <span class="m-widget14__legend-text" v-text="legend"></span>
    </div>
    `
})

var app = new Vue({
    el: '#root',
    data:{
        token:'{{csrf_token()}}',
        monthlySalesLocation:-1,
        selectedLocation : -1,
        selectedCategory:999,
        selectedItem:null,
        selectedDate:'',
        chart:null,
        twoWeekChart:null,
        
        monthlySales:'{{number_format($data['monthlySales'],0,'.',',')}}',
        preMonthlySales:'{{$data['preMonthlySales']}}',
        monthlyCompare: '{{ round($data['monthlySales']/$data['preMonthlySales']*100,2) }}',
        sales:[
      
    ],
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
            id:-2,
            'name':'Choose Location'
        },
        {
            id:-1,
            'name':'All Locations'
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
        ],
        labels:[],
        dailySales:[],
        'mWidget14Legends':[
        {
            id:1,
            color:'m--bg-accent',
            legend:'50% 拉面',
            value: 50,
            className:"custom",
            meta:{
                color:'m--bg-accent'
            }
        },
        {
            id:2,
            color:'m--bg-danger',
            legend:'25% 烧烤',
            value: 25,
            className:"custom",
            meta:{
                color:'m--bg-danger'
            }

        },
        {
            id:3,
            color:'m--bg-primary',
            legend:'15% 凉菜',
            value: 15,
            className:"custom",
            meta:{
                color:'m--bg-primary'
            }
        },
        {
            id:4,
            color:'m--bg-warning',
            legend:'10% 饮料',
            value: 10,
            className:"custom",
            meta:{
                color:'m--bg-warning'
            }
        },
        ],
        salesShareChart:null,
        salesShareData:{
             datasets: [{
                data: [50,25,15,10],
                backgroundColor:[mUtil.getColor('accent'),mUtil.getColor('danger'),mUtil.getColor('primary'),mUtil.getColor('warning')],
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
        'Red',
        'Yellow',
        'Blue'
    ]
    },
        
    },
    methods:{
        monthlyLocationSelected(){
            this.updateMonthlyData();
            this.getTwoWeekSalesData();
        },
        locationSelected(){
            if(this.selectedItem != null && this.selectedDate != -2){
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
                app.chart.dataProvider = app.sales;
                app.chart.validateData();
            })
        },
        getTwoWeekSalesData(){
            axios.post('/sales/two_week',{
                _token:this.token,
                
                date:this.selectedDate,
                location:this.monthlySalesLocation,
            }).then(function(response){
               app.labels = response.data.labels;
               app.dailySales = response.data.totals;
               app.twoWeekChartUpdateData();
               
            });
        },
        twoWeekChartUpdateData(){
            this.twoWeekChart.data.labels = this.labels;
            this.twoWeekChart.data.datasets[0].data = app.dailySales;
            this.twoWeekChart.update();
        },
        updateMonthlyData(){
             axios.post('/sales/monthly',{
                _token:this.token,
                location:this.monthlySalesLocation
            }).then(function(response){
               
               
              app.monthlySales = response.data.thisMonth;
              app.preMonthlySales = response.data.lastMonth;
              app.monthlyCompare = response.data.monthCompare;
               
            });
        },
    },
    computed: {
        
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
    
        //chart_single_item_sales
this.chart = AmCharts.makeChart("chartdiv", {
    "type": "serial",
    "theme": "light",
    "marginRight": 40,
    "marginLeft": 40,
    "autoMarginOffset": 20,
    "mouseWheelZoomEnabled":true,
    "dataDateFormat": "YYYY-MM-DD HH:NN:SS",
    "valueAxes": [{
        "id": "v1",
        "axisAlpha": 0,
        "position": "left",
        "ignoreAxisWidth":true,
        "precision":0,
    }],
    "balloon": {
        "borderThickness": 1,
        "shadowAlpha": 0
    },
    "graphs": [{
        "id": "g1",
        "balloon":{
          "drop":true,
          "adjustBorderColor":false,
          "color":"#ffffff"
        },
        "bullet": "round",
        "bulletBorderAlpha": 1,
        "bulletColor": "#FFFFFF",
        "bulletSize": 5,
        "hideBulletsCount": 50,
        "lineThickness": 2,
        "title": "red line",
        "useLineColorForBulletBorder": true,
        "valueField": "qty",
        "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
    }],
    "chartScrollbar": {
        "graph": "g1",
        "oppositeAxis":false,
        "offset":30,
        "scrollbarHeight": 80,
        "backgroundAlpha": 0,
        "selectedBackgroundAlpha": 0.1,
        "selectedBackgroundColor": "#888888",
        "graphFillAlpha": 0,
        "graphLineAlpha": 0.5,
        "selectedGraphFillAlpha": 0,
        "selectedGraphLineAlpha": 1,
        "autoGridCount":true,
        "color":"#AAAAAA"
    },
    "chartCursor": {
        "pan": true,
        "valueLineEnabled": true,
        "valueLineBalloonEnabled": true,
        "cursorAlpha":1,
        "cursorColor":"#258cbb",
        "limitToGraph":"g1",
        "valueLineAlpha":0.2,
        "valueZoomable":true
    },
    "valueScrollbar":{
      "oppositeAxis":false,
      "offset":50,
      "scrollbarHeight":10
    },
    "categoryField": "from",
    "categoryAxis": {
        "parseDates": false,
        "dashLength": 1,
        "minorGridEnabled": true,
        "labelRotation":45,

    },
    "export": {
        "enabled": true
    },
    "dataProvider": this.sales,
    
}); // end chart_single_item_sales

// begin two week daily sales



var two_week = document.getElementById('two_week_daily_sales').getContext('2d');
this.twoWeekChart = new Chart(two_week,{
    type:'bar',
    data: {
        labels: this.labels,
        datasets: [
        {
           
            backgroundColor: '#4ac0a2',
            data: this.dailySales,
            borderWidth: 1
        }, 
        ],
    },
    options: {
        title:{
            display:!1,
        },
        tooltips:{
            intersect: false,
            mode:'nearest',
            xPadding:10,
            yPadding:10,
            caretPadding:10,
        },
        legend:{
            display:0,
        },
        maintainAspectRatio:false,
        barRadius:4,
        responsive:0,
        scales: {
            xAxes:[{
                display:false,
                gridLines:false,
                stacked:true,
            }],
            yAxes: [{
                display:false,
                stacked:true,
                gridLines:false
            }]
        },
        layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
    }

});

this.getTwoWeekSalesData();
// end two seek daily sales

// begin sales share chart

var salesShare = document.getElementById('sales_share').getContext('2d');
this.salesShareChart = new Chart(salesShare,{
    type:'doughnut',
    data:this.salesShareData,
    options:{
        cutoutPercentage:70,
        rotation:15,
        legend:{
            display:false,
        }
    },
});
// end sales share chart

    } // end of mounted





}); //end of vue 

</script>
@endsection
