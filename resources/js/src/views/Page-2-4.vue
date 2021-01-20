<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container main-card">
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
          <vs-button
            @click="saveDialog()"
            class="mx-1 invisible"
            color="primary"
            type="border"
            >{{ $t("Save") }}</vs-button
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

      <ag-grid-vue
        ref="agGridTable"
        :localeText="localeText"
        :gridOptions="gridOptions"
        rowSelection="single"
        @selection-changed="handleSelected"
        class="ag-theme-material w-100 my-4 ag-grid-table mt-0"
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

      <vs-divider />

      <app-control>
        <template v-slot:filter>
          <span>작업자 선택을 위해 해당 열을 더블클릭하세요!</span>
        </template>
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
        :gridOptions="gridOptions2"
        rowSelection="single"
        class="ag-theme-material w-100 my-4 ag-grid-table"
        style="height: auto;"
        :columnDefs="columnDefs2"
        :defaultColDef="defaultColDef"
        :rowData="itemsComp2">
      </ag-grid-vue>

    </vx-card>

    <vs-popup fullscreen title="" :active.sync="detailDialog" button-close-hidden>
      <app-control>
        <template v-slot:action>
          <vs-button
            @click="exportExcelDetail()"
            class="mx-1"
            color="primary"
            type="border"
            >{{ $t("ToExcel") }}</vs-button
          >
          <vs-button
            @click="detailDialog = false"
            class="mx-1"
            color="primary"
            type="border"
            >{{ $t("Close") }}</vs-button
          >
        </template>
      </app-control>
      <div class="container">
        <vs-table stripe :data="detailData.summary">
          <vs-tr>
            <vs-th style="pointer-events: none;" colspan="5">
              <span class="h4 py-2 font-bold">작업지시서전표</span>
            </vs-th>
          </vs-tr>

          <vs-tr>
            <vs-th style="pointer-events: none;" colspan="5">
              <span class="h5 py-2 font-bold">전표번호</span>
              <span class="h5 py-2 font-bold"> : {{ detailData.job_no }}</span>
            </vs-th>
          </vs-tr>

          <vs-tr>
            <vs-th style="width: 18%; pointer-events: none;" class="h5 py-2 font-bold text-center">품목코드</vs-th>
            <vs-th style="width: 18%; pointer-events: none;" class="h5 py-2 font-bold text-center">품명 및 규격</vs-th>
            <vs-th style="width: 18%; pointer-events: none;" class="h5 py-2 font-bold text-center">생산공장명</vs-th>
            <vs-th style="width: 18%; pointer-events: none;" class="h5 py-2 font-bold text-center">수량</vs-th>
            <vs-th style="width: 18%; pointer-events: none;" class="h5 py-2 font-bold text-center">안전재고</vs-th>
            <vs-th style="pointer-events: none;" class="h5 py-2 font-bold text-center"></vs-th>
          </vs-tr>

          <vs-tr :key="indextr" v-for="(tr, indextr) in detailData.summary">
            <vs-td>{{ tr['item_id'] }}</vs-td>
            <vs-td>{{ tr['item_nm'] }}</vs-td>
            <vs-td class="text-right">{{ tr['fact_nm'] }}</vs-td>
            <vs-td class="text-right">{{ tr['ord_qty'] }}</vs-td>
            <vs-td></vs-td>
            <vs-td></vs-td>
          </vs-tr>

          <vs-tr>
            <vs-th style="pointer-events: none;" colspan="5" class="h5 py-2">
              {{ detailData.summary_dt }}
            </vs-th>
          </vs-tr>
        </vs-table>

        <vs-table stripe class="mt-5" :data="detailData.details">
          <vs-tr>
            <vs-th style="pointer-events: none;" colspan="6">
              <span class="h4 py-2 font-bold">작업지시서전표</span>
            </vs-th>
          </vs-tr>
          <vs-tr>
            <vs-th style="width: 18%; pointer-events: none;" class="h5 py-2 font-bold text-center">품목코드</vs-th>
            <vs-th style="width: 18%; pointer-events: none;" class="h5 py-2 font-bold text-center">품명 및 규격</vs-th>
            <vs-th style="width: 18%; pointer-events: none;" class="h5 py-2 font-bold text-center">소요량</vs-th>
            <vs-th style="width: 18%; pointer-events: none;" class="h5 py-2 font-bold text-center">안전재고수량</vs-th>
            <vs-th style="width: 18%; pointer-events: none;" class="h5 py-2 font-bold text-center">함량비(%)</vs-th>
            <vs-th class="h5 py-2 font-bold text-center">원산지</vs-th>
          </vs-tr>

          <template v-for="(detail, index) in detailData.details">
            <template>
              <vs-tr v-for="tr in detail.subdetails" :key="tr['item_id']">
                <vs-td>{{ tr['item_id'] }}</vs-td>
                <vs-td>{{ tr['item_nm'] }}</vs-td>
                <vs-td class="text-right">{{ tr['req'] }}</vs-td>
                <vs-td></vs-td>
                <vs-td class="text-center">{{ parseFloat(tr['ratio'], 2) }}</vs-td>
                <vs-td class="text-center">{{ tr['origin'] }}</vs-td>
              </vs-tr>
            </template>
            <vs-tr :key="'A' + index">
              <td colspan="2" class="text-center">합계</td>
              <td class="text-right">{{ detail.reqSum }}</td>
              <td></td>
              <td class="text-center">{{ parseFloat(detail.ratio, 2) }}</td>
              <td class="text-center">{{ detail.origin }}</td>
            </vs-tr>
          </template>

          <vs-tr>
            <vs-th style="pointer-events: none;" colspan="6" class="h5 py-2">
              {{ detailData.details_dt }}
            </vs-th>
          </vs-tr>
        </vs-table>
      </div>
    </vs-popup>

    <vs-popup title="" :active.sync="empDialog" button-close-hidden class="preview-dialog">
      <app-control>
        <template v-slot:action>
          <vs-button
            @click="saveEmp()"
            class="mx-1"
            color="primary"
            type="border"
            >{{ $t("Save") }}</vs-button
          >
          <vs-button
            @click="empDialog = false"
            class="mx-1"
            color="primary"
            type="border"
            >{{ $t("Close") }}</vs-button
          >
        </template>
      </app-control>

      <vs-table multiple v-model="items3_selected" :data="items3">
        <template slot="thead">
          <vs-th>이름</vs-th>
          <vs-th>부서</vs-th>
          <vs-th>직책</vs-th>
          <vs-th>정/부</vs-th>
          <vs-th>주요작업</vs-th>
        </template>

        <template slot-scope="{data}">
          <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data" >
            <vs-td :data="data[indextr]['worker:emp_nm']">
              {{ data[indextr]['worker:emp_nm'] }}
            </vs-td>
            <vs-td :data="data[indextr]['worker:dept_cd']">
              {{ data[indextr]['worker:dept_cd_nm'] }}
            </vs-td>
            <vs-td :data="data[indextr]['worker:duty_cd']">
              {{ data[indextr]['worker:duty_cd_nm'] }}
            </vs-td>
            <vs-td :data="data[indextr]['worker:role_cd']">
              {{ data[indextr]['worker:role_cd_nm'] }}
            </vs-td>
            <vs-td :data="data[indextr]['worker:main_job']">
              {{ data[indextr]['worker:main_job'] }}
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
import job_ord_dtl from "@/services/job_ord_dtl";
import worker from "@/services/worker";
import job_ord_dtl_work from "@/services/job_ord_dtl_work";
import { mapActions } from "vuex";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";
import ImportExcel from "@/components/excel/ImportExcel.vue";

import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import { Korean as KoreanLocale } from "flatpickr/dist/l10n/ko.js"

import { AgGridVue } from "ag-grid-vue";
import AG_GRID_LOCALE_KR from '@/views/ui-elements/ag-grid-table/agGridLocaleKr.js';
import NumericEditor from '@/views/ui-elements/ag-grid-table/numericEditorVue';
import TextEditor from '@/views/ui-elements/ag-grid-table/textEditorVue';

import "@sass/vuexy/extraComponents/agGridStyleOverride.scss";
import moment from 'moment';

export default {
  name: 'page-2-4',
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
      from: moment().format('YYYY-MM-DD'),
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
      item: null,
      item2: null,
      items: [],
      items2: [],
      items3: [],
      items3_selected: [],

      detailDialog: false,
      empDialog: false,
      detailData: {
        job_ord: null,
        summary_dt: null,
        summary: [],
        details: [],
        details_dt: null
      },

      localeText: AG_GRID_LOCALE_KR,
      maxPageNumbers: 7,
      gridOptions: {
        rowHeight: 40,
        headerHeight: 40,
        onCellDoubleClicked: this.handleDoubleClick
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
        { headerName: 'No', field: 'no', cellStyle: {textAlign: 'center'}, width: 50 },
        { headerName: '작업번호', field: 'job_ord:job_no', filter: false, editable: false, width: 120, cellStyle: {'text-decoration': 'underline', 'cursor': 'pointer'} },
        { headerName: '품목ID', field: 'job_ord:item_id', filter: false, editable: false, width: 120, cellStyle: {'text-decoration': 'underline', 'cursor': 'pointer'} },
        { headerName: '품목명', field: 'job_ord:item_nm', filter: false, editable: false, width: 150 },
        { headerName: '지시수량', field: 'job_ord:ord_qty', type: 'numericColumn', filter: false, editable: false, width: 120 },
        { headerName: '생산수량', field: 'job_ord:prod_qty', type: 'numericColumn', filter: false, editable: false, width: 120 },
        { headerName: '담당자', field: 'job_ord:ord_nm', filter: false, editable: false, width: 120 },
        { headerName: '생산공장', field: 'job_ord:fact_cd', filter: false, editable: false, width: 120 }
      ],

      gridOptions2: {
        rowHeight: 40,
        headerHeight: 40,
        domLayout: 'autoHeight',
        onCellDoubleClicked: this.handleDoubleClick2
      },
      gridApi2: null,
      defaultColDef2: {
        sortable: true,
        editable: false,
        resizable: true,
        suppressMenu: false
      },
      columnDefs2: [
        { headerName: 'No', field: 'no', cellStyle: {textAlign: 'center'}, width: 50 },
        { headerName: '공정순서', field: 'SEQ_NM', filter: false, editable: false, width: 150 },
        { headerName: '공정명', field: 'PROC_NM', filter: false, editable: false, width: 150 },
        { headerName: '공정내용', field: 'PROC_DTL', filter: false, editable: false, width: 150 },
        { headerName: '소요시간', field: 'PROC_TIME', filter: false, editable: false, width: 150 },
        { headerName: 'CCP 유무', field: 'CCP_YN', filter: false, editable: false, width: 150 },
        { headerName: '시작시간', field: 'SRT_DTM', filter: false, editable: false, width: 150 },
        { headerName: '종료시간', field: 'END_DTM', filter: false, editable: false, width: 150 },
        { headerName: '작업자', field: 'EMP_NM', filter: false, editable: false, width: 200 },
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

    handleDoubleClick () {
      let rows = this.gridApi.getSelectedRows()
      this.$set(this, 'item', {
        job_ord: null,
        summary_dt: null,
        summary: [],
        details: [],
        details_dt: null
      })

      if (rows.length > 0) {
        this.$set(this, 'item', rows[0])
        this.$set(this, 'detailDialog', true)
        this.fetch({
          job_no: rows[0]['job_ord:job_no'],
        })
      }
    },

    handleDoubleClick2 () {
      let rows = this.gridApi2.getSelectedRows()
      this.$set(this, 'item3', [])

      if (rows.length > 0) {
        this.$set(this, 'item2', rows[0])
        this.$set(this, 'empDialog', true)
        this.query4(rows[0].JOB_NO, rows[0].ITEM_ID, rows[0].SEQ_NO)
      }
    },

    handleSelected () {
      let rows = this.gridApi.getSelectedRows()
      if (rows.length > 0) {
        this.$set(this, 'item', rows[0])
        this.query2(rows[0]['job_ord:job_no'], rows[0]['job_ord:item_id'])
      }
    },

    exportExcelDetail () {
      window.location.href = job_ord.summary_export({
        job_no: this.item['job_ord:job_no'],
      });
    },

    fetch (args = {}) {
      this.spinner();

      job_ord
        .summary_details({
          job_no: this.item['job_ord:job_no'],
          ...args
        })
        .then((res) => {
          this.spinner(false);

          if (res.data.details) {
            this.$set(this.detailData, 'details', res.data.details)
          }

          if (res.data.details_dt) {
            this.$set(this.detailData, 'details_dt', res.data.details_dt)
          }

          if (res.data.job_no) {
            this.$set(this.detailData, 'job_no', res.data.job_no)
          }

          if (res.data.summary) {
            this.$set(this.detailData, 'summary', res.data.summary)
          }

          if (res.data.summary_dt) {
            this.$set(this.detailData, 'summary_dt', res.data.summary_dt)
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

    query (callback = Function) {
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
          sort: 'JOB_NO',
          order: 'DESC',
        })
        .then((res) => {
          this.spinner(false);
          this.items = res.data.data;
          callback(this.items)
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

    query2 (jobNo, itemId) {
      this.spinner();

      job_ord_dtl
        .fetch({
          limit: -1,
          job_no: jobNo,
          item_id: itemId,
          with: 'emp',
        })
        .then((res) => {
          this.spinner(false);
          this.items2 = res.data.data;
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

    query3 () {
      worker
        .fetch({
          limit: -1,
          dept_cd: '10'
        })
        .then((res) => {
          if (res.data.data.length > 0) {
            this.items3 = res.data.data
          }
        })
        .catch((err) => {
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

    query4 (jobNo, itemId, seqNo) {
      this.spinner()

      job_ord_dtl_work
        .fetch({
          limit: -1,
          job_no: jobNo,
          item_id: itemId,
          seq_no: seqNo
        })
        .then((res) => {
          this.spinner(false)

          let empIds = res.data.data.map(item => {
            return item['job_ord_dtl_work:emp_id']
          })

          let selectedItems3 = this.items3.filter((item3) => {
            return empIds.includes(item3['worker:emp_id'])
          });

          this.$set(this, 'items3_selected', selectedItems3)
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

    saveEmp() {
      this.spinner()

      let selected = this.items3_selected.map((item3) => {
        return item3['worker:emp_id']
      })

      job_ord_dtl_work
        .sync({
          job_no: this.item2.JOB_NO,
          item_id: this.item2.ITEM_ID,
          seq_no: this.item2.SEQ_NO,
          sync: selected
        })
        .then((res) => {
          this.spinner(false)

          if (res.data.success) {
            this.$set(this, 'empDialog', false)
            this.query2(this.item2.JOB_NO, this.item2.ITEM_ID)
            this.$vs.notify({
              title: this.$t("SuccessSaveData"),
              position: "top-right",
              color: "success",
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

    exportExcel () {
      let params = {};
      params['job_no'] = this.item['job_ord:job_no'];
      params["item_id"] = this.item['job_ord:item_id'];

      window.location.href = job_ord_dtl.export(params);
    },

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-2-3"),
      });
    },
  },

  mounted () {
    this.gridApi = this.gridOptions.api
    this.gridApi2 = this.gridOptions2.api
  },

  created () {
    setTimeout(() => {
      this.query3()
      this.query((items) => {
        if (items.length > 0) {
          this.$set(this, 'item', items[0])
          this.query2(items[0]['job_ord:job_no'], items[0]['job_ord:item_id'])
        }
      })
    }, 500)
  }
};
</script>

<style lang="css">
.vs-table--not-data {
  display: none !important;
}
th.text-center .vs-table-text {
  justify-content: center;
}
.job-ord-dtl-sub-row > .ag-cell {
  background: rgba(18, 156, 233, 0.05) !important;
}
</style>