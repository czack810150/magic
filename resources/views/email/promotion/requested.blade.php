@component('mail::message')
# New Promotion request


{{$promotion->employee->name}} has requested to work in {{$promotion->newLocation->name}} as {{$promotion->newJob->rank}}.


@component('mail::button', ['url' => url('promotion/view')])
View
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
