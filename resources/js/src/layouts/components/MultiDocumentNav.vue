<template>
    <div>
        <!-- <vs-button @click="addTab({path: '/example', value: 'example', label: 'Example', component: 'example'})">Example</vs-button>
        <vs-button @click="addTab({path: '/1/1', value: 'page-1-1', label: 'Page-1-1', component: 'page-1-1'})">Page 1-1</vs-button>
        <vs-button @click="addTab({path: '/1/2', value: 'page-1-2', label: 'Page-1-2', component: 'page-1-2'})">Page 1-2</vs-button>
        <vs-button @click="addTab({path: '/1/3', value: 'page-1-3', label: 'Page-1-3', component: 'page-1-3'})">Page 1-3</vs-button> -->

        <div v-if="tabs.length > 0" class="flex flex-row overflow-x-auto mt-12">
            <vs-button 
                v-for="(tab, key) in tabs" 
                :key="key" 
                size="large"
                :type="activeTab == tab.value ? 'line' : 'line'"
                :color="activeTab == tab.value ? 'primary' : 'dark'"
                :style="activeTab == tab.value ? 'border-color: inherit' : ''"
                @click="routeTo({path: tab.path})"
                class="py-1 pr-2 pl-5 flex-shrink-0"
            >
                <div class="flex flex-row">
                    <span v-text="tab.label" class="h6" :class="activeTab == tab.value ? 'text-primary font-semibold' : ''"></span>
                    <vs-button 
                        :type="activeTab == tab.value ? 'flat' : 'flat'"
                        :color="activeTab == tab.value ? 'primary' : 'dark'"
                        size="small"
                        icon="close"
                        class="ml-2"
                        style="margin-top: -9px;"
                        @click="closeTab(tab)"
                    ></vs-button>
                </div>
            </vs-button>
        </div>

        <div class="p-5" v-if="activeTabComponent">
            <!-- Inactive components will be cached! -->
            <keep-alive>
                <component v-bind:is="activeTabComponent"></component>
            </keep-alive>
        </div>
    </div>
</template>

<script>
function lazyLoadView(AsyncView) {
  const AsyncHandler = () => ({
    component: AsyncView,
    // A component to use while the component is loading.
    loading: require('@/views/_loading.vue').default,
    // Delay before showing the loading component.
    // Default: 200 (milliseconds).
    delay: 0,
    // A fallback component in case the timeout is exceeded
    // when loading the component.
    error: require('@/views/_timeout.vue').default,
    // Time before giving up trying to load the component.
    // Default: Infinity (milliseconds).
    timeout: 10000,
  })

  return Promise.resolve({
    functional: true,
    render(h, { data, children }) {
      // Transparently pass any props or children
      // to the view component.
      return h(AsyncHandler, data, children)
    },
  })
}

import {mapGetters, mapActions} from 'vuex';
export default {
    components: {
        'tab-home': () => lazyLoadView(import(/* webpackChunkName: "home" */ '@/views/Home.vue')),
        'tab-empty': () => lazyLoadView(import(/* webpackChunkName: "empty" */ '@/views/Empty.vue')),
        'tab-example': () => lazyLoadView(import(/* webpackChunkName: "example" */ '@/views/Example.vue')),
        'tab-page-1-1': () => lazyLoadView(import(/* webpackChunkName: "page-1-1" */ '@/views/Page-1-1.vue')),
        'tab-page-1-2': () => lazyLoadView(import(/* webpackChunkName: "page-1-2" */ '@/views/Page-1-2.vue')),
        'tab-page-1-3': () => lazyLoadView(import(/* webpackChunkName: "page-1-3" */ '@/views/Page-1-3.vue')),
        'tab-page-1-4-1': () => lazyLoadView(import(/* webpackChunkName: "page-1-4-1" */ '@/views/Page-1-4-1.vue')),
        'tab-page-1-4-2': () => lazyLoadView(import(/* webpackChunkName: "page-1-4-2" */ '@/views/Page-1-4-2.vue')),
        'tab-page-1-4-3': () => lazyLoadView(import(/* webpackChunkName: "page-1-4-3" */ '@/views/Page-1-4-3.vue')),
        'tab-page-1-5-1': () => lazyLoadView(import(/* webpackChunkName: "page-1-5-1" */ '@/views/Page-1-5-1.vue')),
        'tab-page-1-5-2': () => lazyLoadView(import(/* webpackChunkName: "page-1-5-2" */ '@/views/Page-1-5-2.vue')),
        'tab-page-1-5-3': () => lazyLoadView(import(/* webpackChunkName: "page-1-5-3" */ '@/views/Page-1-5-3.vue')),
        'tab-page-1-6': () => lazyLoadView(import(/* webpackChunkName: "page-1-6" */ '@/views/Page-1-6.vue')),
        'tab-page-1-7': () => lazyLoadView(import(/* webpackChunkName: "page-1-7" */ '@/views/Page-1-7.vue')),
        'tab-page-1-8-1': () => lazyLoadView(import(/* webpackChunkName: "page-1-8-1" */ '@/views/Page-1-8-1.vue')),
        'tab-page-1-8-2': () => lazyLoadView(import(/* webpackChunkName: "page-1-8-2" */ '@/views/Page-1-8-2.vue')),
        'tab-page-1-9': () => lazyLoadView(import(/* webpackChunkName: "page-1-9" */ '@/views/Page-1-9.vue')),
        'tab-page-1-10': () => lazyLoadView(import(/* webpackChunkName: "page-1-10" */ '@/views/Page-1-10.vue')),
        'tab-page-1-11': () => lazyLoadView(import(/* webpackChunkName: "page-1-11" */ '@/views/Page-1-11.vue')),
    },

    computed: {
        ...mapGetters({
            activeTab: 'mdn/getActive',
            tabs: 'mdn/getTabs',
            activeTabComponent: 'mdn/getActiveTabComponent'
        })
    },

    methods: {
        ...mapActions({
            gotoTab: 'mdn/gotoTab',
            addTab: 'mdn/addTab',
            removeTab: 'mdn/removeTab',
            routeTo: 'mdn/tabRouteTo',
        }),
        closeTab (tab) {
            this.$vs.dialog({
                type: 'confirm',
                color: 'dark',
                title: this.$t('Confirmation'),
                text: this.$t('CloseDocument'),
                acceptText: this.$t('Accept'),
                cancelText: this.$t('Cancel'),
                accept: () => this.removeTab(tab)
            })
        }
    },
}
</script>

<style>
.scrollbar-hidden::-webkit-scrollbar {
    display: none;
}
.vs-tabs--li {
    padding-right: 30px;
}
.vs-tabs--btn-tag {
    position: absolute;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    top: 9px;
    right: 9px;
    z-index: 200;
    border-radius: 3px;
    border: 0px;
    background: rgb(255,255,255);
    box-shadow: 0px 0px 10px 0px rgba(0,0,0,.05);
    cursor: pointer;
    z-index: 200;
}
.vs-tabs--btn-tag i {
    padding-right: 0px !important;
    font-size: .9rem;
}
</style>