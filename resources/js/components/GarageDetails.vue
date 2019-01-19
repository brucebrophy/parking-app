<template>
	<div class="container">
		<!-- Show the garage details right here -->
	</div>
</template>

<script>
export default {
	mounted() {
		this.getGarageDetails();
	},
	data() {
		return {
			availableSpots: null,
			occupiedSpots: null,
			totalSpots: null
		};
	},
	methods: {
		getGarageDetails() {
			// this is hard-coded for now, but this could change if the application grows
			axios
				.get("/api/garages/1")
				.then(result => {
					this.availableSpots = result.data.garage.available_spots;
					this.occupiedSpots = result.data.garage.occupied_spots;
					this.totalSpots = result.data.garage.total_spots;
				})
				.catch(err => {
					console.log(err);
				});
		}
	}
};
</script>

