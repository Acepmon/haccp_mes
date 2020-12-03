<template>
	<div>
		<!-- <h4>page 1-2.</h4> -->

		<vx-card class="mt-5">
			<h2 class="mb-5">생산담당자 관리</h2>

			<div class="mb-5">
				<vs-button size="small">추가</vs-button>
				<vs-button :disabled="selected.length == 0" size="small">삭제</vs-button>
			</div>

			<vs-table stripe pagination max-items="5" :data="datas" v-model="selected" @selected="handleSelected">
				<template slot="thead">
					<vs-th>번호</vs-th>
					<vs-th>이름</vs-th>
					<vs-th>휴대폰번호</vs-th>
					<vs-th>업무구분</vs-th>
					<vs-th>업무내용</vs-th>
					<vs-th>보건증갱신기간</vs-th>
					<vs-th>정/부</vs-th>
				</template>

				<template slot-scope="{data}">
					<vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">

						<vs-td :data="data[indextr].number">
							{{ data[indextr].number }}
						</vs-td>

						<vs-td :data="data[indextr].name">
							{{ data[indextr].name }}
						</vs-td>

						<vs-td :data="data[indextr].phone">
							{{ data[indextr].phone }}
						</vs-td>

						<vs-td :data="data[indextr].class">
							{{ data[indextr].class }}
						</vs-td>

						<vs-td :data="data[indextr].info">
							{{ data[indextr].info }}
						</vs-td>

						<vs-td :data="data[indextr].health">
							{{ data[indextr].health }}
						</vs-td>

						<vs-td :data="data[indextr].type">
							{{ data[indextr].type }}
						</vs-td>

					</vs-tr>
				</template>
			</vs-table>
		</vx-card>

		<vs-popup class="holamundo" fullscreen title="생산 업무담당자 등록" :active.sync="popupActive">
			<div>
				<vs-table :data="[0]">
					<vs-tr>
						<vs-th class="py-3">이름</vs-th>
						<vs-td>
							<vs-input v-model="selected.name" />
						</vs-td>

						<vs-th class="py-3">휴대폰번호(ID)</vs-th>
						<vs-td>
							<vs-input v-model="selected.phone" />
						</vs-td>
					</vs-tr>
					<vs-tr>
						<vs-th class="py-3">비밀번호</vs-th>
						<vs-td>
							<vs-input />
						</vs-td>

						<vs-th class="py-3">비밀번호롹인</vs-th>
						<vs-td>
							<vs-input />
						</vs-td>
					</vs-tr>
					<vs-tr>
						<vs-th class="py-3">업무구분</vs-th>
						<vs-td>
							<vs-select v-model="selected.class" />
						</vs-td>

						<vs-th class="py-3">업무내용</vs-th>
						<vs-td>
							<vs-select v-model="selected.info" />
						</vs-td>
					</vs-tr>
					<vs-tr>
						<vs-th class="py-3">정/부</vs-th>
						<vs-td>
							<div class="vx-row">
								<div class="vx-col">
									<vs-checkbox v-model="checkBox1">정</vs-checkbox>
								</div>
								<div class="vx-col">
									<vs-checkbox v-model="checkBox2">부</vs-checkbox>
								</div>
							</div>
						</vs-td>

						<vs-th class="py-3">보건증갱신기간</vs-th>
						<vs-td>
							<vs-select v-model="selected.health"/>
						</vs-td>
					</vs-tr>
				</vs-table>
			</div>
		</vs-popup>
	</div>
</template>

<script>
export default {
	data() {
		return {
			datas: [
				{
					number: 1,
					name: '홍길동',
					phone: 1234,
					class: '조리',
					info: '준비기',
					health: '',
					type: '정'
				},
				{
					number: 2,
					name: '홍길동',
					phone: 1234,
					class: '조리',
					info: '준비기',
					health: '',
					type: '부'
				}
			],
			checkBox1: true,
			checkBox2: false,
			selected: [],
			popupActive: false,
		}
	},
	methods: {
		handleSelected(tr) {
			this.popupActive = true
			this.$vs.notify({
				title: `Selected ${tr.number}`,
				text: `Name: ${tr.name}`
			})
		}
	}
}
</script>