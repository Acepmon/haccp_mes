<template>
  <vx-card id="div-with-loading" class="vs-con-loading__container">
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

    <form action="#">
      <vs-input
        class="w-full mb-base"
        label-placeholder="Old Password"
        v-model="old_password"
      />
      <vs-input
        class="w-full mb-base"
        label-placeholder="New Password"
        v-model="new_password"
      />
      <vs-input
        class="w-full mb-base"
        label-placeholder="Confirm Password"
        v-model="confirm_new_password"
      />
    </form>
  </vx-card>
</template>

<script>
import axios from "axios";
import api from "@/services/user";
import { mapActions } from "vuex";

export default {
  data() {
    return {
      password: {
        old_password: "",
        new_password: "",
        confirm_new_password: "",
      }
    };
  },
  computed: {
    activeUserInfo() {
      return this.$store.state.AppActiveUser;
    },
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
        accept: () => this.removeTab("profile-password"),
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
  },
};
</script>
