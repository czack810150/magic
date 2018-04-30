@component('mail::message')
# Leave Request

A new ({{$leave->type->cName}}) leave has been requested by {{$leave->employee->cName}} of {{$leave->employee->location->name}} Location.


@component('mail::table')
| From      | To         | Comment  |
| ------------- |:-------------:| --------:|
| {{$leave->from->toFormattedDateString()}}      | {{$leave->to->toFormattedDateString()}}      | {{$leave->comment?$leave->comment:'No comment'}}     |

@endcomponent


@component('mail::button', ['url' => url('leave')])
View
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
