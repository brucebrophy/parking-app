<template>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<router-link :class="'navbar-brand'" :to="{ name: 'ticket-page' }">Park K/W</router-link>
		<button
			class="navbar-toggler"
			type="button"
			data-toggle="collapse"
			data-target="#navbarNav"
			aria-controls="navbarNav"
			aria-expanded="false"
			aria-label="Toggle navigation"
		>
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<router-link :class="'nav-link'" :to="{ name: 'payment-page' }">Pay</router-link>
				</li>
			</ul>
		</div>
	</nav>
</template>

