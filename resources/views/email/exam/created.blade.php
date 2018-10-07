@component('mail::message')
# 晋级考试

<p>Promotional Exam <strong>{{$exam->name}}</strong> has been created for {{$exam->employee->name}} of {{$exam->employee->location->name}} Location.</p>



Thanks,<br>
{{ config('app.name') }}
@endcomponent
