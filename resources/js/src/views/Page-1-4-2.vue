<template>
	<div>
		<vx-card id="div-with-loading" class="vs-con-loading__container">
			<div class="flex flex-wrap mb-2">
				<div class="w-full sm:w-1/2 px-1 flex justify-end">
				</div>
				<div class="w-full sm:w-1/2 px-1 flex justify-end">
					<vs-button @click="query()" class="mx-1 mr-16" color="dark" type="border">{{ $t('Query') }}</vs-button>
					<vs-button @click="addDialog()" class="mx-1" color="dark" type="border">{{ $t('Add') }}</vs-button>
					<vs-button @click="saveDialog()" class="mx-1" color="dark" type="border">{{ $t('Save') }}</vs-button>
					<vs-button @click="removeDialog()" class="mx-1" color="dark" type="border">{{ $t('Delete') }}</vs-button>
					<vs-button @click="closeDialog()" class="mx-1" color="dark" type="border">{{ $t('Close') }}</vs-button>
				</div>
			</div>
		</vx-card>

		<form action="#">
			<!--  -->
		</form>

		<vs-divider/>

		<div class="flex flex-wrap justify-end mb-2">
			<vs-button @click="excel()" class="mx-1" color="dark" type="border" :disabled="haccp_mst_files.length <= 0">{{ $t('ToExcel') }}</vs-button>
		</div>

		<div class="overflow-y-auto" style="max-height: 300px;">
			<vs-table stripe pagination description sst :max-items="pagination.limit" :data="haccp_mst_files" :total="pagination.total" @change-page="handleChangePage" @sort="handleSort" v-model="haccp_mst_file" @selected="handleSelected">

				<template slot="thead">
					<vs-th>No</vs-th>
					<vs-th sort-key="rev_no">개정번호</vs-th>
					<vs-th sort-key="rev_dt">등록일자</vs-th>
					<vs-th sort-key="rev_content">개정내용</vs-th>
					<vs-th sort-key="rev_reason">개정사유</vs-th>
					<vs-th>첨부화일</vs-th>
				</template>

				<template slot-scope="{data}">
					<vs-tr :data="tr" :key="index" v-for="(tr, index) in haccp_mst_files">

						<vs-td :data="(rowIndex(index))">
							{{ (rowIndex(index)) }}
						</vs-td>

						<vs-td :data="data[index]['haccp_mst_file:rev_no']">
							{{ data[index]['haccp_mst_file:rev_no'] }}
						</vs-td>

						<vs-td :data="data[index]['haccp_mst_file:rev_dt']">
							{{ data[index]['haccp_mst_file:rev_dt'] }}
						</vs-td>

						<vs-td :data="data[index]['haccp_mst_file:rev_content']">
							{{ data[index]['haccp_mst_file:rev_content'] }}
						</vs-td>

						<vs-td :data="data[index]['haccp_mst_file:rev_reason']">
							{{ data[index]['haccp_mst_file:rev_reason'] }}
						</vs-td>

						<vs-td :data="data[index]['haccp_mst_file:att_dtm']">
							<div class="flex flex-row">
								<span v-if="data[index]['haccp_mst_file:att_file'].length > 0" v-text="data[index]['haccp_mst_file:att_file'][0].att_nm" class="pt-1"></span>
								<vs-button color="primary" class="ml-2" :href="'/api/haccp_mst_file/' + data[index]['haccp_mst_file:rev_seq'] + '/att_file/' + data[index]['haccp_mst_file:att_file'][0].att_seq + '/download'" type="flat" size="small" icon-pack="feather" icon="icon-download"></vs-button>
							</div>
						</vs-td>

					</vs-tr>
				</template>
			</vs-table>
		</div>
	</div>
</template>

<script>
import axios from 'axios'
import comm_cd from '@/services/comm_cd'
import api from '@/services/haccp_mst_file'

export default {
	data () {
		return {
			doc_mgmt: {
				'doc_mgmt:doc_id': null,
				'doc_mgmt:type_cd': null,
				'doc_mgmt:doc_nm': null,
				'doc_mgmt:doc_desc': null,
				'doc_mgmt:att_dtm': null,
				'doc_mgmt:reg_id': null,
				'doc_mgmt:reg_dtm': null,
			},
			errors: {
				'doc_mgmt:doc_id': null,
				'doc_mgmt:type_cd': null,
				'doc_mgmt:doc_nm': null,
				'doc_mgmt:doc_desc': null,
				'doc_mgmt:att_dtm': null,
			},
			doc_mgmts: [],
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
			this.$set(this, 'doc_mgmt', {
				'doc_mgmt:doc_id': null,
				'doc_mgmt:type_cd': null,
				'doc_mgmt:doc_nm': null,
				'doc_mgmt:doc_desc': null,
				'doc_mgmt:att_dtm': null,
				'doc_mgmt:reg_id': null,
				'doc_mgmt:reg_dtm': null,
			})
		},

		clearErrors () {
			this.$set(this, 'errors', {
				'doc_mgmt:doc_id': null,
				'doc_mgmt:type_cd': null,
				'doc_mgmt:doc_nm': null,
				'doc_mgmt:doc_desc': null,
				'doc_mgmt:att_dtm': null,
			})
		},

		displayErrors (errors) {
			for (const [key, value] of Object.entries(errors)) {
				this.$set(this.errors, key, Array.isArray(value) ? value[0] : value)
			}
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

		query () {
			// 
		},

		add () {
			// 
		},

		save () {
			// 
		},

		remove () {
			// 
		},

		addDialog () {
			this.$vs.dialog({
                type: 'confirm',
                color: 'primary',
                title: this.$t('Confirmation'),
                text: this.$t('AddData'),
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
                text: this.$t('SaveData'),
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
                text: this.$t('DeleteData'),
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
	}
}
</script>