<template>
	<div>
		<!-- <h4>page-1-3</h4> -->

		<vs-breadcrumb
			:separator="$vs.rtl ? 'chevron_left' : 'chevron_right'"
			:items="
			[
				{
					title: '업무담당자 관리',
					url: '/1'
				},
				{
					title: '담당자 정보 등록',
					url: '/1/1',
					active: true
				},
			]"
		></vs-breadcrumb>

		<vx-card class="mt-5">
			<h2 class="mb-5">기본정보</h2>

			<vs-table stripe :data="[0]">

				<vs-tr>
					<vs-th class="h5 py-5 self-center">휴대폰 번호(ID)</vs-th>
					<vs-td>
						<vs-input />
					</vs-td>
				</vs-tr>

				<vs-tr>
					<vs-th class="h5 py-5 self-center">비밀번호</vs-th>
					<vs-td>
						<vs-input />
					</vs-td>
				</vs-tr>

				<vs-tr>
					<vs-th class="h5 py-5 self-center">비밀번호 헉인</vs-th>
					<vs-td>
						<vs-input />
					</vs-td>
				</vs-tr>
				
				<vs-tr>
					<vs-th class="h5 py-5 self-center">이름</vs-th>
					<vs-td>
						<vs-input />
					</vs-td>
				</vs-tr>

				<vs-tr>
					<vs-th class="h5 py-5 self-center">이메일</vs-th>
					<vs-td>
						<vs-input />
					</vs-td>
				</vs-tr>

				<vs-tr>
					<vs-th class="h5 py-5 self-center">메뉴접근 권한</vs-th>
					<vs-td>
						<div class="flex flex-row flex-wrap">
							<vs-button color="primary" class="px-3 ml-1 mt-1" type="border" icon-pack="feather" icon="icon-check">정보관리</vs-button>
							<vs-button color="primary" class="px-3 ml-1 mt-1" type="border" icon-pack="feather" icon="icon-check">생산정보관리</vs-button>
							<vs-button color="primary" class="px-3 ml-1 mt-1" type="border" icon-pack="feather" icon="icon-check">원/부자재관리</vs-button>
							<vs-button color="dark" disabled type="border" class="px-3 ml-1 mt-1">생산관리</vs-button>
							<vs-button color="dark" disabled type="border" class="px-3 ml-1 mt-1">품질관리</vs-button>
							<vs-button color="dark" disabled type="border" class="px-3 ml-1 mt-1">수주/출하관리</vs-button>
							<vs-button color="primary" class="px-3 ml-1 mt-1" type="border" icon-pack="feather" icon="icon-check">OEM관리</vs-button>
							<vs-button color="dark" disabled type="border" class="px-3 ml-1 mt-1">전자문서</vs-button>
						</div>
					</vs-td>
				</vs-tr>

				<vs-tr>
					<vs-th class="h5 py-5 self-center">담당업무</vs-th>
					<vs-td>
						<div class="flex flex-row flex-wrap">
							<vs-button color="primary" class="px-3 ml-1 mt-1" type="border" icon-pack="feather" icon="icon-check">원/부자재</vs-button>
							<vs-button color="primary" class="px-3 ml-1 mt-1" type="border" icon-pack="feather" icon="icon-check">생산관리</vs-button>
							<vs-button color="dark" disabled type="border" class="px-3 ml-1 mt-1">HACCP 이행관리</vs-button>
							<vs-button color="dark" disabled type="border" class="px-3 ml-1 mt-1">출하관리</vs-button>
						</div>
					</vs-td>
				</vs-tr>

				<vs-tr>
					<vs-th class="h5 py-5 self-center">업무 권한</vs-th>
					<vs-td>
						<div class="flex flex-row flex-wrap">
							<vs-button color="dark" disabled type="border" class="px-3 ml-1 mt-1">업무담당자</vs-button>
							<vs-button color="primary" class="px-3 ml-1 mt-1" type="border" icon-pack="feather" icon="icon-check">중간승인자(생산팀장)</vs-button>
							<vs-button color="dark" disabled type="border" class="px-3 ml-1 mt-1">최종승인자(대표이사)</vs-button>
						</div>
					</vs-td>
				</vs-tr>

				<vs-tr>
					<vs-th class="h5 py-5 self-center">게정상태</vs-th>
					<vs-td>
						<vs-select placeholder="사용" />
					</vs-td>
				</vs-tr>

			</vs-table>
		</vx-card>
	</div>
</template>

<script>
export default {
	data() {
		return {
			// 
		}
	}
}
</script>