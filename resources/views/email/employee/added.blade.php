@component('mail::message')
# New employee

{{$employee->cName}} has joined us!

@component('mail::button', ['url' => 'www.magicnoodleteam.com'])
View
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
