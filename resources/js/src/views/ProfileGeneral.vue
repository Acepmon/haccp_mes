<template>
  <vx-card id="div-with-loading" class="vs-con-loading__container main-card">
    <app-control>
      <template v-slot:filter></template>
      <template v-slot:action>
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
      </template>
    </app-control>

    <vs-divider />

    <app-form>
      <app-form-group required>
        <template v-slot:label>휴대폰번호(ID)</template>

        <vs-input
          v-model="item['user:user_id']"
          :danger="errors['user:user_id'] != null"
          :danger-text="errors['user:user_id']"
          readonly
        />
      </app-form-group>

      <app-form-group required>
        <template v-slot:label>이름</template>

        <vs-input
          v-model="item['user:user_nm']"
          :danger="errors['user:user_nm'] != null"
          :danger-text="errors['user:user_nm']"
        />
      </app-form-group>

      <app-form-group>
        <template v-slot:label>이메일</template>

        <vs-input
          v-model="item['user:email']"
          :danger="errors['user:email'] != null"
          :danger-text="errors['user:email']"
        />
      </app-form-group>
    </app-form>

  </vx-card>
</template>

<script>
import axios from "axios";
import api from "@/services/user";
import { mapActions } from "vuex";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";

export default {
  name: 'profile-general',
  components: {
    AppControl,
    AppForm,
    AppFormGroup
  },
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
