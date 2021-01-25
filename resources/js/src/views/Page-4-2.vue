<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container main-card">
      <app-control>
        <template v-slot:filter>
          <span class="px-5 pt-2">자료검색</span>
          <vs-input class="control-field-lm" v-model="searchKeyword" placeholder="일자 품목코드 품목명 규격 LOT번호" />
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
            @click="addDialog()"
            class="mx-1 invisible"
            color="primary"
            type="border"
            >{{ $t("Add") }}</vs-button
          >
          <!-- <import-excel :onSuccess="loadDataInTable" v-model="importFile" :header="0" :skips="1"> -->
          <import-excel :onSuccess="loadDataInTable" v-model="importFile" :header="0" :skips="1"></import-excel>
          <!-- <import-excel :onSuccess="loadDataInTable" v-model="importFile" >
          </import-excel> -->
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
          <span class="pl-5">시리얼/LOT 내역을 보려면 해당 열을 더블클릭하세요!</span>
        </template>
        <!-- <template v-slot:action>
          <vs-button
            @click="exportExcel()"
            class="mx-1"
            color="primary"
            type="border"
            :disabled="items.length <= 0"
            >{{ $t("ToExcel") }}</vs-button
          >
        </template> -->
      </app-control>

      <ag-grid-vue
        ref="agGridTable"
        :localeText="localeText"
        :gridOptions="gridOptions"
        rowSelection="single"
        class="ag-theme-material w-100 my-4 ag-grid-table"
        style="max-height: 100%;"
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
<!-- 
        <template slot="thead">
          <vs-th :sort-key="heading" v-for="heading in header" :key="heading">{{ heading }}</vs-th>
        </template> -->

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

    <vs-popup title="" :active.sync="lotInfoDialog" button-close-hidden id="div-with-loading2" class="vs-con-loading__container preview-dialog">
      <app-control>
        <template v-slot:action>
          <vs-button
            @click="lotInfoDialog = false"
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
        :gridOptions="gridOptions2"
        class="ag-theme-material w-100 my-4 ag-grid-table"
        style="max-height: 100%;"
        :columnDefs="columnDefs2"
        :defaultColDef="defaultColDef"
        :rowData="items2Comp">
      </ag-grid-vue>
    </vs-popup>
  </div>
</template>

<script>
import axios from "axios";
// import comm_cd from "@/services/comm_cd";
import api from "@/services/prod_info";
import lot_info from "@/services/lot_info";
import { mapActions } from "vuex";
import ImportExcel from '@/components/excel/ImportExcel.vue'
import { AgGridVue } from 'ag-grid-vue'
import AG_GRID_LOCALE_KR from '@/views/ui-elements/ag-grid-table/agGridLocaleKr.js';
import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";

import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'

export default {
  name: 'page-4-2',
  components: {
    ImportExcel,
    AgGridVue,
    AppControl,
    AppForm,
    AppFormGroup
  },

  data () {
    return {
      item: {},
      items: [],
      items2: [],
      types: [],
      searchBy: 'key_word',
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
        sort: "ACC_NO",
        order: "ASC",
      },

      lotInfoDialog: false,

      tableData: [],
      header: [],
      sheetName: '',

      localeText: AG_GRID_LOCALE_KR,
      maxPageNumbers: 7,
      gridOptions: {
        rowHeight: 40,
        headerHeight: 40,
        onCellDoubleClicked: this.handleDblClick
      },
      gridApi: null,
      defaultColDef: {
        sortable: true,
        resizable: true,
        suppressMenu: false
      },

      gridOptions2: {
        rowHeight: 40,
        headerHeight: 40
      },
      gridApi2: null,

      columnDefs: [
        { headerName: 'No', field: 'no', cellStyle: {textAlign: 'center'}, width: 50},
        { headerName: '일자-No', field: 'prod_info:acc_no', width: 100,},
        { headerName: '품목코드', field: 'prod_info:item_id', filter: true, width: 100,},
        { headerName: '품목이름', field: 'prod_info:item_nm', width: 300,},
        { headerName: '출고창고', field: 'prod_info:out_wh_nm', width: 100,},
        { headerName: '입고창고', field: 'prod_info:in_wh_nm', width: 100,},
        { headerName: '규격', field: 'prod_info:spec', width: 200,},
        { headerName: '수량', field: 'prod_info:qty', type: 'numericColumn', width: 100,},
        { headerName: '시리얼/Lot No', field: 'prod_info:lot_no', width: 100,},
      ],

      columnDefs2: [
        { headerName: 'No', field: 'no', cellStyle: {textAlign: 'center'}, width: 50 },
        { headerName: '일자-No', field: 'lot_info:dt_no', width: 100 },
        { headerName: '연결전표-No', field: 'lot_info:acc_no', width: 100 },
        { headerName: '품목코드', field: 'lot_info:item_id', width: 100 },
        { headerName: '품목이름', field: 'lot_info:item_nm', width: 200 },
        { headerName: '규격', field: 'lot_info:spec', width: 100 },
        { headerName: '시리얼/Lot No', field: 'lot_info:lot_no', width: 100 },
        { headerName: '수량', field: 'lot_info:qty', type: 'numericColumn', width: 100 },
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

    // sortParam: function () {
    //   return {
    //     sort: this.sorting.sort != null ? this.sorting.sort : "REG_DTM",
    //     order: this.sorting.order != null ? this.sorting.order : "DESC",
    //   };
    // },


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

    spinner2(loading = true) {
      if (loading) {
        this.$vs.loading({
          container: "#div-with-loading2",
          scale: 0.6,
        });
      } else {
        this.$vs.loading.close("#div-with-loading2 > .con-vs-loading");
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

    query() {
      this.spinner();

      let search_params = {};

      if (this.searchKeyword != null) {
        search_params[this.searchBy] = this.searchKeyword;
      }

      api
        .fetch({
          ...this.paginationParam,
          sort: 'ACC_NO',
          order: 'DESC',
          limit: -1,
          ...search_params,
          with: '' // example: disable like this
        })
        .then((res) => {
          this.spinner(false);
          this.items = res.data.data;
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

    handleDblClick () {
      let rows = this.gridApi.getSelectedRows()

      if (rows.length > 0) {
        this.$set(this, 'lotInfoDialog', true)
        this.$set(this, 'item', rows[0])
        this.query2()
      }
    },

    query2() {
      this.spinner2();

      lot_info
        .fetch({
          acc_no: this.item['prod_info:acc_no'],
          limit: -1,
          sort: 'DT_NO',
          order: 'DESC',
          with: '',
        })
        .then((res) => {
          this.spinner2(false);
          if (res.data) {
            this.$set(this, 'items2', res.data.data)
          }
        })
        .catch((err) => {
          this.spinner2(false);
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

      api
        .sync({
          'sync': this.gridOptions.rowData
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

      api
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

    // exportExcel () {
    //   let search_params = {};

    //   if (this.searchKeyword != null) {
    //     search_params[this.searchBy] = this.searchKeyword;
    //   }

    //   if (this.searchType != null) {
    //     search_params["cust_no"] = this.searchType;
    //   }

    //   window.location.href = api.export(search_params);
    // },

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-3-1"),
      });
    },
  },

  created() {
    setTimeout(() => {
      this.query()
    }, 500)
  },
};
</script>

<style scoped>
.vs-popup--background {
  pointer-events: none;
}
</style>