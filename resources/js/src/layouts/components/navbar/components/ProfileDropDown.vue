<template>
  <div class="the-navbar__user-meta flex items-center" v-if="activeUserInfo.displayName">

    <!-- <div class="text-right leading-tight hidden sm:block">
      <p class="font-semibold">Hi {{ activeUserInfo.displayName }}</p>
    </div> -->

    <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">

      <!-- <div class="con-img ml-3">
        <img v-if="activeUserInfo.photoURL" key="onlineImg" :src="activeUserInfo.photoURL" alt="user-img" width="40" height="40" class="rounded-full shadow-md cursor-pointer block" />
      </div> -->

      <vs-dropdown-menu class="vx-navbar-dropdown">
        <ul style="min-width: 9rem">

          <li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white">
            <feather-icon icon="UserIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Profile</span>
          </li>

          <vs-divider class="m-1" />

          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="logout">
            <feather-icon icon="LogOutIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">로그아웃</span>
          </li>
        </ul>
      </vs-dropdown-menu>
    </vs-dropdown>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  computed: {
    activeUserInfo () {
      return this.$store.state.AppActiveUser
    }
  },
  methods: {
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
