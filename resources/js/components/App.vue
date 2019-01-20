<template>
	<div>
		<navigation></navigation>
		<router-view></router-view>
	</div>
</template>

<script>
import Navigation from "./Navigation.vue";

export default {
	components: {
		Navigation
	},
	data() {
		return {
			//
		};
	}
};
</script>

