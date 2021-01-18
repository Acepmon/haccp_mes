<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container main-card">
      <app-control>
        <template v-slot:filter>
          <span class="px-5 pt-2">품목명</span>
          <vs-input class="control-field" v-model="searchNm" />
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
            @click="saveDialog()"
            class="mx-1"
            color="primary"
            type="border"
            >{{ $t("Save") }}</vs-button
          >
          <import-excel :onSuccess="loadDataInTable" v-model="importFile" :header="1"></import-excel>
          <vs-button
            @click="closeDialog()"
            class="mx-1"
            color="primary"
            type="border"
            >{{ $t("Close") }}</vs-button
          >
        </template>
      </app-control>

      <ag-grid-vue
        ref="agGridTable"
        :localeText="localeText"
        rowSelection="single"
        @selection-changed="handleSelected"
        :gridOptions="gridOptions"
        class="ag-theme-material w-100 my-4 ag-grid-table mt-0"
        style="max-height: 300px;"
        :columnDefs="columnDefs"
        :defaultColDef="defaultColDef"
        :rowData="itemsComp"
        :pagination="true"
        :paginationPageSize="paginationPageSize"
        :suppressPaginationPanel="true">
      </ag-grid-vue>

      <vs-pagination
        :total="totalPages"
        :max="maxPageNumbers"
        v-model="currentPage" />

      <ag-grid-vue
        ref="agGridTable"
        :localeText="localeText"
        :gridOptions="gridOptions2"
        class="ag-theme-material w-100 my-4 ag-grid-table"
        style="height: auto;"
        :frameworkComponents="frameworkComponents"
        @cellValueChanged="onCellValueChanged($event)"
        :columnDefs="columnDefs2"
        :defaultColDef="defaultColDef"
        :rowData="itemsComp2">
      </ag-grid-vue>

    </vx-card>

    <vs-popup fullscreen :title="$t('UploadExcel')" :active.sync="importDialog" button-close-hidden>
      <div class="flex flex-wrap mb-2">
        <div class="w-full sm:w-1/2 px-1 flex justify-end"></div>
        <div class="w-full sm:w-1/2 px-1 flex justify-end">
          <vs-button
            @click="importExcelDialog()"
            class="mx-1"
            color="primary"
            type="border"
            >{{ $t("Save") }}</vs-button
          >
          <vs-button
            @click="importDialog = false"
            class="mx-1"
            color="primary"
            type="border"
            >{{ $t("Close") }}</vs-button
          >
        </div>
      </div>

      <vs-table stripe pagination :max-items="30" :data="tableData">
        <template slot="header">
          <h4>{{ sheetName }}</h4>
        </template>

        <template slot-scope="{data}">
          <!-- eslint-disable-next-line -->
          <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
            <vs-td :data="col" v-for="(col, indexcol) in data[indextr]" :key="indexcol + col">
              {{ col }}
            </vs-td>
          </vs-tr>
        </template>
      </vs-table>
    </vs-popup>
  </div>
</template>

<script>
import axios from "axios";
import comm_cd from "@/services/comm_cd";
import proc_dtl from "@/services/proc_dtl";
import proc_dtl_sub from "@/services/proc_dtl_sub";
import item_mst from "@/services/item_mst";
import proc_src from "@/services/proc_src";
import { mapActions } from "vuex";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";
import ImportExcel from '@/components/excel/ImportExcel.vue';

import { AgGridVue } from 'ag-grid-vue'
import AG_GRID_LOCALE_KR from '@/views/ui-elements/ag-grid-table/agGridLocaleKr.js';

import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'

import NumericEditor from '@/views/ui-elements/ag-grid-table/numericEditorVue';
import TextEditor from '@/views/ui-elements/ag-grid-table/textEditorVue';

export default {
  name: 'page-2-1',
  components: {
    AppControl,
    AppForm,
    AppFormGroup,
    ImportExcel,
    AgGridVue
  },

  data () {
    return {
      searchNm: null,
      importFile: null,
      importDialog: false,

      tableData: [],
      header: [],
      sheetName: '',

      items: [],
      items2: [],

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

      gridOptions2: {
        rowHeight: 40,
        headerHeight: 40,
        domLayout: 'autoHeight',
        getRowClass: (params) => {
          if (params.data['TABLE_NM'] == 'PROC_DTL_SUB') {
            return 'proc-dtl-sub-row';
          }
        },
        singleClickEdit: true
      },
      gridApi2: null,
      defaultColDef2: {
        sortable: true,
        editable: false,
        resizable: true,
        suppressMenu: false
      },
      frameworkComponents: {
        numericEditor: NumericEditor,
        textEditor: TextEditor
      },

      columnDefs: [
        { headerName: 'No', field: 'no', cellStyle: {textAlign: 'center'}, width: 50 },
        { headerName: '품목ID', field: 'item_mst:item_id', filter: false, editable: false, width: 200 },
        { headerName: '품목명', field: 'item_mst:item_nm', filter: false, editable: false, width: 300 },
        { headerName: '규격', field: 'item_mst:spec', filter: false, editable: false, width: 300 },
        { headerName: '단위', field: 'item_mst:unit', filter: false, editable: false, width: 300 }
      ],

      columnDefs2: [
        { headerName: 'No', field: 'no', cellStyle: {textAlign: 'center'}, width: 50 },
        { headerName: '공정구분', field: 'SRC_NM', filter: false, editable: false, width: 200 },
        { headerName: '공정순서', field: 'SEQ_NM', filter: false, editable: false, width: 100 },
        { headerName: '공정명', field: 'PROC_NM', filter: false, editable: false, width: 200 },
        { headerName: '공정내용', field: 'PROC_DTL', filter: false, editable: false, width: 400 },
        { headerName: '소요시간', field: 'PROC_TIME', filter: false, editable: true, width: 100, type: 'numericColumn', cellEditor: 'numericEditor' },
        { 
          headerName: 'CCP 유무',
          field: 'CCP_YN',
          filter: false,
          editable: true,
          width: 100,
          cellEditor: 'agSelectCellEditor',
          cellEditorParams: {
            values: ['Y', 'N'],
          }
        },
        // { headerName: 'BOM 재료', field: 'ITEM_NM', filter: false, editable: false, width: 200 },
        // { headerName: '생산수량', field: 'PROD_QTY', filter: false, editable: false, width: 200 },
        // { headerName: '소요수량', field: 'USE_QTY', filter: false, editable: false, width: 200 }
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
    itemsComp2: function () {
      return this.items2.map((item, index) => {
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
    }
  },

  mounted () {
    this.gridApi = this.gridOptions.api
    this.gridApi2 = this.gridOptions2.api
  },

  methods: {
    ...mapActions({
      removeTab: "mdn/removeTab",
    }),

    validateRequired(except = []) {
      let passed = true;
      for (const [key, value] of Object.entries(this.required)) {
        if (except.includes(key)) {
          continue;
        }

        if (Array.isArray(this.selected[key])) {
          if (
            this.selected[key] === undefined ||
            this.selected[key].length == 0
          ) {
            this.$set(this.errors, key, '필수항목입니다.')
            passed = false;
          }
        } else {
          if (this.selected[key]) {
          } else {
            this.$set(this.errors, key, '필수항목입니다.')
            passed = false;
          }
        }
      }

      return passed;
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

    handleSelected () {
      let rows = this.gridApi.getSelectedRows()

      if (rows.length > 0) {
        this.$set(this, 'item', rows[0])
        this.query2(rows[0]['item_mst:item_id'])
      }
    },

    displayErrors(errors) {
      for (const [key, value] of Object.entries(errors)) {
        this.$set(this.errors, key, Array.isArray(value) ? value[0] : value);
      }
    },

    loadDataInTable ({ results, header, meta }) {
      this.header = header
      this.tableData = results
      // this.sheetName = meta.sheetName
      this.$set(this, 'importDialog', true)
    },

    importExcelDialog () {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("ImportExcel"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.importExcel(),
      });
    },

    importExcel () {
      this.spinner()

      let formData = new FormData();
      if (this.importFile) {
        formData.append("file", this.importFile);
      }

      proc_dtl
        .unified_import(formData)
        .then((res) => {
          this.spinner(false)

          if (res.data.success) {
            this.$vs.notify({
              title: this.$t("SuccessSaveData"),
              position: "top-right",
              color: "success",
              text: res.data.message,
              time: 5000,
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
          this.spinner(false);
          this.$vs.notify({
            title: this.$t("Error"),
            position: "top-right",
            color: "warning",
            iconPack: "feather",
            icon: "icon-alert-circle",
            text: err.response.data.message,
          });
        })
    },

    query (callback = Function) {
      this.spinner();

      let search_params = {};

      if (this.searchNm != null) {
        search_params['item_nm'] = this.searchNm;
      }

      proc_dtl
        .fetch({
          ...this.paginationParam,
          limit: -1,
          ...search_params,
          grid1: true,
          with: ''
        })
        .then((res) => {
          this.spinner(false);
          this.items = res.data.data;
          callback(this.items)
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

    query2 (itemId) {
      this.spinner();

      proc_dtl
        .fetch({
          limit: -1,
          item_id: itemId,
          with: ''
        })
        .then((res) => {
          this.spinner(false);
          this.items2 = res.data.data.map((item) => {
            item['changed'] = false
            return item
          });
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

    onCellValueChanged (event) {
      let newData = event.data
      newData.changed = true
      if (!("" + newData.no).includes('*')) {
        newData.no = '* ' + newData.no
      }
      event.api.updateRowData(newData)
    },

    save() {
      this.spinner();

      let changedData = this.gridOptions2.rowData.filter((item) => item.changed)

      proc_dtl
        .sync({
          'sync': changedData
        })
        .then((res) => {
          this.spinner(false);

          if (res.data.success) {
            this.$vs.notify({
              title: this.$t("SuccessSaveData"),
              position: "top-right",
              color: "success",
            });
            this.query2(this.items[0]['item_mst:item_id']);
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

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-2-1"),
      });
    },
  },

  created() {
    setTimeout(() => {
      this.query((items) => {
        if (items.length > 0) {
          this.query2(items[0]['item_mst:item_id'])
        }
      })
    }, 500)
  },
};
</script> 

<style>
.proc-dtl-sub-row > .ag-cell {
  background: rgba(18, 156, 233, 0.05) !important;
}
</style>