<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container main-card">
      <app-control>
        <template v-slot:filter>
          <span class="pt-2 px-4">공통코드명</span>

          <vs-input v-model="searchNm" class="control-field" />
        </template>
        <template v-slot:action>
          <vs-button
            @click="query()"
            class="mx-1 mr-16"
            color="primary"
            type="border"
            >{{ $t("Query") }}</vs-button
          >
          <vs-button
            @click="addRow()"
            class="mx-1"
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
            class="mx-1 invisible"
            color="primary"
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

      <app-control>
        <template v-slot:action>
           <vs-button
            @click="excel()"
            class="mx-1"
            color="primary"
            type="border"
            :disabled="items1.length <= 0"
            >{{ $t("ToExcel") }}</vs-button
          >
        </template>
      </app-control>

      <ag-grid-vue
        ref="agGridTable"
        :localeText="localeText"
        rowSelection="single"
        @selection-changed="handleSelected"
        :gridOptions="gridOptions"
        class="ag-theme-material w-100 my-4 ag-grid-table"
        style="max-height: 300px;"
        :columnDefs="columnDefs"
        :defaultColDef="defaultColDef"
        :rowData="items1Comp">
      </ag-grid-vue>

      <app-control class="mt-5">
        <template v-slot:filter>
          <span class="pt-2 px-4">그룹코드명</span>
          <vs-input
            v-model="item1['comm_cd:comm2_nm']"
            class="control-field"
            readonly
          />
        </template>
      </app-control>

      <ag-grid-vue
        ref="agGridTable"
        :localeText="localeText"
        :gridOptions="gridOptions2"
        class="ag-theme-material w-100 my-4 ag-grid-table"
        style="height: auto;"
        :columnDefs="columnDefs2"
        :defaultColDef="defaultColDef"
        :rowData="items2Comp">
      </ag-grid-vue>
    </vx-card>
  </div>
</template>

<script>
import axios from "axios";
import api from "@/services/comm_cd";
import { mapActions } from "vuex";
import { AgGridVue } from 'ag-grid-vue'
import AG_GRID_LOCALE_KR from '@/views/ui-elements/ag-grid-table/agGridLocaleKr.js';

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";

import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'

export default {
  components: {
    AgGridVue,
    AppControl,
    AppForm,
    AppFormGroup
  },
  data() {
    return {
      searchNm: null,

      item1: {
        "comm_cd:comm1_cd": null,
        "comm_cd:comm2_cd": null,
        "comm_cd:comm2_nm": null,
        "comm_cd:reg_id": null,
        "comm_cd:reg_dtm": null,
      },

      items1: [],
      items2: [],

      localeText: AG_GRID_LOCALE_KR,
      gridApi: null,
      gridApi2: null,
      gridOptions: {
        rowHeight: 40,
        headerHeight: 40
      },
      gridOptions2: {
        rowHeight: 40,
        headerHeight: 40,
        domLayout: 'autoHeight'
      },
      defaultColDef: {
        sortable: true,
        editable: true,
        resizable: true,
        suppressMenu: false
      },

      columnDefs: [
        { headerName: 'No', field: 'no', filter: false, editable: false, width: 80 },
        { headerName: '그룹코드', field: 'comm_cd:comm1_cd', editable: false, width: 200 },
        { headerName: '그룹코드명', field: 'comm_cd:comm2_nm', editable: false, width: 200 },
        { headerName: '등록자', field: 'comm_cd:reg_id', editable: false, width: 200 },
        { headerName: '등록일시', field: 'comm_cd:reg_dtm', editable: false, width: 200 }
      ],

      columnDefs2: [
        { headerName: 'No', field: 'no', filter: false, editable: false, width: 80 },
        { headerName: '코드', field: 'comm_cd:comm2_cd', editable: false, width: 200 },
        { headerName: '코드명', field: 'comm_cd:comm2_nm', width: 200 }
      ],
    };
  },

  computed: {
    items1Comp: function () {
      return this.items1.map((item, index) => {
        return {
          'no': (index + 1),
          ...item
        } 
      })
    },
    items2Comp: function () {
      return this.items2.map((item, index) => {
        return {
          'no': (index + 1),
          ...item
        } 
      })
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
      this.$set(this, "item", {
        "comm_cd:comm1_cd": null,
        "comm_cd:comm2_cd": null,
        "comm_cd:comm2_nm": null,
        "comm_cd:reg_id": null,
        "comm_cd:reg_dtm": null,
      });
    },

    clearErrors() {
      // this.$set(this, 'errors', {
      // 	'comm_cd:comm1_cd': null,
      // 	'comm_cd:comm2_cd': null,
      // 	'comm_cd:comm2_nm': null,
      // 	'comm_cd:reg_id': null,
      // 	'comm_cd:reg_dtm': null,
      // })
    },

    displayErrors(errors) {
      for (const [key, value] of Object.entries(errors)) {
        this.$set(this.errors, key, Array.isArray(value) ? value[0] : value);
      }
    },

    handleSelected() {
      let rows = this.gridApi.getSelectedRows()

      if (rows.length > 0) {
        this.clearErrors();
        this.$set(this, "items2", []);
        this.$set(this, 'item1', rows[0])
        this.fetch()
      }
    },

    fetch () {
      api
        .get({
          limit: -1,
          comm1_cd: this.item1["comm_cd:comm1_cd"],
        })
        .then((res) => {
          this.spinner(false);
          this.items2 = res.data.data;
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

    query(callback = Function) {
      this.spinner();

      let search_params = {};

      if (this.searchNm != null) {
        search_params["comm2_nm"] = this.searchNm;
      }

      api
        .get({
          limit: -1,
          ...search_params,
        })
        .then((res) => {
          this.spinner(false);
          this.items1 = res.data.data;
          callback(this.items1)
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

    add() {},

    save() {
      this.clearErrors();
      this.spinner();

      api
        .sync(this.item1["comm_cd:comm1_cd"], {
          'sync': this.gridOptions2.rowData
        })
        .then((res) => {
          this.spinner(false);

          if (res.data.success) {
            this.$vs.notify({
              title: this.$t("SuccessSaveData"),
              position: "top-right",
              color: "success"
            });
            this.query();
            this.clear();
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

    remove() {
      this.clearErrors();
      this.spinner();

      api
        .delete(this.item1['comm_cd:comm1_cd'])
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
        accept: () => this.removeTab("page-7-1"),
      });
    },

    addDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "primary",
        title: this.$t("Confirmation"),
        text: this.$t("AddData"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.add(),
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

    addRow() {
      this.items2.push({
        "comm_cd:comm1_cd": null,
        "comm_cd:comm2_cd": null,
        "comm_cd:comm2_nm": null,
        "comm_cd:reg_id": null,
        "comm_cd:reg_dtm": null,
      });
    },

    removeRow(index) {
      this.items2.splice(index, 1);
    }
  },

  mounted () {
    this.gridApi = this.gridOptions.api
    this.gridApi2 = this.gridOptions2.api
  },

  created () {
    setTimeout(() => {
      this.query((items) => {
        if (items.length > 0) {
          this.item1 = items[0]
          this.fetch()
        }
      })
    }, 500)
  }
}
</script>