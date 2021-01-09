<template>
	<div>
		<h4>You are in home.</h4>

		<div class="mt-5">
			<ag-grid-table></ag-grid-table>
		</div>
	</div>
</template>

<script>
import AgGridTable from './ui-elements/ag-grid-table/AgGridTable'
export default {
	name: 'home',
	components: {
		AgGridTable
	}
}
</script>