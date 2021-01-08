<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container pt-0">
      <app-control>
        <template v-slot:filter>
          <span class="flex items-center px-5">기간</span>
          <flat-pickr
            :config="configFromdateTimePicker"
            v-model="from"
            placeholder="시작일자"
            @on-change="onFromChange"
            class="control-field-dtm mx-1"
          />
          <span class="flex items-center px-2">~</span>
          <flat-pickr
            :config="configTodateTimePicker"
            v-model="to"
            placeholder="종료일자"
            @on-change="onToChange"
            class="control-field-dtm mx-1"
          />
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
          <import-excel :onSuccess="loadDataInTable" v-model="importFile"></import-excel>
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
        class="ag-theme-material w-100 my-4 ag-grid-table mt-0"
        style="max-height: 400px;"
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
import job_ord from "@/services/job_ord";
import { mapActions } from "vuex";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";
import ImportExcel from "@/components/excel/ImportExcel.vue";

import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import { Korean as KoreanLocale } from "flatpickr/dist/l10n/ko.js"

import { AgGridVue } from "ag-grid-vue";
import NumericEditor from '@/views/ui-elements/ag-grid-table/numericEditorVue';
import TextEditor from '@/views/ui-elements/ag-grid-table/textEditorVue';

import "@sass/vuexy/extraComponents/agGridStyleOverride.scss";
import moment from 'moment';

export default {
  components: {
    AppControl,
    AppForm,
    AppFormGroup,
    ImportExcel,
    AgGridVue,
    flatPickr
  },

  data () {
    return {
      format: "yyyy-MM-dd",
      from: moment().startOf('month').format('YYYY-MM-DD'),
      to: moment().format('YYYY-MM-DD'),
      configFromdateTimePicker: {
        maxDate: null,
        locale: KoreanLocale,
      },
      configTodateTimePicker: {
        minDate: null,
        locale: KoreanLocale,
      },
      importFile: null,
      importDialog: false,
      items: [],

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
      frameworkComponents: {
        numericEditor: NumericEditor,
        textEditor: TextEditor
      },
      columnDefs: [
        {
          headerName: 'No',
          field: 'no',
          filter: false,
          editable: false,
          width: 80,
        },
        {
          headerName: '작업번호',
          field: 'job_ord:job_no',
          filter: false,
          editable: false,
          width: 120,
        },
        {
          headerName: '품목ID',
          field: 'job_ord:item_id',
          filter: false,
          editable: false,
          width: 120,
        },
        {
          headerName: '품목명',
          field: 'job_ord:item_nm',
          filter: false,
          editable: false,
          width: 150,
        },
        {
          headerName: '지시수량',
          field: 'job_ord:ord_qty',
          type: 'numericColumn',
          filter: false,
          editable: false,
          width: 120,
        },
        {
          headerName: '생산수량',
          field: 'job_ord:prod_qty',
          type: 'numericColumn',
          filter: false,
          editable: false,
          width: 120,
        },
        {
          headerName: '담당자',
          field: 'job_ord:ord_nm',
          filter: false,
          editable: false,
          width: 120,
        },
        {
          headerName: '생산공장',
          field: 'job_ord:fact_cd',
          filter: false,
          editable: false,
          width: 120,
        },
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

    onFromChange(selectedDates, dateStr, instance) {
      this.$set(this.configTodateTimePicker, "minDate", dateStr);
    },

    onToChange(selectedDates, dateStr, instance) {
      this.$set(this.configFromdateTimePicker, "maxDate", dateStr);
    },

    loadDataInTable ({ results, header, meta }) {
      this.header = header
      this.tableData = results
      this.sheetName = meta.sheetName
      this.$set(this, 'importDialog', true)
    },

    query () {
      this.spinner();

      let search_params = {};

      if (this.from != null) {
        search_params['from'] = this.from;
      }

      if (this.to != null) {
        search_params['to'] = this.to;
      }

      job_ord
        .fetch({
          limit: -1,
          ...search_params,
        })
        .then((res) => {
          this.spinner(false);
          this.items = res.data.data;
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

      job_ord
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

      window.location.href = job_ord.export(search_params);
    },

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-2-2"),
      });
    },
  },

  mounted () {
    this.gridApi = this.gridOptions.api
  },

  created () {
    setTimeout(() => {
      this.query()
    }, 500)
  }
};
</script>

<style>
</style>