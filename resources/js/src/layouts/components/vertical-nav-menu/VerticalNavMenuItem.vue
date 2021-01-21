<!-- =========================================================================================
    File Name: VerticalNavMenuItem.vue
    Description: Vertical NavMenu item component. Extends vuesax framework's 'vs-sidebar-item' component
    Component Name: VerticalNavMenuItem
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div
    class="vs-sidebar--item"
    :class="[
      {'vs-sidebar-item-active'            : activeLink},
      {'disabled-item pointer-events-none' : isDisabled}
    ]" >
      <template v-if="tabExceeded">
        <a
          tabindex="-1"
          exact
          :class="[{'router-link-active': activeLink}]"
          class="cursor-pointer"
          @click="showExceededDialog"
          :target="target" >
            <vs-icon v-if="!featherIcon" :icon-pack="iconPack" :icon="icon" />
            <feather-icon v-else-if="icon" :class="{'w-3 h-3': iconSmall}" :icon="icon" />
            <slot />
        </a>
      </template>

      <template v-else>
        <template v-if="popup">
          <a
            tabindex="-1"
            exact
            class="cursor-pointer"
            @click="showPopupDialog"
            :target="target" >
              <vs-icon v-if="!featherIcon" :icon-pack="iconPack" :icon="icon" />
              <feather-icon v-else-if="icon" :class="{'w-3 h-3': iconSmall}" :icon="icon" />
              <slot />
          </a>
        </template>
        <template v-else>
          <router-link
            tabindex="-1"
            v-if="to"
            exact
            :class="[{'router-link-active': activeLink}]"
            :to="to"
            :target="target" >
              <vs-icon v-if="!featherIcon" :icon-pack="iconPack" :icon="icon" />
              <feather-icon v-else-if="icon" :class="{'w-3 h-3': iconSmall}" :icon="icon" />
              <slot />
          </router-link>

          <a v-else :target="target" :href="href" tabindex="-1">
            <vs-icon v-if="!featherIcon" :icon-pack="iconPack" :icon="icon" />
            <!-- <feather-icon v-else :class="{'w-3 h-3': iconSmall}" :icon="icon" /> -->
            <slot />
          </a>
        </template>
      </template>

      <vs-popup v-if="popup" fullscreen title="" :active.sync="popupDialog" button-close-hidden>
        <app-control>
          <template v-slot:action>
            <vs-button
              @click="popupDialog = false"
              class="mx-1"
              color="primary"
              type="border"
              >{{ $t("Close") }}</vs-button
            >
          </template>
        </app-control>
        <keep-alive>
          <component v-bind:is="activeComponent"></component>
        </keep-alive>
      </vs-popup>
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

import AppControl from "@/views/ui-elements/AppControl";
import {mapGetters} from 'vuex';
export default {
  name: 'v-nav-menu-item',
  components: {
    AppControl,
    "tab-page-2-5": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-2-5" */ "@/views/Page-2-5.vue")
      ),
    "tab-page-2-6": () =>
      lazyLoadView(
        import(/* webpackChunkName: "page-2-6" */ "@/views/Page-2-6.vue")
      ),
  },
  data () {
    return {
      popupDialog: false
    }
  },
  props: {
    icon        : { type: String,                 default: ''               },
    iconSmall   : { type: Boolean,                default: false            },
    iconPack    : { type: String,                 default: 'material-icons' },
    href        : { type: [String, null],         default: '#'              },
    to          : { type: [String, Object, null], default: null             },
    slug        : { type: String,                 default: null             },
    index       : { type: [String, Number],       default: null             },
    featherIcon : { type: Boolean,                default: true             },
    target      : { type: String,                 default: '_self'          },
    isDisabled  : { type: Boolean,                default: false            },
    popup       : { type: Boolean,                default: false            },
    popupComponent:{type: String,                 default: null             }
  },
  computed: {
    activeLink () {
      return !!((this.to === this.$route.path || this.$route.meta.parent === this.slug) && this.to)
    },
    ...mapGetters({
      tabExceeded: 'mdn/tabExceeded',
    }),
    activeComponent () {
      if (this.popupComponent == 'page-2-5' || this.popupComponent == 'page-2-6') {
        return this.$store.getters.switchPopupComponent
      }
      return 'tab-' + this.popupComponent
    }
  },
  methods: {
    showExceededDialog () {
      this.$vs.dialog({
        color: 'warning',
        title: this.$t('Warning'),
        text: this.$t('TabLimitReached'),
        acceptText: this.$t('Accept')
      })
    },

    showPopupDialog () {
      this.$set(this, 'popupDialog', true)
    }
  }
}

</script>

