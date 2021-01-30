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
            @click="showPopupDialog(popupComponent)"
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
          <template v-slot:filter>
            <vs-button
              @click="openStandaloneWindow"
              class="mx-1"
              color="primary"
              type="border"
              size="large"
              >{{ $t("StandaloneWindow") }}</vs-button
            >
          </template>
          <template v-slot:action>
            <vs-button
              @click="activeComponent = 'page-2-6';countdownTimer = 30;"
              class="mx-1"
              color="primary"
              type="border"
              size="large"
              v-if="activeComponent == 'page-2-5'"
              >{{ $t("SwitchToCcpMonitor") }}</vs-button
            >
            <vs-button
              @click="activeComponent = 'page-2-5';countdownTimer = 30;"
              class="mx-1"
              color="primary"
              type="border"
              size="large"
              v-if="activeComponent == 'page-2-6'"
              >{{ $t("SwitchToJobOrd") }}</vs-button
            >
            <vs-button
              @click="popupDialog = false"
              class="mx-1"
              color="primary"
              type="border"
              size="large"
              >{{ $t("Close") }}</vs-button
            >
          </template>
        </app-control>

        <keep-alive :include="activeComponent">
          <component v-bind:is="activeComponent"></component>
        </keep-alive>
      </vs-popup>
  </div>
</template>

<script>

import AppControl from "@/views/ui-elements/AppControl";
import {mapGetters} from 'vuex';
export default {
  name: 'v-nav-menu-item',
  components: {
    AppControl,
  },
  data () {
    return {
      popupDialog: false,
      activeComponent: this.popupComponent,

      countdownTimer: 30,
      refreshIntervalId: null
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
    countdown () {
      return this.countdownTimer
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

    showPopupDialog (popupComponent) {
      this.activeComponent = popupComponent
      this.$set(this, 'popupDialog', true)
      this.countdownTimer = 30
    },

    resetTimer () {
      clearInterval(this.refreshIntervalId)

      if (this.activeComponent == 'page-2-5') {
        this.$set(this, 'activeComponent', 'page-2-6')
      } else if (this.activeComponent == 'page-2-6') {
        this.$set(this, 'activeComponent', 'page-2-5')
      }

      this.countdownTimer = 30
    },

    startCountdown () {
      let intervalId = setInterval(() => {
        if (this.countdownTimer == 1) {
          this.resetTimer()
          this.startCountdown()
        } else {
          this.countdownTimer = this.countdownTimer - 1
        }
      }, 1000)

      this.refreshIntervalId = intervalId
    },

    openStandaloneWindow () {
      window.open('/monitor', '_blank')
    }
  },

  created () {
    // setInterval(() => {
    //   if (this.activeComponent == 'page-2-5') {
    //     this.$set(this, 'activeComponent', 'page-2-6')
    //   } else if (this.activeComponent == 'page-2-6') {
    //     this.$set(this, 'activeComponent', 'page-2-5')
    //   }
    // }, 1000 * 30)
    this.startCountdown()
  }
}

</script>

