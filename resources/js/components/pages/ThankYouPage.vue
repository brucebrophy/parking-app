<template>
	<div class="container">
		<div class="col-md-6 offset-md-3">
			<div class="card text-center mt-5 mb-5">
				<div class="card-header text-white bg-dark py-3">
					<h5 class="mb-0">Thank You!</h5>
				</div>
				<div class="card-body">
					<h5 class="card-title">Your ticket is now valid!</h5>
					
					<router-link :class="'btn btn-primary d-block w-50 mx-auto mt-3'" :to="{ name: 'ticket-page' }">Go Back</router-link>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	mounted() {
		//
	},
	data() {
		return {
			//
		};
	},
	methods: {
		//
	}
};
</script>

