@extends('layouts.master')
@section('content')

<!--begin::Portlet-->
<div class="m-portlet m-portlet--full-height ">
						
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-clipboard"></i>
												</span>
												<h3 class="m-portlet__head-text">
													Marking
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
										
												<li class="m-portlet__nav-item">
												<a href="/exam/attemptedExams" class="btn btn-secondary">Back</a>
												
												</li>
											</ul>
										</div>
									</div>
					
<div class="m-portlet__body m-portlet__body-padding">
@if(isset($exam))
<div class="tab-content">
			<div class="tab-pane active" id="m_widget4_tab1_content">
				<!--begin::Widget 14-->
				<div class="m-widget4">
					<!--begin::Widget 14 Item-->  
					<div class="m-widget4__item">
						<div class="m-widget4__img m-widget4__img--pic">							 
							<img src="{{ asset('/storage/'.$exam->employee->employee_profile->img) }}" alt="">   
						</div>
						<div class="m-widget4__info">
							<span class="m-widget4__title">
							{{$exam->employee->cName}}
							</span><br> 
							<span class="m-widget4__sub">
							{{$exam->name}} {{$exam->taken_at}}
							</span>							 		 
						</div>
						<div class="m-widget4__ext">
							<a href="#"  class="m-btn m-btn--pill m-btn--hover-brand btn btn-sm btn-secondary">通过</a>
						</div>
					</div>
					<!--end::Widget 14 Item--> 			 
				</div>
				<!--end::Widget 14-->             
			</div>
		</div>


<div class="row m-row--no-padding m-row--col-separator-xl">
			<div class="col-md-12 col-lg-6 col-xl-3">
				<!--begin::Total Profit-->
				<div class="m-widget24">					 
				    <div class="m-widget24__item">
				        <h4 class="m-widget24__title">
				            Total Questions
				        </h4><br>
				        <span class="m-widget24__desc">
				            考试题数
				        </span>
				        <span class="m-widget24__stats m--font-brand">
				            {{$questions}}
				        </span>		
				        <div class="m--space-10"></div>
						<div class="progress m-progress--sm">
							<div class="progress-bar m--bg-brand" role="progressbar" style="width: {{ $attempted/$questions*100  }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<span class="m-widget24__change">
							回答数
						</span>
						<span class="m-widget24__number">
							{{$attempted}}
					    </span>
				    </div>				      
				</div>
				<!--end::Total Profit-->
			</div>

			<div class="col-md-12 col-lg-6 col-xl-3">
				<div class="m-widget24">					 
				    <div class="m-widget24__item">
				        <h4 class="m-widget24__title">
				            Multiple Choice
				        </h4><br>
				        <span class="m-widget24__desc">
				            选择题
				        </span>
				        <span class="m-widget24__stats m--font-info">
				            {{$mc}}
				        </span>		
				        <div class="m--space-10"></div>
						<div class="progress m-progress--sm">
							<div class="progress-bar m--bg-info" role="progressbar" style="width: {{ $exam->score/$mc*100  }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<span class="m-widget24__change">
							正确数/率
						</span>
						<span class="m-widget24__number">
							{{ round($exam->score/$mc,2)*100  }}%
					    </span>
					    <span class="m-widget24__number">
							{{$exam->score}}
					    </span>
				    </div>				      
				</div>
			</div>

			<div class="col-md-12 col-lg-6 col-xl-3">
				<div class="m-widget24">					 
				    <div class="m-widget24__item">
				        <h4 class="m-widget24__title">
				            Short Answer
				        </h4><br>
				        <span class="m-widget24__desc">
				            简答题
				        </span>
				        <span class="m-widget24__stats m--font-danger">
				            {{$sa}}
				        </span>		
				        <div class="m--space-10"></div>
						<div class="progress m-progress--sm">
							<div class="progress-bar m--bg-danger" role="progressbar" style="width: {{ round($attemptedSA/$sa,2)*100  }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<span class="m-widget24__change">
							回答数
						</span>
						<span class="m-widget24__number">
							{{ round($attemptedSA/$sa,2)*100  }}%
					    </span>
					    <span class="m-widget24__number">
							{{$attemptedSA }}
					    </span>
				    </div>				      
				</div>
			</div>
</div>

<ul class="list-unstyled">
@foreach($exam->question as $question)
	@if($question->question->mc)
		<li class="my-2">
			<div class="card" style="width: auto;"><div class="card-body"><h6 class="card-title"><span class="badge badge-pill badge-warning">选择</span> {{ $question->question->body }}
				@if(is_null($question->answer_id))
					<span class="badge badge-danger">没有提供答案</span>
				@endif
			</h6> 
			<ul class="list-unstyled">
				@if(!is_null($question->answer_id))
					
               		 @foreach($question->question->answer as $answer)
                			@if($answer->correct)
   								<li class="mb-3"><span class="badge badge-success">{{ $answer->answer }}</span></li>
   							@elseif( $answer->id == $question->answer->id )
   								<li class="mb-3"><span class="badge badge-danger">{{ $answer->answer }}</span></li>
   							@else
   					  			 <li class="mb-3"><span class="badge badge-light">{{ $answer->answer }}</span></li>
   							@endif	
               		 @endforeach
        	
        		@else
        			 @foreach($question->question->answer as $answer)
                			@if($answer->correct)
   								<li class="mb-3"><span class="badge badge-success">{{ $answer->answer }}</span></li>
   							@else
   					  			 <li class="mb-3"><span class="badge badge-light">{{ $answer->answer }}</span></li>
   							@endif	
               		 @endforeach


				@endif
			</ul>
				


			</div></div>	
			</li>
	@else
		<li class="my-2">
			<div class="card" style="width: auto;"><div class="card-body"><h6 class="card-title"><span class="badge badge-pill badge-primary">简答</span> {{ $question->question->body }}</h6>
				@if( $question->short_answer )
				<p>{{ $question->short_answer }}</p>
				@else
				<p>No provided answer</p>
				@endif
			
		</li>
	@endif
@endforeach
</ul>
@endif
</div>
</div>
@endsection
