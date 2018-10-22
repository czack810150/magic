@component('mail::message')
# 以下 {{ count($employees) }} 位员工已完成试用期180小时

@foreach($employees as $e)
{{ $e->name }}, {{$e->location->name}}, Joined since {{$e->hired->toDateString()}}, 有效工时 {{$e->effectiveHours}}

@endforeach


Thanks,<br>
{{ config('app.name') }}
@endcomponent
