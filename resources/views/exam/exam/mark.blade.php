@extends('layouts.master')
@section('content')
<div class="container">
<h1>Marking</h1>

@if(isset($exam))
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
<div class="form-group">
<a href="/exam" class="btn btn-secondary">Back</a>
</div>





</div>



@endsection
