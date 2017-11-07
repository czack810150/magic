@if(count($result))

<table class="table table-hover">
<thead>
	<tr>
		<th>Date</th><th>Location</th><th>Category</th><th>Item</th><th>Result</th><th>Action</th>
	</tr>
</thead>
<tbody>
	@foreach($result as $r)
	<tr>
		<td>{{ $r->date }}</td>
		<td>{{ $r->location->name }}</td>
		<td>{{ $r->score_item->score_category->name }}</td>
		<td>{{ $r->score_item->name }}</td>
		<td>{{ $r->value }}</td>
		<td>
			<button class="btn btn-danger btn-sm m-btn m-btn--custom" type="button" onclick="removeScoreItem('{{ $r->id }}')">Remove</button>
		</td>
		
	</tr>
	@endforeach

</tbody>

@else
<p>No Evalutation Items for the selected period.</p>
@endif

<script>

function removeScoreItem(itemId)
{
	$.post(
				'/score/remove',
				{
					_token: '{{ csrf_token() }}',
					logId: itemId
				},
				function(data,status){
					if(status == 'success'){
						console.log(data);
						$('#viewModal').modal('hide');
					}
				}
				);
}

	</script>