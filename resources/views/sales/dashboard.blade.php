@extends('layouts.master')
@section('content')


<section id="root">
<div class="m-portlet ">
    <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-up-arrow-1"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            Overview <small>销售情况</small>
                        </h3>
                    </div>
                </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                        	 <li class="m-portlet__nav-item">
                        <select class="custom-select" v-model="selectedYear" @change="yearSelected">
                            <option v-for="year in years" v-bind:value="year" v-text="year"></option>
                        </select>
                            </li>
                            <li class="m-portlet__nav-item">
                        <select class="custom-select" v-model="selectedMonth" @change="monthSelected">
                            <option v-for="month in months" v-bind:value="month" v-text="month.name"></option>
                        </select>
                            </li>
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
            <div class="col-md-12 col-lg-6 col-xl-4">
                <!--begin::Year to date sales-->
                <div class="m-widget24">                     
                    <div class="m-widget24__item">
                        <h4 class="m-widget24__title">
                            Year to Date Sales
                        </h4><br>
                        <span class="m-widget24__desc">
                             @{{selectedYear}}
                        </span>
                        <span class="m-widget24__stats m--font-danger">
                            $ @{{yearToDateSales}}
                        </span>     
                        <div class="m--space-10"></div>
                        <div class="progress m-progress--sm">
                            <div class="progress-bar m--bg-danger" role="progressbar" v-bind:style="{'width': yearlyCompare+'%'}" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="m-widget24__change">
                            Last Year
                        </span>
                        <span class="m-widget24__number">
                            @{{ yearlyCompare }}%
                        </span>
                    </div>                    
                </div>
                <!--end::Total Profit-->
            </div>
            <div class="col-md-12 col-lg-6 col-xl-4">
                <!--begin::Total Profit-->
                <div class="m-widget24">                     
                    <div class="m-widget24__item">
                        <h4 class="m-widget24__title">
                            Monthly Sales
                        </h4><br>
                        <span class="m-widget24__desc">
                            @{{selectedMonth.name}} @{{selectedYear}}
                        </span>
                        <span class="m-widget24__stats m--font-success">
                            $ @{{monthlySales}}
                        </span>     
                        <div class="m--space-10"></div>
                        <div class="progress m-progress--sm">
                            <div class="progress-bar m--bg-success" role="progressbar" v-bind:style="{'width': monthlyCompare+'%'}" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="m-widget24__change">
                            Previous Month
                        </span>
                        <span class="m-widget24__number">
                            @{{ monthlyCompare }}%
                        </span>
                    </div>                    
                </div>
                <!--end::Total Profit-->
            </div>
 <div class="col-md-12 col-lg-6 col-xl-4">
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
        <canvas  id="month_daily_sales"></canvas>
    </div>
</div>
<!--end:: Widgets/Daily Sales-->            
</div>
</div>

<div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="col-md-12 col-lg-6 col-xl-4">
                <ul>
                    <li v-for="category in categorySales">@{{category.item_category.cName}} @{{ category.qty }} @{{ category.amount }}</li>
                </ul>
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
<!--end:: Widgets/Profit Share-->           
</div>

</div>


</div>
</div>



<div class="m-portlet ">
    <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-up-arrow-1"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            Hourly Sales <small>小时销售</small>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                        <select class="custom-select" v-model="selectedYear" @change="yearSelected">
                            <option v-for="year in years" v-bind:value="year" v-text="year"></option>
                        </select>
                            </li>
                            <li class="m-portlet__nav-item">
                        <select class="custom-select" v-model="selectedMonth" @change="monthSelected">
                            <option v-for="month in months" v-bind:value="month" v-text="month.name"></option>
                        </select>
                            </li>
                            <li class="m-portlet__nav-item">
                        <select class="custom-select" v-model="monthlySalesLocation" @change="monthlyLocationSelected">
                            <option v-for="location in locations" v-bind:value="location.id" v-text="location.name"></option>
                        </select>
                            </li>
                             <li class="m-portlet__nav-item">
                        <select class="custom-select" v-model="selectedHourlyType" @change="hourlyTypeSelected">
                            <option v-for="type in hourlyTypes" v-bind:value="type.value" v-text="type.name"></option>
                        </select>
                            </li>
                           
                            
                        </ul>
                  
                </div>          
                        
            
            </div>
<div class="m-portlet__body  m-portlet__body--no-padding">
    <div id="hourlyChartDiv"></div>
</div>
</div>






</section>






@endsection

@section('pageJS')
<script>
var app = new Vue({
    el: '#root',
    data:{
        token:'{{csrf_token()}}',
        monthlySalesLocation:-1,
        selectedLocation : -1,
        selectedCategory:999,
        selectedItem:null,
        selectedDate:'',
        
        monthDailyChart:null,
        
        monthlySales:'{{number_format($data['monthlySales'],0,'.',',')}}',
        preMonthlySales:'{{$data['preMonthlySales']}}',
        monthlyCompare: '{{ round($data['monthlySales']/$data['preMonthlySales']*100,2) }}',
        yearlyCompare: '{{ $data['yearlyCompare'] }}',
        years:[
        	2018,
        ],
        selectedYear:moment().year(),
        months:[
        	{name:'January', value:1},
        	{name:'February', value:2},
        	{name:'March', value:3},
        	{name:'April', value:4},
        	{name:'May', value:5},
        	{name:'June', value:6},
        	{name:'July', value:7},
        	{name:'August', value:8},
        	{name:'September', value:9},
        	{name:'October', value:10},
        	{name:'November', value:11},
        	{name:'December', value:12},
        ],
        selectedMonth:{
        	value:moment().month()+1,
        	name:moment().format('MMMM'),
        	},
        sales:[],
        labels:[],
        dailySales:[],
        hourlySalesAmt:[],
        hourlySalesAmtChart:null,
        hourlyTypes:[
            {name:'Dine-in',value:'TABLE'},
            {name:'Pick up',value:'TAKEOUT'},
            {name:'Delivery',value:'DELIVERY'},
        ],
        selectedHourlyType:'TABLE',
        
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
        
        yearToDateSales:'{{number_format($data['yearSales'],0,'.',',')}}',
        preYearSales: {{ $data['preYearSales']}},

        categorySales:[],
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
        categoryShareQtyChart:null,
        categoryShareQtyData:{
             datasets: [{
                data: [50,25,15,10],
                backgroundColor:[mUtil.getColor('accent'),mUtil.getColor('danger'),mUtil.getColor('primary'),mUtil.getColor('warning')],
    }],},
       

        
    },
    methods:{
        monthlyLocationSelected(){
            this.updateMonthlyData();
            this.getMonthDailyData();
            this.updateYearlyData();
            this.getHourlySalesAmount();
            this.categoryBreakdown();

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
        getMonthDailyData(){
            axios.post('/sales/month_daily',{
                _token:this.token,
                year: this.selectedYear,
                month:this.selectedMonth.value,
                location:this.monthlySalesLocation,
            }).then(function(response){
               app.labels = response.data.labels;
               app.dailySales = response.data.totals;
               app.monthDailyChartUpdateData();
               
            });
        },
        monthDailyChartUpdateData(){
            this.monthDailyChart.data.labels = this.labels;
            this.monthDailyChart.data.datasets[0].data = app.dailySales;
            this.monthDailyChart.update();
        },
        updateMonthlyData(){
             axios.post('/sales/monthlyByYearMonthLocation',{
                _token:this.token,
                location:this.monthlySalesLocation,
                year:this.selectedYear,
                month:this.selectedMonth.value
            }).then(function(response){
               	// console.log(response.data);
               
              app.monthlySales = response.data.selectedMonth;
              app.preMonthlySales = response.data.prevMonth;
              app.monthlyCompare = response.data.monthCompare;
               
            });
        },
        updateYearlyData(){
            axios.post('/sales/yearlyByLocation',{
                _token:this.token,
                location: this.monthlySalesLocation,
                year: this.selectedYear,
            }).then(function(response){
                app.yearToDateSales = response.data.yearSales;
                app.yearlyCompare = response.data.yearlyCompare;
        
            });
            
        },
        yearSelected(){
        	this.updateMonthlyData();
            this.getMonthDailyData();
            this.getHourlySalesAmount();
            this.categoryBreakdown();
        },
        monthSelected(){
        	this.updateMonthlyData();
            this.getMonthDailyData();
            this.getHourlySalesAmount();
            this.categoryBreakdown();
        },
        getHourlySalesAmount(){
            axios.post('/sales/hourlySalesAmt',{
                _token:this.token,
                location:this.monthlySalesLocation,
                year:this.selectedYear,
                month:this.selectedMonth.value,
                type:this.selectedHourlyType,
            }).then(function(response){
                console.log(response.data[0]);
                app.hourlySalesAmt = response.data;
                app.hourlySalesAmtChart.dataProvider = app.hourlySalesAmt;
                app.hourlySalesAmtChart.validateData();
               
            });
        },
        hourlyTypeSelected(){
            this.getHourlySalesAmount();
        },
        categoryBreakdown(){
            axios.post('/sales/categoryBreakdown',{
                _token:this.token,
                location:this.monthlySalesLocation,
                year:this.selectedYear,
                month:this.selectedMonth.value,
            }).then(function(response){
                console.log(response.data);
                app.categorySales = response.data;
                for(var i in response.data){
                    app.categoryShareQtyData.datasets[0].data.push(response.data[i].qty);
                }
                app.categoryShareQtyChart.update();
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

 // begin month daily sales
var monthDaily = document.getElementById('month_daily_sales').getContext('2d');
this.monthDailyChart = new Chart(monthDaily,{
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
                    bottom: 20
                }
            },
    }

});

this.getMonthDailyData();
this.categoryBreakdown();

// end month daily sales
// begin hourly sales amount chart

// this.getHourlySalesAmount();

this.hourlySalesAmtChart = AmCharts.makeChart("hourlyChartDiv", {

    "type": "serial",
    "theme": "light",
    "marginRight": 80,
    "autoMarginOffset": 20,
    "marginTop": 7,
    "dataDateFormat": "YYYY-MM-DD HH:NN:SS",
    "dataProvider": this.hourlySalesAmt,
    "valueAxes": [{
        "axisAlpha": 0.2,
        "dashLength": 1,
        "position": "left"
    }],
    "mouseWheelZoomEnabled": true,
    "graphs": [{
        "lineColor":"#41b197",
        "id": "g1",
        "balloonText": '$'+"[[value]]",
        "bullet": "round",
        "bulletBorderAlpha": 1,
        "bulletColor": "#FFFFFF",
        "hideBulletsCount": 50,
        "title": "red line",
        "valueField": "invoiceAmt",
        "useLineColorForBulletBorder": true,
        "balloon":{
            "drop":true
        }
    }],
    "chartScrollbar": {
        "autoGridCount": true,
        "graph": "g1",
        "scrollbarHeight": 80
    },
    "chartCursor": {
       "limitToGraph":"g1"
    },
    "categoryField": "from",
    "categoryAxis": {
        "parseDates": false,
        "axisColor": "#DADADA",
        "dashLength": 1,
        "minorGridEnabled": true,
        "labelRotation": 45,
        "labelFunction":function(valueText,serialDateItem,categoryAxis){return moment(valueText).format('MMM D, ha');},
        
    },
    "export": {
        "enabled": true
    }
});
// this.hourlySalesAmtChart.addListener("rendered", zoomChart);


// begin sales share chart

var salesShare = document.getElementById('sales_share').getContext('2d');
this.categoryShareQtyChart = new Chart(salesShare,{
    type:'doughnut',
    data:this.categoryShareQtyData,
    options:{
        cutoutPercentage:70,
        rotation:15,
        legend:{
            display:true,
        }
    },
});
// end sales share chart


    }
 });


</script>

<!-- Styles -->
<style>
#hourlyChartDiv {
    width   : 100%;
    height  : 500px;
}                                                                   
</style>


@endsection