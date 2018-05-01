@component('mail::message')
# Promotion Approved

{{$promotion->employee->name}}'s promotion application as {{$promotion->newJob->rank}} has been approved! 

@component('mail::button', ['url' => url('promotion/view')])
View
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
