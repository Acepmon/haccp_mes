<template>
  <vx-card no-shadow>
    <div class="flex flex-wrap mb-2">
      <div class="w-full sm:w-1/2 px-1 flex justify-end"></div>
      <div class="w-full sm:w-1/2 px-1 flex justify-end">
        <vs-button
          @click="query()"
          class="mx-1"
          color="dark"
          type="border"
          >{{ $t("Query") }}</vs-button
        >
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
      <!-- Row 1 -->
      <div class="flex flex-wrap">
        <div class="w-full sm:w-1/2 px-1">
          <div class="vx-row mb-2">
            <div class="vx-col sm:w-1/3 w-full flex justify-end">
              <span class="pt-2"
                ><span class="text-danger">*</span> 휴대폰번호(ID)</span
              >
            </div>
            <div class="vx-col sm:w-2/3 w-full">
              <vs-input
                v-model="item['user:user_id']"
                :danger="errors['user:user_id'] != null"
                :danger-text="errors['user:user_id']"
                readonly
              />
            </div>
          </div>
        </div>

        <div class="w-full sm:w-1/2 px-1">
          <div class="vx-row mb-2">
            <div class="vx-col sm:w-1/3 w-full flex justify-end">
              <span class="pt-2"><span class="text-danger">*</span> 이름</span>
            </div>
            <div class="vx-col sm:w-2/3 w-full">
              <vs-input
                v-model="item['user:user_nm']"
                :danger="errors['user:user_nm'] != null"
                :danger-text="errors['user:user_nm']"
              />
            </div>
          </div>
        </div>
      </div>
      <!-- /row 1 -->

      <!-- Row 2 -->
      <div class="flex flex-wrap">
        <div class="w-full sm:w-1/2 px-1">
          <div class="vx-row mb-2">
            <div class="vx-col sm:w-1/3 w-full flex justify-end">
              <span class="pt-2">이메일</span>
            </div>
            <div class="vx-col sm:w-2/3 w-full">
              <vs-input
                v-model="item['user:email']"
                :danger="errors['user:email'] != null"
                :danger-text="errors['user:email']"
              />
            </div>
          </div>
        </div>
      </div>
      <!-- /row 2 -->
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
      item: {
        "user:user_id": null,
        "user:user_nm": null,
        "user:email": null,
      },
      errors: {
        "user:user_id": null,
        "user:user_nm": null,
        "user:email": null,
      },
    };
  },
  computed: {
    activeUserInfo() {
      let loggedIn = localStorage.getItem('loggedIn')
      let json = JSON.parse(loggedIn)
      return json;
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
      this.$set(this, "item", {
        "user:user_id": null,
        "user:user_nm": null,
        "user:email": null,
      });
    },

    clearErrors() {
      this.$set(this, "errors", {
        "user:user_id": null,
        "user:user_nm": null,
        "user:email": null,
      });
    },

    displayErrors(errors) {
      for (const [key, value] of Object.entries(errors)) {
        this.$set(this.errors, key, Array.isArray(value) ? value[0] : value);
      }
    },

    query () {
      let loggedIn = localStorage.getItem('loggedIn')
      let json = JSON.parse(loggedIn)
      axios.get('/sanctum/csrf-cookie').then(() => {
        axios.get('/api/auth/user').then((res) => {
          this.$set(this.item, 'user:user_id', res.data.data.USER_ID)
          this.$set(this.item, 'user:user_nm', res.data.data.USER_NM)
          this.$set(this.item, 'user:email', res.data.data.EMAIL)
        })
      })
    },

    save () {
      // 
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
    }
  },

  created () {
    this.query()
  }
};
</script>
