<template>
	<div>
		<h4>Login History</h4>

        <vx-card class="mt-5">
            <div class="flex flex-wrap">
                <div class="w-full sm:w-1/3 mb-4 px-1">
					<p>Date</p>
					<div class="flex flex-row">
						<datepicker :format="filter.format" placeholder="Date from" class="pr-1" v-model="filter.from"></datepicker>
						<datepicker :format="filter.format" placeholder="Date to" class="pl-1" v-model="filter.to"></datepicker>
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

						<vs-td :data="data[indextr].user.user_nm">
							{{ data[indextr].user.user_nm }}
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
import axios from 'axios'
import Datepicker from 'vuejs-datepicker';

export default {
	components: {
		Datepicker
	},
    data() {
        return {
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
        fetchLoginHistory: function (page, limit) {
            axios.get(`/api/login_hist?with=user&page=${page}&limit=${limit}`)
                .then((res) => {
					this.datas = res.data.data
					this.total = res.data.meta.total
					console.log(this.total)
                })
		},
		handleSearch(searching) {
			let _print = `The user searched for: ${searching}\n`
			this.$refs.pre.appendChild(document.createTextNode(_print))
		},
		handleChangePage(page) {
			let _print = `The user changed the page to: ${page}\n`
			this.$refs.pre.appendChild(document.createTextNode(_print))
		},
		handleSort(key, active) {
			let _print = `the user ordered: ${key} ${active}\n`
			this.$refs.pre.appendChild(document.createTextNode(_print))
		},
        query: function () {
            this.fetchLoginHistory(1, 0)
        },
    },
    created () {
        this.fetchLoginHistory(1, 0)
    }
}
</script>