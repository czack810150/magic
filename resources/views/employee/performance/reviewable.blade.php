<table class="table">
<thead>
</thead>
<tbody>
@foreach($employees as $e)

<tr><td>{{ $e->cName }}</td><td>{{ $e->id }}</td>
<td>{{ $e->location }}</td> 
 </tr>

@endforeach
</tbody>
</table>