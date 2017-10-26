@extends('layouts.master')
@section('content')
<div class="container" id="app">

<ol>
	<todo-item v-for="item in groceryList" v-bind:todo="item" v-bind:key="item.id"></todo-item>

</ol>


</div>

<script>
Vue.component('todo-item',{
		props: ['todo'],
		template: '<li>@{{ todo.text }}</li>'
	})

	var app = new Vue({
		el: '#app',
		data: {
			groceryList: [
				{ id: 0, text: 'Vegetables' },
				{ id: 1, text: 'Cheese' },
				{ id: 2, text: 'Whatever else humans are supposed to eat' },
			]
		},
		beforeCreate: function(){
			console.log('before create')
		},
		created: function(){
			console.log(this.groceryList)
		}

	});

	

</script>

@endsection