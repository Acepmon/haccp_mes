<template>
	<div>
		<h4>User Entry</h4>

        <vx-card class="mt-5">
            <div class="flex flex-wrap justify-end mb-5">
                <vs-button @click="add()" class="mx-1" color="dark" type="border">Add</vs-button>
                <vs-button @click="save()" class="mx-1" color="dark" type="border">Save</vs-button>
                <vs-button @click="query()" class="mx-1" color="dark" type="border">Query</vs-button>
                <vs-button @click="remove()" class="mx-1" color="dark" type="border">Delete</vs-button>
            </div>

            <div class="flex flex-wrap">
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/6 mb-4 px-1">
                    <vs-input class="w-full" label="User ID" v-model="selected.user_id" />
                </div>
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/6 mb-4 px-1">
                    <vs-input class="w-full" label="User Password" v-model="selected.user_pw" />
                </div>
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/6 mb-4 px-1">
                    <vs-input class="w-full" label="User Name" v-model="selected.user_nm" />
                </div>
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/6 mb-4 px-1">
                    <vs-input class="w-full" label="User e-Mail" v-model="selected.email" />
                </div>
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/2 xl:w-1/6 mb-4 px-1">
                    <vs-input class="w-full" label="Role Name" v-model="selected.role_cd" />
                </div>
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/2 xl:w-1/6 mb-4 px-1">
                    <vs-input class="w-full" label="Use Status" v-model="selected.user_sts_yn" />
                </div>
            </div>

            <vs-table stripe pagination max-items="15" :data="datas" v-model="selected" @selected="handleSelected">
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
            status: [
                { 'label': 'Active', 'value': 'Y' },
                { 'label': 'Inactive', 'value': 'N' }
            ],
            selected: {
                user_id: null,
                user_pw: null,
                user_nm: null,
                email: null,
                role_cd: null,
                user_sts_yn: null,
            },
            datas: [],
            page: 1,
            limit: 15
        }
    },
    methods: {
        fetchUsers: function (page, limit) {
            axios.get('/api/user')
                .then((res) => {
                    this.datas = res.data.data
                    console.log(res.data.data)
                })
        },
        handleSelected(tr) {
            // 
		},
        add: function () {
            alert('add')
        },
        save: function () {
            alert('save')
        },
        query: function () {
            this.fetchUsers()
        },
        remove: function () {
            alert('remove')
        }
    }
}
</script>