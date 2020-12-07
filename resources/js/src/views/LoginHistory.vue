<template>
	<div>
		<h4>Login History</h4>

        <vx-card class="mt-5">
            <div class="flex flex-wrap">
                <div class="w-full sm:w-1/3 mb-4 px-1">
					<p>Date</p>
					<div class="flex flex-row">
						<datepicker :language="ko" :format="filter.format" placeholder="Date from" class="pr-1" v-model="filter.from"></datepicker>
						<datepicker :language="ko" :format="filter.format" placeholder="Date to" class="pl-1" v-model="filter.to"></datepicker>
					</div>
                </div>
                <div class="w-full sm:w-1/3 mb-4 px-1">
                    <vs-input class="w-full" label="User ID/Name" v-model="filter.keyword" />
                </div>
				<div class="w-full sm:w-1/3 mb-4 px-1 text-right">
					<p>&nbsp;</p>
                    <vs-button @click="query()" class="mx-1" color="dark" type="border">Query</vs-button>
                </div>
            </div>

            <vs-table stripe pagination description sst max-items="10" :data="datas" :total="total">
				<template slot="thead">
					<vs-th>No</vs-th>
					<vs-th>User ID</vs-th>
					<vs-th>User Name</vs-th>
					<vs-th>IP Address</vs-th>
					<vs-th>Login Date</vs-th>
					<vs-th>Logout Date</vs-th>
				</template>

				<template slot-scope="{data}">
					<vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">

						<vs-td :data="(indextr + 1)">
							{{ (indextr + 1) }}
						</vs-td>

						<vs-td :data="data[indextr].user_id">
							{{ data[indextr].user_id }}
						</vs-td>

						<vs-td :data="data[indextr].user_nm">
							{{ data[indextr].user_nm }}
						</vs-td>

						<vs-td :data="data[indextr].ip_addr">
							{{ data[indextr].ip_addr }}
						</vs-td>

						<vs-td :data="data[indextr].login_dtm">
							{{ data[indextr].login_dtm }}
						</vs-td>

						<vs-td :data="data[indextr].logout_dtm">
							{{ data[indextr].logout_dtm }}
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
import Datepicker from 'vuejs-datepicker';
import {en, ko, mn} from 'vuejs-datepicker/dist/locale'
import loginHist from '@/services/loginHist'

export default {
	components: {
		Datepicker
	},
    data() {
        return {
			en: en,
			ko: ko,
			mn: mn,
			filter: {
				format: 'yyyy-MM-dd',
				from: null,
				to: null,
				keyword: null
			},
			datas: [],
			total: 15
        }
    },
    methods: {
		handleChangePage(page) {
			let _print = `The user changed the page to: ${page}\n`
			this.$refs.pre.appendChild(document.createTextNode(_print))
		},
		handleSort(key, active) {
			let _print = `the user ordered: ${key} ${active}\n`
			this.$refs.pre.appendChild(document.createTextNode(_print))
		},
        query: function () {
			let from = this.filter.from != null ? moment(this.filter.from).format('YYYY-MM-DD') : ''
			let to = this.filter.to != null ? moment(this.filter.to).format('YYYY-MM-DD') : ''
			let keyword = this.filter.keyword != null ? this.filter.keyword : ''

			loginHist.fetch({
				from: from,
				to: to,
				keyword: keyword
			}).then((res) => {
				this.datas = res.data.data
				console.log(this.datas)
			})
        },
    },
    created () {
		loginHist.fetch().then((res) => {
			this.datas = res.data.data
			console.log(this.datas)
		})
    }
}
</script>