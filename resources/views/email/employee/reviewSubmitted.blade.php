@component('mail::message')
# Review Submitted
{{$review->employee->location->name}}的员工<strong>{{$review->employee->name}}</strong>的考核已被{{$review->manager->name}}提交。
请予以关注。
<p>
考核结果为: {{ $review->description }}
</p>
<p>
表现得分: {{$review->performance}}
</p>
<p>
店长评分: {{$review->manager_score}}
</p>
<p>
员工自评: {{$review->self_score}}
</p>
<p>
店长评语: {{$review->manager_note}}
</p>
<p>
员工自评语: {{$review->self_note}}
</p>



Thanks,<br>
{{ config('app.name') }}
@endcomponent
