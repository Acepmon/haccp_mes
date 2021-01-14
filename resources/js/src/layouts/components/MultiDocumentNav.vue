<template>
  <div>
    <!-- <vs-button @click="addTab({path: '/example', value: 'example', label: 'Example', component: 'example'})">Example</vs-button>
        <vs-button @click="addTab({path: '/1/1', value: 'page-1-1', label: 'Page-1-1', component: 'page-1-1'})">Page 1-1</vs-button>
        <vs-button @click="addTab({path: '/1/2', value: 'page-1-2', label: 'Page-1-2', component: 'page-1-2'})">Page 1-2</vs-button>
        <vs-button @click="addTab({path: '/1/3', value: 'page-1-3', label: 'Page-1-3', component: 'page-1-3'})">Page 1-3</vs-button> -->

    <div v-if="tabs.length > 0" class="flex flex-row overflow-x-auto mt-16">
      <vs-button
        v-for="(tab, key) in tabs"
        :key="key"
        size="large"
        :type="activeTab == tab.value ? 'line' : 'line'"
        :color="activeTab == tab.value ? 'primary' : 'dark'"
        :style="activeTab == tab.value ? 'border-color: inherit' : ''"
        @click="routeTo({ path: tab.path })"
        class="py-1 pr-2 pl-5 flex-shrink-0"
        @contextmenu.prevent="
          $refs.menu.open($event);
          contextTab = tab.value;
        "
      >
        <div class="flex flex-row">
          <span
            v-text="tab.label"
            class="h6"
            :class="activeTab == tab.value ? 'text-primary font-semibold' : ''"
          ></span>
          <vs-button
            :type="activeTab == tab.value ? 'flat' : 'flat'"
            :color="activeTab == tab.value ? 'primary' : 'dark'"
            size="small"
            icon="close"
            class="ml-2"
            style="margin-top: -9px"
            @click="closeTab(tab)"
          ></vs-button>
        </div>
      </vs-button>

      <vue-context ref="menu">
        <li>
          <a href="#" @click="contextClose()" class="flex items-center text-sm">
            <span class="ml-2">Close</span>
          </a>
        </li>
        <li>
          <a
            href="#"
            @click="contextCloseOther()"
            class="flex items-center text-sm"
          >
            <span class="ml-2">Close other</span>
          </a>
        </li>
        <li>
          <a
            href="#"
            @click="contextCloseRight()"
            class="flex items-center text-sm"
          >
            <span class="ml-2">Close to the right</span>
          </a>
        </li>
        <li>
          <a
            href="#"
            @click="contextCloseAll()"
            class="flex items-center text-sm"
          >
            <span class="ml-2">Close all</span>
          </a>
        </li>
      </vue-context>
    </div>

    <div class="p-5" v-if="activeTabComponent">
      <!-- Inactive components will be cached! -->
      <keep-alive :include="keepAliveComponents">
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
    loading: require("@/views/_loading.vue").default,
    // Delay before showing the loading component.
    // Default: 200 (milliseconds).
    delay: 0,
    // A fallback component in case the timeout is exceeded
    // when loading the component.
    error: require("@/views/_timeout.vue").default,
    // Time before giving up trying to load the component.
    // Default: Infinity (milliseconds).
    timeout: 10000,
  });

  return Promise.resolve({
    functional: true,
    render(h, { data, children }) {
      // Transparently pass any props or children
      // to the view component.
      return h(AsyncHandler, data, children);
    },
  });
}

import { VueContext } from "vue-context";
import { mapGetters, mapActions } from "vuex";
export default {
  components: {
    VueContext,
    "tab-home": () =>
      lazyLoadView(
        import(/* webpackChunkName: "home" */ "@/views/Home.vue")
      ),
    "tab-empty": () =>
      lazyLoadView(
        import(/* webpackChunkName: "empty" */ "@/views/Empty.vue")
      ),
    "tab-example": () =>
      lazyLoadView(
        import(/* webpackChunkName: "example" */ "@/views/Example.vue")
      ),
    "tab-page-1-1": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-1-1" */ "@/views/Page-1-1.vue")
      ),
    "tab-page-1-2": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-1-2" */ "@/views/Page-1-2.vue")
      ),
    "tab-page-1-3": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-1-3" */ "@/views/Page-1-3.vue")
      ),
    "tab-page-1-4-1": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-1-4-1" */ "@/views/Page-1-4-1.vue")
      ),
    "tab-page-1-4-2": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-1-4-2" */ "@/views/Page-1-4-2.vue")
      ),
    "tab-page-1-4-3": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-1-4-3" */ "@/views/Page-1-4-3.vue")
      ),
    "tab-page-1-5-1": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-1-5-1" */ "@/views/Page-1-5-1.vue")
      ),
    "tab-page-1-5-2": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-1-5-2" */ "@/views/Page-1-5-2.vue")
      ),
    "tab-page-1-5-3": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-1-5-3" */ "@/views/Page-1-5-3.vue")
      ),
    "tab-page-1-6": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-1-6" */ "@/views/Page-1-6.vue")
      ),
    "tab-page-1-6-1": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-1-6-1" */ "@/views/Page-1-6-1.vue")
      ),
    "tab-page-1-7": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-1-7" */ "@/views/Page-1-7.vue")
      ),
    "tab-page-1-8-1": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-1-8-1" */ "@/views/Page-1-8-1.vue")
      ),
    "tab-page-1-8-2": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-1-8-2" */ "@/views/Page-1-8-2.vue")
      ),
    "tab-page-1-9": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-1-9" */ "@/views/Page-1-9.vue")
      ),
    "tab-page-1-10": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-1-10" */ "@/views/Page-1-10.vue")
      ),
    "tab-page-1-11": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-1-11" */ "@/views/Page-1-11.vue")
      ),
    "tab-page-2-1": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-2-1" */ "@/views/Page-2-1.vue")
      ),
    "tab-page-2-2": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-2-2" */ "@/views/Page-2-2.vue")
      ),
    "tab-page-2-3": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-2-3" */ "@/views/Page-2-3.vue")
      ),
    "tab-page-3-1": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-3-1" */ "@/views/Page-3-1.vue")
      ),
    "tab-page-3-2": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-3-2" */ "@/views/Page-3-2.vue")
      ),
    "tab-page-4-1": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-4-1" */ "@/views/Page-4-1.vue")
      ),
    // "tab-page-4-2": () =>
    //   lazyLoadView(
    //     import(/* webpackChunkName: "page-4-2" */ "@/views/Page-4-2.vue")
    //   ),
    "tab-page-6-1": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-6-1" */ "@/views/Page-6-1.vue")
      ),
    "tab-page-6-2": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-6-2" */ "@/views/Page-6-2.vue")
      ),
    "tab-page-6-3": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-6-3" */ "@/views/Page-6-3.vue")
      ),
    "tab-page-6-4": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-6-4" */ "@/views/Page-6-4.vue")
      ),
    "tab-page-7-1": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-7-1" */ "@/views/Page-7-1.vue")
      ),
    "tab-page-7-2": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-7-2" */ "@/views/Page-7-2.vue")
      ),
    "tab-profile-general": () =>
      lazyLoadView(
        import(/* webpackChunkName: "profile-general" */ "@/views/ProfileGeneral.vue")
      ),
    "tab-profile-password": () =>
      lazyLoadView(
        import(/* webpackChunkName: "profile-password" */ "@/views/ProfilePassword.vue")
      ),
    "tab-profile-notifications": () =>
      lazyLoadView(
        import(/* webpackChunkName: "profile-notifications" */ "@/views/ProfileNotifications.vue")
      ),
  },

  data() {
    return {
      contextTab: null,
    };
  },

  computed: {
    ...mapGetters({
      activeTab: "mdn/getActive",
      tabs: "mdn/getTabs",
      activeTabComponent: "mdn/getActiveTabComponent",
    }),

    keepAliveComponents () {
      return this.tabs.map(tab => tab.component)
    }
  },

  methods: {
    ...mapActions({
      gotoTab: "mdn/gotoTab",
      addTab: "mdn/addTab",
      removeTab: "mdn/removeTab",
      removeTabs: "mdn/removeTabs",
      routeTo: "mdn/tabRouteTo",
    }),

    closeTab(tab) {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab(tab),
      });
    },

    contextClose() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab(this.contextTab),
      });
    },

    contextCloseOther() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => {
          let tabsToRemove = [];
          let tabsClone = [...this.tabs];

          tabsClone.forEach((tab) => {
            if (tab.value != this.contextTab) {
              tabsToRemove.push(tab);
            }
          });

          this.removeTabs(tabsToRemove);
        },
      });
    },

    contextCloseRight() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => {
          let tabsToRemove = [];
          let tabsClone = [...this.tabs];
          let found = false;

          tabsClone.forEach((tab) => {
            if (found) {
              tabsToRemove.push(tab);
            }
            if (tab.value == this.contextTab) {
              found = true;
            }
          });

          this.removeTabs(tabsToRemove);
        },
      });
    },

    contextCloseAll() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => {
          let tabsClone = [...this.tabs];
          this.removeTabs(tabsClone);
        },
      });
    },
  },
};
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
  background: rgb(255, 255, 255);
  box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.05);
  cursor: pointer;
  z-index: 200;
}
.vs-tabs--btn-tag i {
  padding-right: 0px !important;
  font-size: 0.9rem;
}
</style>