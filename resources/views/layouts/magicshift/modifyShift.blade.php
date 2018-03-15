<div id="modifyShiftDialog" class="m-portlet m-form">

  <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">
              Modify Shift <small>Edit or Remove</small>
            </h3>
          </div>      
        </div>
  </div>

  <div class="m-portlet__body">

<div class="form-group row">
 <label for="startDate" class="col-sm-2 col-form-label"><i class="fa  fa-calendar-o"></i>&nbsp&nbspDate</label>
 <div class="col-sm-4">
  <input type="text" class="form-control form-control-sm" id="startDate" name="startDate">
 </div>
 <div class="col-sm-1"> - </div>
  <div class="col-sm-4">
  <input type="text" class="form-control form-control-sm" id="endDate" name="endDate">
 </div>
</div>

<div class="form-group row">
 <label for="startTime" class="col-sm-2 col-form-label"><i class="fa  fa-clock-o"></i>&nbsp&nbspTime</label>
 <div class="col-sm-3">
  <input type="text" class="form-control form-control-sm" id="startTime" name="startTime">
 </div>
 <div class="col-sm-1"> - </div>
  <div class="col-sm-3">
  <input type="text" class="form-control form-control-sm" id="endTime" name="endTime">
 </div>
</div>

<div class="form-group m-form__group  row">
              <label class="col-form-label col-4" for="roleOptions"><i class="fa  fa-rocket"></i>&nbsp;&nbsp;Role</label>
              <div class="col-8">
              {{ Form::select('modifyRole',$roles,null,['id'=>'modifyRole','class'=>'form-control m-input']) }}
              </div>
</div>

<div class="form-group m-form__group  row">
              <label class="col-form-label col-4" for="modifyDutyOptions"><i class="fa  fa-puzzle-piece"></i>&nbsp;&nbsp;Duty</label>
              <div class="col-8" id="dutyOptions">
                {{ Form::select('modifyDuty',$duties,null,['class'=>'form-control','placeholder'=>'No Assigned Duty','id'=>'modifyDuty']) }}
              </div>
</div>


<div class="row mb-3">
<div class="col-12">
<textarea rows="3" class="form-control" placeholder="Notes" id="shiftNote" name="shiftNote" autofocus></textarea>
</div>
</div>

<div class="form-group row m-form">
	<label class="col-form-label col-2 ">Remove</label>
				<div class="col-3 ">
							<div id="removeSlider" class="m-nouislider m-nouislider--handle-danger"></div>
					<span class="m-form__help">Slide to confirm</span>
				</div>
</div>


</div>
<div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
          <div class="row">
            <div class="col-2"></div>
            <div class="col-10">
              <button id="modifyBtn" type="button" class="btn btn-success">Save & Close</button>
              <button id="modifyCancel" type="button" class="btn btn-secondary">Cancel</button>
            </div>
          </div>
        </div>
        </div>


</div> 