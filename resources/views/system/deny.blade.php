@extends('layouts.master')
@section('content')
<div class="row">
	<div class="col-6">
		<div class="m-alert m-alert--icon alert alert-danger" role="alert">
			<div class="m-alert__icon">
				<i class="flaticon-danger"></i>
			</div>
			<div class="m-alert__text">
		<strong>Sorry!</strong> You are not authorized to view this information.
		</div>
		<!-- <div class="m-alert__actions" style="width:220px;">
			<button type="button" class="btn btn-outline-light btn-sm m-btn--hover-brand" data-dismiss="alert1" aria-label="Close">Dismiss</button>
		</div> -->
		</div>
	</div>
</div>

@endsection