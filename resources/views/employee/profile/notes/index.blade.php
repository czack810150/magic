<!--begin::Portlet-->
<div class="m-portlet">
<div id="employeeNotes">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												
												<h3 class="m-portlet__head-text">
													Write down private notes about this employee.
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
													<button class="btn btn-sm btn-primary m-btn m-btn--icon" data-toggle="modal" data-target="#newNoteModal">
														<span><i class="la la-plus"></i>
														<span>Add Note</span>
														</span>
													</button>
												</li>
											</ul>
										</div>
									</div>
<div class="m-portlet__body">
@if(sizeof($notes))
<table class="table">
<thead>
<tr><th>Date Modified</th><th>Note</th><th>Last Edited By</th><th>Visibility</th><th>Actions</th><tr>
</thead>
<tbody>
	@foreach($notes as $n)
		@if($n->visibility <= $user->authorization->level)
	<tr>
		<td>{{ $n->updated_at->toFormattedDateString() }}</td>
		<td>{{ $n->note }}</td>
		<td>{{ $n->author }}</td>
		@if($n->visibility == 99)
		<td>Admins Only</td>
		@else
		<td> Admins and Managers</td>
		@endif
		
		<td>
			<button type="button" class="btn btn-secondary m-btn m-btn--icon m-btn--icon-only" onclick="editNote('{{ $n->id }}')"><i class="fa flaticon-edit-1"></i></button>
			<button type="button" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only" onclick="tryRemoveNote('{{ $n->id }}')"><i class="fa flaticon-circle"></i></button>
		</td>
	</tr>
		@endif
	@endforeach
</tbody>
</table>
@else
<p>No notes found</p>
@endif
</div><!-- m-portlet__body -->

</div><!-- end of employeeNotes -->																	
</div>
<!--end::Portlet-->



<!--  new note Modal -->
<div class="modal fade" id="newNoteModal" tabindex="-1" role="dialog" aria-labelledby="newNoteModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newNoteModalLabel"><i class="la la-sticky-note"></i>Create Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--begin::Form-->
			<form class="m-form">
				<div class="m-portlet__body">	
					<div class="m-form__section m-form__section--first">
						<div class="form-group m-form__group row">
							<label class="col-4 col-form-label">Note</label>
							<div class="col-8">
								<textarea name="note" class="form-control m-input" placeholder="Note (Max. 255 characters)" rows="10"></textarea>
								
							</div>
						</div>
						
											
						<div class="m-form__group form-group row">
							<label class="col-4 col-form-label">Who can see this?</label>
							<div class="col-8">
								<div class="m-form__group form-group row">
										<div class="">
											<div class="m-radio-list">
												<label class="m-radio">
												<input type="radio" name="visibility" value="99"> Admins only
												<span></span>
												</label>
												<label class="m-radio">
												<input type="radio" name="visibility" value="20"> Admins and managers
												<span></span>
												</label>
											</div>
											<span class="m-form__help">The note will be visible to the roles specified above.</span>
										</div>
		                   </div>
		                </div>
		            </div>
	            </div>
	           </div>
			</form>
			<!--end::Form-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveNote('{{ $employee->id }}')">Save</button>
      </div>
    </div>
  </div>
</div>

<!--  edit note Modal -->
<div class="modal fade" id="editNoteModal" tabindex="-1" role="dialog" aria-labelledby="editNoteModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editNoteModalLabel"><span><i class="la la-sticky-note"></i><span>Edit Note</h5></span></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--begin::Form-->
			<form class="m-form">
				<div class="m-portlet__body">	
					<div class="m-form__section m-form__section--first">
						<div class="form-group m-form__group row">
							<label class="col-4 col-form-label">Note</label>
							<div class="col-8">
								<textarea name="editNote" class="form-control m-input" rows="10" id="editNote" required></textarea>
								
							</div>
						</div>
						
											
						<div class="m-form__group form-group row">
							<label class="col-4 col-form-label">Who can see this?</label>
							<div class="col-8">
								<div class="m-form__group form-group row">
										<div>
											<div class="m-radio-list">
												<label class="m-radio">
												<input type="radio" name="editVisibility" value="99"> Admins only
												<span></span>
												</label>
												<label class="m-radio">
												<input type="radio" name="editVisibility" value="20"> Admins and managers
												<span></span>
												</label>
											</div>
											<span class="m-form__help">The note will be visible to the roles specified above.</span>
										</div>
		                  		</div>
		                	</div>
		            </div>
	            </div>
	           </div>
			</form>
			<!--end::Form-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateNote('{{ $employee->id }}')">Save</button>
      </div>
    </div>
  </div>
</div>


<!-- remove confirm Modal -->
<div class="modal fade" id="removeNoteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="removeNoteConfirmationModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="removeNoteConfirmationModalLabel"><i class="fa fa-close"></i>Delete Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       Do you really want to delete this note? This cannot be undone.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" onclick="deleteNote()">Delete</button>
      </div>
    </div>
  </div>
</div>