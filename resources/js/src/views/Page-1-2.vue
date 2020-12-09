<template>
	<div>
        <vx-card>
            <form ref="form">
                <div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-6">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span><span class="text-danger">*</span> 휴대폰번호(ID)</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input />
                            </div>
                        </div>
                    </div>

                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-6">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span><span class="text-danger">*</span> 이름</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-6">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span><span class="text-danger">*</span> 비밀번호</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input />
                            </div>
                        </div>
                    </div>

                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-6">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span>비밀번호확인</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-6">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span>이메일</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-6">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span><span class="text-danger">*</span> 메뉴접근권한</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full flex flex-row">
                                <vs-button color="primary" class="px-3 ml-1 mt-1" type="border" icon-pack="feather" icon="icon-check">원/부자재관리</vs-button>
                                <vs-button color="dark" disabled type="border" class="px-3 ml-1 mt-1">생산관리</vs-button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-6">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span><span class="text-danger">*</span> 담당업무</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full flex flex-row">
                                <vs-button color="primary" class="px-3 ml-1 mt-1" type="border" icon-pack="feather" icon="icon-check">원/부자재관리</vs-button>
                                <vs-button color="dark" disabled type="border" class="px-3 ml-1 mt-1">생산관리</vs-button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-6">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span><span class="text-danger">*</span> 업무권한</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-select></vs-select>
                            </div>
                        </div>
                    </div>

                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-6">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span><span class="text-danger">*</span> 사용여부</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-select></vs-select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </vx-card>

		<vx-card class="mt-5">
            <div class="flex flex-wrap justify-end mb-5">
                <vs-button @click="add()" class="mx-1" color="dark" type="border" :disabled="isSelected">Add</vs-button>
                <vs-button @click="save()" class="mx-1" color="dark" type="border" :disabled="!isSelected">Save</vs-button>
                <vs-button @click="query()" class="mx-1" color="dark" type="border">Query</vs-button>
                <vs-button @click="close()" class="mx-1" color="dark" type="border">Close</vs-button>
                <vs-button @click="remove()" class="mx-1" color="dark" type="border" :disabled="!isSelected">Delete</vs-button>
            </div>

            <form ref="form">
                <div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 mb-4 px-1">
                        <vs-input class="w-full" label="User ID" v-model="selected.user_id" description-text="Maximum of 15 characters allowed" />
                    </div>
                    <div class="w-full sm:w-1/2 mb-4 px-1">
                        <vs-input class="w-full" label="User Password" v-model="selected.user_pw" type="password" />
                    </div>
                    <div class="w-full sm:w-1/2 mb-4 px-1">
                        <vs-input class="w-full" label="User Name" v-model="selected.user_nm" description-text="Maximum of 20 characters allowed" />
                    </div>
                    <div class="w-full sm:w-1/2 mb-4 px-1">
                        <vs-input class="w-full" label="User e-Mail" v-model="selected.email" type="email" :success="validEmail" success-text="Email valid" />
                    </div>
                    <div class="w-full sm:w-1/2 mb-4 px-1">
                        <vs-select class="w-full" label="Role Name" v-model="selected.role_cd" multiple>
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
            </form>

            <div class="flex flex-wrap justify-end mb-5">
                <vs-button @click="excel()" class="mx-1" color="dark" type="border" :disabled="datas.length <= 0">To Excel</vs-button>
            </div>

            <vs-table stripe pagination description sst :max-items="pagination.limit" :data="datas" :total="pagination.total" @change-page="handleChangePage" @sort="handleSort" v-model="selected" @selected="handleSelected">
				<template slot="thead">
					<vs-th>No</vs-th>
					<vs-th sort-key="user_id">사용자 ID</vs-th>
					<vs-th sort-key="user_nm">이름</vs-th>
					<vs-th sort-key="user_pw">비밀번호</vs-th>
					<vs-th sort-key="email">이메일</vs-th>
					<vs-th sort-key="appr_cd">담당업무</vs-th>
					<vs-th sort-key="role_cd">메뉴접근권한</vs-th>
                    <vs-th sort-key="reg_dtm">등록일시</vs-th>
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

						<vs-td :data="data[index].user_pw">
							{{ data[index].user_pw }}
						</vs-td>

						<vs-td :data="data[index].email">
							{{ data[index].email }}
						</vs-td>

                        <vs-td :data="data[index].appr_nm">
							{{ data[index].appr_nm }}
						</vs-td>

						<vs-td :data="data[index].role_nm">
							{{ data[index].role_nm }}
						</vs-td>

                        <vs-td :data="data[index].reg_dtm">
							{{ data[index].reg_dtm }}
						</vs-td>

					</vs-tr>
				</template>
			</vs-table>
        </vx-card>
	</div>
</template>

<script>
import axios from 'axios'
import comm_cd from '@/services/comm_cd'
import api from '@/services/user'

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
                role_cd: [],
                appr_cd: null,
                job_cd: null,
                user_sts_yn: null,
            },
            isSelected: false,
            datas: [],

            pagination: {
				page: 1,
				limit: 15,
				total: 0,
			},
			sorting: {
				sort: 'reg_dtm',
				order: 'asc'
			},
        }
    },
    computed: {
        validEmail() {
            return this.selected.email != null ? /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.selected.email) : false
        },

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
        overallIndex: function (index) {
			return (this.pagination.page * this.pagination.limit)-this.pagination.limit + index + 1
		},

        handleSelected: function (tr) {
            this.isSelected = true
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

        clearSelected: function () {
            this.isSelected = false
            this.selected = {
                user_id: null,
                user_pw: null,
                user_nm: null,
                email: null,
                role_cd: null,
                appr_cd: null,
                job_cd: null,
                user_sts_yn: null
            }
        },

        add: function () {
            api.post(this.selected)
                .then((res) => {
                    if (res.data.success) {
                        this.$vs.notify({
                            color: 'success',
                            position: 'top-right',
                            title: `New User`,
                            text: `Successfully added new user record`
                        })
                        this.query()
                        this.clearSelected()
                    }
                })
        },

        save: function () {
            this.$vs.dialog({
                color: 'success',
                title: 'Confirmation',
                text: 'Save user record?',
                accept: function () {
                    api.put(this.selected.user_id, this.selected)
                        .then((res) => {
                            if (res.data.success) {
                                this.$vs.notify({
                                    color: 'success',
                                    position: 'top-right',
                                    title: `Saved User`,
                                    text: `Successfully updated user record`
                                })
                                this.query()
                                this.clearSelected()
                            }
                        })
                }
            })
        },

        query: function () {
            api.fetch({
                ...this.paginationParam,
			    ...this.sortParam
            }).then((res) => {
                this.datas = res.data.data
                this.pagination.total = res.data.meta.total
				this.pagination.page = res.data.meta.current_page
            })
        },

        close: function () {
            this.$vs.dialog({
                color: 'dark',
                title: 'Confirmation',
                text: 'Close document?',
                accept: function () {
                    alert('Alerted')
                }
            })
        },

        remove: function () {
            var sUserId = this.selected.user_id
            this.$vs.dialog({
                color: 'danger',
                title: 'Confirmation',
                text: 'Delete user record?',
                accept: function () {
                    api.delete(sUserId)
                        .then((res) => {
                            if (res.data.success) {
                                this.$vs.notify({
                                    color: 'success',
                                    position: 'top-right',
                                    title: `Deleted user`,
                                    text: `Successfully deleted user record`
                                })
                                this.query()
                                this.clearSelected()
                            }
                        })
                }
            })
        },

        excel: function () {
            window.location.href = api.downloadUrl()
        }
    },
    created () {
        comm_cd.fetchRoles({limit: 0}).then((res) => {
            this.roles = res.data.data
        })

        comm_cd.fetchApprovals({limit: 0}).then((res) => {
            this.approvals = res.data.data
        })

        comm_cd.fetchJobs({limit: 0}).then((res) => {
            this.jobs = res.data.data
        })

        this.query()
    }
}
</script>