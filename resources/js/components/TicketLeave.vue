<template>
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
							<label for="licenceNum">Licence Plate Number</label>
							<input type="text" name="licence" v-validate="'required'" data-vv-validate-on="blur" v-model="licenceNumber" placeholder="OUTATIME" class="form-control" id="licenceNum">
							<span class="error mt-1 text-danger">{{ errors.first('licence') }}</span>
						</div>
						
						<button type="submit" @click.prevent="payTicket" :disabled="buttonsDisabled" class="btn btn-primary mb-3">Pay</button>
						<button type="submit" @click.prevent="leaveGarage" :disabled="buttonsDisabled" class="btn btn-success mb-3">Leave</button>
					</form>
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
			licenceNumber: null
		};
	},
	methods: {
		payTicket() {
			axios
				.get("/api/garage/1/user/" + this.licenceNumber)
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
		leaveGarage() {
			axios
				.delete("/api/garage/1/user/" + this.licenceNumber)
				.then(result => {
					this.$router.push({
						name: "good-bye-page",
						params: result.data
					});
				})
				.catch(err => {
					console.log(err);
				});
		}
	},
	computed: {
		buttonsDisabled() {
			if (!this.licenceNumber) {
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