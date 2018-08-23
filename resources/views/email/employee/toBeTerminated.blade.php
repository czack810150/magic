@component('mail::message')

{{$employee->location->name}} employee 
<p>{{$employee->name}} {{$employee->employeeNumber}} is leaving us on {{$employee->termination->toFormattedDateString()}}.</p>
<p>{{$employee->name}} joined us since {{$employee->hired->toFormattedDateString()}}. And has worked for us about {{$employee->hours->sum(function($hour){return $hour->wk1Effective + $hour->wk2Effective + $hour->wk1EffectiveCash + $hour->wk2EffectiveCash;})}} hours.</p> 

Good Bye! 

Thanks,<br>
{{ config('app.name') }}
@endcomponent
