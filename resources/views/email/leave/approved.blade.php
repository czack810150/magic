@component('mail::message')
# Leave request approved

{{ $leave->employee->name }} {{ $leave->employee->employeeNumber }} of {{ $leave->location->name }} {{$leave->type->cName}} leave request for {{ $leave->from->toFormattedDateString() }} - {{ $leave->to->toFormattedDateString() }} has been approved by {{ $leave->approvedBy->name }}.

@if(!empty($leave->comment))
<p>Message: {{ $leave->comment }}</p>
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
