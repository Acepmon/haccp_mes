<template>
	<div class="information-mgmt-container">
		<h4>information mgmt</h4>
	</div>
</template>

<script>
export default { 
	data() {
		return {
			menuItems: [
				{
					url: "/",
					name: "Home",
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