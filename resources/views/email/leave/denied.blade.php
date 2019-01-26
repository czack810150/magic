@component('mail::message')
# Leave request denied

{{ $leave->employee->name }} {{ $leave->employee->employeeNumber }} of {{ $leave->location->name }} {{$leave->type->cName}} leave request for {{ $leave->from->toFormattedDateString() }} - {{ $leave->to->toFormattedDateString() }} has been denied.

@if(!empty($leave->comment))
<p>Message: {{ $leave->comment }}</p>
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
