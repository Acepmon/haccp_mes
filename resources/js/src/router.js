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
                component: () => import('./views/Home.vue'),
                meta: {
                  auth: {redirect: {name: 'login'}, forbiddenRedirect: '/error-403'}
                }
              },
              {
                path: '/page2',
                name: 'page-2',
                component: () => import('./views/Page2.vue'),
                meta: {
                  auth: {redirect: {name: 'login'}, forbiddenRedirect: '/error-403'}
                }
              },
              {
                path: '/information-mgmt',
                name: 'information-management',
                component: () => import('./views/InformationMgmt.vue'),
                meta: {
                  auth: {redirect: {name: 'login'}, forbiddenRedirect: '/error-403'}
                }
              },
              {
                path: '/purchase-mgmt',
                name: 'purchase-management',
                component: () => import('./views/PurchaseMgmt.vue'),
                meta: {
                  auth: {redirect: {name: 'login'}, forbiddenRedirect: '/error-403'}
                }
              },
              {
                path: '/order-process',
                name: 'order-process',
                component: () => import('./views/OrderProcess.vue'),
                meta: {
                  auth: {redirect: {name: 'login'}, forbiddenRedirect: '/error-403'}
                }
              },
              {
                path: '/production-mgmt',
                name: 'production-management',
                component: () => import('./views/ProductionMgmt.vue'),
                meta: {
                  auth: {redirect: {name: 'login'}, forbiddenRedirect: '/error-403'}
                }
              },
              {
                path: '/shipping-mgmt',
                name: 'shipping-management',
                component: () => import('./views/ShippingMgmt.vue'),
                meta: {
                  auth: {redirect: {name: 'login'}, forbiddenRedirect: '/error-403'}
                }
              },
              {
                path: '/haccp-monitor',
                name: 'haccp-monitor',
                component: () => import('./views/HaccpMonitor.vue'),
                meta: {
                  auth: {redirect: {name: 'login'}, forbiddenRedirect: '/error-403'}
                }
              },
              {
                path: '/data-mgmt',
                name: 'data-management',
                component: () => import('./views/DataMgmt.vue'),
                meta: {
                  auth: {redirect: {name: 'login'}, forbiddenRedirect: '/error-403'}
                }
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
