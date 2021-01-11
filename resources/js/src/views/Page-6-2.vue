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
          @click="add()"
          class="mx-1"
          color="primary invisible"
          type="border"
          >{{ $t("Add") }}</vs-button
        >
        <vs-button
          @click="saveDialog()"
          class="mx-1"
          color="primary"
          type="border"
          :disabled="item['ccp_limit:device_id'] == null"
          >{{ $t("Save") }}</vs-button
        >
        <vs-button
          @click="removeDialog()"
          class="mx-1"
          color="primary"
          type="border"
          :disabled="item['ccp_limit:device_id'] == null"
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
      <app-form-group required full>
        <template v-slot:label>상한값</template>

        <vs-input
          type="number"
          class="control-field-number"
          maxlength="10"
          v-model="item['ccp_limit:lmt_up']"
          :danger="errors['ccp_limit:lmt_up'] != null"
          :danger-text="errors['ccp_limit:lmt_up']"
        />
      </app-form-group>
      <app-form-group required full>
        <template v-slot:label>하한값</template>

        <vs-input
          type="number"
          class="control-field-number"
          maxlength="10"
          v-model="item['ccp_limit:lmt_dn']"
          :danger="errors['ccp_limit:lmt_dn'] != null"
          :danger-text="errors['ccp_limit:lmt_dn']"
        />
      </app-form-group>
      <app-form-group full>
        <template v-slot:label>비고</template>

        <vs-input
          class="control-field-lg"
          maxlength="100"
          v-model="item['ccp_limit:remark']"
          :danger="errors['ccp_limit:remark'] != null"
          :danger-text="errors['ccp_limit:remark']"
        />
      </app-form-group>
    </app-form>

    <ag-grid-vue
      ref="agGridTable"
      :localeText="localeText"
      rowSelection="single"
      @selection-changed="handleSelected"
      :gridOptions="gridOptions"
      class="ag-theme-material w-100 my-4 ag-grid-table"
      style="max-height: 100%;"
      :columnDefs="columnDefs"
      :defaultColDef="defaultColDef"
      :rowData="itemsComp"
      :pagination="true"
      :paginationPageSize="paginationPageSize"
      :suppressPaginationPanel="true">
    </ag-grid-vue>

    <!-- <vs-pagination
      :total="totalPages"
      :max="maxPageNumbers"
      v-model="currentPage" /> -->
  </vx-card>
</template>

<script>
import axios from "axios";
import comm_cd from "@/services/comm_cd";
import ccp_limit from "@/services/ccp_limit";
import { mapActions } from "vuex";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";

import { AgGridVue } from 'ag-grid-vue'
import AG_GRID_LOCALE_KR from '@/views/ui-elements/ag-grid-table/agGridLocaleKr.js';;
import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'

export default {
  name: 'page-6-2',
  components: {
    AppControl,
    AppForm,
    AppFormGroup,
    AgGridVue
  },

  data () {
    return {
      item: {
        'ccp_limit:device_id': null,
        'ccp_limit:device_nm': null,
        'ccp_limit:lmt_up': null,
        'ccp_limit:lmt_dn': null,
        'ccp_limit:remark': null,
        'ccp_limit:reg_id': null,
        'ccp_limit:reg_dtm': null
      },
      errors: {
        'ccp_limit:device_id': null,
        'ccp_limit:device_nm': null,
        'ccp_limit:lmt_up': null,
        'ccp_limit:lmt_dn': null,
        'ccp_limit:remark': null,
        'ccp_limit:reg_id': null,
        'ccp_limit:reg_dtm': null
      },
      required: {
        'ccp_limit:lmt_up': '상한값',
        'ccp_limit:lmt_dn': '하한값',
      },
      items: [],

      localeText: AG_GRID_LOCALE_KR,
      maxPageNumbers: 7,
      gridOptions: {
        rowHeight: 40,
        headerHeight: 40
      },
      gridApi: null,
      defaultColDef: {
        sortable: true,
        editable: false,
        resizable: true,
        suppressMenu: false
      },
      columnDefs: [
        { headerName: 'No', field: 'no', cellStyle: {textAlign: 'center'}, width: 50 },
        { headerName: 'CCP 장비코드', field: 'comm2_cd', filter: false, width: 400 },
        { headerName: 'CCP 장비명', field: 'comm2_nm', filter: false, width: 400 },
      ]
    }
  },

  computed: {
    itemsComp: function () {
      return this.items.map((item, index) => {
        return {
          'no': (index + 1),
          ...item
        } 
      })
    },

    totalPages () {
      if (this.gridApi) return this.gridApi.paginationGetTotalPages()
      else return 0
    },
    paginationPageSize () {
      if (this.gridApi) return this.gridApi.paginationGetPageSize()
      else return 50
    },
    currentPage: {
      get () {
        if (this.gridApi) return this.gridApi.paginationGetCurrentPage() + 1
        else return 1
      },
      set (val) {
        this.gridApi.paginationGoToPage(val - 1)
      }
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

    clear() {
      for (const [key, value] of Object.entries(this.item)) {
        this.$set(this.item, key, null)
      }
    },

    clearErrors() {
      for (const [key, value] of Object.entries(this.errors)) {
        this.$set(this.errors, key, null)
      }
    },

    handleSelected () {
      let rows = this.gridApi.getSelectedRows()

      if (rows.length > 0) {
        this.clearErrors();
        this.get(rows[0]['comm2_cd'])
      }
    },

    query () {
      this.spinner();

      comm_cd
        .fetch({
          cd1: 'C00',
          sort: 'COMM2_CD',
          order: 'ASC',
          limit: -1
        })
        .then((res) => {
          this.spinner(false);
          this.items = res.data;
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

    get (deviceId) {
      this.spinner();

      ccp_limit
        .get(deviceId)
        .then((res) => {
          this.spinner(false);
          this.item = res.data.result;
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

    save () {
      this.clearErrors();
      this.spinner();

      ccp_limit
        .put(this.item["ccp_limit:device_id"], this.item)
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
            // this.clear()
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

    remove () {
      this.clearErrors();
      this.spinner();

      ccp_limit
        .delete(this.item["ccp_limit:device_id"])
        .then((res) => {
          this.spinner(false);

          if (res.data.success) {
            this.$vs.notify({
              title: this.$t("SuccessDeleteData"),
              position: "top-right",
              color: "success",
              text: res.data.message,
            });
            this.clear();
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

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-6-2"),
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

    removeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("Confirmation"),
        text: this.$t("DeleteData"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.remove(),
      });
    },
  },

  mounted () {
    this.gridApi = this.gridOptions.api
  },

  created () {
    setTimeout(() => {
      this.query();
    }, 200);
  }
}
</script>

<style>

</style>