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
													知识强化培训
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


<!--begin::Section-->
<div class="m-section">
<div class="row mb-5">
			<div class="col-md-6 col-lg-6 col-xl-6">
				<!--begin::Total Profit-->
				<div class="m-widget24">					 
				    <div class="m-widget24__item">
				        <h4 class="m-widget24__title">
				            Target Questions
				        </h4><br>
				        <span class="m-widget24__desc">
				            目标题数
				        </span>
				        <span class="m-widget24__stats m--font-brand">
                        @{{count}} 
				        </span>		
				        <div class="m--space-10"></div>
						
							
                        <div id="slider" class="col-10 ml-4"></div>
						
					
				    </div>				      
				</div>
				<!--end::Total Profit-->
			</div>
            <div class="col-md-6 col-lg-6 col-xl-6">
            <ul class="list-unstyled">
                <li v-for="selected in selectedCats"
                @click="removeSelected(selected)"
                ><h3><span class="m-badge m-badge--danger m-badge-wide" v-text="selected.name"></span></h3></li>
            </ul>
            </div>
</div>

                    <h3 class="m-section__heading">
                        Target Question Categories
                    </h3>
                    <div class="m-section__content">
                        <!--begin::Preview-->
                        <div class="m-demo">                             
                            <div class="m-demo__preview" style="background: #F7F8FC;"> 
                                <div class="m-list-badge">
                                    
                                    <div class="m-list-badge__items">
                                        <button v-for="category in categories"  class="btn m-btn--pill btn-outline-info m-2" type="button" v-text="category.name"
                                        @click="addCategory(category)"></button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <!--end::Preview-->
                    </div>
                </div>
                <!--end::Section-->




</div>	
<div class="m-portlet__foot">
				<div class="row align-items-center">
					<div class="col-lg-12">
						<button type="submit" class="btn btn-success" @click="generate">生成</button>
						<button type="submit" class="btn btn-secondary" @click="resetCreate">取消</button>
					</div>
				</div>
			</div>

</div>
<!--end::Portlet-->
@endsection
@section('pageJS')
<script>
var vm = new Vue({
    el: '#root',
    data: {
        count: 0,
        categories:[],
        selectedCats:[],

    },
    methods:{
        addCategory(cat){
            
            if(this.selectedCats.indexOf(cat) == -1){
                this.selectedCats.push(cat);
            } else {
                console.log(cat.name + ' is already selected')
            }
        },
        resetCreate(){
            this.selectedCats = [];
            this.count = 20;
        },
        removeSelected(cat){
            const index = this.selectedCats.indexOf(cat)
            
            this.selectedCats.splice(index,1)
        },
        generate(){
            if(vm.selectedCats.length){
            axios.post('/exam/learn/store',{
                _token: '{{csrf_token()}}',
                count: vm.count,
                cats: vm.selectedCats
            }).then(function(response){
                console.log(response.data);
            })
            } else {
                alert('You must select at least one category.');
            }
        }
    },
    mounted: function(){
        axios.get('/questionCategory').then(function(response){
            
            vm.categories = response.data
        })
    }
})


var slider = document.getElementById('slider');
noUiSlider.create(slider,{
    start:[20],
    connect: true,
    step:1,
    padding:5,
    range:{
        min:15,
        max:55
    },
    format: {
	  to: function ( value ) {
		return value;
	  },
	  from: function ( value ) {
		return value;
	  }
	}
});
slider.noUiSlider.on('update',function(values,handle){
    vm.count = values[handle];
});

</script>
@endsection