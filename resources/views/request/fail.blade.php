@extends('layouts.master')
@section('content')
					<div class="m-alert m-alert--icon m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
					<div class="m-alert__icon">
						<i class="la la-close"></i>
					</div>
					<div class="m-alert__text">
             			<strong>Something wrong...</strong>	{{ $message }}
					</div>	
					</div>
@endsection