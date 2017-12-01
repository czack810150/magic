@extends('layouts.master')
@section('content')

 <!--begin::Portlet-->
<div class="m-portlet">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Message to Management
				</h3>
			</div>
		</div>
	</div>
	<!--begin::Form-->
	<form class="m-form m-form--fit m-form--label-align-right">
		<div class="m-portlet__body">

			<div class="form-group m-form__group col-lg-9 col-md-9 col-sm-12">
						<label for="subject">Subject 标题</label>
						<input type="text" class="form-control m-input" id="subject" name="subject" placeholder="">
					</div>


			<div class="form-group m-form__group row">
				
				<div class="col-lg-9 col-md-9 col-sm-12">
					<div class="summernote" id="summernote"></div>
				</div>
			</div>
			
		</div>

		<div class="m-form__group form-group">
										<label for="">写给谁看？</label>
										<div class="m-checkbox-inline">
											<label class="m-checkbox">
											<input type="checkbox" name="gm"> 总经理
											<span></span>
											</label>
											<label class="m-checkbox">
											<input type="checkbox" name="dm"> 区域经理
											<span></span>
											</label>
										</div>
										<span class="m-form__help">可以单选或者多选</span>
									</div>

		<div class="m-portlet__foot m-portlet__foot--fit">
			<div class="m-form__actions m-form__actions">
				<div class="row">
					<div class="col-lg-9 ml-lg-auto">
						<button type="reset" class="btn btn-brand" onclick="submitMessage()">Submit</button>
						<button type="reset" class="btn btn-secondary" onclick="resetMessage()">Reset</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!--end::Form-->
</div>
<!--end::Portlet-->
@endsection
@section('pageJS')
<script src="{{ asset('assets/demo/default/custom/components/forms/widgets/summernote.js') }}"></script>
<script>
$('#summernote').summernote({
	height:300,
	minHeight:null,
	maxHeight:null,
	focus:true,
	  toolbar: [
    // [groupName, [list of button]]
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']]
  ] 
});

function submitMessage(){
	
	if(!$('#summernote').summernote('isEmpty')){
		var markupStr = $('#summernote').summernote('code');
		var gm = false;
		var dm = false;
		if($('input[name=gm]').is(':checked')){
			gm = true;
		}
		if($('input[name=dm]').is(':checked')){
			dm = true;
		}
		if(gm == false && dm == false){
			alert('请至少选则一个收件人.');
			return 1;
		}
		
		$.post(
			'/message/management/send',
			{
				_token: '{{ csrf_token() }}',
				message: markupStr,
				gm: gm,
				dm: dm,
				subject: $("#subject").val(),
			},
			function(data,status){
				if(status == 'success'){
					window.location.replace(data);
				}
			}
			);
	}
	
}

function resetMessage(){
	$('#summernote').summernote('reset');
}

</script>
@endsection
