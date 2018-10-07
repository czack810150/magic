<table class="table">
<thead>
	<tr><th>日期</th><th>Day</th><th>In</th><th>Out</th><th>记时</th>
</thead>
<tbody>
@foreach($clocks as $c)

@php
$in = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$c->clockIn);
$out = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$c->clockOut);
@endphp

<tr>
	<td>{{ $in->toDateString() }}</td>
	<td>{{ $in->format('l') }}</td>
	<td>{{ $in->toTimeString() }}</td><td>{{ $out->toTimeString() }}</td>
	<td>{{ round($in->diffInSeconds($out)/3600,2) }}</td>
</tr>
@endforeach

</tbody>
</table>