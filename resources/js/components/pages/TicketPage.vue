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
					<div class="card text-center">
						<div class="card-header text-light bg-dark text-center py-3">
							<h5 class="mb-0">Coming In?</h5>
						</div>
						<div v-if="totalSpots > occupiedSpots" class="card-body">
							<p class="card-title">Please fill out the form below to get your ticket generated.</p>

							<div class="row">
								<div class="col-md-8 offset-md-2">
									<form>
										<div class="form-group text-left">
											<label for="licenceNum">Enter Licence Plate #</label>
											<input type="text" v-model="licenceNumber" class="form-control" id="licenceNum">
										</div>
										<div class="form-group text-left">
											<label for="parkingDuration">Select Duration of Parking</label>
											<select v-model="selectedRate" class="form-control" id="parkingDuration">
												<option :value="null" disabled>Select a duration..</option>
												<option v-for="rate in rates" :key="rate.id" :value="rate">{{ rate.title }}</option>
											</select>
										</div>

										<p v-if="selectedRate">Cost: {{ formatPrice(selectedRate.price) }}</p>

										<button type="submit" @click.prevent="createTicket" class="btn btn-primary">Generate Ticket</button>
									</form>
								</div>
							</div>
						</div>
						<div v-else class="card-body">
							<h5 class="card-title">All the spots right now are currently occupied.</h5>
							<!-- complete notify functionality? -->
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card text-center">
						<div class="card-header text-light bg-dark text-center py-3">
							<h5 class="mb-0">Going Out?</h5>
						</div>
						<div class="card-body">
							<p class="card-title">Fill out the form below to find your ticket.</p>
							
							<div class="row">
								<div class="col-md-8 offset-md-2">
									<form>
										<div class="form-group text-left">
											<label for="licenceNum">Enter Licence Plate #</label>
											<input type="text" v-model="licenceNumber" class="form-control" id="licenceNum">
										</div>
										
										<button type="submit" @click.prevent="showTicket" class="btn btn-primary">Find Ticket</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	mounted() {
		this.getRates();
		this.getGarageDetails();
	},
	data() {
		return {
			rates: [],
			selectedRate: null,
			licenceNumber: null,
			availableSpots: null,
			occupiedSpots: null,
			totalSpots: null
		};
	},
	methods: {
		getRates() {
			axios
				.get("/api/rates")
				.then(result => {
					this.rates = result.data.rates;
				})
				.catch(err => {
					console.log(err);
				});
		},
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
		},
		createTicket() {
			axios
				.post("/api/garage/1/user", {
					licence_number: this.licenceNumber,
					rate_id: this.selectedRate.id
				})
				.then(result => {
					this.$router.push({
						name: "thank-you-page",
						params: result.data
					});
				})
				.catch(err => {
					console.log(err);
				});
		},
		showTicket() {
			axios
				.get("/api/garage/1/user/" + this.licenceNumber, {
					licence_number: this.licenceNumber
				})
				.then(result => {
					this.$router.push({
						name: "payment-page",
						params: result.data
					});
				})
				.catch(err => {
					console.log(err);
				});
		},
		formatPrice(price) {
			return new Intl.NumberFormat("en-US", {
				style: "currency",
				currency: "USD",
				minimumFractionDigits: 2
			}).format(price / 100);
		}
	}
};
</script>

