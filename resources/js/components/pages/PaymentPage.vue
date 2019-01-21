<template>
	<div class="container">
		<div class="col-md-6 offset-md-3">
			<div class="card mt-5 mb-5">
				<div class="card-header text-white bg-dark py-3">
					<h5 class="mb-0">Payment</h5>
				</div>
				<div v-if="showTicketDetails" class="card-body">
					<h5 class="card-title">Complete the form below to complete your payment</h5>

					<div>
						<p>Total: {{ formatPrice(ticketDetails.rate.price) }}</p>
						<p>Ticket Number: {{ ticketDetails.ticket_number }}</p>
						<p>Licence Plate Number: {{ ticketDetails.licence_number }}</p>
						<p>Duration: {{ ticketDetails.rate.title }}</p>
					</div>

					<hr>
					
					<div class="text-center mt-3" v-if="ticketDetails.is_valid">
						<p>It looks like you already paid for this ticket!</p>
						<router-link :class="'btn btn-primary'" :to="{ name: 'ticket-page' }">Go Back</router-link>
					</div>
					<form v-if="! ticketDetails.is_valid">
						<div class="form-group">
							<label for="full_name">Full Name</label>
							<input class="form-control" name="name" v-model="name" v-validate="'required'" data-vv-validate-on="blur" id="full_name" placeholder="John Smith" type="text">
							<span class="error mt-1 text-danger">{{ errors.first('name') }}</span>
						</div>
						<div class="form-group">
							<label for="card_number">Credit Card Number</label>
							<input class="form-control" name="card_number" v-model="card_number" v-validate="'required'" data-vv-validate-on="blur" id="card_number" placeholder="Credit Card Number" type="text">
							<span class="error mt-1 text-danger">{{ errors.first('card_number') }}</span>
						</div>
						<div class="row mb-4">
							<div class="col-md-6">
								<div class="form-group">
									<label for="expirty_date">Expiry Date</label>
									<input class="form-control" name="expiry" v-model="expiry" v-validate="'required'" data-vv-validate-on="blur" id="expirty_date" placeholder="MM/YY" type="text">
									<span class="error mt-1 text-danger">{{ errors.first('expiry') }}</span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="code">Security Code</label>
									<input class="form-control" name="code" v-model="code" v-validate="'required'" data-vv-validate-on="blur" id="code" placeholder="100" type="text">
									<span class="error mt-1 text-danger">{{ errors.first('code') }}</span>
								</div>
							</div>
						</div>

						<router-link :class="'btn btn-link'" :to="{ name: 'ticket-page' }">Cancel</router-link>
						<button type="submit" @click.prevent="submitPayment" :disabled="buttonDisabled" class="btn btn-success float-right">Pay Now</button>
					</form>
				</div>
				<div v-else class="card-body">
					<h5 class="card-title text-center">Opps, can't seem to find your ticket. Try again!</h5>

					<router-link :class="'btn btn-primary d-block w-50 mx-auto mt-3'" :to="{ name: 'ticket-page' }">Cancel</router-link>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	mounted() {
		if (!_.isEmpty(this.$route.params)) {
			this.showTicketDetails = true;
			this.ticketDetails = this.$route.params.ticket;
		}
	},
	data() {
		return {
			ticketDetails: null,
			showTicketDetails: false,
			name: null,
			card_number: null,
			expiry: null,
			code: null
		};
	},
	methods: {
		submitPayment() {
			axios
				.patch("/api/garages/1/tickets/" + this.ticketDetails.id)
				.then(result => {
					this.$router.push({
						name: "thank-you-page"
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
	},
	computed: {
		buttonDisabled() {
			if (!this.name || !this.card_number || !this.expiry || !this.code) {
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

