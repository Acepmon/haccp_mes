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
                component: () => import('./views/Home.vue')
              },
              {
                path: '/example',
                name: 'example',
                component: () => import('./views/Example.vue')
              },
              {
                path: '/1',
                name: '정보관리',
                redirect: '/1/1'
              },
              {
                path: '/1/1',
                name: '회사정보등록',
                component: () => import('./views/Page-1-1.vue')
              },
              {
                path: '/1/2',
                name: '생산담당자등록',
                component: () => import('./views/Page-1-2.vue')
              },
              {
                path: '/1/3',
                name: 'HACCP담당자등록',
                component: () => import('./views/Page-1-3.vue')
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
              }
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
