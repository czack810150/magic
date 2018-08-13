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
                            Sales <small>销售情况</small>
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
            <div class="col-md-12 col-lg-6 col-xl-3">
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
</div>
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
        chart:null,
        twoWeekChart:null,
        
        monthlySales:'{{number_format($data['monthlySales'],0,'.',',')}}',
        preMonthlySales:'{{$data['preMonthlySales']}}',
        monthlyCompare: '{{ round($data['monthlySales']/$data['preMonthlySales']*100,2) }}',
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
       

        
    },
    methods:{
        monthlyLocationSelected(){
            this.updateMonthlyData();
            //this.getTwoWeekSalesData();
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
        yearSelected(){
        	this.updateMonthlyData();
        },
        monthSelected(){
        	this.updateMonthlyData();
        }
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
    }
 });
</script>
@endsection