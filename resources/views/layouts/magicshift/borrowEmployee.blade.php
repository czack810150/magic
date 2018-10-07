   		<div class="m-portlet m-form" id="borrowDialog">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Borrow Employee <small>Employees from other locations</small>
						</h3>
					</div>			
				</div>
			</div>
			<div class="m-portlet__body">
				
				<div class="form-group m-form__group row">
					<label class="col-form-label col-3">Location</label>
					<div class="col-9">
				{{ Form::select('otherlocation',$otherStores,null,['class'=>'selectpicker','id'=>'otherLocation','placeholder'=>'Choose Location'])}}
					</div>
				</div>

				<div class="form-group m-form__group row" id="positionSelect">
					<label class="col-form-label col-3">Position</label>
					<div class="col-9">
				{{ Form::select('borrowPosition',$positions,null,['class'=>'selectpicker','id'=>'borrowPosition','placeholder'=>'Choose Position'])}}
					</div>
				</div>

				<div class="form-group m-form__group row">
					<label class="col-form-label col-3">Employee</label>
					<div class="col-9" id="availables">
				
					</div>
				</div>





			</div>

			<div class="m-portlet__foot m-portlet__foot--fit">
				<div class="m-form__actions">
					<div class="row">
						<div class="col-2"></div>
						<div class="col-10">
							<button id="borrowBtn" type="button" class="btn btn-success">Borrow</button>
							<button id="borrowCancel" type="button" class="btn btn-secondary">Cancel</button>
						</div>
					</div>
				</div>
			</div>


		</div>