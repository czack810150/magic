<div id="copyScheduleDialog" class="m-portlet m-form">

  <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">
              Copy Shifts
            </h3>
          </div>      
        </div>
  </div>

  <div class="m-portlet__body">

    <h5>Copy shifts into the current timeline:</h5>
    <p id="currentTimeline"></p>

<div class="form-group row">
 <label for="copyFrom" class="col-sm-2 col-form-label">From</label>
 <div class="col-sm-4">
  <input type="text" class="form-control form-control-sm" id="copyFrom" name="copyFrom" tabindex="-1">
 </div>
 <div class="col-sm-1"> - </div>
  <div class="col-sm-4">
  <input type="text" class="form-control form-control-sm" id="copyTo" name="copyTo" disabled>
 </div>
</div>



</div>
<div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
          <div class="row">
            <div class="col-2"></div>
            <div class="col-10">
              <button id="copyBtn" type="button" class="btn btn-success">Copy Shifts</button>
              <button id="copyCancel" type="button" class="btn btn-secondary">Cancel</button>
            </div>
          </div>
        </div>
        </div>


</div> 