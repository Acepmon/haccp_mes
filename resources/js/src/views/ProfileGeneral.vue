<template>
  <vx-card no-shadow>
    <div class="flex flex-wrap mb-2">
      <div class="w-full sm:w-1/2 px-1 flex justify-end"></div>
      <div class="w-full sm:w-1/2 px-1 flex justify-end">
        <vs-button
          @click="saveDialog()"
          class="mx-1"
          color="dark"
          type="border"
          >{{ $t("Save") }}</vs-button
        >
        <vs-button
          @click="closeDialog()"
          class="mx-1"
          color="dark"
          type="border"
          >{{ $t("Close") }}</vs-button
        >
      </div>
    </div>

    <!-- Img Row -->
    <div class="flex flex-wrap items-center mb-base">
      <vs-avatar :src="activeUserInfo.photoURL" size="70px" class="mr-4 mb-4" />
      <div>
        <vs-button class="mr-4 sm:mb-0 mb-2">Upload photo</vs-button>
        <vs-button type="border" color="danger">Remove</vs-button>
        <p class="text-sm mt-2">Allowed JPG, GIF or PNG. Max size of 800kB</p>
      </div>
    </div>

    <!-- Info -->
    <vs-input class="w-full mb-base" label-placeholder="Username" v-model="username"></vs-input>
    <vs-input class="w-full mb-base" label-placeholder="Name" v-model="name"></vs-input>
    <vs-input class="w-full" label-placeholder="Email" v-model="email"></vs-input>

    <vs-alert icon-pack="feather" icon="icon-info" class="h-full my-4" color="warning">
      <span>Your account is not verified. <a href="#" class="hover:underline">Resend Confirmation</a></span>
    </vs-alert>

    <vs-input class="w-full my-base" label-placeholder="Company" v-model="company"></vs-input>
  </vx-card>
</template>

<script>
import axios from "axios";
import api from "@/services/user";
import { mapActions } from "vuex";

export default {
  data () {
    return {
      username: 'johny_01',
      name: this.$store.state.AppActiveUser.displayName,
      email: 'john@admin.com',
      company: 'SnowMash Technologies Pvt Ltd'
    }
  },
  computed: {
    activeUserInfo () {
      return this.$store.state.AppActiveUser
    }
  },
  methods: {
    ...mapActions({
      removeTab: "mdn/removeTab",
    }),

    spinner(loading = true) {
      if (loading) {
        this.$vs.loading({
          container: "#div-with-loading",
          scale: 0.6,
        });
      } else {
        this.$vs.loading.close("#div-with-loading > .con-vs-loading");
      }
    },

    clear() {
      this.$set(this, "worker", {
        worker_id: null,
        worker_nm: null,
        tel_no: null,
        work_cd: null,
        health_chk_dt: null,
        role_cd: null,
        remark: null,
        reg_id: null,
        reg_dtm: null,
      });
    },

    clearErrors() {
      this.$set(this, "errors", {
        worker_id: null,
        worker_nm: null,
        tel_no: null,
        work_cd: null,
        health_chk_dt: null,
        role_cd: null,
        remark: null,
      });
    },

    displayErrors(errors) {
      for (const [key, value] of Object.entries(errors)) {
        this.$set(this.errors, key, Array.isArray(value) ? value[0] : value);
      }
    },

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("profile-general"),
      });
    },

    saveDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "success",
        title: this.$t("Confirmation"),
        text: this.$t("SaveData"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.save(),
      });
    },
  }
}
</script>
