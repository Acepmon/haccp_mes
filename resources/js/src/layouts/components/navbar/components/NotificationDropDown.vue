<template>
  <!-- NOTIFICATIONS -->
  <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">
    <feather-icon icon="BellIcon" class="cursor-pointer mt-1 sm:mr-6 mr-2" :badge="unreadNotifications.length" />

    <vs-dropdown-menu class="notification-dropdown dropdown-custom vx-navbar-dropdown">

      <div class="notification-top text-center p-5 bg-primary text-white">
        <h3 class="text-white">{{ unreadNotifications.length }} New</h3>
        <p class="opacity-75">App Notifications</p>
      </div>

      <component :is="scrollbarTag" ref="mainSidebarPs" class="scroll-area--nofications-dropdown p-0 mb-10" :settings="settings" :key="$vs.rtl">
        <ul class="bordered-items">
          <li v-for="ntf in unreadNotifications" :key="ntf.index" class="flex justify-between px-4 py-4 notification cursor-pointer">
            <div class="flex items-start">
              <feather-icon :icon="ntf.icon" :svgClasses="[`text-${ntf.category}`, 'stroke-current mr-1 h-6 w-6']"></feather-icon>
              <div class="mx-2">
                <span class="font-medium block notification-title" :class="[`text-${ntf.category}`]">{{ ntf.title }}</span>
                <small>{{ ntf.msg }}</small>
              </div>
            </div>
            <small class="mt-1 whitespace-no-wrap">{{ elapsedTime(ntf.time) }}</small>
          </li>
        </ul>
      </component>

      <div class="
        checkout-footer
        fixed
        bottom-0
        rounded-b-lg
        text-primary
        w-full
        p-2
        font-semibold
        text-center
        border
        border-b-0
        border-l-0
        border-r-0
        border-solid
        d-theme-border-grey-light
        cursor-pointer">
        <router-link to="/profile/notifications">View All Notifications</router-link>
      </div>
    </vs-dropdown-menu>
  </vs-dropdown>
</template>

<script>
import axios from 'axios'
import user from "@/services/user";
import VuePerfectScrollbar from 'vue-perfect-scrollbar'

export default {
  components: {
    VuePerfectScrollbar
  },
  data () {
    return {
      notifications: [],
      settings: {
        maxScrollbarLength: 60,
        wheelSpeed: .60
      }
    }
  },
  computed: {
    scrollbarTag () { return this.$store.getters.scrollbarTag },
    unreadNotifications () {
      return this.notifications.map((item, index) => {
        return {
          'no': (index + 1),
          ...item.data
        } 
      })
    }
  },
  methods: {
    elapsedTime (startTime) {
      const x        = new Date(startTime)
      const now      = new Date()
      let timeDiff = now - x
      timeDiff    /= 1000

      const seconds = Math.round(timeDiff)
      timeDiff    = Math.floor(timeDiff / 60)

      const minutes = Math.round(timeDiff % 60)
      timeDiff    = Math.floor(timeDiff / 60)

      const hours   = Math.round(timeDiff % 24)
      timeDiff    = Math.floor(timeDiff / 24)

      const days    = Math.round(timeDiff % 365)
      timeDiff    = Math.floor(timeDiff / 365)

      const years   = timeDiff

      if (years > 0) {
        return `${years + (years > 1 ? ' Years ' : ' Year ')}ago`
      } else if (days > 0) {
        return `${days + (days > 1 ? ' Days ' : ' Day ')}ago`
      } else if (hours > 0) {
        return `${hours + (hours > 1 ? ' Hrs ' : ' Hour ')}ago`
      } else if (minutes > 0) {
        return `${minutes + (minutes > 1 ? ' Mins ' : ' Min ')}ago`
      } else if (seconds > 0) {
        return seconds + (seconds > 1 ? ' sec ago' : 'just now')
      }

      return 'Just Now'
    },
    // Method for creating dummy notification time
    randomDate ({ hr, min, sec }) {
      const date = new Date()

      if (hr) date.setHours(date.getHours() - hr)
      if (min) date.setMinutes(date.getMinutes() - min)
      if (sec) date.setSeconds(date.getSeconds() - sec)

      return date
    },

    fetchUnreadNotifications () {
      let loggedIn = localStorage.getItem('loggedIn')
      let json = JSON.parse(loggedIn)
      axios.get('/sanctum/csrf-cookie').then(() => {
        axios.get('/api/auth/user/notifications/unread').then((res) => {
          this.$set(this, 'notifications', res.data.data)
        })
      })
    }
  },
  created () {
    this.fetchUnreadNotifications()
  }
}

</script>

