<template>
	<div>
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<div class="d-flex justify-content-center align-items-center align py-3">
						<h4 class="display-5 mb-0">
							<i class="fas fa-parking"></i> Parking Details
						</h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="d-flex justify-content-center py-3">
						<span class="status-indicator status-good">{{ totalSpots }} Total Spots</span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="d-flex justify-content-center py-3">
						<span class="status-indicator" :class="{ 'status-good' : availableSpots >= 10 , 'status-okay' : availableSpots >= 5, 'status-bad' : availableSpots < 5,  }">{{ availableSpots }} Available Spots</span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="d-flex justify-content-center py-3">
						<span class="status-indicator" :class="{ 'status-bad' : occupiedSpots >= 10 , 'status-okay' : occupiedSpots >= 5, 'status-good' : occupiedSpots < 5,  }">{{ occupiedSpots }} Occupied Spots</span>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<ticket-enter></ticket-enter>
				</div>
				<div class="col-md-6">
					<ticket-leave></ticket-leave>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import TicketEnter from "./../TicketEnter.vue";
import TicketLeave from "./../TicketLeave.vue";

export default {
	components: {
		TicketEnter,
		TicketLeave
	},
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

