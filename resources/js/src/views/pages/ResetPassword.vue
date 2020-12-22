<template>
  <div class="h-screen flex w-full bg-img">
    <div class="vx-col sm:w-3/5 md:w-3/5 lg:w-3/4 xl:w-3/5 mx-auto self-center">
      <vx-card>
        <div slot="no-body" class="full-page-bg-color">
          <div class="vx-row">
            <div
              class="vx-col hidden sm:hidden md:hidden lg:block lg:w-1/2 mx-auto self-center"
            >
              <img
                src="@assets/images/pages/reset-password.png"
                alt="login"
                class="mx-auto"
              />
            </div>
            <div
              class="vx-col sm:w-full md:w-full lg:w-1/2 mx-auto self-center d-theme-dark-bg"
            >
              <div class="p-8">
                <div class="vx-card__title mb-8">
                  <h4 class="mb-4">Reset Password</h4>
                  <p>Please enter your new password.</p>
                </div>

                <vs-alert class="mb-4" :active="resError" color="danger" icon-pack="feather" icon="icon-info">
                  <span v-text="resMsg"></span>
                </vs-alert>

                <vs-input
                  type="email"
                  label-placeholder="Email"
                  v-model="password.email"
                  class="w-full mb-6"
                  :danger="errors['email'] != null"
                  :danger-text="errors['email']"
                  readonly
                />
                <vs-input
                  type="password"
                  label-placeholder="Password"
                  v-model="password.password"
                  :danger="errors['password'] != null"
                  :danger-text="errors['password']"
                  class="w-full mb-6"
                  autofocus
                />
                <vs-input
                  type="password"
                  label-placeholder="Confirm Password"
                  v-model="password.password_confirmation"
                  :danger="errors['password_confirmation'] != null"
                  :danger-text="errors['password_confirmation']"
                  class="w-full mb-8"
                />

                <div
                  class="flex flex-wrap justify-between flex-col-reverse sm:flex-row"
                >
                  <vs-button
                    type="border"
                    to="/login"
                    class="w-full sm:w-auto mb-8 sm:mb-auto mt-3 sm:mt-auto"
                    >Go Back To Login</vs-button
                  >
                  <vs-button @click="reset()" class="w-full sm:w-auto vs-con-loading__container" id="reset-btn">Reset</vs-button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </vx-card>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import config from '@/services/config'

export default {
  data() {
    return {
      resError: false,
      resMsg: '',
      password: {
        email: null,
        password: null,
        password_confirmation: null,
        token: null
      },
      errors: {
        email: null,
        password: null,
        password_confirmation: null,
      },
    };
  },

  computed: {
    urlParameters: function () {
      return this.$route.query
    }
  },

  methods: {
    btnLoading (loading = true) {
      if (loading) {
        this.$vs.loading({
          background: 'primary',
          color: '#fff',
          container: "#reset-btn",
          scale: 0.45
        })
      } else {
        this.$vs.loading.close("#reset-btn > .con-vs-loading")
      }
    },

    clearErrors () {
      this.$set(this, 'errors', {
        email: null,
        password: null,
        password_confirmation: null,
      })
    },

    displayErrors(errors) {
      for (const [key, value] of Object.entries(errors)) {
        this.$set(this.errors, key, Array.isArray(value) ? value[0] : value);
      }
    },

    reset () {
      this.clearErrors()
      this.btnLoading(true)
      this.resError = false

      axios.post(`${config.baseUrl}/auth/reset-password`, this.password)
        .then((res) => {
          this.btnLoading(false)

          if (res.data.success) {
            this.$vs.dialog({
              title: 'Password successfully reset',
              position: "top-right",
              color: "success",
              text: 'Your password has been successfully reset. Login with your new password.',
              acceptText: 'Go to Login',
              accept: () => this.$router.push('/login')
            });
          } else {
            this.resError = true
            this.resMsg = err.response.data.message
            // this.$vs.notify({
            //   title: this.$t("Error"),
            //   position: "top-right",
            //   color: "warning",
            //   iconPack: "feather",
            //   icon: "icon-alert-circle",
            //   text: res.data.message,
            // });
          }
        })
        .catch((err) => {
          this.btnLoading(false)
          this.resError = true
          this.resMsg = err.response.data.message
          this.displayErrors(
            err.response.data.hasOwnProperty("errors")
              ? err.response.data.errors
              : null
          );
        })
    }
  },

  created () {
    setTimeout(() => {
      this.$set(this.password, 'token', this.urlParameters.token)
      this.$set(this.password, 'email', this.urlParameters.email)
    }, 1000)
  }
};
</script>
