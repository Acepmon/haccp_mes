<template>
  <!-- NOTIFICATIONS -->
  <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">
    <feather-icon icon="BellIcon" class="cursor-pointer mt-1 sm:mr-6 mr-2" :badge="unreadCount" />

    <vs-dropdown-menu class="notification-dropdown dropdown-custom vx-navbar-dropdown">

      <div class="notification-top text-center p-3 bg-primary text-white">
        <div class="flex flex-row flex-wrap">
          <h3 class="text-white text-left flex-1 pl-3 pt-2">
            <span>{{ unreadCount }} 새알림</span>
          </h3>
          <vs-button
            @click="markAsRead()"
            color="light"
            type="border"
            >{{ $t("NotifReadAll") }}</vs-button
          >
        </div>
      </div>

      <component :is="scrollbarTag" ref="mainSidebarPs" class="scroll-area--nofications-dropdown p-0" :settings="settings" :key="$vs.rtl" v-if="unreadNotifications.length > 0">
        <ul class="bordered-items">
          <li v-for="ntf in unreadNotifications" :key="ntf.index" class="flex justify-between px-4 py-4 notification" :class="{'cursor-pointer': ntf.url}" @click="notifClick(ntf)">
            <div class="flex items-start">
              <!-- <feather-icon :icon="ntf.icon" :svgClasses="[`text-${ntf.category}`, 'stroke-current mr-1 h-6 w-6']"></feather-icon> -->
              <div class="mx-2">
                <span class="font-medium font-semibold block notification-title" :class="[`text-${ntf.category}`]">{{ ntf.title }}</span>
                <small>{{ ntf.msg }}</small>
              </div>
            </div>
            <small class="mt-1 whitespace-no-wrap">{{ elapsedTime(ntf.time) }}</small>
          </li>
        </ul>
      </component>

      <div class="
        checkout-footer
        bottom-0
        rounded-b-lg
        text-primary
        w-full
        p-5
        font-semibold
        text-center
        border
        border-b-0
        border-l-0
        border-r-0
        border-solid
        d-theme-border-grey-light
        cursor-pointer">
        <router-link to="/profile/notifications">전체 알림보기</router-link>
      </div>
    </vs-dropdown-menu>
  </vs-dropdown>
</template>

<script>
import axios from 'axios'
import VuePerfectScrollbar from 'vue-perfect-scrollbar'
import { mapActions, mapGetters } from "vuex";
import firebase from 'firebase/app'
import 'firebase/app'
import 'firebase/messaging'

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
    ...mapGetters({
      unreadNotifications: 'notif/unreadNotifications',
      unreadCount: 'notif/unreadCount',
    })
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

    notifClick(ntf) {
      if (ntf.url && ntf.url != null) {
        let url = new URL(ntf.url)
        this.$router.push({ path: url.pathname })
      }
    },

    ...mapActions({
      playNotification: "notif/playNotification",
      fetchNotifications: "notif/fetchNotifications",
      markAsRead: 'notif/markAsRead'
    }),

    saveNotificationToken(token) {
      const registerNotifTokenURL = '/api/auth/user/device_token'
      const payload = {
        registration_id: token,
        type: 'web'
      }
      axios.get('/sanctum/csrf-cookie').then(() => {
        axios.post(registerNotifTokenURL, payload)
          .then((response) => {
            console.log('Successfully saved notification token!')
            console.log(response.data)
          })
          .catch((error) => {
            console.log('Error: could not save notification token')
            if (error.response) {
              console.log(error.response.status)
              // Most of the time a "this field must be unique" error will be returned,
              // meaning that the token already exists in db, which is good.
              if (error.response.data.registration_id) {
                for (let err of error.response.data.registration_id) {
                  console.log(err)
                }
              } else {
                console.log('No reason returned by backend')
              }
              // If the request could not be sent because of a network error for example
            } else if (error.request) {
              console.log('A network error occurred.')
              // For any other kind of error
            } else {
              console.log(error.message)
            }
          })
      })
    },
  },

  mounted () {
    let loggedIn = localStorage.getItem('loggedIn')
    let json = JSON.parse(loggedIn)
    let userId = json.USER_ID

    window.Echo.private('App.User.' + userId)
      .notification((notification) => {
        this.playNotification()
        this.fetchNotifications()

        this.$vs.notify({
          title: notification.title,
          position: "top-right",
          color: "primary",
          iconPack: "feather",
          icon: "icon-alert-circle",
          text: notification.msg,
        });
      })

    var config = {
      apiKey: "AIzaSyCME99yTOTC4LKPIqUqSOuyxsLSqGRIUg8",
      authDomain: "haccp-mes.firebaseapp.com",
      projectId: "haccp-mes",
      storageBucket: "haccp-mes.appspot.com",
      messagingSenderId: "518404578173",
      appId: "1:518404578173:web:3a85c5553012e22826ca14",
      measurementId: "G-NJTD4RD45T"
    }
    firebase.initializeApp(config)

    const messaging = firebase.messaging()

    messaging.usePublicVapidKey("BIPX6O-78pp9Ftw4rBEEaXB4c5JciYDcB22_y-ZlYgJemT1MkkESk5Qwt3wCk89Ey1SIvb8OITQVNVaWW5VHgqQ")

    messaging.requestPermission().then(() => {
      console.log('Notification permission granted.')
      messaging.getToken().then((token) => {
        console.log('New token created: ', token)
        this.saveNotificationToken(token)
      })
    }).catch((err) => {
      console.log('Unable to get permission to notify.', err)
    })

    messaging.onTokenRefresh(function () {
      messaging.getToken().then(function (newToken) {
        console.log('Token refreshed: ', newToken)
        this.saveNotificationToken(newToken)
      }).catch(function (err) {
        console.log('Unable to retrieve refreshed token ', err)
      })
    })
  },

  created () {
    this.fetchNotifications()
  }
}

</script>

