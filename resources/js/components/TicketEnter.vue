<template>
	<div class="card text-center mb-3">
		<div class="card-header text-light bg-dark text-center py-3">
			<h5 class="mb-0">Coming In?</h5>
		</div>
		<div v-if="totalSpots > occupiedSpots" class="card-body">
			<p class="card-title">Please fill out the form below to get your ticket generated.</p>

			<div class="row">
				<div class="col-md-8 offset-md-2">
					<form>
						<div class="form-group text-left">
							<label for="licenceNum">Licence Plate Number</label>
							<input type="text" name="licence" v-validate="'required'" data-vv-validate-on="blur" v-model="licenceNumber" placeholder="OUTATIME" class="form-control" id="licenceNum">
							<span class="error mt-1 text-danger">{{ errors.first('licence') }}</span>
						</div>
						<div class="form-group text-left">
							<label for="parkingDuration">Select Duration of Parking</label>
							<select v-model="selectedRate"  v-validate="'required'" data-vv-validate-on="blur" name="rate" class="form-control" id="parkingDuration">
								<option :value="null" disabled>Select a duration..</option>
								<option v-for="rate in rates" :key="rate.id" :value="rate">{{ rate.title }}</option>
							</select>
							<span class="error mt-1 text-danger">{{ errors.first('rate') }}</span>
						</div>

						<p v-if="selectedRate">Cost: {{ formatPrice(selectedRate.price) }}</p>

						<p class="text-danger" v-if="errorMsg">{{ errorMsg }}</p>

						<button type="submit" @click.prevent="createTicket" :disabled="buttonDisabled" class="btn btn-primary">Generate Ticket</button>
					</form>
				</div>
			</div>
		</div>
		<div v-else class="card-body">
			<h5 class="card-title">All the spots right now are currently occupied.</h5>
			<!-- complete notify functionality? -->
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
			occupiedSpots: null,
			totalSpots: null,
			errorMsg: null
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
					// console.log(result);
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
				.post("/api/garages/1/tickets", {
					licence_number: this.licenceNumber,
					rate_id: this.selectedRate.id
				})
				.then(result => {
					this.$router.push({
						name: "ticket-details-page",
						params: result.data
					});
				})
				.catch(err => {
					this.errorMsg = err.response.data.message;
				});
		},
		formatPrice(price) {
			return new Intl.NumberFormat("en-US", {
				style: "currency",
				currency: "USD",
				minimumFractionDigits: 2
			}).format(price / 100);
		}
	},
	computed: {
		buttonDisabled() {
			if (!this.licenceNumber || !this.selectedRate) {
				return true;
			}

			if (this.errors.any()) {
				return true;
			}

			return false;
		}
	}
};
</script>


