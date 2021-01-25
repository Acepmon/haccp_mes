<template>
    <vs-popup title="Session is about to expire" :active.sync="dialogActive">
        Your session is about to expire in <span v-text="countdown" class="text-danger"></span> seconds
    </vs-popup>
</template>

<script>
import axios from 'axios'

export default {
    name: 'AutoLogout',

    data () {
        return {
            events: ['click', 'mousemove', 'mousedown', 'scroll', 'keypress', 'load'],

            dialogActive: false,
            warningTimer: null,
            sessionTimeoutMin: 60,
            countdownTimer: 10,
            refreshIntervalId: null
        }
    },

    computed: {
        countdown () {
            return this.countdownTimer
        }
    },

    mounted () {
        this.events.forEach((event) => {
            window.addEventListener(event, this.resetTimer)
        })

        this.setTimers()
    },

    destroyed () {
        this.events.forEach((event) => {
            window.removeEventListener(event, this.resetTimer)
        })

        this.resetTimer()
    },

    methods: {
        setTimers () {
            this.warningTimer = setTimeout(this.warningMessage, (60 * 1000) * this.sessionTimeoutMin)
        },

        expireEvent() {
            window.location.reload()
        },

        startCountdown () {
            this.dialogActive = true

            let intervalId = setInterval(() => {
                if (this.countdownTimer == 0) {
                    this.expireEvent()
                    this.resetTimer()
                } else {
                    this.countdownTimer = this.countdownTimer - 1
                }
            }, 1000)

            this.refreshIntervalId = intervalId
        },

        warningMessage () {
            this.startCountdown()
        },

        resetTimer () {
            clearTimeout(this.warningTimer)
            clearInterval(this.refreshIntervalId)
            if (this.dialogActive) {
                this.sessionRefresh()
            }

            this.dialogActive = false
            this.countdownTimer = 10

            this.setTimers()
        },

        sessionRefresh () {
            axios.get('/sanctum/csrf-cookie').then(() => {});
        }
    }
}
</script>