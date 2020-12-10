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
                  <h4 class="mb-4">{{ $t('Login') }}</h4>
                  <p>Welcome back, please login to your account.</p>
                </div>

                <vs-alert class="mb-4" :active="resError" color="danger" icon-pack="feather" icon="icon-info">
                  <span v-text="resMsg"></span>
                </vs-alert>

                <!-- <form ref="form"> -->
                  <div>
                    <form action="#" @submit.prevent="handleLogin">
                      <vs-input
                          name="userId"
                          icon-no-border
                          icon="icon icon-user"
                          icon-pack="feather"
                          placeholder="사용자 ID"
                          v-model="formData.USER_ID"
                          v-on:keyup.enter="handleLogin"
                          class="w-full"/>

                      <vs-input
                          type="password"
                          name="password"
                          icon-no-border
                          icon="icon icon-lock"
                          icon-pack="feather"
                          placeholder="비밀번호"
                          v-model="formData.password"
                          v-on:keyup.enter="handleLogin"
                          class="w-full mt-6" />

                      <div class="flex flex-wrap justify-between mt-5">
                          <!-- <vs-checkbox v-model="checkbox_remember_me" class="mb-3">Remember Me</vs-checkbox> -->
                          <!-- <router-link to="">Forgot Password?</router-link> -->
                      </div>
                      <!-- <vs-button  type="border">Register</vs-button> -->
                      <vs-button @click="handleLogin" class="float-left my-3 mb-5 vs-con-loading__container" id="login-btn">{{ $t('Login') }}</vs-button>

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
      resError: false,
      resMsg: '',
      formData: {
        USER_ID: "",
        password: "",
      },
      checkbox_remember_me: false,
    }
  },

  methods: {
    handleLogin () {
      this.resError = false
      this.$vs.loading({
        background: 'primary',
        color: '#fff',
        container: "#login-btn",
        scale: 0.45
      })

      axios.get('/sanctum/csrf-cookie').then(() => {
        axios.post('/auth', this.formData, {headers: {'Content-Type': 'application/json', 'Accept': 'application/json'}}).then((res) => {
          this.$vs.loading.close("#login-btn > .con-vs-loading")

          if (res.data.success) {
            this.resError = false

            localStorage.setItem('loggedIn', res.data.result)

            this.$router.push({path: '/'})
          } else {
            this.resError = true
            this.resMsg = res.data.result
          }
        }).catch((err) => {
          this.$vs.loading.close("#login-btn > .con-vs-loading")
          this.resError = true
          this.resMsg = err.response.data.message
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
