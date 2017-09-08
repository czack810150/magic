@if(count($errors))
<div class="form-group">
<div class="alert alert-danger" role="alert">
<ul>
	@foreach($errors->all() as $e)
		<li>{{$e}}</li>
	@endforeach
</ul>
</div>
</div>
@endif