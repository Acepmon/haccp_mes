<template>
	<div>
		<vx-card id="div-with-loading" class="vs-con-loading__container">
			<div class="flex flex-wrap justify-end mb-2">
				<vs-button @click="addDialog()" class="mx-1" color="dark" type="border">{{ $t('Add') }}</vs-button>
                <vs-button @click="saveDialog()" class="mx-1" color="dark" type="border">{{ $t('Save') }}</vs-button>
                <vs-button @click="query()" class="mx-1" color="dark" type="border">{{ $t('Query') }}</vs-button>
                <vs-button @click="removeDialog()" class="mx-1" color="dark" type="border">{{ $t('Delete') }}</vs-button>
                <vs-button @click="closeDialog()" class="mx-1" color="dark" type="border">{{ $t('Close') }}</vs-button>
            </div>
		</vx-card>
	</div>
</template>

<script>
import axios from 'axios'
import comm_cd from '@/services/comm_cd'
import api from '@/services/user'
import {mapActions} from 'vuex';

export default {
	data () {
		return {
			pagination: {
				page: 1,
				limit: 15,
				total: 0,
			},
			sorting: {
				sort: 'reg_dtm',
				order: 'desc'
			},
		}
	},

	computed: {
		paginationParam: function () {
			return {
				page: this.pagination.page,
				limit: this.pagination.limit
			}
        },

		sortParam: function () {
			return {
				sort: this.sorting.sort != null ? this.sorting.sort : 'login_dtm',
				order: this.sorting.order != null ? this.sorting.order : 'asc',
			}
		}
	},

	methods: {
		...mapActions({
            removeTab: 'mdn/removeTab',
		}),

		spinner (loading = true) {
			if (loading) {
				this.$vs.loading({
					container: '#div-with-loading',
					scale: 0.6
				})
			} else {
				this.$vs.loading.close('#div-with-loading > .con-vs-loading')
			}
		},

		clear () {
			this.$set(this, 'worker', {
				worker_id: null,
				worker_nm: null,
				tel_no: null,
				work_cd: null,
				health_chk_dt: null,
				role_cd: null,
				remark: null,
				reg_id: null,
				reg_dtm: null,
			})
		},

		rowIndex: function (index) {
			return (this.pagination.page * this.pagination.limit)-this.pagination.limit + index + 1
		},

		handleChangePage(page) {
			this.pagination.page = page
			this.query()
		},

        handleSort(sort, order) {
			this.sorting.sort = sort
			this.sorting.order = order
			this.query()
        },

		add () {
			// 
		},

		save () {
			// 
		},

		query () {
			// 
		},

		remove () {
			// 
		},

		close () {
			// 
		},

		addDialog () {
			this.$vs.dialog({
                type: 'confirm',
                color: 'primary',
                title: this.$t('Confirmation'),
                text: this.$t('AddWorker'),
                acceptText: this.$t('Accept'),
                cancelText: this.$t('Cancel'),
                accept: () => this.add()
            })
		},

		saveDialog () {
			this.$vs.dialog({
                type: 'confirm',
                color: 'success',
                title: this.$t('Confirmation'),
                text: this.$t('SaveWorker'),
                acceptText: this.$t('Accept'),
                cancelText: this.$t('Cancel'),
                accept: () => this.save()
            })
		},

		removeDialog () {
			this.$vs.dialog({
                type: 'confirm',
                color: 'danger',
                title: this.$t('Confirmation'),
                text: this.$t('DeleteWorker'),
                acceptText: this.$t('Accept'),
                cancelText: this.$t('Cancel'),
                accept: () => this.remove()
            })
		},

		closeDialog () {
			this.$vs.dialog({
                type: 'confirm',
                color: 'dark',
                title: this.$t('Confirmation'),
                text: this.$t('CloseDocument'),
                acceptText: this.$t('Accept'),
                cancelText: this.$t('Cancel'),
                accept: () => this.removeTab('page-1-4-1')
            })
		}
	},

	created() {
		// console.log('Page-1-4-1 created')
	}
}
</script>