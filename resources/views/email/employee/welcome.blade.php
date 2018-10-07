@component('mail::message')
# Welcome aborad!

<p>Hello, {{$employee->name}}! </p>
<p>We are thrilled to have you joined us at Magic Noodle!</p>
<p>Please click the button below to verify your email address {{$employee->email}} is correct.</p>

@component('mail::button', ['url' => url("email/$token/confirm/")])
Confirm
@endcomponent

Thanks,<br>
Magic Noodle Inc.
@endcomponent
