<h4>{{$location->name}} <span class="text-muted">{{$frequency}}</span></h4>

@if(count($periods))
<table class="table">
<thead>
<tr><th>Period</th><th>前厅</th><th>人数</th><th>厨工</th><th>人数</th><th>拉面师</th><th>人数</th><th>后厨Total</th><th>Store Total</th><th>Effective</th></tr>
</thead>
<tbody>
	@foreach($periods as $p)
<tr>
	<td>{{$p->start}} ~ {{$p->end}}</td>
	<td>{{round($p->frontHour,2)}}</td>
	<td>{{$p->frontCount}}</td>
	<td>{{round($p->backHour,2)}}</td>
	<td>{{$p->backCount}}</td>
	<td>{{round($p->noodleHour,2)}}</td>
	<td>{{$p->noodleCount}}</td>
	<td>{{ round($p->backHour+$p->noodleHour) }}</td>
	<td>{{ round($p->frontHour + $p->backHour + $p->noodleHour) }}</td>
	<td>{{ round($p->totalEffective) }}</td>

</tr>
	@endforeach

</tbody>
</table>
@else
<p class="m--font-secondary">No data available</p>
@endif