<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container main-card">
      <app-control>
        <template v-slot:filter>
          <v-select
            class="control-field"
            placeholder="검색항목"
            :options="[{l: '품목명', v: 'item_nm'},{l: '품목 ID', v: 'item_id'}]" 
            :reduce="item => item.v" 
            v-model="searchBy" 
            label="l"
            :searchable="false" />
          <vs-input v-model="searchKeyword" class="control-field ml-2" />

          <span class="pt-2 px-4">품목</span>
          <v-select
            class="control-field"
            :options="types" 
            :reduce="item => item.comm2_cd" 
            label="comm2_nm" 
            v-model="searchType" 
            :searchable="false" />
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
            :disabled="items.length <= 0"
            @click="saveDialog()"
            class="mx-1 flex-shrink-0"
            color="primary"
            type="border"
            >{{ $t("Save") }}</vs-button
          >
          <import-excel :onSuccess="loadDataInTable" v-model="importFile" :skips="1"></import-excel>
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
            @click="exportExcel()"
            class="mx-1"
            color="primary"
            type="border"
            :disabled="items.length <= 0"
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
        :rowData="itemsComp"
        :frameworkComponents="frameworkComponents"
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
        :columnDefs="columnDefs2"
        :defaultColDef="defaultColDef"
        :rowData="items2Comp"
        :frameworkComponents="frameworkComponents">
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

      <vs-table stripe pagination :max-items="30" search :data="tableData">
        <template slot="header">
          <h4>{{ sheetName }}</h4>
        </template>

        <template slot="thead">
          <vs-th :sort-key="heading" v-for="heading in header" :key="heading">{{ heading }}</vs-th>
        </template>

        <template slot-scope="{data}">
          <!-- eslint-disable-next-line -->
          <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data" v-if="indextr != 0">
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
import api from "@/services/item_mst";
import bom_config from '@/services/bom_config';
import { mapActions } from "vuex";
import ImportExcel from '@/components/excel/ImportExcel.vue'
import { AgGridVue } from 'ag-grid-vue'
import AG_GRID_LOCALE_KR from '@/views/ui-elements/ag-grid-table/agGridLocaleKr.js';

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";

import NumericEditor from '@/views/ui-elements/ag-grid-table/numericEditorVue';

import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'
export default {
  name: 'page-1-7',
  components: {
    ImportExcel,
    AgGridVue,
    AppControl,
    AppForm,
    AppFormGroup
  },

  data () {
    return {
      item: {
      },
      items: [],
      items2: [],
      types: [],
      searchBy: 'item_nm',
      searchKeyword: null,
      searchType: '',
      importFile: null,
      importDialog: false,
      pagination: {
        page: 1,
        limit: 15,
        total: 0,
      },
      sorting: {
        sort: "REG_DTM",
        order: "DESC",
      },

      tableData: [],
      header: [],
      sheetName: '',

      localeText: AG_GRID_LOCALE_KR,
      maxPageNumbers: 7,
      gridApi: null,
      gridApi2: null,
      gridOptions: {
        rowHeight: 40,
        headerHeight: 40
      },
      gridOptions2: {
        rowHeight: 40,
        headerHeight: 40,
        singleClickEdit: true,
        domLayout: 'autoHeight'
      },
      defaultColDef: {
        sortable: true,
        editable: true,
        resizable: true,
        suppressMenu: false
      },
      frameworkComponents: {
        numericEditor: NumericEditor
      },

      columnDefs2: [
        {
          headerName: 'No',
          field: 'no',
          cellStyle: {textAlign: 'center'},
          width: 50
        },
        { headerName: '소모품목코드', field: 'bom_config:item2_id', editable: false, width: 150 },
        { headerName: '소모품목명', field: 'bom_config:item2_nm', editable: false, width: 200 },
        { headerName: 'BOM버전', field: 'bom_config:bom_ver', editable: false, width: 200 },
        { headerName: '생산수량', field: 'bom_config:prod_qty', type: 'numericColumn', cellEditor: 'numericEditor', width: 100 },
        { headerName: '소요량', field: 'bom_config:use_qty', type: 'numericColumn', cellEditor: 'numericEditor', width: 100 },
        { headerName: '단위(대)', field: 'item_mst:unit1_nm', editable: false, width: 100 },
        { headerName: '수량(대)', field: 'item_mst:unit1_qty', type: 'numericColumn', editable: false, width: 100 },
        { headerName: '단위(중)', field: 'item_mst:unit2_nm', editable: false, width: 100 },
        { headerName: '수량(중)', field: 'item_mst:unit2_qty', type: 'numericColumn', editable: false, width: 100 },
        { headerName: '단위(소)', field: 'item_mst:unit3_nm', editable: false, width: 100 },
      ],

      columnDefs: [
        { headerName: 'No', field: 'no', cellStyle: {textAlign: 'center'}, width: 50 },
        { headerName: '코드', field: 'item_mst:item_id', editable: false, width: 150 },
        { headerName: '품목명', field: 'item_mst:item_nm', editable: false, width: 200 },
        { headerName: '규격명', field: 'item_mst:spec', editable: false, width: 100 },
        { headerName: '단위', field: 'item_mst:unit', editable: false, width: 100 },
        { headerName: '당수량(분자)', field: 'item_mst:qty1', editable: false, type: 'numericColumn', width: 100 },
        { headerName: '대표품목 환산수량', field: 'item_mst:conn_no', editable: false, type: 'numericColumn', width: 100 },
        { headerName: '연결품목 환산수량', field: 'item_mst:conn_qty', editable: false, type: 'numericColumn', width: 100 },
      ],
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

    items2Comp: function () {
      return this.items2.map((item, index) => {
        return {
          'no': (index + 1),
          ...item
        } 
      })
    },

    paginationParam: function () {
      return {
        page: this.pagination.page,
        limit: this.pagination.limit,
      };
    },

    sortParam: function () {
      return {
        sort: this.sorting.sort != null ? this.sorting.sort : "REG_DTM",
        order: this.sorting.order != null ? this.sorting.order : "DESC",
      };
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

    handleChangePage(page) {
      this.pagination.page = page;
      this.query();
    },

    handleSort(sort, order) {
      this.sorting.sort = sort;
      this.sorting.order = order;
      this.query();
    },

    handleSelected () {
      let rows = this.gridApi.getSelectedRows()

      if (rows.length > 0) {
        this.$set(this, 'item', rows[0])
        this.query2(rows[0]['item_mst:item_id'])
      }
    },

    loadDataInTable ({ results, header, meta }) {
      this.header = header
      this.tableData = results
      this.sheetName = meta.sheetName
      this.$set(this, 'importDialog', true)
    },

    rowIndex: function (index) {
      return (
        this.pagination.page * this.pagination.limit -
        this.pagination.limit +
        index +
        1
      );
    },

    query2(item1_id) {
      this.spinner();

      let search_params = {
        item1_id: item1_id
      };

      bom_config
        .fetch({
          limit: -1,
          ...search_params,
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

      if (this.searchKeyword != null) {
        search_params[this.searchBy] = this.searchKeyword;
      }

      if (this.searchType != null) {
        search_params["item_cd"] = this.searchType;
      }

      api
        .fetch({
          ...this.paginationParam,
          ...this.sortParam,
          limit: -1,
          ...search_params,
          groupBy: 'ITEM1_ID'
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

    save () {
      this.spinner();

      bom_config
        .sync({
          'sync': this.gridOptions2.rowData
        })
        .then((res) => {
          this.spinner(false);

          if (res.data.success) {
            this.$vs.notify({
              title: this.$t("SuccessSaveData"),
              position: "top-right",
              color: "success",
              text: res.data.message,
            });
            this.query2(this.item['item_mst:item_id']);
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

      bom_config
        .import(formData)
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

    exportExcel () {
      let search_params = {};

      if (this.searchKeyword != null) {
        search_params[this.searchBy] = this.searchKeyword;
      }

      if (this.searchType != null) {
        search_params["item_cd"] = this.searchType;
      }

      window.location.href = bom_config.export(search_params);
    },

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-1-7"),
      });
    },
  },

  created() {
    comm_cd.fetch({ cd1: "B10" }).then((res) => {
      this.types = res.data;
    });

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

<style scoped>
.vs-popup--background {
  pointer-events: none;
}
</style>