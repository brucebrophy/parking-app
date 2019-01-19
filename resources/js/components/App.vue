<template>
	<div>
		<navigation></navigation>
		<garage-details></garage-details>
		<router-view></router-view>
	</div>
</template>

<script>
import Navigation from "./Navigation.vue";
import GarageDetails from "./GarageDetails.vue";

export default {
	components: {
		Navigation,
		GarageDetails
	},
	data() {
		return {
			foo: "bar"
		};
	}
};
</script>

