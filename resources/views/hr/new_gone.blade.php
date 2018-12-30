
<div class="row">
   	<div class="col-12">	
		<!--begin::Portlet-->
		<div class="m-portlet" id="inOut">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-map-location"></i>
						</span>
						<h3 class="m-portlet__head-text">
							New Hires & Terminations
						</h3>
					</div>			
				</div>
				<div class="m-portlet__head-tools">
					<ul class="m-portlet__nav">
						<li class="m-portlet__nav-item">
							<select class="custom-select" v-model="selectedYear" @change="updateHiresTerminations">
								
								<option v-for="year in years" :value="year" v-text="year"></option>
							</select>
						</li>	
						<li class="m-portlet__nav-item">
							<select class="custom-select" v-model="selectedLocation"  @change="updateHiresTerminations">
								<option value="all">All Locations</option>
								<option v-for="(name,id) in locations" :value="id" v-text="name"></option>
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
						            New Hires
						        </h4><br>
						        <span class="m-widget24__desc">
						            入职人数
						        </span>
						        <span class="m-widget24__stats m--font-success">
						            @{{ ins }}
						        </span>		
						        <div class="m--space-10"></div>
								<div class="progress m-progress--sm">
									<div class="progress-bar m--bg-success" role="progressbar" :style="newHiresBar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<span class="m-widget24__change">
									Compared to previous year
								</span>
								<span class="m-widget24__number">
									@{{ (ins/insPrevious*100).toFixed(1) }}%
							    </span>
						    </div>				      
						</div>
						<!--end::Total Profit-->
					</div>

					<div class="col-md-12 col-lg-6 col-xl-3">
						<!--begin::Total Profit-->
						<div class="m-widget24">					 
						    <div class="m-widget24__item">
						        <h4 class="m-widget24__title">
						            Terminations
						        </h4><br>
						        <span class="m-widget24__desc">
						            离职人数
						        </span>
						        <span class="m-widget24__stats m--font-danger">
						            @{{ outs }}
						        </span>		
						        <div class="m--space-10"></div>
								<div class="progress m-progress--sm">
									<div class="progress-bar m--bg-danger" role="progressbar" :style="terminationsBar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<span class="m-widget24__change">
									Compared to previous year
								</span>
								<span class="m-widget24__number">
									
									@{{(this.outs / this.outsPrevious * 100).toFixed(1)}}%
							    </span>
						    </div>				      
						</div>
						<!--end::Total Profit-->
					</div>

					<div class="col-md-12 col-lg-6 col-xl-3">
						<!--begin::Total Profit-->
						<div class="m-widget24">					 
						    <div class="m-widget24__item">
						        <h4 class="m-widget24__title">
						            Growth
						        </h4><br>
						        <span class="m-widget24__desc">
						            增长率
						        </span>
						        <span class="m-widget24__stats m--font-info">
						            @{{ growth }}%
						        </span>		
						        <div class="m--space-10"></div>
								<div class="progress m-progress--sm">
									<div class="progress-bar m--bg-info" role="progressbar" style="width: {{round($data['activeEmployees']/$data['totalEmployees']*100,2)}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								{{-- <span class="m-widget24__change">
									Compared to previous year
								</span>
								<span class="m-widget24__number">
									@{{ growthPrevious }}%
							    </span> --}}
						    </div>				      
						</div>
						<!--end::Total Profit-->
					</div>
				</div>
			</div>
		</div>	
		<!--end::Portlet-->
	</div>
</div>
<script>
	let inOut = new Vue({
		el: '#inOut',
		data:{
			ins:{{ $data['newHires'] }},
			outs:{{ $data['terminations'] }},
			insPrevious:{{ $data['newHiresPrevious'] }},
			outsPrevious:{{ $data['terminationsPrevious'] }},
			locations: @json($locationOptions),
			years:@json($yearOptions),
			selectedLocation:'all',
			selectedYear: new Date().getFullYear(),
		},
		computed:{
			growth(){
				if(this.ins == this.outs){
					return 0;
				}

				if(this.outs > 0){
					return (this.ins/this.outs*100 -100).toFixed(1);
				} else {
					return (this.ins/1*100 -100).toFixed(1);
				}
				
			},
			growthPrevious(){
				if(this.outsPrevious > 0){
					return (this.insPrevious / this.outsPrevious *100 -100).toFixed(1);
				} else {
					return (this.insPrevious / 1 *100 -100).toFixed(1);
				}
				
			},
			newHiresBar(){
				if(this.insPrevious > 0){
					return 'width:'+ (this.ins / this.insPrevious * 100).toFixed(1)+'%';
				} else {
					return 'width:0%';
				}
				
			},
			terminationsBar(){
				if(this.outsPrevious > 0){
					return 'width:'+ (this.outs / this.outsPrevious * 100).toFixed(1)+'%';
				} else {
					return 'width:0%';
				}
			}	
		},
		methods:{
			updateHiresTerminations(){
				axios.post('/hr/hires_terminations',{
					year:this.selectedYear,
					location:this.selectedLocation,
				}).then(res => {
					console.log(res.data);
					if(res.data.success){
						this.ins = res.data.data.newHires;
						this.outs =res.data.data.terminations;
						this.insPrevious = res.data.data.newHiresPrevious;
						this.outsPrevious = res.data.data.terminationsPrevious;
					}
				}).catch(e => {
					alert(e);
					console.log(e)
				});
			}
		},

	})
</script>