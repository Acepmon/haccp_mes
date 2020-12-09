/**
 * Tab object structure
 * - tabId : integer
 * - tabLabel : string
 * - tabTo : string
 * - tabComponent: string
 * - tabActive : boolean
 */

import router from '@/router'

const mdn = {
    namespaced: true,

    state: () => ({
        activeTab: 0,
        tabs: [],
        maxTabs: 2
    }),

    mutations: {
        ADD_TAB (state, payload) {
            state.tabs.push({
                value: payload.value,
                label: payload.label,
                component: payload.component,
                path: payload.path,
            })
        },

        REMOVE_TAB (state, payload) {
            state.tabs.splice(payload.index, 1)
        },

        SET_ACTIVE_TAB (state, payload) {
            state.activeTab = payload.value
        },

        SET_ACTIVE_LAST (state) {
            if (state.tabs.length > 0) {
                state.activeTab = state.tabs[state.tabs.length - 1].value
            }
        },

        SET_ACTIVE_FIRST (state) {
            if (state.tabs.length > 0) {
                state.activeTab = state.tabs[0].value
            }
        }
    },

    getters: {
        getTabIndex: (state) => (value) => {
            for (let index = 0; index < state.tabs.length; index++) {
                if (state.tabs[index].value == value) {
                    return index
                }
            }

            return -1
        },

        tabExists: (state) => (tab) => {
            for (let index = 0; index < state.tabs.length; index++) {
                if (state.tabs[index].value == tab.value) {
                    return true
                }
            }
            return false
        },

        getTabs: (state) => {
            return state.tabs
        },

        getLastTab: (state) => {
            if (state.tabs.length > 0) {
                return state.tabs[state.tabs.length - 1]
            }

            return null
        },

        getFirstTab: (state) => {
            if (state.tabs.length > 0) {
                return state.tabs[0]
            }

            return null
        },

        getActive: (state) => {
            return state.activeTab
        },

        getActiveTabComponent: (state) => {
            for (let index = 0; index < state.tabs.length; index++) {
                if (state.tabs[index].value == state.activeTab) {
                    return 'tab-' + state.tabs[index].component
                }
            }

            return 'tab-empty'
        }
    },

    actions: {
        addTab({commit, getters, state}, tab) {
            if (!getters.tabExists({value: tab.value})) {
                commit('ADD_TAB', tab)
            }

            if (state.activeTab != tab.value) {
                commit('SET_ACTIVE_TAB', tab)
            }
        },

        removeTab({commit, getters}, tab) {
            commit('REMOVE_TAB', {index: getters.getTabIndex(tab.value)})

            if (getters.getLastTab) {
                router.push({
                    path: getters.getLastTab.path
                }).catch(() => {})
            } else {
                router.push({ path: '/1' }).catch(() => {})
            }
        },

        gotoTab({commit, getters}, tab) {
            if (getters.tabExists({value: tab.value})) {
                commit('SET_ACTIVE_TAB', {value: tab.value})
            }
        },

        gotoLatest() {
            commit('SET_ACTIVE_LAST')
        },

        gotoFirst() {
            commit('SET_ACTIVE_FIRST')
        },

        tabRouteTo(context, tab) {
            if (router.history.current.path != tab.path) {
                router.push({path: tab.path}).catch(() => {})
            }
        }
    }
}

export default mdn;