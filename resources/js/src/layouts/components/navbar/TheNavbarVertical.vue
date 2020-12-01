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

        <vs-navbar-item index="0">
          <router-link to="/information-mgmt">정보관리</router-link>
        </vs-navbar-item>

        <vs-navbar-item index="0">
          <router-link to="/purchase-mgmt">구매관리</router-link>
        </vs-navbar-item>

        <vs-navbar-item index="0">
          <router-link to="/order-process">주문처리</router-link>
        </vs-navbar-item>

        <vs-navbar-item index="0">
          <router-link to="/production-mgmt">생산관리</router-link>
        </vs-navbar-item>

        <vs-navbar-item index="0">
          <router-link to="/shipping-mgmt">출하관리</router-link>
        </vs-navbar-item>

        <vs-navbar-item index="0">
          <router-link to="/haccp-monitor">HACCP모니터링</router-link>
        </vs-navbar-item>

        <vs-navbar-item index="0">
          <router-link to="/data-mgmt">자료관리</router-link>
        </vs-navbar-item>

        <!-- <bookmarks :navbarColor="navbarColor" v-if="windowWidth >= 992" /> -->

        <vs-spacer />

        <!-- <search-bar class="mr-4" />

        <notification-drop-down /> -->

        <profile-drop-down />

        <vs-navbar-item index="0" class="ml-5 text-danger cursor-pointer">
          <span @click="logout">로그아웃</span>
        </vs-navbar-item>

      </vs-navbar>
    </div>
  </div>
</template>


<script>
import Bookmarks            from './components/Bookmarks.vue'
import SearchBar            from './components/SearchBar.vue'
import NotificationDropDown from './components/NotificationDropDown.vue'
import ProfileDropDown      from './components/ProfileDropDown.vue'

export default {
  name: 'the-navbar-vertical',
  props: {
    navbarColor: {
      type: String,
      default: '#fff'
    }
  },
  components: {
    Bookmarks,
    SearchBar,
    NotificationDropDown,
    ProfileDropDown
  },
  computed: {
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
    }
  },
  methods: {
    showSidebar () {
      this.$store.commit('TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE', true)
    },

    logout () {
      localStorage.removeItem('userInfo')

      // This is just for demo Purpose. If user clicks on logout -> redirect
      this.$router.push('/pages/login').catch(() => {})
    }
  }
}
</script>

