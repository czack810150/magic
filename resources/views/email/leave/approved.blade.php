@component('mail::message')
# Leave Request Approved

Your {{$leave->type->cName}} leave request for {{ $leave->from->toFormattedDateString() }} - {{ $leave->to->toFormattedDateString() }} has been approved.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
