<!-- =========================================================================================
    File Name: Login.vue
    Description: Login Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
  <div class="h-screen flex w-full bg-img vx-row no-gutter items-center justify-center" id="page-login">
    <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-3/4 xl:w-3/5 sm:m-0 m-4">
      <vx-card>
        <div slot="no-body" class="full-page-bg-color">

          <div class="vx-row no-gutter justify-center items-center">

            <div class="vx-col hidden lg:block lg:w-1/2">
              <img src="@assets/images/pages/login.png" alt="login" class="mx-auto">
            </div>

            <div class="vx-col sm:w-full md:w-full lg:w-1/2 d-theme-dark-bg">
              <div class="p-8 login-tabs-container">

                <div class="vx-card__title mb-4">
                  <h4 class="mb-4">Login</h4>
                  <p>Welcome back, please login to your account.</p>
                </div>

                <!-- <form ref="form"> -->
                  <div>
                    <form action="#" @submit.prevent="handleLogin">
                      <vs-input
                          name="userId"
                          icon-no-border
                          icon="icon icon-user"
                          icon-pack="feather"
                          label-placeholder="User ID"
                          v-model="formData.USER_ID"
                          class="w-full"/>

                      <vs-input
                          type="password"
                          name="password"
                          icon-no-border
                          icon="icon icon-lock"
                          icon-pack="feather"
                          label-placeholder="Password"
                          v-model="formData.password"
                          class="w-full mt-6" />

                      <div class="flex flex-wrap justify-between mt-5">
                          <!-- <vs-checkbox v-model="checkbox_remember_me" class="mb-3">Remember Me</vs-checkbox> -->
                          <!-- <router-link to="">Forgot Password?</router-link> -->
                      </div>
                      <!-- <vs-button  type="border">Register</vs-button> -->
                      <vs-button @click="handleLogin" class="float-left my-3 mb-5">Login</vs-button>

                      <vs-divider></vs-divider>
                    </form>

                  </div>
                <!-- </form> -->

              </div>
            </div>
          </div>
        </div>
      </vx-card>
    </div>
  </div>
</template>

<script>
import auth from '@/services/auth'
import axios from 'axios'

export default{
  data() {
    return {
      formData: {
        USER_ID: "",
        password: "",
      },
      checkbox_remember_me: false,
    }
  },

  methods: {
    submit() {
      auth.login(this.formData).then((res) => {
        if (res.data.success) {
          
          this.$router.push({ path: '/' })
        }
      }).catch((err) => {
        if (!err.response.data.success) {
          alert(err.response.data.message)
        }
      })
    },

    handleLogin () {
      axios.get('/sanctum/csrf-cookie').then((res) => {
        axios.post('/auth', this.formData, {headers: {'Content-Type': 'application/json', 'Accept': 'application/json'}}).then((res) => {
          if (res.data.success) {
            localStorage.setItem('loggedIn', res.data.result)

            this.$router.push({path: '/'})
          }
        })
      })
    }
  }
}
</script>

<style lang="scss">
#page-login {
  .social-login-buttons {
    .bg-facebook { background-color: #1551b1 }
    .bg-twitter { background-color: #00aaff }
    .bg-google { background-color: #4285F4 }
    .bg-github { background-color: #333 }
  }
}
</style>
