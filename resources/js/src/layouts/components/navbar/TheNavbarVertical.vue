<!-- =========================================================================================
  File Name: TheNavbar.vue
  Description: Navbar component
  Component Name: TheNavbar
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
  <div class="relative">

    <div class="vx-navbar-wrapper" :class="classObj">

      <vs-navbar class="vx-navbar navbar-custom navbar-skelton" :color="navbarColorLocal" :class="textColor">

        <!-- SM - OPEN SIDEBAR BUTTON -->
        <feather-icon class="sm:inline-flex xl:hidden cursor-pointer p-2" icon="MenuIcon" @click.stop="showSidebar" />

        <!-- <vs-navbar-title>
          <router-link to="/">복을만드는사람들</router-link>
        </vs-navbar-title> -->

        <vs-navbar-item :index="index" v-for="(item, index) in menuItemsUpdated" :key="index">
          <router-link :to="item.url" v-text="item.name"></router-link>
        </vs-navbar-item>

        <!-- <bookmarks :navbarColor="navbarColor" v-if="windowWidth >= 992" /> -->

        <vs-spacer />

        <!-- <i18n class="mr-5" /> -->

        <!-- <search-bar class="mr-4" /> -->

        <notification-drop-down />

        <vs-navbar-item>
          <router-link to="/profile">Hi {{ loggedIn.USER_NM }}</router-link>
        </vs-navbar-item>

        <profile-drop-down />

        <vs-navbar-item index="0" class="ml-5 text-danger cursor-pointer">
          <span @click="logout">로그아웃</span>
        </vs-navbar-item>

      </vs-navbar>
    </div>
  </div>
</template>


<script>
import axios from 'axios'
import Bookmarks            from './components/Bookmarks.vue'
import SearchBar            from './components/SearchBar.vue'
import I18n                 from './components/I18n.vue'
import NotificationDropDown from './components/NotificationDropDown.vue'
import ProfileDropDown      from './components/ProfileDropDown.vue'
import navMenuItems         from './../vertical-nav-menu/navMenuItems'
export default {
  name: 'the-navbar-vertical',
  props: {
    navbarColor: {
      type: String,
      default: '#fff'
    }
  },
  components: {
    I18n,
    Bookmarks,
    SearchBar,
    NotificationDropDown,
    ProfileDropDown
  },
  computed: {
    loggedIn () {
      return JSON.parse(localStorage.getItem('loggedIn'))
    },
    navbarColorLocal () {
      return this.$store.state.theme === 'dark' && this.navbarColor === '#fff' ? '#10163a' : this.navbarColor
    },
    verticalNavMenuWidth () {
      return this.$store.state.verticalNavMenuWidth
    },
    textColor () {
      return {'text-white': (this.navbarColor !== '#10163a' && this.$store.state.theme === 'dark') || (this.navbarColor !== '#fff' && this.$store.state.theme !== 'dark')}
    },
    windowWidth () {
      return this.$store.state.windowWidth
    },

    // NAVBAR STYLE
    classObj () {
      if      (this.verticalNavMenuWidth === 'default') return 'navbar-default'
      else if (this.verticalNavMenuWidth === 'reduced') return 'navbar-reduced'
      else if (this.verticalNavMenuWidth)               return 'navbar-full'
    },

    menuItemsUpdated () {
      const clone = navMenuItems.slice().filter(item => !item.hideMenu)

      for (const [index, item] of navMenuItems.entries()) {
        if (item.header && item.items.length && (index || 1)) {
          const i = clone.findIndex(ix => ix.header === item.header)
          for (const [subIndex, subItem] of item.items.entries()) {
            clone.splice(i + 1 + subIndex, 0, subItem)
          }
        }
      }

      return clone
    },
  },
  methods: {
    showSidebar () {
      this.$store.commit('TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE', true)
    },

    logout () {
      axios.post('/logout')
        .then((res) => {
          localStorage.removeItem('userInfo')

          // This is just for demo Purpose. If user clicks on logout -> redirect
          this.$router.push('/login').catch(() => {})
        })
    }
  }
}
</script>
