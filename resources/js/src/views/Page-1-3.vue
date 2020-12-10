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
                <vs-button @click="excel()" class="mx-1" color="dark" type="border" :disabled="workers.length <= 0">{{ $t('ToExcel') }}</vs-button>
            </div>

			<div class="overflow-y-auto" style="max-height: 300px;">
                <vs-table stripe pagination description sst :max-items="pagination.limit" :data="workers" :total="pagination.total" @change-page="handleChangePage" @sort="handleSort" v-model="worker">

                    <template slot="thead">
                        <vs-th>No</vs-th>
                        <vs-th sort-key="worker_nm">이름</vs-th>
                        <vs-th sort-key="tel_no">휴대폰번호</vs-th>
                        <vs-th sort-key="work_cd">업무구분</vs-th>
                        <vs-th sort-key="remark">업무내용</vs-th>
                        <vs-th sort-key="health_chk_dt">보건증갱신일자</vs-th>
                        <vs-th sort-key="role_cd">정/부</vs-th>
                        <vs-th sort-key="reg_dtm">등록일시</vs-th>
                    </template>

                    <template slot-scope="{data}">
                        <vs-tr :data="tr" :key="index" v-for="(tr, index) in workers">

                            <vs-td :data="(rowIndex(index))">
                                {{ (rowIndex(index)) }}
                            </vs-td>

                            <vs-td :data="data[index].worker_nm">
                                {{ data[index].worker_nm }}
                            </vs-td>

                            <vs-td :data="data[index].tel_no">
                                {{ data[index].tel_no }}
                            </vs-td>

                            <vs-td :data="data[index].work_cd">
                                {{ data[index].work_cd }}
                            </vs-td>

                            <vs-td :data="data[index].remark">
                                {{ data[index].remark }}
                            </vs-td>

                            <vs-td :data="data[index].health_chk_dt">
                                {{ data[index].health_chk_dt }}
                            </vs-td>

                            <vs-td :data="data[index].role_cd">
                                {{ data[index].role_cd }}
                            </vs-td>

                            <vs-td :data="data[index].reg_dtm">
                                {{ data[index].reg_dtm }}
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
import api from '@/services/worker'
import {mapActions} from 'vuex';

export default {
	data () {
		return {
			worker: {
				worker_id: null,
				worker_nm: null,
				tel_no: null,
				work_cd: null,
				health_chk_dt: null,
				role_cd: null,
				remark: null,
				reg_id: null,
				reg_dtm: null,
			},
			workers: [],
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
                this.workers = res.data.data
                this.pagination.total = res.data.meta.total
				this.pagination.page = res.data.meta.current_page
            }).catch(() => {
				this.spinner(false)
			})
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

		remove () {
			// 
		},

		excel () {
			window.location.href = api.downloadUrl()
		},

		closeDialog () {
			this.$vs.dialog({
                type: 'confirm',
                color: 'dark',
                title: this.$t('Confirmation'),
                text: this.$t('CloseDocument'),
                acceptText: this.$t('Accept'),
                cancelText: this.$t('Cancel'),
                accept: () => this.removeTab('page-1-3')
            })
		},

		addDialog () {
			this.$vs.dialog({
                type: 'confirm',
                color: 'primary',
                title: this.$t('Confirmation'),
                text: this.$t('AddWorker'),
                acceptText: this.$t('Accept'),
                cancelText: this.$t('Cancel'),
                accept: () => this.save()
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
		}
	}
}
</script>