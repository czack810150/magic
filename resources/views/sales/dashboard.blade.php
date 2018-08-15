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
        hourlySalesAmt:[{'from':'2018-08-01','invoiceAmt':"100"},],
        hourlySalesAmtChart:null,
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
        yearToDateSales:'{{number_format($data['yearSales'],0,'.',',')}}',
        preYearSales: {{ $data['preYearSales']}},
        
       

        
    },
    methods:{
        monthlyLocationSelected(){
            this.updateMonthlyData();
            this.getMonthDailyData();
            this.updateYearlyData();
            this.getHourlySalesAmount();

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
        },
        monthSelected(){
        	this.updateMonthlyData();
            this.getMonthDailyData();
            this.getHourlySalesAmount();
        },
        getHourlySalesAmount(){
            axios.post('/sales/hourlySalesAmt',{
                _token:this.token,
                location:this.monthlySalesLocation,
                year:this.selectedYear,
                month:this.selectedMonth.value
            }).then(function(response){
                console.log(response.data[0]);
                app.hourlySalesAmt = response.data;
                app.hourlySalesAmtChart.dataProvider = app.hourlySalesAmt;
                app.hourlySalesAmtChart.validateData();
               
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

// end month daily sales
// begin hourly sales amount chart

this.getHourlySalesAmount();

this.hourlySalesAmtChart = AmCharts.makeChart("hourlyChartDiv", {
    "type": "serial",
    "theme": "light",
    "marginRight": 80,
    "autoMarginOffset": 20,
    "marginTop": 7,
    "dataProvider": this.hourlySalesAmt,
    "valueAxes": [{
        "axisAlpha": 0.2,
        "dashLength": 1,
        "position": "left"
    }],
    "mouseWheelZoomEnabled": true,
    "graphs": [{
        "id": "g1",
        "balloonText": "[[value]]",
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
        "scrollbarHeight": 40
    },
    "chartCursor": {
       "limitToGraph":"g1"
    },
    "categoryField": "from",
    "categoryAxis": {
        "parseDates": true,
        "axisColor": "#DADADA",
        "dashLength": 1,
        "minorGridEnabled": true
    },
    "export": {
        "enabled": true
    }
});
// this.hourlySalesAmtChart.addListener("rendered", zoomChart);


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

<!-- Resources -->


<!-- Chart code -->
<script>
// var hourlySalesAmtData = generateChartData();



// zoomChart();




// generate some random data, quite different range

// generate some random data, quite different range
function generateChartData() {
    var chartData = [];
    var firstDate = new Date();
    firstDate.setDate(firstDate.getDate() - 5);
    var visits = 1200;
    for (var i = 0; i < 1000; i++) {
        // we create date objects here. In your data, you can have date strings
        // and then set format of your dates using chart.dataDateFormat property,
        // however when possible, use date objects, as this will speed up chart rendering.
        var newDate = new Date(firstDate);
        newDate.setDate(newDate.getDate() + i);
        
        visits += Math.round((Math.random()<0.5?1:-1)*Math.random()*10);

        chartData.push({
            date: newDate,
            visits: visits
        });
    }
    return chartData;
}


</script>
@endsection