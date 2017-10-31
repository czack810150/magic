
<h2>Reviewables</h2>
<section id="app">
<div class="row">
<div class='col-sm-6'>
<table class="table table-hover" >
<thead>
	<tr>
		<th>Position</th><th>Employee</th><th>Card</th><th>Performance</th>
	</tr>
</thead>
<tbody>
	@foreach($employees as $e)
	<tr v-on:click="scoreEmployee('{{ $e->id }}','{{ $e->cName }}')">
		<td>{{ $e->job->rank }}</td>
		<td>{{ $e->cName }} {{ $e->firstName }},{{ $e->lastName }}</td>
		<td>{{ $e->employeeNumber }}</td>
		<td>{{ $e->score }}</td>
		
	</tr>
	@endforeach

</tbody>
</table>
</div>
</div>



<!-- Modal -->
<div class="modal fade" id="scoreModal" tabindex="-1" role="dialog" aria-labelledby="scoreModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="scoreModalTitle">Employee Review for @{{employeeName}} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div id="result" class="mb-2"></div>
        <div class="form-group">
        	<label for="reviewDate">For Date</label>
        	<input type="text" class="form-input" v-model="reviewDate" id="reviewDate">
        </div>

        <div class="row">
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
</section>


<script>
//$('#reviewDate').datepicker();

var app = new Vue({
	el: '#app',
	data: {
		token: '{{ csrf_token() }}',
		message:'vue',
		reviewDate:moment().format('YYYY-MM-DD'),
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
		showItems: function(categoryId){
			$.post(
				'/score/item/getItemsByCategory',
				{
					_token: this.token,
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
					reviewDate: app.reviewDate,
					employee: app.employeeId,
					item: itemId,
					location: app.locationId,
				},
				function(data,status){
					if(status == 'success'){
						var html = '<div class="alert alert-success">'+ data.name+'</div>';
						$('#result').html(html);
						console.log(data.name);
					}
				},'json'
				);
		}

$('#scoreModal').on('hidden.bs.modal',function(e){
	$('#result').html('');
	$('#items').html('');
});
	</script>

