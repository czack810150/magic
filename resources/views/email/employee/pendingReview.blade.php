@component('mail::message')
#Employees Pending Appraisals

@component('mail::table')
| Name | Card | Location | Current Job | Hours | Last review date | Days|
| :------- |:-------| :-------| :----- |:-------| :-----| :------- |:-----| 
@foreach($pendings as $p)
| {{$p->name}} | {{$p->employeeNumber}} | {{$p->location->name}}| {{$p->job->rank}}|{{$p->effectiveHours}}| @if(count($p->job_location)){{$p->job_location->last()->review->copy()->subDays(180)->toFormattedDateString()}}|{{Carbon\Carbon::now()->diffInDays($p->job_location->last()->review->subDays(180))}}|@else |{{$p->hired->toFormattedDateString()}} (Date Hired)|{{Carbon\Carbon::now()->diffInDays($p->hired)}}|@endif


@endforeach
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
