@component('mail::message')
# Promotional Exam has been submitted

{{$exam->employee->location->name}} {{$exam->employee->name}}'s {{$exam->name}} has been submitted!


Thanks,<br>
{{ config('app.name') }}
@endcomponent
