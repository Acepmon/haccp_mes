<template>
	<div>
		<vx-card id="div-with-loading" class="vs-con-loading__container">
			<div class="flex flex-wrap mb-2">
				<div class="w-full sm:w-1/2 px-1 flex justify-end">
				</div>
				<div class="w-full sm:w-1/2 px-1 flex justify-end">
					<vs-button @click="query()" class="mx-1 mr-16" color="dark" type="border">{{ $t('Query') }}</vs-button>
					<vs-button @click="saveDialog()" class="mx-1" color="dark" type="border" :disabled="!comp_info['comp_info:comp_id']">{{ $t('Save') }}</vs-button>
					<vs-button @click="removeDialog()" class="mx-1" color="dark" type="border" :disabled="!comp_info['comp_info:comp_id']">{{ $t('Delete') }}</vs-button>
					<vs-button @click="closeDialog()" class="mx-1" color="dark" type="border">{{ $t('Close') }}</vs-button>
				</div>
			</div>

			<form action="#">
				<!-- Row 1 -->
				<div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex justify-end">
                                <span class="pt-2"><span class="text-danger">*</span> 사업자등록번호</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info['comp_info:comp_id']" :danger="errors['comp_info:comp_id'] != null" :danger-text="errors['comp_info:comp_id']" />
                            </div>
                        </div>
                    </div>

                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex justify-end">
                                <span class="pt-2"><span class="text-danger">*</span> 회사명</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info['comp_info:comp_nm']" :danger="errors['comp_info:comp_nm'] != null" :danger-text="errors['comp_info:comp_nm']" />
                            </div>
                        </div>
                    </div>
                </div>
				<!-- /row 1 -->

				<!-- Row 2 -->
				<div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex justify-end">
                                <span class="pt-2"><span class="text-danger">*</span> 대표자명</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info['comp_info:ceo_nm']" :danger="errors['comp_info:ceo_nm'] != null" :danger-text="errors['comp_info:ceo_nm']" />
                            </div>
                        </div>
                    </div>

                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex justify-end">
                                <span class="pt-2">홈페이지</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info['comp_info:url']" :danger="errors['comp_info:url'] != null" :danger-text="errors['comp_info:url']" />
                            </div>
                        </div>
                    </div>
                </div>
				<!-- /row 2 -->

				<!-- Row 3 -->
				<div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex justify-end">
                                <span class="pt-2">전화번호</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info['comp_info:tel_no']" :danger="errors['comp_info:tel_no'] != null" :danger-text="errors['comp_info:tel_no']" />
                            </div>
                        </div>
                    </div>

                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex justify-end">
                                <span class="pt-2">팩스번호</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info['comp_info:fax_no']" type="number" class="vs-input-text-right" :danger="errors['comp_info:fax_no'] != null" :danger-text="errors['comp_info:fax_no']" />
                            </div>
                        </div>
                    </div>
                </div>
				<!-- /row 3 -->

				<!-- Row 4 -->
				<div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex justify-end">
                                <span class="pt-2">우편번호</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info['comp_info:zip_cd']" :danger="errors['comp_info:zip_cd'] != null" :danger-text="errors['comp_info:zip_cd']" />
                            </div>
                        </div>
                    </div>
                </div>
				<!-- /row 4 -->

				<!-- Row 5 -->
				<div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex justify-end">
                                <span class="pt-2">주소</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input class="w-full" v-model="comp_info['comp_info:addr1']" :danger="errors['comp_info:addr1'] != null" :danger-text="errors['comp_info:addr1']" />
                            </div>
                        </div>
						<div class="vx-row mb-2">
							<div class="vx-col sm:w-1/3 w-full flex justify-end"></div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input class="w-full" v-model="comp_info['comp_info:addr2']" :danger="errors['comp_info:addr2'] != null" :danger-text="errors['comp_info:addr2']" />
                            </div>
                        </div>
                    </div>
                </div>
				<!-- /row 5 -->

				<!-- Row 6 -->
				<div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex justify-end">
                                <span class="pt-2">HACCP 팀장 정보</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-button @click="chooseUserDialog()" color="primary" type="border">담당자 변경</vs-button>
								<div class="con-text-validation span-text-validation-danger vs-input--text-validation-span" v-if="errors['comp_info:haccp_id'] != null">
									<span class="span-text-validation" v-text="errors['comp_info:haccp_id']"></span>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
				<!-- /row 6 -->

				<!-- Row 7 -->
				<div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex justify-end">
                                <span class="pt-2">이름</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info['comp_info:haccp_user']['user:user_nm']" />
                            </div>
                        </div>
                    </div>

                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex justify-end">
                                <span class="pt-2">휴대폰번호(ID)</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info['comp_info:haccp_user']['user:user_id']" />
                            </div>
                        </div>
                    </div>
                </div>
				<!-- /row 7 -->

				<!-- Row 8 -->
				<div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex justify-end">
                                <span class="pt-2">이메일</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info['comp_info:haccp_user']['user:email']" />
                            </div>
                        </div>
                    </div>
                </div>
				<!-- /row 8 -->

				<!-- Row 9 -->
				<div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 px-1">
                        <div class="vx-row mb-2">
                            <div class="vx-col sm:w-1/3 w-full flex justify-end">
                                <span class="pt-2">HACCP 젹용 품목류</span>
                            </div>
                            <div class="vx-col sm:w-2/3 w-full">
                                <vs-input v-model="comp_info['comp_info:haccp_item']" :danger="errors['comp_info:haccp_item'] != null" :danger-text="errors['comp_info:haccp_item']" />
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
					<vs-select-item v-for="(user, index) in users" :key="index" :text="user['user:user_nm']" :value="user"></vs-select-item>
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
				'comp_info:comp_id': null,
				'comp_info:comp_nm': null,
				'comp_info:ceo_nm': null,
				'comp_info:tel_no': null,
				'comp_info:fax_no': null,
				'comp_info:url': null,
				'comp_info:zip_cd': null,
				'comp_info:addr1': null,
				'comp_info:addr2': null,
				'comp_info:haccp_id': null,
				'comp_info:haccp_user': {
					'user:user_id': null,
					'user:user_nm': null,
					'user:email': null
				},
				'comp_info:haccp_item': null,
				'comp_info:reg_id': null,
				'comp_info:reg_dtm': null,
			},
			errors: {
				'comp_info:comp_id': null,
				'comp_info:comp_nm': null,
				'comp_info:ceo_nm': null,
				'comp_info:tel_no': null,
				'comp_info:fax_no': null,
				'comp_info:url': null,
				'comp_info:zip_cd': null,
				'comp_info:addr1': null,
				'comp_info:addr2': null,
				'comp_info:haccp_id': null,
				'comp_info:haccp_item': null,
			},
		}
	},

	created () {
		console.log(this.$vs.loading.close)

		setTimeout(() => {
			this.query()
		}, 200);
	},

	methods: {
		...mapActions({
            removeTab: 'mdn/removeTab',
		}),

		clear () {
			this.$set(this, 'comp_info', {
				'comp_info:comp_id': null,
				'comp_info:comp_nm': null,
				'comp_info:ceo_nm': null,
				'comp_info:tel_no': null,
				'comp_info:fax_no': null,
				'comp_info:url': null,
				'comp_info:zip_cd': null,
				'comp_info:addr1': null,
				'comp_info:addr2': null,
				'comp_info:haccp_id': null,
				'comp_info:haccp_user': {
					'user:user_id': null,
					'user:user_nm': null,
					'user:email': null
				},
				'comp_info:haccp_item': null,
				'comp_info:reg_id': null,
				'comp_info:reg_dtm': null,
			})
		},

		spinner (loading = true) {
			if (loading && this.$vs.loading != undefined) {
				this.$vs.loading({
					container: '#div-with-loading',
					scale: 0.6
				})
			} else {
				this.$vs.loading.close('#div-with-loading > .con-vs-loading')
			}
		},

		clearErrors () {
			this.$set(this, 'errors', {
				'comp_info:comp_id': null,
				'comp_info:comp_nm': null,
				'comp_info:ceo_nm': null,
				'comp_info:tel_no': null,
				'comp_info:fax_no': null,
				'comp_info:url': null,
				'comp_info:zip_cd': null,
				'comp_info:addr1': null,
				'comp_info:addr2': null,
				'comp_info:haccp_id': null,
				'comp_info:haccp_item': null,
			})
		},

		displayErrors (errors) {
			for (const [key, value] of Object.entries(errors)) {
				this.$set(this.errors, key, Array.isArray(value) ? value[0] : value)
			}
		},

		save () {
			this.spinner()
			this.clearErrors()

			api.post(this.comp_info).then((res) => {
				this.spinner(false)

				if (res.data.success) {
					this.$vs.notify({
						title: this.$t('SuccessSaveData'),
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
				this.displayErrors(err.response.data.hasOwnProperty('errors') ? err.response.data.errors : null)
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

		query () {
			this.spinner()

			api.fetch().then((res) => {
				this.spinner(false)

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

					if (res.data.data['comp_info:haccp_user'] == null) {
						this.comp_info['comp_info:haccp_user'] = {
							'user:user_id': null,
							'user:user_nm': null,
							'user:email': null
						}
					}
				}
			}).catch((err) => {
				this.displayErrors(err.response.data.hasOwnProperty('errors') ? err.response.data.errors : null)
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
			this.spinner()

			api.delete(this.comp_info['comp_info:comp_id']).then((res) => {
				this.spinner(false)

				if (res.data.success) {
					this.clear()
					this.$vs.notify({
						title: this.$t('SuccessDeleteData'),
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
				this.displayErrors(err.response.data.hasOwnProperty('errors') ? err.response.data.errors : null)
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
                accept: () => this.removeTab('page-1-1')
            })
		},
		
		chooseUserDialog () {
			this.userSelectionPrompt = true
			this.selectedUser = this.comp_info['comp_info:haccp_user']
			user.fetch({
				limit: -1
			}).then((res) => {
				this.users = res.data.data
			})
		},

		selectUser () {
			this.comp_info['comp_info:haccp_id'] = this.selectedUser['user:user_id']
			this.comp_info['comp_info:haccp_user'] = this.selectedUser
			this.selectedUser = null
		}
	}
}
</script>