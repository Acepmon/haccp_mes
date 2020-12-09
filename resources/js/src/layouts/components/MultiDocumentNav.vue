<template>
    <div>
        <!-- <vs-button @click="addTab({path: '/example', value: 'example', label: 'Example', component: 'example'})">Example</vs-button>
        <vs-button @click="addTab({path: '/1/1', value: 'page-1-1', label: 'Page-1-1', component: 'page-1-1'})">Page 1-1</vs-button>
        <vs-button @click="addTab({path: '/1/2', value: 'page-1-2', label: 'Page-1-2', component: 'page-1-2'})">Page 1-2</vs-button>
        <vs-button @click="addTab({path: '/1/3', value: 'page-1-3', label: 'Page-1-3', component: 'page-1-3'})">Page 1-3</vs-button> -->

        <div v-if="tabs.length > 0">
            <vs-button 
                v-for="(tab, key) in tabs" 
                :key="key" 
                size="large"
                :type="activeTab == tab.value ? 'line' : 'line'"
                :color="activeTab == tab.value ? 'primary' : 'dark'"
                :style="activeTab == tab.value ? 'border-color: inherit' : ''"
                @click="$router.push({path: tab.path})"
                class="py-1 pr-2 pl-5"
            >
                <div class="flex flex-row">
                    <span v-text="tab.label" :class="activeTab == tab.value ? 'text-primary font-semibold' : ''"></span>
                    <vs-button 
                        :type="activeTab == tab.value ? 'flat' : 'flat'"
                        :color="activeTab == tab.value ? 'primary' : 'dark'"
                        size="small" 
                        icon="close"
                        class="ml-2"
                        style="margin-top: -5px;"
                        @click="removeTab(tab)"
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
import {mapGetters, mapActions} from 'vuex';
export default {
    components: {
        'tab-home': () => import(/* webpackChunkName: "Home" */ '@/views/Home'),
        'tab-empty': () => import(/* webpackChunkName: "Empty" */ '@/views/Empty'),
        'tab-example': () => import(/* webpackChunkName: "Example" */ '@/views/Example'),
        'tab-page-1-1': () => import(/* webpackChunkName: "Page-1-1" */ '@/views/Page-1-1'),
        'tab-page-1-2': () => import(/* webpackChunkName: "Page-1-2" */ '@/views/Page-1-2'),
        'tab-page-1-3': () => import(/* webpackChunkName: "Page-1-3" */ '@/views/Page-1-3'),
        'tab-page-1-4-1': () => import(/* webpackChunkName: "Page-1-4-1" */ '@/views/Page-1-4-1'),
        'tab-page-1-4-2': () => import(/* webpackChunkName: "Page-1-4-2" */ '@/views/Page-1-4-2'),
        'tab-page-1-4-3': () => import(/* webpackChunkName: "Page-1-4-3" */ '@/views/Page-1-4-3'),
        'tab-page-1-5-1': () => import(/* webpackChunkName: "Page-1-5-1" */ '@/views/Page-1-5-1'),
        'tab-page-1-5-2': () => import(/* webpackChunkName: "Page-1-5-2" */ '@/views/Page-1-5-2'),
        'tab-page-1-5-3': () => import(/* webpackChunkName: "Page-1-5-3" */ '@/views/Page-1-5-3'),
        'tab-page-1-6': () => import(/* webpackChunkName: "Page-1-6" */ '@/views/Page-1-6'),
        'tab-page-1-7': () => import(/* webpackChunkName: "Page-1-7" */ '@/views/Page-1-7'),
        'tab-page-1-8-1': () => import(/* webpackChunkName: "Page-1-8-1" */ '@/views/Page-1-8-1'),
        'tab-page-1-8-2': () => import(/* webpackChunkName: "Page-1-8-2" */ '@/views/Page-1-8-2'),
        'tab-page-1-9': () => import(/* webpackChunkName: "Page-1-9" */ '@/views/Page-1-9'),
        'tab-page-1-10': () => import(/* webpackChunkName: "Page-1-10" */ '@/views/Page-1-10'),
        'tab-page-1-11': () => import(/* webpackChunkName: "Page-1-11" */ '@/views/Page-1-11'),
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
        })
    }
}
</script>

<style>
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