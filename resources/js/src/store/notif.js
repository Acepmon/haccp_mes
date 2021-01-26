import axios from 'axios'

const notif = {
    namespaced: true,

    state: () => ({
        items: [],
    }),

    mutations: {
        SET_NOTIFICATIONS (state, payload) {
            state.items = payload
        },
        ADD_NOTIFICATION (state, payload) {
            state.items.push(payload)
        },
        REMOVE_NOTIFICATION (state, payload) {
            state.items = state.items.filter(item => item.id !== payload.id)
        }
    },

    getters: {
        unreadNotifications: (state) => {
            return state.items.filter(item => item.read_at == null).map(item => item.data)
        },
        unreadCount: (state) => {
            return state.items.filter(item => item.read_at == null).length
        }
    },

    actions: {
        playNotification () {
            const audio = new Audio('/message.mp3')
            audio.play()
        },

        fetchNotifications ({ commit }) {
            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.get('/api/auth/user/notifications').then((res) => {
                    commit('SET_NOTIFICATIONS', res.data.data)
                })
            })
        },

        markAsRead ({ dispatch }) {
            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.post('/api/auth/user/notifications').then(() => {
                    dispatch('fetchNotifications')
                })
                .catch((err) => {
                    this.$vs.notify({
                        title: this.$t("Error"),
                        position: "top-right",
                        color: "warning",
                        iconPack: "feather",
                        icon: "icon-alert-circle",
                        text: err.response.data.message,
                    });
                });
            })
        }
    }
}

export default notif;