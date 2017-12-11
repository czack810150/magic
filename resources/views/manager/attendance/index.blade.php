@extends('layouts.master')
@section('content')

@foreach($managers as $m)
<p>{{ $m->cName }}</p>
@endforeach

@endsection