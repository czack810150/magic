@component('mail::message')
# Leave Request Denied

Your {{$leave->type->cName}} leave request for {{ $leave->from->toFormattedDateString() }} - {{ $leave->to->toFormattedDateString() }} has been denied.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
