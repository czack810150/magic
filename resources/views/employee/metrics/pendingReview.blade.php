@extends('layouts.master')
@section('content')
@if(count($pendings))
    <table class="table">
        <tr><th>Name</th><th>Card</th><th>Location</th><th>Current Job</th><th>Hours</th><th>Reviewable</th><th>Last review date</th><th>Days</th></tr>
        @foreach($pendings as $p)
            <tr>
                <td>{{$p->name}}</td>
                <td>{{$p->employeeNumber}}</td>
                <td>{{$p->location->name}}</td>
                <td>{{$p->job->rank}}</td>
                <td>{{$p->effectiveHours}}</td>
                <td>@if($p->reviewable)<span class="m--font-success">Yes</span>@else<span class="m--font-danger">No</span>@endif</td>
                @if(count($p->job_location))
                <td>{{$p->job_location->last()->review->toFormattedDateString()}}</td>
                 <td>{{Carbon\Carbon::now()->diffInDays($p->job_location->last()->review)}}</td>
                @else
                <td>
                    {{$p->hired->toFormattedDateString()}} (Date Hired)
                </td>
                 <td>{{Carbon\Carbon::now()->diffInDays($p->hired)}}</td>
                @endif
              

            </tr>
        @endforeach
    </table>
@endif
@endsection
