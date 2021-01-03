<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container">
      <div class="flex flex-wrap mb-2">
        <div class="w-full sm:w-2/3 px-1 flex justify-end">
          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <v-select
                  style="width: 150px;"
                  placeholder="검색항목"
                  :options="[{l: '품목명', v: 'item_nm'},{l: '품목 ID', v: 'item_id'}]" 
                  :reduce="item => item.v" 
                  label="l" 
                  v-model="searchBy" 
                  :searchable="false" />
              </div>
              <div class="vx-col sm:w-2/3 w-full">
                <vs-input v-model="searchKeyword" />
              </div>
            </div>
          </div>
          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2">품목</span>
              </div>
              <div class="vx-col sm:w-2/3 w-full flex flex-row">
                <v-select
                  style="width: 150px;"
                  :options="types" 
                  :reduce="item => item.comm2_cd" 
                  label="comm2_nm" 
                  v-model="searchType" 
                  :searchable="false" />
                <vs-button
                  @click="query()"
                  class="mx-1 px-4 flex-shrink-0"
                  color="primary"
                  type="border"
                  >{{ $t("Query") }}</vs-button
                >
              </div>
            </div>
          </div>
        </div>
        <div class="w-full sm:w-1/3 px-1 flex justify-end">
          <div>
            <!-- <vs-button
              :disabled="items.length <= 0"
              @click="saveDialog()"
              class="mx-1 flex-shrink-0"
              color="primary"
              type="border"
              >{{ $t("Save") }}</vs-button> -->
            
          </div>
          <import-excel :onSuccess="loadDataInTable" v-model="importFile" :header="0" :skips="1"></import-excel>
          <div>
            <vs-button
              @click="closeDialog()"
              class="mx-1 flex-shrink-0 py-3"
              color="primary"
              type="border"
              >{{ $t("Close") }}</vs-button
            >
          </div>
        </div>
      </div>

      <vs-divider />

      <div class="flex flex-wrap justify-end mb-2">
        <vs-button
          @click="exportExcel()"
          class="mx-1"
          color="primary"
          type="border"
          :disabled="items.length <= 0"
          >{{ $t("ToExcel") }}</vs-button
        >
      </div>

      <ag-grid-vue
        ref="agGridTable"
        :gridOptions="gridOptions"
        class="ag-theme-material w-100 my-4 ag-grid-table"
        style="max-height: 500px;"
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

      <div class="overflow-y-auto" style="max-height: 500px; display: none;">
        <vs-table
          stripe
          pagination
          description
          sst
          :max-items="pagination.limit"
          :data="items"
          :total="pagination.total"
          @change-page="handleChangePage"
          @sort="handleSort"
        >
          <template slot="thead">
            <vs-th>No</vs-th>
            <vs-th sort-key="item_id">목ID</vs-th>
            <vs-th sort-key="item_nm">품목명</vs-th>
            <vs-th sort-key="spec">규격명</vs-th>
            <vs-th sort-key="unit">단위</vs-th>
            <vs-th sort-key="qty1">당수량(분자)</vs-th>
            <vs-th sort-key="qty2">봉수량</vs-th>
            <vs-th sort-key="conn_no">대표품목 환산수량</vs-th>
            <vs-th sort-key="conn_qty">연결품목 환산수량</vs-th>
            <vs-th sort-key="in_amt">입고가</vs-th>
            <vs-th sort-key="out_amt">출고가</vs-th>
            <vs-th sort-key="item_cd">품목</vs-th>
            <vs-th sort-key="grp1_cd">그룹1</vs-th>
            <vs-th sort-key="grp2_cd">그룹2</vs-th>
            <vs-th sort-key="grp3_cd">그룹3</vs-th>
            <vs-th sort-key="use_yn">사용</vs-th>
            <vs-th sort-key="process_cd">생산공정</vs-th>
          </template>

          <template slot-scope="{ data }">
            <vs-tr :data="tr" :key="index" v-for="(tr, index) in items">

              <vs-td :data="rowIndex(index)">
                {{ rowIndex(index) }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:item_id']">
                {{ data[index]["item_mst:item_id"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:item_nm']">
                {{ data[index]["item_mst:item_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:spec']">
                {{ data[index]["item_mst:spec"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:unit']">
                {{ data[index]["item_mst:unit"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:qty1']" class="text-right">
                {{ data[index]["item_mst:qty1"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:qty2']" class="text-right">
                {{ data[index]["item_mst:qty2"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:conn_no']" class="text-right">
                {{ data[index]["item_mst:conn_no"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:conn_qty']" class="text-right">
                {{ data[index]["item_mst:conn_qty"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:in_amt']" class="text-right">
                {{ data[index]["item_mst:in_amt"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:out_amt']" class="text-right">
                {{ data[index]["item_mst:out_amt"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:item_cd']">
                {{ data[index]["item_mst:item_cd_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:grp1_cd']">
                {{ data[index]["item_mst:grp1_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:grp2_cd']">
                {{ data[index]["item_mst:grp2_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:grp3_cd']">
                {{ data[index]["item_mst:grp3_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:use_yn']">
                {{ data[index]["item_mst:use_yn"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:process_cd']">
                {{ data[index]["item_mst:process_nm"] }}
              </vs-td>

            </vs-tr>
          </template>
        </vs-table>
      </div>
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
import { mapActions } from "vuex";
import ImportExcel from '@/components/excel/ImportExcel.vue'
import { AgGridVue } from 'ag-grid-vue'

import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'

export default {
  components: {
    ImportExcel,
    AgGridVue
  },

  data () {
    return {
      items: [],
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

      maxPageNumbers: 7,
      gridOptions: {
        rowHeight: 40
      },
      gridApi: null,
      defaultColDef: {
        sortable: true,
        editable: false,
        resizable: true,
        suppressMenu: false
      },

      columnDefs: [
        {
          headerName: 'No',
          field: 'no',
          filter: false,
          editable: false,
          width: 100,
        },
        {
          headerName: '코드',
          field: 'item_mst:item_id',
          editable: false,
          width: 100,
        },
        {
          headerName: '품목명',
          field: 'item_mst:item_nm',
          editable: false,
          width: 200,
        },
        {
          headerName: '규격명',
          field: 'item_mst:spec',
          editable: false,
          width: 100,
        },
        {
          headerName: '단위',
          field: 'item_mst:unit',
          editable: false,
          width: 100,
        },
        {
          headerName: '당수량(분자)',
          field: 'item_mst:qty1',
          editable: false,
          type: 'numericColumn',
          width: 100,
        },
        {
          headerName: '대표품목 환산수량',
          field: 'item_mst:conn_no',
          editable: false,
          type: 'numericColumn',
          width: 100,
        },
        {
          headerName: '연결품목 환산수량',
          field: 'item_mst:conn_qty',
          editable: false,
          type: 'numericColumn',
          width: 100,
        },
        {
          headerName: '품목',
          field: 'item_mst:item_cd_nm',
          editable: false,
          width: 100,
        },
        {
          headerName: '그룹1',
          field: 'item_mst:grp1_nm',
          editable: false,
          width: 100,
        },
        {
          headerName: '그룹2',
          field: 'item_mst:grp2_nm',
          editable: false,
          width: 100,
        },
        {
          headerName: '단위(대)',
          field: 'item_mst:unit1_nm',
          editable: false,
          width: 100,
        },
        {
          headerName: '수량(대)',
          field: 'item_mst:unit1_qty',
          type: 'numericColumn',
          editable: false,
          width: 100,
        },
        {
          headerName: '단위(중)',
          field: 'item_mst:unit2_nm',
          editable: false,
          width: 100,
        },
        {
          headerName: '수량(중)',
          field: 'item_mst:unit2_qty',
          type: 'numericColumn',
          editable: false,
          width: 100,
        },
        {
          headerName: '단위(소)',
          field: 'item_mst:unit3_nm',
          editable: false,
          width: 100,
        },
        {
          headerName: '수량(소)',
          field: 'item_mst:unit3_qty',
          type: 'numericColumn',
          editable: false,
          width: 100,
        }
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

      if (this.searchType != null) {
        search_params["item_cd"] = this.searchType;
      }

      api
        .fetch({
          ...this.paginationParam,
          ...this.sortParam,
          limit: -1,
          ...search_params,
        })
        .then((res) => {
          this.spinner(false);
          this.items = res.data.data;
          this.pagination.total = res.data.meta.total;
          this.pagination.page = res.data.meta.current_page;
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

    exportExcel () {
      let search_params = {};

      if (this.searchKeyword != null) {
        search_params[this.searchBy] = this.searchKeyword;
      }

      if (this.searchType != null) {
        search_params["item_cd"] = this.searchType;
      }

      window.location.href = api.export(search_params);
    },

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-1-6"),
      });
    },
  },

  created() {
    comm_cd.fetch({ cd1: "B10" }).then((res) => {
      this.types = res.data;
    });
  },
};
</script>

<style scoped>
.vs-popup--background {
  pointer-events: none;
}
</style>