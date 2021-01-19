<template>
  <vx-card id="div-with-loading" class="vs-con-loading__container main-card">
    <app-control>
      <template v-slot:action>
        <vs-button
          @click="query()"
          class="mx-1 mr-16"
          color="primary"
          type="border"
          >{{ $t("Query") }}</vs-button
        >
        <vs-button
          @click="addDialog()"
          class="mx-1 invisible"
          color="primary"
          type="border"
          >{{ $t("Add") }}</vs-button
        >
        <vs-button
          @click="saveDialog()"
          class="mx-1"
          color="primary"
          type="border"
          >{{ $t("Save") }}</vs-button
        >
        <vs-button
          @click="removeDialog()"
          class="mx-1"
          color="primary invisble"
          type="border"
          >{{ $t("Delete") }}</vs-button
        >
        <vs-button
          @click="closeDialog()"
          class="mx-1"
          color="primary"
          type="border"
          >{{ $t("Close") }}</vs-button
        >
      </template>
    </app-control>

    <vs-divider />

    <app-form>
      <app-form-group required>
        <template v-slot:label>OS</template>

        <vs-input
          class="control-field"
          maxlength="100"
          v-model="item['os']"
          :danger="errors['os'] != null"
          :danger-text="errors['os']"
        />
      </app-form-group>

      <app-form-group required>
        <template v-slot:label>App ID</template>

        <vs-input
          class="control-field"
          maxlength="100"
          v-model="item['app_id']"
          :danger="errors['app_id'] != null"
          :danger-text="errors['app_id']"
        />
      </app-form-group>

      <app-form-group required>
        <template v-slot:label>Version</template>

        <vs-input
          class="control-field"
          maxlength="100"
          v-model="item['version']"
          :danger="errors['version'] != null"
          :danger-text="errors['version']"
        />
      </app-form-group>
    </app-form>
  </vx-card>
</template>

<script>
import axios from "axios";
import comm_cd from "@/services/comm_cd";
import app_version from "@/services/app_version";
import { mapActions } from "vuex";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";

export default {
  name: 'page-1-12',

  components: {
    AppControl,
    AppForm,
    AppFormGroup,
  },

  data() {
    return {
      item: {
        "os": null,
        "app_id": null,
        "version": null,
      },
      errors: {
        "os": null,
        "app_id": null,
        "version": null,
      },
      required: {
        "os": "OS",
        "app_id": "App ID",
        "version": "Version",
      },
    }
  },

  methods: {
    ...mapActions({
      removeTab: "mdn/removeTab",
    }),

    validateRequired() {
      let passed = true
      for (const [key, value] of Object.entries(this.required)) {
        if (Array.isArray(this.item[key])) {
          if (this.item[key] === undefined || this.item[key].length == 0) {
            this.$set(this.errors, key, '필수항목입니다.')
            passed = false
          }
        } else {
          if (this.item[key]) {
          } else {
            this.$set(this.errors, key, '필수항목입니다.')
            passed = false
          }
        }
      }

      return passed
    },

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

    displayErrors(errors) {
      for (const [key, value] of Object.entries(errors)) {
        this.$set(this.errors, key, Array.isArray(value) ? value[0] : value);
      }
    },

    query() {
      this.spinner();

      app_version
        .fetch()
        .then((res) => {
          this.spinner(false);
          this.item = res.data.data;
        })
        .catch((err) => {
          this.spinner(false);
          this.$vs.notify({
            title: this.$t("Error"),
            position: "top-right",
            color: "warning",
            iconPack: "feather",
            icon: "icon-alert-circle",
            text: err.response.data.message,
          });
        });
    },

    save() {
      this.spinner()

      app_version
        .put(this.item)
        .then((res) => {
          this.spinner(false);

          if (res.data.success) {
            this.$vs.notify({
              title: this.$t("SuccessSaveData"),
              position: "top-right",
              color: "success",
              text: res.data.message,
            });
            this.query();
          } else {
            this.$vs.notify({
              title: this.$t("Error"),
              position: "top-right",
              color: "warning",
              iconPack: "feather",
              icon: "icon-alert-circle",
              text: res.data.message,
            });
          }
        })
        .catch((err) => {
          this.displayErrors(
            err.response.data.hasOwnProperty("errors")
              ? err.response.data.errors
              : null
          );
          this.spinner(false);
          this.$vs.notify({
            title: this.$t("Error"),
            position: "top-right",
            color: "warning",
            iconPack: "feather",
            icon: "icon-alert-circle",
            text: err.response.data.message,
          });
        });
    },

    saveDialog() {
      if (this.validateRequired()) {
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

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-1-4-2"),
      });
    },
  },

  created() {
    setTimeout(() => {
      this.query()
    }, 500)
  },
}
</script>

<style>

</style>