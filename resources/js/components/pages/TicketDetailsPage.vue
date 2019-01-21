<template>
	<div class="container">
		<div class="col-md-6 offset-md-3">
			<div class="card mt-5">
				<div class="card-header text-white bg-dark py-3">
					<h5 class="mb-0">Ticket Details</h5>
				</div>
				<div class="card-body">
					<div v-if="showTicketDetails">
						<p>Ticket Number: {{ this.ticketDetails.ticket_number }}</p>
						<p>Licence Plate Number: {{ this.ticketDetails.licence_number }}</p>
						<p>Duration: {{ this.ticketDetails.rate.title }}</p>
					</div>
					
					<router-link :class="'btn btn-primary'" :to="{ name: 'ticket-page' }">Go Back</router-link>
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
			showTicketDetails: false,
			ticketDetails: null
		};
	}
};
</script>

