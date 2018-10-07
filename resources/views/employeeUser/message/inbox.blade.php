@extends('layouts.master')
@section('content')

 <!--begin::Portlet-->
<div class="m-portlet">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Messages 
				</h3>
			</div>
		</div>
	</div>
	<!--begin::Form-->
	
		<div class="m-portlet__body">
			@if(sizeof($employee->message))
			<table class="table table-hover table-responsive">
				<thead  ><tr><th style="min-width:120px;">Location</th><th style="min-width:120px">Position</th><th>Sender</th><th>Subject</th><th>Status</th><th>Content</th><th>Date</th></tr></thead>
				<tbody>
					@foreach($employee->message as $m)
					
					<tr onclick="viewMessage('{{ $m->message_id }}',{{ $m->id }})">
						<td>{{ $m->message->employee->location->name }}</td>
						<td>{{ $m->message->employee->job->rank }}</td>
						<td>{{ $m->message->employee->cName }}</td>
						<td>{{ $m->message->subject }}</td>
						@if($m->read)
						<td><span class="badge badge-pill badge-primary">Read</span></td>
						@else
						<td><span class="badge badge-pill badge-danger">New</span></td>
						@endif
						<td style="overflow:hidden;white-space:nowrap;max-width:500px">{{$m->message->body}}</td>
						<td>{{ $m->message->created_at->toFormattedDateString() }}</td>
					</tr>
				@endforeach
					
				</tbody>
			</table>
				
			@else
			<p>There are no messages</p>
			@endif
				

		

	</div>

</div>
<!--end::Portlet-->


<!-- Message modal -->
<div class="modal fade bd-example-modal-lg" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
         <div class="modal-header">
        <h5 class="modal-title" id="messageModalLabel">Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       	<div class="row">
       		<div class="col-12">
       			<p>by <span id="author"></span>, <span id="sendDate"></span></p>
       			<input type="text" id="mail_id" hidden>
       		</div>
       	</div>
       	<div id="messageBody">
       	</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="markRead()">Mark as Read</button>
      </div>
    </div>
  </div>
</div>


<script>
function viewMessage(message,mail_id){
	
	$.post(
		'/message/management/message/'+ message + '/show',
		{
			_token: '{{ csrf_token() }}',
			message: message,
		},
		function(data,status){
			if(status == 'success'){
				$('#mail_id').val(mail_id);
				$('#messageModalLabel').html(data.subject);
				$('#author').html(data.employee.cName);
				$('#sendDate').html(data.updated_at);
				$('#messageBody').html(data.body);
				$('#messageModal').modal();
			}
		},'json'
		);
}

function markRead(){
 	const mail_id = $('#mail_id').val();
 	$.post(
 		'/message/management/message/' + mail_id + '/read',
 		{
 			_token: '{{ csrf_token() }}',
 		},
 		function(data,status){
 			if(status == 'success'){
 				$('#messageModal').modal('hide');
 				if(data == 'read'){
 					location.reload();
 				}
 			}
 		}
 		);
}
</script>
@endsection
