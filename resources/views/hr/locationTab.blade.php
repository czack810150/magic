 <!--begin:: Widgets/Stats-->
<div class="m-portlet ">
	<div class="m-portlet__body  m-portlet__body--no-padding">
		<div class="row m-row--no-padding m-row--col-separator-xl">
			<div class="col-md-12 col-lg-6 col-xl-3">
				<!--begin::Total Profit-->
				<div class="m-widget24">					 
				    <div class="m-widget24__item">
				        <h4 class="m-widget24__title">
				            Company
				        </h4><br>
				        <span class="m-widget24__desc">
				            公司全体在职
				        </span>
				        <span class="m-widget24__stats m--font-brand">
				            {{ $data['activeEmployees'] }}
				        </span>		
				        <div class="m--space-10"></div>
						<div class="progress m-progress--sm">
							<div class="progress-bar m--bg-brand" role="progressbar" style="width: {{round($data['activeEmployees']/$data['totalEmployees']*100,2)}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<span class="m-widget24__change">
							在职率 （在职 / 在职与休假)
						</span>
						<span class="m-widget24__number">
							{{round($data['activeEmployees']/$data['totalEmployees']*100,2)}}%
					    </span>
				    </div>				      
				</div>
				<!--end::Total Profit-->
			</div>

			@foreach($data['locationEmployees'] as $location => $value)
			<div class="col-md-12 col-lg-6 col-xl-3">
				<!--begin::New Feedbacks-->
				<div class="m-widget24">
					 <div class="m-widget24__item">
				        <h4 class="m-widget24__title">
				            {{$location}}
				        </h4><br>
				        <span class="m-widget24__desc">
				            Active 在职
				        </span>
				        <span class="m-widget24__stats m--font-success">
				            {{ $value['totalActive'] }}
				        </span>		
				        <div class="m--space-10"></div>
						<div class="progress m-progress--sm">
							<div class="progress-bar m--bg-success" role="progressbar" style="width: {{ round($value['activeRate']*100,2) }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<span class="m-widget24__change">
							在职率
						</span>
						<span class="m-widget24__number">
							{{ round($value['activeRate']*100,2) }}%
					    </span>
				    </div>		
				</div>
				<!--end::New Feedbacks--> 
			</div>
			@endforeach
			
			
		</div>
	</div>
</div>
<!--end:: Widgets/Stats--> 