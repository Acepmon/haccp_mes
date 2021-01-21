/*=========================================================================================
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const router = new Router({
    mode: 'history',
    base: '/',
    scrollBehavior () {
        return { x: 0, y: 0 }
    },
    routes: [

        {
        // =============================================================================
        // MAIN LAYOUT ROUTES
        // =============================================================================
            path: '',
            component: () => import('./layouts/main/Main.vue'),
            children: [
            // =============================================================================
            // Theme Routes
            // =============================================================================
              {
                path: '/',
                name: 'home',
                // component: () => import('./views/Home.vue')
                redirect: '/1'
              },
              {
                path: '/1',
                name: '정보관리',
                component: () => import(/* webpackChunkName: "empty" */ './views/Empty.vue')
              },
              {
                path: '/1/1',
                name: '회사정보등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/1', value: 'page-1-1', label: '회사정보등록', component: 'page-1-1'}) } }
              },
              {
                path: '/1/2',
                name: 'HACCP담당자 관리',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/2', value: 'page-1-2', label: 'HACCP담당자 관리', component: 'page-1-2'}) } }
              },
              {
                path: '/1/3',
                name: '생산담당자 관리',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/3', value: 'page-1-3', label: '생산담당자 관리', component: 'page-1-3'}) } }
              },
              {
                path: '/1/4/1',
                name: 'HACCP 기준서 등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/4/1', value: 'page-1-4-1', label: 'HACCP 기준서 등록', component: 'page-1-4-1'}) } }
              },
              {
                path: '/1/4/2',
                name: '식품위생서류 등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/4/2', value: 'page-1-4-2', label: '식품위생서류 등록', component: 'page-1-4-2'}) } }
              },
              {
                path: '/1/4/3',
                name: 'HACCP 이행점검표',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/4/3', value: 'page-1-4-3', label: 'HACCP 이행점검표', component: 'page-1-4-3'}) } }
              },
              {
                path: '/1/5/1',
                name: '가공원료 기준등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/5/1', value: 'page-1-5-1', label: '가공원료 기준등록', component: 'page-1-5-1'}) } }
              },
              {
                path: '/1/5/2',
                name: '원료 기준등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/5/2', value: 'page-1-5-2', label: '원료 기준등록', component: 'page-1-5-2'}) } }
              },
              {
                path: '/1/5/3',
                name: '부자재 기준등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/5/3', value: 'page-1-5-3', label: '부자재 기준등록', component: 'page-1-5-3'}) } }
              },
              {
                path: '/1/6',
                name: '원/부자재 관리',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/6', value: 'page-1-6', label: '원/부자재 관리', component: 'page-1-6'}) } }
              },
              {
                path: '/1/6/1',
                name: '원/부자재 단위관리',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/6/1', value: 'page-1-6-1', label: '원/부자재 단위관리', component: 'page-1-6-1'}) } }
              },
              {
                path: '/1/7',
                name: 'BOM 관리',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/7', value: 'page-1-7', label: 'BOM 관리', component: 'page-1-7'}) } }
              },
              {
                path: '/1/8/1',
                name: '전처리공정등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/8/1', value: 'page-1-8-1', label: '전처리공정등록', component: 'page-1-8-1'}) } }
              },
              {
                path: '/1/8/2',
                name: '제조공정등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/8/2', value: 'page-1-8-2', label: '제조공정등록', component: 'page-1-8-2'}) } }
              },
              {
                path: '/1/9',
                name: '구매기업정보등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/9', value: 'page-1-9', label: '구매기업정보등록', component: 'page-1-9'}) } }
              },
              {
                path: '/1/10',
                name: '납품기업정보등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/10', value: 'page-1-10', label: '납품기업정보등록', component: 'page-1-10'}) } }
              },
              {
                path: '/1/11',
                name: '정보보호관리',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/11', value: 'page-1-11', label: '정보보호관리', component: 'page-1-11'}) } }
              },
              {
                path: '/1/12',
                name: 'App Version',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/12', value: 'page-1-12', label: 'App Version', component: 'page-1-12'}) } }
              },

              {
                path: '/2',
                name: '구매관리',
                component: () => import(/* webpackChunkName: "empty" */ './views/Empty.vue')
              },
              {
                path: '/2/1',
                name: '제품별 표준공정등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/2/1', value: 'page-2-1', label: '제품별 표준공정등록', component: 'page-2-1'}) } }
              },
              {
                path: '/2/2',
                name: '생산지시 등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/2/2', value: 'page-2-2', label: '생산지시 등록', component: 'page-2-2'}) } }
              },
              {
                path: '/2/3',
                name: '생산지시 조회',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/2/3', value: 'page-2-3', label: '생산지시 조회', component: 'page-2-3'}) } }
              },
              {
                path: '/2/4',
                name: '작업자 배치',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/2/4', value: 'page-2-4', label: '작업자 배치', component: 'page-2-4'}) } }
              },
              {
                path: '/2/7',
                name: '생산자 근태기록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/2/7', value: 'page-2-7', label: '생산자 근태기록', component: 'page-2-7'}) } }
              },

              {
                path: '/3',
                name: '거래처관리',
                component: () => import(/* webpackChunkName: "empty" */ './views/Empty.vue')
              },
              {
                path: '/3/1',
                name: '거래처 등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/3/1', value: 'page-3-1', label: '거래처 등록', component: 'page-3-1'}) } }
              },
              {
                path: '/3/2',
                name: '거래처 조회',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/3/2', value: 'page-3-2', label: '거래처 조회', component: 'page-3-2'}) } }
              },
              
              {
                path: '/4',
                name: '재고관리',
                component: () => import(/* webpackChunkName: "empty" */ './views/Empty.vue')
              },
              {
                path: '/4/1',
                name: '시리얼/Lot 등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/4/1', value: 'page-4-1', label: '시리얼/Lot 등록', component: 'page-4-1'}) } }
              },
              {
                path: '/4/2',
                name: '생산불출 등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/4/2', value: 'page-4-2', label: '생산불출 등록', component: 'page-4-2'}) } }
              },
              {
                path: '/4/3',
                name: '창고별 재고조회',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/4/3', value: 'page-4-3', label: '창고별 재고조회', component: 'page-4-3'}) } }
              },
              {
                path: '/4/4',
                name: '품목별 단가정보',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/4/4', value: 'page-4-4', label: '품목별 단가정보', component: 'page-4-4'}) } }
              },
              
              {
                path: '/5',
                name: '출하관리',
                component: () => import(/* webpackChunkName: "empty" */ './views/Empty.vue')
              },
              {
                path: '/6',
                name: 'HACCP모니터링',
                component: () => import(/* webpackChunkName: "empty" */ './views/Empty.vue')
              },
              {
                path: '/6/1',
                name: 'CCP 모니터링',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/6/1', value: 'page-6-1', label: 'CCP 모니터링', component: 'page-6-1'}) } }
              },
              {
                path: '/6/2',
                name: 'CCP 이탈한계설정',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/6/2', value: 'page-6-2', label: 'CCP 이탈한계설정', component: 'page-6-2'}) } }
              },
              {
                path: '/6/3',
                name: 'CCP 이탈정보',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/6/3', value: 'page-6-3', label: 'CCP 이탈정보', component: 'page-6-3'}) } }
              },
              {
                path: '/6/4',
                name: 'CCP 자료 조회',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/6/4', value: 'page-6-4', label: 'CCP 자료 조회', component: 'page-6-4'}) } }
              },
              {
                path: '/6/5',
                name: 'HACCP 점검결과',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/6/5', value: 'page-6-5', label: 'HACCP 점검결과', component: 'page-6-5'}) } }
              },
              {
                path: '/7',
                name: '자료관리',
                component: () => import(/* webpackChunkName: "empty" */ './views/Empty.vue')
              },
              {
                path: '/7/1',
                name: '공통코드 관리',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/7/1', value: 'page-7-1', label: '공통코드 관리', component: 'page-7-1'}) } }
              },
              {
                path: '/7/2',
                name: '사용자 로그이력',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/7/2', value: 'page-7-2', label: '사용자로그이력', component: 'page-7-2'}) } }
              },
              {
                path: '/profile',
                name: 'Profile',
                redirect: '/profile/general'
              },
              {
                path: '/profile/general',
                name: 'Profile General',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/profile/general', value: 'profile-general', label: 'Profile General', component: 'profile-general'}) } }
              },
              {
                path: '/profile/password',
                name: 'Change Password',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/profile/password', value: 'profile-password', label: 'Change Password', component: 'profile-password'}) } }
              },
              {
                path: '/profile/notifications',
                name: 'Notifications',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/profile/notifications', value: 'profile-notifications', label: 'Notifications', component: 'profile-notifications'}) } }
              },
              {
                path: '/user-entry',
                name: 'User Entry',
                component: () => import(/* webpackChunkName: "user-entry" */ './views/UserEntry.vue')
              },
            ],
        },
        // =============================================================================
        // FULL PAGE LAYOUTS
        // =============================================================================
        {
            path: '',
            component: () => import('@/layouts/full-page/FullPage.vue'),
            children: [
              // =============================================================================
              // PAGES
              // =============================================================================
              {
                path: '/login',
                name: 'login',
                component: () => import('@/views/pages/Login.vue')
              },
              {
                path: '/reset-password',
                name: 'reset-password',
                component: () => import('@/views/pages/ResetPassword.vue')
              },
              {
                path: '/error-404',
                name: 'error-404',
                component: () => import('@/views/pages/Error404.vue')
              },
              {
                path: '/error-403',
                name: 'error-403',
                component: () => import('@/views/pages/Error403.vue')
              },
            ]
        },
        // Redirect to 404 page, if no match found
        {
            path: '*',
            redirect: '/error-404'
        }
    ],
})

router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')
    if (appLoading) {
        appLoading.style.display = "none";
    }
})

export default router
