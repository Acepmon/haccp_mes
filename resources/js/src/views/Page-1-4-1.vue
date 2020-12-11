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

			<form action="#">
				<!--  -->
			</form>

			<vs-divider/>

            <div class="flex flex-wrap justify-end mb-2">
                <vs-button @click="excel()" class="mx-1" color="dark" type="border" :disabled="haccp_mst_files.length <= 0">{{ $t('ToExcel') }}</vs-button>
            </div>

			<div class="overflow-y-auto" style="max-height: 300px;">
                <vs-table stripe pagination description sst :max-items="pagination.limit" :data="haccp_mst_files" :total="pagination.total" @change-page="handleChangePage" @sort="handleSort" v-model="haccp_mst_file">

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

                            <vs-td :data="data[index].rev_no">
                                {{ data[index].rev_no }}
                            </vs-td>

                            <vs-td :data="data[index].rev_dt">
                                {{ data[index].rev_dt }}
                            </vs-td>

                            <vs-td :data="data[index].rev_content">
                                {{ data[index].rev_content }}
                            </vs-td>

                            <vs-td :data="data[index].rev_reason">
                                {{ data[index].rev_reason }}
                            </vs-td>

                            <vs-td>
                                <div v-for="(att, attIndex) in data[index].att" :key="attIndex" v-text="att.att_nm"></div>
                            </vs-td>

                        </vs-tr>
                    </template>
                </vs-table>
            </div>
			
		</vx-card>
	</div>
</template>

<script>
import axios from 'axios'
import comm_cd from '@/services/comm_cd'
import api from '@/services/haccp_mst_file'
import {mapActions} from 'vuex';

export default {
	data () {
		return {
			haccp_mst_file: {
				rev_seq: null,
				rev_no: null,
				rev_dt: null,
				att_dtm: null,
				rev_content: null,
				rev_reason: null,
				reg_id: null,
				reg_dtm: null,
				att: {
					att_dtm: null,
					att_seq: null,
					att_nm: null,
					att_path: null,
					file_sz: null,
					rmk: null,
				}
			},
			haccp_mst_files: [],
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
			this.$set(this, 'haccp_mst_file', {
				rev_seq: null,
				rev_no: null,
				rev_dt: null,
				att_dtm: null,
				rev_content: null,
				rev_reason: null,
				reg_id: null,
				reg_dtm: null,
				att: []
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
			this.spinner()

			api.fetch({
                ...this.paginationParam,
			    ...this.sortParam
            }).then((res) => {
				this.spinner(false)
                this.haccp_mst_files = res.data.data
                this.pagination.total = res.data.meta.total
				this.pagination.page = res.data.meta.current_page
            }).catch(() => {
				this.spinner(false)
				this.$vs.notify({
					title: this.$t('Error'),
					position: 'top-right',
					color: 'warning',
					iconPack: 'feather',
					icon:'icon-alert-circle',
					text: err.response.data.message,
				})
			})
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