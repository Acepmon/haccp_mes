<template>
	<div>
		<h4>회사 정보</h4>

		<vs-breadcrumb
			:separator="$vs.rtl ? 'chevron_left' : 'chevron_right'"
			:items="
			[
				{
					title: '정보관리',
					url: '/1'
				},
				{
					title: '기업정보 수정',
					url: '/1/1',
					active: true
				},
			]"
		></vs-breadcrumb>

		<vx-card class="mt-5">
			<h2 class="mb-5">기본정보</h2>

			<vs-table stripe :data="data">

				<vs-tr>
					<vs-th class="h5 py-5 text-center">회사명</vs-th>
					<vs-td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cupiditate laboriosam id hic natus quo dolorum voluptas</vs-td>
				</vs-tr>
				<vs-tr>
					<vs-th class="h5 py-5 text-center">사업자등록번호</vs-th>
					<vs-td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cupiditate laboriosam id hic natus quo dolorum voluptas</vs-td>
				</vs-tr>
				<vs-tr>
					<vs-th class="h5 py-5 text-center">대표명</vs-th>
					<vs-td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cupiditate laboriosam id hic natus quo dolorum voluptas</vs-td>
				</vs-tr>
				<vs-tr>
					<vs-th class="h5 py-5 text-center">전화번호</vs-th>
					<vs-td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cupiditate laboriosam id hic natus quo dolorum voluptas</vs-td>
				</vs-tr>
				<vs-tr>
					<vs-th class="h5 py-5 text-center">팩스번호</vs-th>
					<vs-td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cupiditate laboriosam id hic natus quo dolorum voluptas</vs-td>
				</vs-tr>
				<vs-tr>
					<vs-th class="h5 py-5 text-center">홈페이지</vs-th>
					<vs-td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cupiditate laboriosam id hic natus quo dolorum voluptas</vs-td>
				</vs-tr>

			</vs-table>

			<div class="mt-5">
				<h5>주소</h5>

				<form>
					<div class="vx-row">
						<div class="vx-col">
							<vs-input v-model="disabled1" label-placeholder="" disabled />
						</div>
						<div class="vx-col">
							<!-- search button -->
							<vs-button type="border">주소첮기</vs-button>
						</div>
					</div>
					<div class="vx-row">
						<div class="vx-col">
							<vs-input v-model="disabled2" label-placeholder="" disabled />
						</div>
					</div>
					<div class="vx-row">
						<div class="vx-col">
							<vs-input v-model="addressDetails" label-placeholder="상세주소" />
						</div>
					</div>
				</form>
			</div>
		</vx-card>
	</div>
</template>

<script>
export default {
	data() {
		return {
			data: [
				{label: '회사명', value: ''},
				{label: '사업자등록번호', value: ''},
				{label: '대표명', value: ''},
				{label: '전화번호', value: ''},
				{label: '팩스번호', value: ''},
				{label: '홈페이지', value: ''},
			],
			address: {
				disabled1: '',
				disabled2: '',
				addressDetails: ''
			}
		}
	}
}
</script>