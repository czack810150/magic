@extends('layouts.master')
@section('content')

<div class="m-portlet" id="root">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Current Products Line
				</h3>
			</div>
		</div>
	
	</div>
	<div class="m-portlet__body">
	
		
		<table class="table table"  width="100%">
			<thead>
			<tr>
			<th style="width:12%">itemCode</th>
			<th style="width:12%">Category</th>
			<th style="width:12%">Name</th>
			<th style="width:12%">Price</th>
			
			</tr>
			</thead>
			<tbody>
			<tr v-for="i in items">
				<td>@{{i.itemCode}}</td>
				<td>
					<select class="custom-select m-input" v-model="i.itemCategory_id" @change="categorySelected(i)">
						<option v-for="c in categories" :value="c.id" v-text="c.cName" :selected="c.id == i.itemCategory_id? true:false"></option>
					</select>
				</td>
				<td>@{{i.name}}</td>
				<td>
					<input type="number" step="0.01" min="0" v-model="i.price" >
					<button class="btn btn-sm btn-warning" @click="updateItemPrice(i)">Update</button>
				</td>

			</tr>
			</tbody>
		</table>
	</div>
</div>		        
@endsection
@section('pageJS')
<script>
var app = new Vue({
	el: '#root',
	data:{
		token: '{{csrf_token()}}',
		categories : [
			@foreach($categories as $c)
			{
				id: {{$c->id}},
				name: '{{$c->name}}',
				cName: '{{$c->cName}}',
				description: '{{$c->description}}'
			},
			@endforeach
		],
		items:[
		@foreach($items as $i)
			{
				id: '{{$i->id}}',
				name: '{{$i->name}}',
				itemCode: '{{$i->itemCode}}',
				itemCategory_id : '{{$i->itemCategory_id}}',
				price: '{{$i->price}}',
			},
			@endforeach
		],
	},
	methods:{
		categorySelected(item){
			axios.post('product/'+item.id+'/update',{
				_token:this.token,
				category: item.itemCategory_id
			}).then(function(response){
				console.log(response.data)
			}).catch(function(error){
				console.log(error);
			});
		},
		updateItemPrice(item){
			axios.post('product/'+item.id+'/update',{
				_token:this.token,
				price: item.price,
			}).then(function(response){
				console.log(response.data)
			}).catch(function(error){
				console.log(error);
			});
		}
	}
})

</script>
@endsection