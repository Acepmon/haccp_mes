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
  </div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
  name: 'v-nav-menu-item',
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
    isDisabled  : { type: Boolean,                default: false            }
  },
  computed: {
    activeLink () {
      return !!((this.to === this.$route.path || this.$route.meta.parent === this.slug) && this.to)
    },
    ...mapGetters({
      tabExceeded: 'mdn/tabExceeded',
    })
  },
  methods: {
    showExceededDialog () {
      this.$vs.dialog({
        color: 'warning',
        title: this.$t('Warning'),
        text: this.$t('TabLimitReached'),
        acceptText: this.$t('Accept')
      })
    }
  }
}

</script>

