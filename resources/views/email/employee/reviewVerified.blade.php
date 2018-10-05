@component('mail::message')
# 员工考核被批准

{{$review->employee->name}}的考核成绩"{{$review->description}}"被正式批准！
<p>
	下次考核日期为 {{$review->nextReview}}
	</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
