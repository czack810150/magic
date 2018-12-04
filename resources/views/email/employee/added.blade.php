@component('mail::message')
# 新员工加入！

{{$employee->cName}} {{ $employee->firstName }} {{ $employee->lastName }} has joined us!
<p>Location: {{ $employee->location->name }}</p>
<p>Position: {{ $employee->job->rank }}</p>
<p>Rate: ${{ $employee->rate->last()->pay()/100 }}/h</p>

@component('mail::button', ['url' => 'www.magicnoodleteam.com'])
View
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
