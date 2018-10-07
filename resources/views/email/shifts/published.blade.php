@component('mail::message')
# {{$manager->location->name}} 排班发布了

{{$manager->location->name}} {{$manager->job->rank}} {{$manager->name}} 发布了该单位
{{$start}} 到
{{$end}}之间的{{$count}}个排班。

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent
