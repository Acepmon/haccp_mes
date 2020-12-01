<template>
	<div class="purchase-mgmt-container">
		<h4>purchase mgmt</h4>
	</div>
</template>

<script>
export default {
	data() {
		return {
			menuItems: [
				{
					url: "/",
					name: "Home12",
					slug: "home",
					icon: "HomeIcon",
				}
			]
		}
	},
	created() {
		this.$store.dispatch('updateVerticalNavMenuWidth', this.menuItems)
	}
}
</script>