@component('mail::message')
# Introduction

{{$promotion->employee->name}}'s promotion application as {{$promotion->newJob->rank}} has been denied... 

@component('mail::button', ['url' => url('promotion/view')])
View
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
