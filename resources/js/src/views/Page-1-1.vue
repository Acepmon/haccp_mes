<template>
	<div>
		<vx-card id="div-with-loading" class="vs-con-loading__container">
			<div class="flex flex-wrap justify-end mb-2">
                <vs-button @click="saveDialog()" class="mx-1" color="dark" type="border" :disabled="!comp_info.comp_id">{{ $t('Save') }}</vs-button>
                <vs-button @click="query()" class="mx-1" color="dark" type="border">{{ $t('Query') }}</vs-button>
                <vs-button @click="removeDialog()" class="mx-1" color="dark" type="border" :disabled="!comp_info.comp_id">{{ $t('Delete') }}</vs-button>
                <vs-button @click="closeTab()" class="mx-1" color="dark" type="border">{{ $t('Close') }}</vs-button>
            </div>

			<form action="#">
				<!-- Row 1 -->
				<div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span><span class="text-danger">*</span> 사업자등록번호</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info.comp_id" />
                            </div>
                        </div>
                    </div>

                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span><span class="text-danger">*</span> 회사명</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info.comp_nm" />
                            </div>
                        </div>
                    </div>
                </div>
				<!-- /row 1 -->

				<!-- Row 2 -->
				<div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span><span class="text-danger">*</span> 대표자명</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info.ceo_nm" />
                            </div>
                        </div>
                    </div>

                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span>홈페이지</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info.url" />
                            </div>
                        </div>
                    </div>
                </div>
				<!-- /row 2 -->

				<!-- Row 3 -->
				<div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span>전화번호</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info.tel_no" />
                            </div>
                        </div>
                    </div>

                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span>팩스번호</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info.fax_no" />
                            </div>
                        </div>
                    </div>
                </div>
				<!-- /row 3 -->

				<!-- Row 4 -->
				<div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span>우편번호</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info.zip_cd" />
                            </div>
                        </div>
                    </div>
                </div>
				<!-- /row 4 -->

				<!-- Row 5 -->
				<div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span>주소</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input class="w-full" v-model="comp_info.addr1" />
                            </div>
                        </div>
						<div class="vx-row mb-2">
							<div class="vx-col sm:w-1/3 w-full flex items-center justify-end"></div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input class="w-full" v-model="comp_info.addr2" />
                            </div>
                        </div>
                    </div>
                </div>
				<!-- /row 5 -->

				<!-- Row 6 -->
				<div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span>HACCP 팀장 정보</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-button @click="chooseUserDialog()" color="primary" type="border">담당자 변경</vs-button>
                            </div>
                        </div>
                    </div>
                </div>
				<!-- /row 6 -->

				<!-- Row 7 -->
				<div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span>이름</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info.haccp_user.user_nm" />
                            </div>
                        </div>
                    </div>

                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span>휴대폰번호(ID)</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info.haccp_user.user_id" />
                            </div>
                        </div>
                    </div>
                </div>
				<!-- /row 7 -->

				<!-- Row 8 -->
				<div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span>이메일</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info.haccp_user.email" />
                            </div>
                        </div>
                    </div>
                </div>
				<!-- /row 8 -->

				<!-- Row 9 -->
				<div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex items-center justify-end">
                                <span>HACCP 젹용 품목류</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info.haccp_item" />
                            </div>
                        </div>
                    </div>
                </div>
				<!-- /row 9 -->
			</form>
		</vx-card>

		<vs-prompt
			@cancel="selectedUser = null"
			@accept="selectUser"
			@close="close"
			:active.sync="userSelectionPrompt">
			<div class="con-exemple-prompt">
				<span>Select User</span>
				<vs-select class="mt-3 w-full" v-model="selectedUser">
					<vs-select-item v-for="(user, index) in users" :key="index" :text="user.user_nm" :value="user"></vs-select-item>
				</vs-select>
			</div>
		</vs-prompt>
	</div>
</template>

<script>
import axios from 'axios'
import comm_cd from '@/services/comm_cd'
import user from '@/services/user'
import api from '@/services/comp_info'
import {mapActions} from 'vuex';

export default {
	data() {
		return {
			userSelectionPrompt: false,
			users: [],
			selectedUser: null,
			comp_info: {
				comp_id: null,
				comp_nm: null,
				ceo_nm: null,
				tel_no: null,
				fax_no: null,
				url: null,
				zip_cd: null,
				addr1: null,
				addr2: null,
				haccp_id: null,
				haccp_user: {
					user_id: null,
					user_nm: null,
					email: null
				},
				haccp_item: null,
				reg_id: null,
				reg_dtm: null,
			}
		}
	},

	created () {
		setTimeout(() => {
			this.query()
		}, 300);
	},

	methods: {
		...mapActions({
            removeTab: 'mdn/removeTab',
		}),

		clearCompInfo () {
			this.$set(this, 'comp_info', {
				comp_id: null,
				comp_nm: null,
				ceo_nm: null,
				tel_no: null,
				fax_no: null,
				url: null,
				zip_cd: null,
				addr1: null,
				addr2: null,
				haccp_id: null,
				haccp_user: {
					user_id: null,
					user_nm: null,
					email: null
				},
				haccp_item: null,
				reg_id: null,
				reg_dtm: null,
			})
		},

		save () {
			this.$vs.loading({
				container: '#div-with-loading',
				scale: 0.6
			})

			setTimeout( ()=> {
				this.$vs.loading.close('#div-with-loading > .con-vs-loading')
			}, 3000);
		},

		saveDialog () {
			this.$vs.dialog({
                type: 'confirm',
                color: 'success',
                title: this.$t('Confirmation'),
                text: this.$t('SaveCompInfo'),
                acceptText: this.$t('Accept'),
                cancelText: this.$t('Cancel'),
                accept: () => this.save()
            })
		},

		query () {
			this.clearCompInfo()
			this.$vs.loading({
				container: '#div-with-loading',
				scale: 0.6
			})

			api.fetch().then((res) => {
				this.$vs.loading.close('#div-with-loading > .con-vs-loading')

				if (res.data.success == false) {
					this.$vs.notify({
						title: this.$t('Error'),
						position: 'top-right',
						color: 'warning',
						iconPack: 'feather',
        				icon:'icon-alert-circle',
						text: res.data.message,
					})
				} else {
					this.comp_info = res.data.data
				}
			}).catch((err) => {
				this.$vs.loading.close('#div-with-loading > .con-vs-loading')
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
			this.$vs.loading({
				container: '#div-with-loading',
				scale: 0.6
			})

			api.delete(this.comp_info.comp_id).then((res) => {
				this.$vs.loading.close('#div-with-loading > .con-vs-loading')

				if (res.data.success) {
					this.clearCompInfo()
					this.$vs.notify({
						title: this.$t('DeletedCompInfo'),
						position: 'top-right',
						color: 'success',
						text: res.data.message,
					})
				} else {
					this.$vs.notify({
						title: this.$t('Error'),
						position: 'top-right',
						color: 'warning',
						iconPack: 'feather',
						icon:'icon-alert-circle',
						text: res.data.message,
					})
				}
			}).catch((err) => {
				this.$vs.loading.close('#div-with-loading > .con-vs-loading')
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

		removeDialog () {
            this.$vs.dialog({
                type: 'confirm',
                color: 'danger',
                title: this.$t('Confirmation'),
                text: this.$t('DeleteCompInfo'),
                acceptText: this.$t('Accept'),
                cancelText: this.$t('Cancel'),
                accept: () => this.remove()
            })
		},

		closeTab () {
            this.$vs.dialog({
                type: 'confirm',
                color: 'dark',
                title: this.$t('Confirmation'),
                text: this.$t('CloseDocument'),
                acceptText: this.$t('Accept'),
                cancelText: this.$t('Cancel'),
                accept: () => this.removeTab('page-1-1')
            })
		},
		
		chooseUserDialog () {
			this.userSelectionPrompt = true
			this.selectedUser = this.comp_info.haccp_user
			user.fetch({
				limit: -1
			}).then((res) => {
				this.users = res.data.data
			})
		},

		selectUser () {
			this.comp_info.haccp_user = this.selectedUser
			this.selectedUser = null
		}
	}
}
</script>