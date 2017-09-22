@if(isset($locations))
<select name="locationFilter" id="locationFilter" class="form-control">
	@foreach($locations as $location)
		<option value="{{ $location->id }}">{{ $location->name }}</option>
	@endforeach
</select>
@endif