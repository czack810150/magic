<div class="m-portlet m-form" id="createShiftDialog">

			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Create Shift for <span id="newShiftEmployee"></span>
						</h3>
					</div>			
				</div>
			</div>
			
				<div class="m-portlet__body ">	
					<div class="form-group m-form__group row">
						 <label for="shiftDate" class="col-12 form-control-label"><i class="fa  fa-calendar-o"></i>&nbsp;&nbsp;Date&emsp;<span id="shiftDate"></span></label>
					</div>

					<div class="form-group m-form__group  row">
					  	<label class="col-form-label col-4" for="roleOptions"><i class="fa  fa-rocket"></i>&nbsp;&nbsp;Role</label>
					  	<div class="col-8" id="roleOptions"></div>
					</div>


					<div class="form-group m-form__group has-danger row">
					  	<label for="shiftTime" class="col-4 col-form-label"><i class="fa  fa-clock-o"></i>&nbsp&nbspTime</label>
					  	<div class="col-8">
						  	<input type="text" class="form-control form-control-danger m-input" id="shiftTime" name="shiftTime" autofocus>
						  	<div class="form-control-feedback" id="form-control-feedback"></div>
						  	<span class="m-form__help">e.g 9am - 5pm</span>
					  	</div>
					</div>

					<div class="form-group m-form__group row">
						<div class="col-12">
							<textarea rows="3" class="form-control" placeholder="Notes" id="newShiftNote" name="newShiftNote"></textarea>
						</div>
					</div>
	            </div>
	          	<div class="m-portlet__foot m-portlet__foot--fit">
				<div class="m-form__actions">
					<div class="row">
						<div class="col-2"></div>
						<div class="col-10">
							<button id="createBtn" type="button" class="btn btn-success">Add</button>
							<button id="createCancel" type="button" class="btn btn-secondary">Cancel</button>
						</div>
					</div>
				</div>
				</div>
	     
			
</div>
