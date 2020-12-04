<template>
	<div>
		<h4>User Entry</h4>

        <vx-card class="mt-5">
            <div class="flex flex-wrap justify-end mb-5">
                <vs-button @click="add()" class="mx-1" color="dark" type="border" :disabled="isSelected">Add</vs-button>
                <vs-button @click="save()" class="mx-1" color="dark" type="border" :disabled="!isSelected">Save</vs-button>
                <vs-button @click="query()" class="mx-1" color="dark" type="border">Query</vs-button>
                <vs-button @click="remove()" class="mx-1" color="dark" type="border" :disabled="!isSelected">Delete</vs-button>
            </div>

            <div class="flex flex-wrap">
                <div class="w-full sm:w-1/2 mb-4 px-1">
                    <vs-input class="w-full" label="User ID" v-model="selected.user_id" required />
                </div>
                <div class="w-full sm:w-1/2 mb-4 px-1">
                    <vs-input class="w-full" label="User Password" v-model="selected.user_pw" type="password" />
                </div>
                <div class="w-full sm:w-1/2 mb-4 px-1">
                    <vs-input class="w-full" label="User Name" v-model="selected.user_nm" />
                </div>
                <div class="w-full sm:w-1/2 mb-4 px-1">
                    <vs-input class="w-full" label="User e-Mail" v-model="selected.email" type="email" />
                </div>
                <div class="w-full sm:w-1/2 mb-4 px-1">
                    <vs-select class="w-full" label="Role Name" v-model="selected.role_cd">
                        <vs-select-item :key="index" :value="item.comm2_cd" :text="item.comm2_nm" v-for="(item, index) in roles"></vs-select-item>
                    </vs-select>
                </div>
                <div class="w-full sm:w-1/2 mb-4 px-1">
                    <vs-select class="w-full" label="Use Status" v-model="selected.user_sts_yn">
                        <vs-select-item :key="index" :value="item.value" :text="item.text" v-for="(item, index) in status"></vs-select-item>
                    </vs-select>
                </div>
                <div class="w-full sm:w-1/2 mb-4 px-1">
                    <vs-select class="w-full" label="Approval" v-model="selected.appr_cd">
                        <vs-select-item :key="index" :value="item.comm2_cd" :text="item.comm2_nm" v-for="(item, index) in approvals"></vs-select-item>
                    </vs-select>
                </div>
                <div class="w-full sm:w-1/2 mb-4 px-1">
                    <vs-select class="w-full" label="Job" v-model="selected.job_cd">
                        <vs-select-item :key="index" :value="item.comm2_cd" :text="item.comm2_nm" v-for="(item, index) in jobs"></vs-select-item>
                    </vs-select>
                </div>
            </div>

            <div class="flex flex-wrap justify-end mb-5">
                <vs-button @click="excel()" class="mx-1" color="dark" type="border" :disabled="datas.length <= 0">To Excel</vs-button>
            </div>

            <vs-table stripe pagination max-items="10" :data="datas" v-model="selected" @selected="handleSelected">
				<template slot="thead">
					<vs-th>No</vs-th>
					<vs-th>User ID</vs-th>
					<vs-th>User Password</vs-th>
					<vs-th>User Name</vs-th>
					<vs-th>e-Mail</vs-th>
					<vs-th>Role Name</vs-th>
					<vs-th>Registration ID</vs-th>
                    <vs-th>Registration Date</vs-th>
				</template>

				<template slot-scope="{data}">
					<vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">

						<vs-td :data="indextr">
							{{ indextr }}
						</vs-td>

						<vs-td :data="data[indextr].user_id">
							{{ data[indextr].user_id }}
						</vs-td>

						<vs-td :data="data[indextr].user_pw">
							{{ data[indextr].user_pw }}
						</vs-td>

						<vs-td :data="data[indextr].user_nm">
							{{ data[indextr].user_nm }}
						</vs-td>

						<vs-td :data="data[indextr].email">
							{{ data[indextr].email }}
						</vs-td>

						<vs-td :data="data[indextr].role.comm2_nm">
							{{ data[indextr].role.comm2_nm }}
						</vs-td>

						<vs-td :data="data[indextr].reg_id">
							{{ data[indextr].reg_id }}
						</vs-td>

                        <vs-td :data="data[indextr].reg_dtm">
							{{ data[indextr].reg_dtm }}
						</vs-td>

					</vs-tr>
				</template>
			</vs-table>
        </vx-card>
	</div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            roles: [],
            approvals: [],
            jobs: [],
            status: [
                { 'text': 'Y', 'value': 'Y' },
                { 'text': 'N', 'value': 'N' }
            ],
            selected: {
                user_id: null,
                user_pw: null,
                user_nm: null,
                email: null,
                role_cd: null,
                appr_cd: null,
                job_cd: null,
                user_sts_yn: null,
            },
            isSelected: false,
            datas: []
        }
    },
    methods: {
        fetchUsers: function (page, limit) {
            axios.get(`/api/user?with=role&page=${page}&limit=${limit}`)
                .then((res) => {
                    this.datas = res.data.data
                })
        },
        fetchRoles: function (page, limit) {
            axios.get(`/api/comm_cd/roles`)
                .then((res) => {
                    this.roles = res.data.data
                })
        },
        fetchApprovals: function (page, limit) {
            axios.get(`/api/comm_cd/approvals`)
                .then((res) => {
                    this.approvals = res.data.data
                })
        },
        fetchJobs: function (page, limit) {
            axios.get(`/api/comm_cd/jobs`)
                .then((res) => {
                    this.jobs = res.data.data
                })
        },
        handleSelected(tr) {
            this.isSelected = true
            this.selected.user_pw = '1234'
		},
        add: function () {
            alert('add')
        },
        save: function () {
            alert('save')
        },
        query: function () {
            this.fetchUsers(1, 0)
        },
        remove: function () {
            alert('remove')
        },
        excel: function () {
            alert('excel')
        }
    },
    created () {
        this.fetchRoles(1, 0)
        this.fetchApprovals(1, 0)
        this.fetchJobs(1, 0)
        this.fetchUsers(1, 0)
    }
}
</script>