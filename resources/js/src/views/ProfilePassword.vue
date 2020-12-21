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
      <!-- Row 1 -->
      <div class="flex flex-wrap">
        <div class="w-full sm:w-1/2 px-1">
          <div class="vx-row mb-2">
            <div class="vx-col sm:w-1/3 w-full flex justify-end">
              <span class="pt-2"
                ><span class="text-danger">*</span> Old Password</span
              >
            </div>
            <div class="vx-col sm:w-2/3 w-full">
              <vs-input
                type="password"
                v-model="password['old_password']"
                :danger="errors['old_password'] != null"
                :danger-text="errors['old_password']"
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
              <span class="pt-2"><span class="text-danger">*</span> New Password</span>
            </div>
            <div class="vx-col sm:w-2/3 w-full">
              <vs-input
                type="password"
                v-model="password['new_password']"
                :danger="errors['new_password'] != null"
                :danger-text="errors['new_password']"
              />
            </div>
          </div>
        </div>

        <div class="w-full sm:w-1/2 px-1">
          <div class="vx-row mb-2">
            <div class="vx-col sm:w-1/3 w-full flex justify-end">
              <span class="pt-2"><span class="text-danger">*</span> Confirm Password</span>
            </div>
            <div class="vx-col sm:w-2/3 w-full">
              <vs-input
                type="password"
                v-model="password['new_password_confirmation']"
                :danger="errors['new_password_confirmation'] != null"
                :danger-text="errors['new_password_confirmation']"
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
      password: {
        old_password: null,
        new_password: null,
        new_password_confirmation: null,
      },
      errors: {
        old_password: null,
        new_password: null,
        new_password_confirmation: null,
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
      this.$set(this, "password", {
        old_password: null,
        new_password: null,
        new_password_confirmation: null,
      });
    },

    clearErrors() {
      this.$set(this, "errors", {
        old_password: null,
        new_password: null,
        new_password_confirmation: null,
      });
    },

    displayErrors(errors) {
      for (const [key, value] of Object.entries(errors)) {
        this.$set(this.errors, key, Array.isArray(value) ? value[0] : value);
      }
    },

    save () {
      this.clearErrors()
      this.spinner()

      let loggedIn = localStorage.getItem('loggedIn')
      let json = JSON.parse(loggedIn)

      api.password(json.USER_ID, this.password).then((res) => {
				this.spinner(false)

				if (res.data.success) {
					this.$vs.notify({
						title: this.$t('SuccessSaveData'),
						position: 'top-right',
						color: 'success',
						text: res.data.message,
					})

          this.clear()
				} else {
					this.$vs.notify({
						title: this.$t('Error'),
						position: 'top-right',
						color: 'warning',
						iconPack: 'feather',
        				icon:'icon-alert-circle',
						text: res.data.message,
					})
				}
			}).catch((err) => {
				this.displayErrors(err.response.data.hasOwnProperty('errors') ? err.response.data.errors : null)
				this.spinner(false)
				this.$vs.notify({
					title: this.$t('Error'),
					position: 'top-right',
					color: 'warning',
					iconPack: 'feather',
					icon:'icon-alert-circle',
					text: err.response.data.message,
				})
			})
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
