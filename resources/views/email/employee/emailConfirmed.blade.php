@component('mail::message')
# Thank you!

Your email has been confirmed.
<p>Now, you can log into your MagicShift account with following credentials.</p>
<ul>
	<li>User Name: {{$user->email}}</li>
	<li>Password: {{$user->temp_pass}}</li>
</ul>
@component('mail::button', ['url' => url('login')])
Log in
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
