@component('mail::message')
# Employee termination notification

{{ $employee->name }} {{ $employee->employeeNumber }} of {{ $employee->location->name }} is now terminated effectively immidiately.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
