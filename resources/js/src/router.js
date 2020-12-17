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
                component: () => import('./views/Empty.vue')
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
                name: '생산제품등록',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/6', value: 'page-1-6', label: '생산제품등록', component: 'page-1-6'}) } }
              },
              {
                path: '/1/7',
                name: '원료배합비율',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/1/7', value: 'page-1-7', label: '원료배합비율', component: 'page-1-7'}) } }
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
                path: '/2',
                name: '구매관리',
                component: () => import('./views/Empty.vue')
              },
              {
                path: '/3',
                name: '주문처리',
                component: () => import('./views/Empty.vue')
              },
              {
                path: '/4',
                name: '생산관리',
                component: () => import('./views/Empty.vue')
              },
              {
                path: '/5',
                name: '출하관리',
                component: () => import('./views/Empty.vue')
              },
              {
                path: '/6',
                name: 'HACCP모니터링',
                component: () => import('./views/Empty.vue')
              },
              {
                path: '/7',
                name: '자료관리',
                component: () => import('./views/Empty.vue')
              },
              {
                path: '/7/1',
                name: '정보보호관리',
                component: { created () { this.$store.dispatch('mdn/addTab', {path: '/7/1', value: 'page-7-1', label: '정보보호관리', component: 'page-7-1'}) } }
              },

              {
                path: '/user-entry',
                name: 'User Entry',
                component: () => import('./views/UserEntry.vue')
              },
              {
                path: '/login-history',
                name: 'Login History',
                component: () => import('./views/LoginHist.vue')
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
