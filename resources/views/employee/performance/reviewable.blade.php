 
<div class="row">
<div class='col-12'>
<table class="table table-hover" id="app">
<thead>
	<tr>
		<th>Position</th><th>Employee</th><th>Actions</th><th>Card</th><th>Performance</th>
	</tr>
</thead>
<tbody>
	@foreach($employees as $e)
	<tr>
		@if( !is_null($e->employee) )
		<td>{{ $e->employee->job->rank }}</td>
		@else
		<td></td>
		@endif
		@if( !is_null($e->employee) )
		<td>{{ $e->employee->cName }} {{ $e->employee->firstName }},{{ $e->employee->lastName }}</td>
		@else
		<td>Shared Employee: {{ $e->employee_id }}</td>
		@endif
		<td>
			<button class="btn btn-primary btn-sm m-btn m-btn--custom" type="button" v-on:click="scoreEmployee('{{ $e->employee_id }}','')">Score</button> 
			<button class="btn btn-info btn-sm m-btn m-btn--custom" type="button" v-on:click="viewScore('{{ $e->employee_id }}')">View</button> 
		</td>
		@if( !is_null($e->employee) )
		<td>{{ $e->employee->employeeNumber }}</td>
		@else
		<td>Shared Employee</td>
		@endif
		<td>{{ $e->score }}</td>
		
		
	</tr>
	@endforeach

</tbody>
</table>
</div>
</div>



<!-- Modal -->
<div class="modal fade" id="scoreModal" tabindex="-1" role="dialog" aria-labelledby="scoreModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="scoreModalTitle">Employee Review</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div id="result" class="mb-2"></div>
        <div class="form-group">
        	<label for="reviewDate">For Date</label>
        	<input type="text" class="form-control" id="reviewDate">
        </div>

        <div class="row" id="app2">
        	<div class="col-4">
        	<ul class="nav flex-column">
        	@foreach($categories as $c)
  			<li class="mb-1">
   			 <button class="btn btn-primary" type="button" v-on:click="showItems({{$c->id}})">{{ $c->name }}</button>
  			</li>
  			@endforeach
			</ul>
        	</div>
        	<div class="col-8" id="items"></div>

        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
     
      </div>
    </div>
  </div>
</div>


<!-- Modal view score -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewModalTitle">Employee Evaluation Records</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="viewResult">
      	


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
     
      </div>
    </div>
  </div>
</div>



<script>
	$('#reviewDate').val(moment().format('YYYY-MM-DD'));
		$('#reviewDate').datepicker({
		format:'yyyy-mm-dd',
		todayHighlight: true,
		orientation: "bottom left",
		 templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
	});

var app = new Vue({
	el: '#app',
	data: {
		token: '{{ csrf_token() }}',
		employeeName: 'employee',
		employeeId: '',
		locationId: $("#location").val(),
	},
	methods: {
		scoreEmployee: function(employee_id,employee_name){
			this.employeeName = employee_name;
			this.employeeId = employee_id;
			$('#scoreModal').modal();
		},
		viewScore: function(employee_id){
			//alert("view: "+ employee_id + " period: " + $("#period").val() );
			$.post(
				'/score/view/employeePeriod',
				{
					_token: app.token,
					employee: employee_id,
					startDate: $("#period").val(),
					location: $("#location").val()
				},
				function(data,status){
					if(status == 'success'){
						$('#viewResult').html(data);
						$('#viewModal').modal();
					}
				}
				);
		}
		
	}
});

var app2 = new Vue({
	el:'#app2',
	methods: {
		showItems: function(categoryId){
			$.post(
				'/score/item/getItemsByCategory',
				{
					_token: app.token,
					category: categoryId,
				},
				function(data,status){
					if(status == 'success'){
						var html = '<ul class="list-unstyled">';
						for(var i in data){
							if(data[i].value >= 0){
								var buttonClass = 'btn btn-success';
							} else {
								var buttonClass = 'btn btn-danger';
							}
html += '<li class="mb-1"><button onclick="scoreItem(\''+data[i].id+'\')" type="button" class="'+ buttonClass +'">'+data[i].name+ ' '+ data[i].value +'</button></li>';
						}
						html += '</ul>';
						$('#items').html(html);
					}
				},
				'json'
				);
		},
	}
});

function scoreItem(itemId){
			$.post(
				'/employee/performance/store',
				{
					_token: app.token,
					employee: app.employeeId,
					item: itemId,
					location: app.locationId,
					reviewDate: $('#reviewDate').val()
				},
				function(data,status){
					if(status == 'success'){
						var html = '<div class="alert alert-success">'+ data.name+'</div>';
						$('#result').html(html);
						console.log(data);
					}
				},'json'
				);
		}

$('#scoreModal').on('hidden.bs.modal',function(e){
	$('#result').html('');
	$('#items').html('');
});
	</script>

