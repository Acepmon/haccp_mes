<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container">
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
        <template v-slot:filter>
          <span class="pt-2 px-4">그룹코드명</span>
          <vs-input
            v-model="item2['comm_cd:comm2_nm']"
            class="control-field"
            readonly
          />
        </template>
      </app-control>

      <ag-grid-vue
        ref="agGridTable"
        :gridOptions="gridOptions"
        class="ag-theme-material w-100 my-4 ag-grid-table"
        style="max-height: 300px;"
        :columnDefs="columnDefs"
        :defaultColDef="defaultColDef"
        :onGridReady="fillAllCellsWithWidthMeasurement"
        :rowData="itemsComp">
      </ag-grid-vue>

      <vs-divider />

      <app-control>
        <template v-slot:action>
           <vs-button
            @click="excel()"
            class="mx-1"
            color="primary"
            type="border"
            :disabled="items2.length <= 0"
            >{{ $t("ToExcel") }}</vs-button
          >
        </template>
      </app-control>

      <div class="overflow-y-auto" style="max-height: 300px">
        <vs-table
          stripe
          :data="items2"
          v-model="item2"
          @selected="handleSelected"
        >
          <template slot="thead">
            <vs-th>No</vs-th>
            <vs-th sort-key="comm1_cd">그룹코드</vs-th>
            <vs-th sort-key="comm2_nm">그룹코드명</vs-th>
            <vs-th sort-key="reg_id">등록자</vs-th>
            <vs-th sort-key="reg_dtm">등록일시</vs-th>
          </template>

          <template slot-scope="{ data }">
            <vs-tr :data="tr" :key="index" v-for="(tr, index) in items2">
              <vs-td :data="index + 1">
                {{ index + 1 }}
              </vs-td>

              <vs-td :data="data[index]['comm_cd:comm1_cd']">
                {{ data[index]["comm_cd:comm1_cd"] }}
              </vs-td>

              <vs-td :data="data[index]['comm_cd:comm2_nm']">
                {{ data[index]["comm_cd:comm2_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['comm_cd:reg_id']">
                {{ data[index]["comm_cd:reg_id"] }}
              </vs-td>

              <vs-td :data="data[index]['comm_cd:reg_dtm']">
                {{ data[index]["comm_cd:reg_dtm"] }}
              </vs-td>
            </vs-tr>
          </template>
        </vs-table>
      </div>
    </vx-card>
  </div>
</template>

<script>
import axios from "axios";
import api from "@/services/comm_cd";
import { mapActions } from "vuex";
import { AgGridVue } from 'ag-grid-vue'

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

      item2: {
        "comm_cd:comm1_cd": null,
        "comm_cd:comm2_cd": null,
        "comm_cd:comm2_nm": null,
        "comm_cd:reg_id": null,
        "comm_cd:reg_dtm": null,
      },
      item1: {
        "comm_cd:comm1_cd": null,
        "comm_cd:comm2_cd": null,
        "comm_cd:comm2_nm": null,
        "comm_cd:reg_id": null,
        "comm_cd:reg_dtm": null,
      },

      items1: [],
      items2: [],

      gridOptions: {
        rowHeight: 40,
        headerHeight: 40
      },
      defaultColDef: {
        sortable: true,
        editable: true,
        resizable: true,
        suppressMenu: false
      },

      columnDefs: [
        {
          headerName: 'No',
          field: 'no',
          filter: false,
          editable: false,
          minWidth: 100,
        },
        {
          headerName: '코드',
          field: 'comm_cd:comm2_cd',
          editable: false,
          minWidth: 200,
          width: 500
        },
        {
          headerName: '코드명',
          field: 'comm_cd:comm2_nm',
          minWidth: 200,
          width: 500
        }
      ],
    };
  },

  computed: {
    itemsComp: function () {
      return this.items1.map((item, index) => {
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

    handleSelected(tr) {
      this.clearErrors();
      this.$set(this, "items1", []);
      this.fetch()
    },

    fetch () {
      api
        .get({
          limit: -1,
          comm1_cd: this.item2["comm_cd:comm1_cd"],
        })
        .then((res) => {
          this.spinner(false);
          this.items1 = res.data.data;
        })
        .catch(() => {
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
          this.items2 = res.data.data;
          callback(this.items2)
        })
        .catch(() => {
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
        .sync(this.item2["comm_cd:comm1_cd"], {
          'sync': this.gridOptions.rowData
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
        .delete(this.item2['comm_cd:comm1_cd'])
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
      this.items1.push({
        "comm_cd:comm1_cd": null,
        "comm_cd:comm2_cd": null,
        "comm_cd:comm2_nm": null,
        "comm_cd:reg_id": null,
        "comm_cd:reg_dtm": null,
      });
    },

    removeRow(index) {
      this.items1.splice(index, 1);
    },

    fillAllCellsWithWidthMeasurement () {
      Array.prototype.slice
        .call(document.querySelectorAll('.ag-cell'))
        .forEach(function (cell) {
          var width = cell.offsetWidth;
          var isFullWidthRow = cell.parentElement.childNodes.length === 1;
          cell.textContent = (isFullWidthRow ? 'Total width: ' : '') + width + 'px';
        });
    }
  },

  created () {
    setTimeout(() => {
      this.query((items) => {
        if (items.length > 0) {
          this.item2 = items[0]
          this.fetch()
        }
      })
    }, 500)
  }
}
</script>