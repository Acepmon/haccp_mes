<template>
	<div>
        <vx-card class="mt-5">
			<app-control filterClass="sm:w-3/4" actionClass="sm:w-1/4">
				<template v-slot:filter>
					<span class="flex items-center px-5">검색일자</span>
					<flat-pickr :config="configFromdateTimePicker" v-model="from" placeholder="시작일자" @on-change="onFromChange" class="control-field-dtm mx-1" style="width: 100px;" />
					<span class="flex items-center px-2">~</span>
					<flat-pickr :config="configTodateTimePicker" v-model="to" placeholder="종료일자" @on-change="onToChange" class="control-field-dtm mx-1" style="width: 100px;" />
					<span class="flex items-center px-5">사용자 ID/이름</span>
					<vs-input v-model="keyword" class="control-field" />
				</template>

				<template v-slot:action>
					<vs-button
						@click="query()"
						class="mx-1 mr-16"
						color="primary"
						type="border"
						>{{ $t("Query") }}</vs-button
					>
				</template>
			</app-control>

            <vs-table stripe pagination description sst :max-items="pagination.limit" :data="datas" :total="pagination.total" @change-page="handleChangePage" @sort="handleSort">
				<template slot="thead">
					<vs-th>No</vs-th>
					<vs-th sort-key="user_id">사용자 ID</vs-th>
					<vs-th sort-key="user_name">사용자 이름</vs-th>
					<vs-th sort-key="ip_addr">IP 주소</vs-th>
					<vs-th sort-key="login_dtm">로그인 일자</vs-th>
					<vs-th sort-key="logout_dtm">로그아웃 일자</vs-th>
				</template>

				<template slot-scope="{data}">
					<vs-tr :data="tr" :key="index" v-for="(tr, index) in data">

						<vs-td :data="(overallIndex(index))">
							{{ (overallIndex(index)) }}
						</vs-td>

						<vs-td :data="data[index].user_id">
							{{ data[index].user_id }}
						</vs-td>

						<vs-td :data="data[index].user_nm">
							{{ data[index].user_nm }}
						</vs-td>

						<vs-td :data="data[index].ip_addr">
							{{ data[index].ip_addr }}
						</vs-td>

						<vs-td :data="data[index].login_dtm">
							{{ data[index].login_dtm }}
						</vs-td>

						<vs-td :data="data[index].logout_dtm">
							{{ data[index].logout_dtm }}
						</vs-td>

					</vs-tr>
				</template>
			</vs-table>
        </vx-card>
	</div>
</template>

<script>
import moment from 'moment'
import axios from 'axios'
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import {Korean as KoreanLocale} from 'flatpickr/dist/l10n/ko.js';
import api from '@/services/login_hist'

import AppControl from '@/views/ui-elements/AppControl'
import AppForm from '@/views/ui-elements/AppForm'
import AppFormGroup from '@/views/ui-elements/AppFormGroup'

export default {
	components: {
		flatPickr,
		AppControl,
		AppForm,
		AppFormGroup
	},
    data() {
        return {
			format: 'yyyy-MM-dd',
			from: null,
			to: null,
			keyword: null,
			configFromdateTimePicker: {
				maxDate: null,
				locale: KoreanLocale,
            },
            configTodateTimePicker: {
				minDate: null,
				locale: KoreanLocale,
            },
			pagination: {
				page: 1,
				limit: 15,
				total: 0,
			},
			sorting: {
				sort: 'login_dtm',
				order: 'asc'
			},
			datas: [],
        }
	},
	computed: {
		paginationParam: function () {
			return {
				page: this.pagination.page,
				limit: this.pagination.limit
			}
		},

		filterParam: function () {
			return {
				from: this.from != null ? moment(this.from).format('YYYY-MM-DD') : '',
				to: this.to != null ? moment(this.to).format('YYYY-MM-DD') : '',
				keyword: this.keyword != null ? this.keyword : '',
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
		onFromChange(selectedDates, dateStr, instance) {
			this.$set(this.configTodateTimePicker, 'minDate', dateStr);
		},

		onToChange(selectedDates, dateStr, instance) {
			this.$set(this.configFromdateTimePicker, 'maxDate', dateStr);
		},

		overallIndex: function (index) {
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

        query: function () {
			api.fetch({
				...this.paginationParam,
				...this.filterParam,
				...this.sortParam
			}).then((res) => {
				this.datas = res.data.data
				this.pagination.total = res.data.meta.total
				this.pagination.page = res.data.meta.current_page
			})
		},
	},

    created () {
		this.query()
    }
}
</script>