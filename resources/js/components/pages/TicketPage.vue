<template>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="card text-center mt-5">
					<div class="card-header text-light bg-dark text-center py-3">
						<h5 class="mb-0">Coming In?</h5>
					</div>
					<div class="card-body">
						<p class="card-title">Press the button below to get your ticket generated.</p>

						<div class="row">
							<div class="col-md-8 offset-md-2">
								<form>
									<div class="form-group">
										<label for>Select Duration of Parking</label>
										<select v-model="selectedRate" class="form-control">
											<option :value="null" disabled>Select a duration..</option>
											<option v-for="rate in rates" :key="rate.id" :value="rate.id">{{ rate.title }}</option>
										</select>
									</div>

									<button type="submit" @click.prevent="createTicket" class="btn btn-primary">Generate Ticket</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card text-center mt-5">
					<div class="card-header text-light bg-dark text-center py-3">
						<h5 class="mb-0">Going Out?</h5>
					</div>
					<div class="card-body">
						<h5 class="card-title">Special title treatment</h5>
						<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>

						<div class="d-flex justify-content-between">
							<a href="#" class="btn btn-primary">Please Pay Before Leaving</a>
							<a href="#" class="btn btn-primary">Verify Ticket and Leave</a>
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
	},
	data() {
		return {
			rates: [],
			selectedRate: null
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
		createTicket() {
			axios
				.post("/api/garage/1/user", {
					rate_id: this.selectedRate
				})
				.then(result => {
					console.log(result);
					this.$router.push({
						name: "thank-you-page",
						params: result.data
					});
				})
				.catch(err => {
					console.log(err);
				});
		}
	}
};
</script>

