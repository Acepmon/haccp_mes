<template>
  <vx-card>
    <app-control>
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
      </template>
    </app-control>

    <keep-alive :include="activeComponent">
      <component v-bind:is="activeComponent"></component>
    </keep-alive>
  </vx-card>
</template>

<script>
import AppControl from "@/views/ui-elements/AppControl";
export default {
  name: 'monitor',
  components: {
    AppControl,
  },
  data () {
    return {
      activeComponent: 'page-2-5',
      countdownTimer: 30,
      refreshIntervalId: null,
    }
  },
  computed: {
    countdown () {
      return this.countdownTimer
    }
  },
  methods: {
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

<style>

</style>