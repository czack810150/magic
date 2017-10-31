@extends('layouts.master')
@section('content')
<div class="container" id="app">

<h3>All bikes</h3>
<ul class="list-unstyled">
	<bikes></bikes>
</ul>

<h3>Japanese bikes</h3>
<ul class="list-unstyled">
	<li v-for="bike in japBikes" v-text="bike.brand"></li>
</ul>



</div>

<script>

	Vue.component('bikes',{
		template: '<div><bike-list v-for="bike in bikes">@{{ bike.brand }}</bike-list></div>',
		data() {
			return {bikes: [
				{ brand: 'Honda', country: 'Japan'},
				{ brand: 'Yamaha', country: 'Japan'},
				{ brand: 'BMW', country: 'Germany'},
			]
			};
		}
	});

	Vue.component('bike-list',{
		template: '<li><span class="badge badge-success"><slot></slot><span></li>'
	});


	var app = new Vue({
		el: '#app',
		data: {
			message: 'Hello World!',
			bikes: [
				{ brand: 'Honda', country: 'Japan'},
				{ brand: 'Yamaha', country: 'Japan'},
				{ brand: 'BMW', country: 'Germany'},
			]
		},

		computed: {
			japBikes(){
				return this.bikes.filter(bike => bike.country=='Japan');
			}
		}

		

	});

	

</script>

@endsection