@extends('layouts.master')
@section('content')
<div class="container" id="app">
<input type="text" v-model="message">

<p v-on:click="pClick">@{{message}}</p>


<ul v-for="name in names" v-text="name">
</ul>

<input type="text" v-model="newName">
<button :class="success" @click="addName" v-bind:title="title">Add</button>

</div>

<script>
	let app = new Vue({
		el: '#app',
		data: {
			newName: '',
			message: 'Hello Vue!',
			names: ['Ichiro','Hiro','Tom','Bob'],
			title: 'Click to add name to list',
			success: 'btn btn-danger',
		},

		methods: {
			addName(){
				this.names.push(this.newName);
				this.newName = '';
				this.success='btn btn-success';
			},
			pClick() {
				alert('clicked');
			},

		},
	});
</script>

@endsection