@component('mail::message')
# Employee {{$employee->name}} has been assigned {{count($shifts)}} shifts between {{$start}} and {{$end}} at {{$location->name}}

<ul>
@foreach($shifts as $s)
    
<li>{{$s->role->c_name}}, start: {{$s->start}}, end: {{$s->end}} {{$s->duty?$s->duty->cName:''}}</li>
   
@endforeach
</ul>



Thanks,<br>
{{ config('app.name') }}
@endcomponent
