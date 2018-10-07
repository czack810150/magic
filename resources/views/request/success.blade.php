@extends('layouts.master')
@section('content')



					<div class="m-alert m-alert--icon m-alert--outline alert alert-success alert-dismissible fade show" role="alert">
					<div class="m-alert__icon">
						<i class="la la-check-circle"></i>
					</div>
					<div class="m-alert__text">
             			<strong>Success!</strong>	{{ $message }}
					</div>	
					</div>

@endsection