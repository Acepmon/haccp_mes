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
                redirect: '/information'
              },
              {
                path: '/information', //'information'
                name: '정보관리',
                component: () => import(/* webpackChunkName: "empty" */ './views/Empty.vue')
              },
              {
                path: '/information/company', //'information/company'
                name: '회사정보등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/information/company', value: 'page-1-1', label: '회사정보등록', component: 'page-1-1'}) } }
              },
              {
                path: '/information/user', //'information/user
                name: 'HACCP담당자 관리',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/information/user', value: 'page-1-2', label: 'HACCP담당자 관리', component: 'page-1-2'}) } }
              },
              {
                path: '/information/worker', //'information/worker
                name: '생산담당자 관리',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/information/worker', value: 'page-1-3', label: '생산담당자 관리', component: 'page-1-3'}) } }
              },
              {
                path: '/information/haccp/standard-doc', //'information/haccp/standard-doc
                name: 'HACCP 기준서 등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/information/haccp/standard-doc', value: 'page-1-4-1', label: 'HACCP 기준서 등록', component: 'page-1-4-1'}) } }
              },
              {
                path: '/information/haccp/food-doc', //'information/haccp/food-doc
                name: '식품위생서류 등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/information/haccp/food-doc', value: 'page-1-4-2', label: '식품위생서류 등록', component: 'page-1-4-2'}) } }
              },
              {
                path: '/information/haccp/haccp-doc', //'information/haccp/haccp-doc
                name: 'HACCP 이행점검표',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/information/haccp/haccp-doc', value: 'page-1-4-3', label: 'HACCP 이행점검표', component: 'page-1-4-3'}) } }
              },
              {
                path: '/information/material',//'information/material
                name: '원/부자재 관리',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/information/material', value: 'page-1-6', label: '원/부자재 관리', component: 'page-1-6'}) } }
              },
              {
                path: '/information/material-unit',//'information/material-unit
                name: '원/부자재 단위관리',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/information/material-unit', value: 'page-1-6-1', label: '원/부자재 단위관리', component: 'page-1-6-1'}) } }
              },
              {
                path: '/information/bom',//'information/bom
                name: 'BOM 관리',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/information/bom', value: 'page-1-7', label: 'BOM 관리', component: 'page-1-7'}) } }
              },
              {
                path: '/information/security',//'information/security
                name: '정보보호관리',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/information/security', value: 'page-1-11', label: '정보보호관리', component: 'page-1-11'}) } }
              },
              {
                path: '/information/app-version',//'information/app-version
                name: 'App Version',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/information/app-version', value: 'page-1-12', label: 'App Version', component: 'page-1-12'}) } }
              },

              {
                path: '/product',//'product
                name: '생산관리',
                component: () => import(/* webpackChunkName: "empty" */ './views/Empty.vue')
              },
              {
                path: '/product/standard',//'product/standard
                name: '제품별 표준공정등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/product/standard', value: 'page-2-1', label: '제품별 표준공정등록', component: 'page-2-1'}) } }
              },
              {
                path: '/product/job-order',//'product/job-order
                name: '생산지시 등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/product/job-order', value: 'page-2-2', label: '생산지시 등록', component: 'page-2-2'}) } }
              },
              {
                path: '/product/job-order-query',//'product/job-order-query
                name: '생산지시 조회',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/product/job-order-query', value: 'page-2-3', label: '생산지시 조회', component: 'page-2-3'}) } }
              },
              {
                path: '/product/job-order-worker',//'product/job-order-worker
                name: '작업자 배치',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/product/job-order-worker', value: 'page-2-4', label: '작업자 배치', component: 'page-2-4'}) } }
              },
              {
                path: '/product/job-order-attendance',//'product/job-order-attendance
                name: '생산자 근태기록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/product/job-order-attendance', value: 'page-2-7', label: '생산자 근태기록', component: 'page-2-7'}) } }
              },

              {
                path: '/customer',//'customer
                name: '거래처정보',
                component: () => import(/* webpackChunkName: "empty" */ './views/Empty.vue')
              },
              {
                path: '/customer/customer',//'customer/customer
                name: '거래처 등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/customer/customer', value: 'page-3-1', label: '거래처 등록', component: 'page-3-1'}) } }
              },
              {
                path: '/customer/customer-query',//'customer/customer-query
                name: '거래처 조회',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/customer/customer-query', value: 'page-3-2', label: '거래처 조회', component: 'page-3-2'}) } }
              },
              
              {
                path: '/stock',//'stock
                name: '재고관리',
                component: () => import(/* webpackChunkName: "empty" */ './views/Empty.vue')
              },
              {
                path: '/stock/serial-lot',//'stock/serial-lot
                name: '시리얼/Lot 등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/stock/serial-lot', value: 'page-4-1', label: '시리얼/Lot 등록', component: 'page-4-1'}) } }
              },
              {
                path: '/stock/product-delivery',//'stock/product-delivery
                name: '생산불출 등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/stock/product-delivery', value: 'page-4-2', label: '생산불출 등록', component: 'page-4-2'}) } }
              },
              {
                path: '/stock/statistics',//'stock/statistics
                name: '창고별 재고조회',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/stock/statistics', value: 'page-4-3', label: '창고별 재고조회', component: 'page-4-3'}) } }
              },
              {
                path: '/stock/unit-cost',//'stock/unit-cost
                name: '품목별 단가정보',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/stock/unit-cost', value: 'page-4-4', label: '품목별 단가정보', component: 'page-4-4'}) } }
              },
              {
                path: '/haccp',//'haccp
                name: 'HACCP모니터링',
                component: () => import(/* webpackChunkName: "empty" */ './views/Empty.vue')
              },
              {
                path: '/haccp/ccp-monitoring',//'haccp/ccp-monitoring
                name: 'CCP 모니터링',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/haccp/ccp-monitoring', value: 'page-6-1', label: 'CCP 모니터링', component: 'page-6-1'}) } }
              },
              {
                path: '/haccp/ccp-limit',//'haccp/ccp-limit
                name: 'CCP 이탈한계설정',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/haccp/ccp-limit', value: 'page-6-2', label: 'CCP 이탈한계설정', component: 'page-6-2'}) } }
              },
              {
                path: '/haccp/ccp-escape',//'haccp/ccp-escape
                name: 'CCP 이탈정보',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/haccp/ccp-escape', value: 'page-6-3', label: 'CCP 이탈정보', component: 'page-6-3'}) } }
              },
              {
                path: '/haccp/ccp-data-query',//'haccp/ccp-data-query
                name: 'CCP 자료 조회',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/haccp/ccp-data-query', value: 'page-6-4', label: 'CCP 자료 조회', component: 'page-6-4'}) } }
              },
              {
                path: '/haccp/haccp-result',//'haccp/haccp-result
                name: 'HACCP 점검결과',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/haccp/haccp-result', value: 'page-6-5', label: 'HACCP 점검결과', component: 'page-6-5'}) } }
              },
              {
                path: '/data',//'data
                name: '자료관리',
                component: () => import(/* webpackChunkName: "empty" */ './views/Empty.vue')
              },
              {
                path: '/data/code',//'data/code
                name: '공통코드 관리',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/data/code', value: 'page-7-1', label: '공통코드 관리', component: 'page-7-1'}) } }
              },
              {
                path: '/data/log-history',//'data/log-history
                name: '사용자 로그이력',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/data/log-history', value: 'page-7-2', label: '사용자로그이력', component: 'page-7-2'}) } }
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
