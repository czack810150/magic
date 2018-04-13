<div class="m-portlet ">
<div class="m-portlet__head">
									<div class="m-portlet__head-caption">
										<div class="m-portlet__head-title">
											<span class="m-portlet__head-icon">
												<i class="la la-clock-o"></i>
											</span>
											<h3 class="m-portlet__head-text">
												Employee Total
											</h3>
										</div>
									</div>
									
								</div>
	<div class="m-portlet__body  m-portlet__body--no-padding">
		<div class="row m-row--no-padding m-row--col-separator-xl">
			<div class="col-md-12 col-lg-6 col-xl-3">
				<!--begin::Total Profit-->
				<div class="m-widget24">					 
				    <div class="m-widget24__item">
				        <h4 class="m-widget24__title">
				            Total Service Hour
				        </h4><br>
				        <span class="m-widget24__desc">
				            累计有效时间
				        </span>
				        <span class="m-widget24__stats m--font-brand">
				            {{$stats['chequeHour'] + $stats['cashHour']}}
				        </span>		
				        <div class="m--space-10"></div>
						<div class="progress m-progress--sm">
							<div class="progress-bar m--bg-brand" role="progressbar" style="width: {{ round($stats['chequeHour']/($stats['chequeHour'] + $stats['cashHour']),2)*100 }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<span class="m-widget24__change">
							合法工时率
						</span>
						<span class="m-widget24__number">
							{{ round($stats['chequeHour']/($stats['chequeHour'] + $stats['cashHour']),2)*100 }}%
					    </span>
				    </div>				      
				</div>
				<!--end::Total Profit-->
			</div>
			<div class="col-md-12 col-lg-6 col-xl-3">
				<!--begin::New Feedbacks-->
				<div class="m-widget24">
					 <div class="m-widget24__item">
				        <h4 class="m-widget24__title">
				            Effective Hours
				        </h4><br>
				        <span class="m-widget24__desc">
				            合法工时
				        </span>
				        <span class="m-widget24__stats m--font-info">
				           {{$stats['chequeHour'] }}
				        </span>		
				        <div class="m--space-10"></div>
						<div class="progress m-progress--sm">
							<div class="progress-bar m--bg-info" role="progressbar" style="width: {{ round($stats['chequeHour']/$stats['scheduledHour'],2)*100 }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<span class="m-widget24__change">
							有效工时率
						</span>
						<span class="m-widget24__number">
							{{ round($stats['chequeHour']/$stats['scheduledHour'],2)*100 }}%
					    </span>
				    </div>		
				</div>
				<!--end::New Feedbacks--> 
			</div>
			<div class="col-md-12 col-lg-6 col-xl-3">
				<!--begin::New Orders-->
				<div class="m-widget24">
					<div class="m-widget24__item">
				        <h4 class="m-widget24__title">
				            Cash Hours
				        </h4><br>
				        <span class="m-widget24__desc">
				            现金工时
				        </span>
				        <span class="m-widget24__stats m--font-danger">
				            {{$stats['cashHour'] }}
				        </span>		
				        <div class="m--space-10"></div>
						<div class="progress m-progress--sm">
<div class="progress-bar m--bg-danger" role="progressbar" 
@if($stats['scheduledHourCash'])
style="width: {{ round($stats['cashHour']/$stats['scheduledHourCash'],2)*100 }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
@else
style="width: 0%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
@endif
</div>
						</div>
						<span class="m-widget24__change">
							有效工时率
						</span>
						<span class="m-widget24__number">
							@if($stats['scheduledHourCash'])
							{{ round($stats['cashHour']/$stats['scheduledHourCash'],2)*100 }}%
							@else
							no cash hours
							@endif
			            </span>
				    </div>		
				</div>
				<!--end::New Orders--> 
			</div>
			<div class="col-md-12 col-lg-6 col-xl-3">
				<!--begin::New Users-->
				<div class="m-widget24">
					 <div class="m-widget24__item">
				        <h4 class="m-widget24__title">
				            Overtime
				        </h4><br>
				        <span class="m-widget24__desc">
				            超时
				        </span>
				        <span class="m-widget24__stats m--font-success">
				            {{$stats['overtimeHour'] }}
				        </span>		
				        <div class="m--space-10"></div>
				        <div class="progress m-progress--sm">
							<div class="progress-bar m--bg-success" role="progressbar" style="width: {{ round( $stats['overtimeHour']/$stats['chequeHour'],2 )*100 }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<span class="m-widget24__change">
							超时率
						</span>
						<span class="m-widget24__number">
							{{ round( $stats['overtimeHour']/$stats['chequeHour'],2 )*100 }}%
						</span>
				    </div>		
				</div>
				<!--end::New Users--> 
			</div>
		</div>
		<div class="row m-row--no-padding m-row--col-separator-xl">
			<div class="col-md-12 col-lg-6 col-xl-3">
				<!--begin::Total Profit-->
				<div class="m-widget24">					 
				    <div class="m-widget24__item">
				        <h4 class="m-widget24__title">
				            Total Scheduled Hour
				        </h4><br>
				        <span class="m-widget24__desc">
				            累计排班时间
				        </span>
				        <span class="m-widget24__stats m--font-warning">
				            {{$stats['scheduledHour'] + $stats['scheduledHourCash']}}
				        </span>		
				        <div class="m--space-10"></div>
						<div class="progress m-progress--sm">
							<div class="progress-bar m--bg-warning" role="progressbar" style="width: {{ round($stats['chequeHour']/($stats['chequeHour'] + $stats['cashHour']),2)*100 }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<span class="m-widget24__change">
							有效工时率
						</span>
						<span class="m-widget24__number">
							{{ round(($stats['chequeHour']+$stats['cashHour'])/($stats['scheduledHour'] + $stats['scheduledHourCash']),2)*100 }}%
					    </span>
				    </div>				      
				</div>
				<!--end::Total Profit-->
			</div>
			<div class="col-md-12 col-lg-6 col-xl-3">
				<!--begin::New Feedbacks-->
				<div class="m-widget24">
					 <div class="m-widget24__item">
				        <h4 class="m-widget24__title">
				            Scheduled Hours
				        </h4><br>
				        <span class="m-widget24__desc">
				            合法排班工时
				        </span>
				        <span class="m-widget24__stats m--font-primary">
				           {{$stats['scheduledHour'] }}
				        </span>		
				        <div class="m--space-10"></div>
						<div class="progress m-progress--sm">
							<div class="progress-bar m--bg-primary" role="progressbar" style="width: {{ round($stats['scheduledHour']/($stats['scheduledHour']+$stats['scheduledHourCash']),6)*100 }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<span class="m-widget24__change">
							占比
						</span>
						<span class="m-widget24__number">
							{{ round($stats['scheduledHour']/($stats['scheduledHour']+$stats['scheduledHourCash']),6)*100 }}%
					    </span>
				    </div>		
				</div>
				<!--end::New Feedbacks--> 
			</div>
			<div class="col-md-12 col-lg-6 col-xl-3">
				<!--begin::New Orders-->
				<div class="m-widget24">
					<div class="m-widget24__item">
				        <h4 class="m-widget24__title">
				            Scheduled Cash Hours
				        </h4><br>
				        <span class="m-widget24__desc">
				            现金排班工时
				        </span>
				        <span class="m-widget24__stats m--font-focus">
				            {{$stats['scheduledHourCash'] }}
				        </span>		
				        <div class="m--space-10"></div>
						<div class="progress m-progress--sm">
							<div class="progress-bar m--bg-focus" role="progressbar" style="width: {{ round($stats['scheduledHourCash']/($stats['scheduledHour']+$stats['scheduledHourCash']),6)*100 }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<span class="m-widget24__change">
							占比
						</span>
						<span class="m-widget24__number">
							{{ round($stats['scheduledHourCash']/($stats['scheduledHour']+$stats['scheduledHourCash']),6)*100 }}%
			            </span>
				    </div>		
				</div>
				<!--end::New Orders--> 
			</div>
			<div class="col-md-12 col-lg-6 col-xl-3">
				<!--begin::New Users-->
				<div class="m-widget24">
					 <div class="m-widget24__item">
				        <h4 class="m-widget24__title">
				            Night Hours
				        </h4><br>
				        <span class="m-widget24__desc">
				            有效夜班工时
				        </span>
				        <span class="m-widget24__stats m--font-metal">
				            {{$stats['totalNightHour'] }}
				        </span>		
				        <div class="m--space-10"></div>
				        <div class="progress m-progress--sm">
							<div class="progress-bar m--bg-metal" role="progressbar" style="width: {{round($stats['totalNightHour']/($stats['chequeHour'] + $stats['cashHour']),3)*100}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<span class="m-widget24__change">
							夜班白班比
						</span>
						<span class="m-widget24__number">
							{{round($stats['totalNightHour']/($stats['chequeHour'] + $stats['cashHour']),3)*100}}%
						</span>
				    </div>		
				</div>
				<!--end::New Users--> 
			</div>
		</div>


 <div class="row m-row--no-padding m-row--col-separator-xl">
      <div class="col-md-12 col-lg-12 col-xl-4">
        <!--begin:: Widgets/Stats2-1 -->
<div class="m-widget1">
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">前厅工时</h3>
				<span class="m-widget1__desc">Server</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-brand">{{$stats['server']?round($stats['server'],2):'0'}}</span>
			</div>
		</div>
	</div>
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">后厨工时</h3>
				<span class="m-widget1__desc">Line cook</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-danger">{{$stats['cook']?round($stats['cook'],2):'0'}}</span>
			</div>
		</div>
	</div>
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">拉面工时</h3>
				<span class="m-widget1__desc">Noodle master</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-success">{{$stats['noodle']?round($stats['noodle'],2):'0'}}</span>
			</div>
		</div>
	</div>
</div>



<!--end:: Widgets/Stats2-1 -->      
</div>

<div class="col-md-12 col-lg-12 col-xl-4">
        <!--begin:: Widgets/Stats2-2 -->
<div class="m-widget1">
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">抓码</h3>
				<span class="m-widget1__desc">Topping</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-accent">{{$stats['topping']?round($stats['topping'],2):'0'}}</span>
			</div>
		</div>
	</div>
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">烧烤</h3>
				<span class="m-widget1__desc">BBQ</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-info">{{$stats['bbq']?round($stats['bbq'],2):'0'}}</span>
			</div>
		</div>
	</div>
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">凉菜</h3>
				<span class="m-widget1__desc">Cold Apps</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-warning">{{$stats['cold']?round($stats['cold'],2):'0'}}</span>
			</div>
		</div>
	</div>
</div>
<!--begin:: Widgets/Stats2-2 -->      </div>
<div class="col-md-12 col-lg-12 col-xl-4">
        <!--begin:: Widgets/Stats2-2 -->
<div class="m-widget1">
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">洗碗</h3>
				<span class="m-widget1__desc">Dish wash</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-accent">{{$stats['dish']?round($stats['dish'],2):'0'}}</span>
			</div>
		</div>
	</div>
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">挑面</h3>
				<span class="m-widget1__desc">Noodle boil</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-info">{{$stats['boil']?round($stats['boil'],2):'0'}}</span>
			</div>
		</div>
	</div>
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">面点</h3>
				<span class="m-widget1__desc">Pantry</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-warning">{{$stats['pantry']?round($stats['pantry'],2):'0'}}</span>
			</div>
		</div>
	</div>
</div>
<!--begin:: Widgets/Stats2-2 -->      </div>



</div>

	</div>
</div>
<!--end:: Widgets/Stats--> 


<!--Begin::Section-->
<div class="m-portlet">
	<div class="m-portlet__head">
									<div class="m-portlet__head-caption">
										<div class="m-portlet__head-title">
											<span class="m-portlet__head-icon">
												<i class="la la-medkit"></i>
											</span>
											<h3 class="m-portlet__head-text">
												Extra Duties 次数
											</h3>
										</div>
									</div>
									
								</div>
  <div class="m-portlet__body m-portlet__body--no-padding">
    <div class="row m-row--no-padding m-row--col-separator-xl">
      <div class="col-md-12 col-lg-12 col-xl-4">
        <!--begin:: Widgets/Stats2-1 -->
<div class="m-widget1">
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">开早</h3>
				<span class="m-widget1__desc">Opening</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-brand">{{$stats['open']}}</span>
			</div>
		</div>
	</div>
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">收档</h3>
				<span class="m-widget1__desc">Closing</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-danger">{{$stats['close']}}</span>
			</div>
		</div>
	</div>
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">提前收档</h3>
				<span class="m-widget1__desc">Pre Close</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-success">{{$stats['preClose']}}</span>
			</div>
		</div>
	</div>
</div>
<!--end:: Widgets/Stats2-1 -->      </div>
      <div class="col-md-12 col-lg-12 col-xl-4">
        <!--begin:: Widgets/Stats2-2 -->
<div class="m-widget1">
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">清洁</h3>
				<span class="m-widget1__desc">Cleaning</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-accent">{{$stats['clean']}}</span>
			</div>
		</div>
	</div>
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">深度清洁</h3>
				<span class="m-widget1__desc">Deep Cleaning</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-info">{{$stats['deepClean']}}</span>
			</div>
		</div>
	</div>
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">培训</h3>
				<span class="m-widget1__desc">Training</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-warning">{{$stats['training']}}</span>
			</div>
		</div>
	</div>
</div>
<!--begin:: Widgets/Stats2-2 -->      </div>
      <div class="col-md-12 col-lg-12 col-xl-4">
        <!--begin:: Widgets/Stats2-3 -->
<div class="m-widget1">
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">值班经理</h3>
				<span class="m-widget1__desc">Shift Manager</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-success">{{$stats['shiftManager']}}</span>
			</div>
		</div>
	</div>
	
</div>
<!--begin:: Widgets/Stats2-3 -->      </div>
    </div>
  </div>
</div>
<!--End::Section-->