<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container">
      <app-control>
        <template v-slot:filter>
          <v-select
            class="control-field"
            placeholder="검색항목"
            :options="[{l: '회사명', v: 'cust_nm'},{l: '사업자등록번호', v: 'cust_id'}]" 
            :reduce="item => item.v" 
            label="l" 
            v-model="searchBy" 
            :searchable="false" />
          <vs-input v-model="searchKeyword" class="control-field ml-2" />
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
          <import-excel :onSuccess="loadDataInTable" v-model="importFile" :header="0" :skips="1">
          </import-excel>
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
        :gridOptions="gridOptions"
        class="ag-theme-material w-100 my-4 ag-grid-table"
        style="max-height: 400px;"
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
            <vs-th sort-key="cust_id">거래처코드</vs-th>
            <vs-th sort-key="cust_nm">거래처명</vs-th>
            <vs-th sort-key="ceo_nm">대표</vs-th>
            <vs-th sort-key="mob_no">핸드폰번호</vs-th>
            <vs-th sort-key="qty1">담당자</vs-th>
            <vs-th sort-key="qty2">담당자 연락처</vs-th>
            <vs-th sort-key="conn_no">전화번호</vs-th>
            <vs-th sort-key="conn_qty">Fax 번호</vs-th>
            <vs-th sort-key="in_amt">검색창내용</vs-th>
            <vs-th sort-key="out_amt">Email</vs-th>
            <vs-th sort-key="cust_no">계층그룹명</vs-th>
            <vs-th sort-key="grp1_cd">주소</vs-th>
            <vs-th sort-key="grp2_cd">적요</vs-th>
            <vs-th sort-key="use_yn">사용구분</vs-th>
           </template>

          <template slot-scope="{ data }">
            <vs-tr :data="tr" :key="index" v-for="(tr, index) in items">

              <vs-td :data="rowIndex(index)">
                {{ rowIndex(index) }}
              </vs-td>

              <vs-td :data="data[index]['cust_info:cust_id']">
                {{ data[index]["cust_info:cust_id"] }}
              </vs-td>

              <vs-td :data="data[index]['cust_info:cust_nm']">
                {{ data[index]["cust_info:cust_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['cust_info:ceo_nm']">
                {{ data[index]["cust_info:ceo_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['cust_info:mob_no']">
                {{ data[index]["cust_info:mob_no"] }}
              </vs-td>

              <vs-td :data="data[index]['cust_info:cust_no']">
                {{ data[index]["cust_info:cust_no_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['cust_info:tel_no']">
                {{ data[index]["cust_info:tel_no"] }}
              </vs-td>

              <vs-td :data="data[index]['cust_info:fax_no']">
                {{ data[index]["cust_info:fax_no"] }}
              </vs-td>

              <vs-td :data="data[index]['cust_info:srh_no']">
                {{ data[index]["cust_info:srh_no"] }}
              </vs-td>

              <vs-td :data="data[index]['cust_info:email']">
                {{ data[index]["cust_info:email"] }}
              </vs-td>

              <vs-td :data="data[index]['cust_info:grp_nm']">
                {{ data[index]["cust_info:grp_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['cust_info:addr']">
                {{ data[index]["cust_info:addr"] }}
              </vs-td>

              <vs-td :data="data[index]['cust_info:remark']">
                {{ data[index]["cust_info:remark"] }}
              </vs-td>
              
              <vs-td :data="data[index]['cust_info:use_yn']">
                {{ data[index]["cust_info:use_yn"] }}
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
// import comm_cd from "@/services/comm_cd";
import api from "@/services/cust_info";
import { mapActions } from "vuex";
import ImportExcel from '@/components/excel/ImportExcel.vue'
import { AgGridVue } from 'ag-grid-vue'
import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";

import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'

export default {
  components: {
    ImportExcel,
    AgGridVue,
    AppControl,
    AppForm,
    AppFormGroup
  },

  data () {
    return {
      items: [],
      types: [],
      searchBy: 'cust_nm',
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
        sort: "CUST_ID",
        order: "ASC",
      },

      tableData: [],
      header: [],
      sheetName: '',

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
        {
          headerName: 'No',
          field: 'no',
          filter: false,
          editable: false,
          width: 100,
        },
        {
          headerName: '거래처코드',
          field: 'cust_info:cust_id',
          editable: false,
          width: 100,
        },
        {
          headerName: '품목거래처명',
          field: 'cust_info:cust_nm',
          editable: false,
          width: 200,
        },
        {
          headerName: '대표',
          field: 'cust_info:ceo_nm',
          editable: false,
          width: 100,
        },
        {
          headerName: '핸드폰번호',
          field: 'cust_info:mob_no',
          editable: false,
          width: 100,
        },
        {
          headerName: '담당',
          field: 'cust_info:cust_nm',
          editable: false,
          //type: 'numericColumn',
          width: 100,
        },
        {
          headerName: '담당자 연락처',
          field: 'cust_info:cust_no',
          editable: false,
          //type: 'numericColumn',
          width: 100,
        },
        {
          headerName: '전화번호',
          field: 'cust_info:tel_no',
          editable: false,
          //type: 'numericColumn',
          width: 100,
        },
        {
          headerName: 'Fax 번호',
          field: 'cust_info:fax_no',
          editable: false,
          width: 100,
        },
        {
          headerName: '검색창내용',
          field: 'cust_info:srh_no',
          editable: false,
          width: 100,
        },
        {
          headerName: 'Email',
          field: 'cust_info:email',
          editable: false,
          width: 100,
        },
        {
          headerName: '계층그룹명',
          field: 'cust_info:grp_nm',
          editable: false,
          width: 100,
        },
        {
          headerName: '주소',
          field: 'cust_info:addr',
          //type: 'numericColumn',
          editable: false,
          width: 100,
        },
        {
          headerName: '적요',
          field: 'cust_info:remark',
          editable: false,
          width: 100,
        },
        {
          headerName: '사용구분',
          field: 'cust_info:use_yn',
          //type: 'numericColumn',
          editable: false,
          width: 100,
        },
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
        search_params["cust_no"] = this.searchType;
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
        search_params["cust_no"] = this.searchType;
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