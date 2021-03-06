<template>
  <vx-card id="div-with-loading" class="vs-con-loading__container main-card">
    <app-control>
      <template v-slot:filter>
        <span class="flex items-center px-5 pt-2">기간</span>
        <flat-pickr
          :config="configFromdateTimePicker"
          v-model="from"
          placeholder="시작일자"
          @on-change="onFromChange"
          class="control-field-dtm mx-1"
        />
        <span class="flex items-center px-2 pt-2">~</span>
        <flat-pickr
          :config="configTodateTimePicker"
          v-model="to"
          placeholder="종료일자"
          @on-change="onToChange"
          class="control-field-dtm mx-1"
        />
        <span class="flex items-center px-5 pt-2">CCP 장비</span>
        <v-select 
          class="control-field-lg"
          :options="devices" 
          :reduce="item => item.comm2_cd" 
          label="comm2_nm" 
          v-model="searchDeviceId" 
          :searchable="false" />
      </template>
      <template v-slot:action>
        <vs-button
          @click="pagination.currentPage = 1; item = null; query()"
          class="mx-1 mr-16"
          color="primary"
          type="border"
          >{{ $t("Query") }}</vs-button
        >
        <vs-button
          @click="saveDialog()"
          class="mx-1"
          color="primary invisible"
          type="border"
          >{{ $t("Save") }}</vs-button
        >
        <vs-button
          @click="toGraph()"
          class="mx-1"
          color="primary"
          type="border"
          :disabled="searchDeviceId == ''"
          >{{ $t("ToGraph") }}</vs-button
        >
        <vs-button
          @click="exportExcel()"
          class="mx-1"
          color="primary"
          type="border"
          :disabled="items.length <= 0"
          >{{ $t("ToExcel") }}</vs-button
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

    <vue-apex-charts type="area" height="350" :options="chartOptions" :series="chartSeries" v-if="item != null && chartSeries.length > 0"></vue-apex-charts>

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
</template>

<script>
import axios from "axios";
import comm_cd from "@/services/comm_cd";
import ccp_data from "@/services/ccp_data";
import { mapActions } from "vuex";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";

import { AgGridVue } from 'ag-grid-vue'
import AG_GRID_LOCALE_KR from '@/views/ui-elements/ag-grid-table/agGridLocaleKr.js';;
import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'

import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import { Korean as KoreanLocale } from "flatpickr/dist/l10n/ko.js"

import moment from 'moment';

import VueApexCharts from 'vue-apexcharts'

export default {
  name: 'page-6-4',

  components: {
    AppControl,
    AppForm,
    AppFormGroup,
    AgGridVue,
    flatPickr,
    VueApexCharts
  },

  data () {
    return {
      format: "yyyy-MM-dd",
      from: moment().startOf('month').format('YYYY-MM-DD'),
      fromSuffix: '000000',
      to: moment().format('YYYY-MM-DD'),
      searchDeviceId: '',
      configFromdateTimePicker: {
        maxDate: null,
        locale: KoreanLocale,
      },
      configTodateTimePicker: {
        minDate: null,
        locale: KoreanLocale,
      },

      item: null,
      devices: [],
      items: [],
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
      columnDefs: [
        { headerName: 'No', field: 'no', cellStyle: {textAlign: 'center'}, width: 50 },
        { headerName: '장비명', field: 'device_nm', filter: false, width: 300 },
        { headerName: '데이터', field: 'data', cellStyle: {textAlign: 'center'}, width: 300 },
        { headerName: '일시', field: 'reg_dtm_parsed', cellStyle: {textAlign: 'center'}, width: 300 },
      ],
      pagination: {
        total: 0,
        totalPages: 0,
        pageSize: 50,
        currentPage: 1
      },

      chartData: [],
      chartCategories: [],
    }
  },

  computed: {
    itemsComp: function () {
      return this.items.map((item, index) => {
        return {
          'no': (this.pagination.currentPage - 1) * this.pagination.pageSize + (index + 1),
          ...item
        } 
      })
    },

    totalPages () {
      if (this.pagination) return this.pagination.totalPages
      else return 0
    },
    paginationPageSize () {
      if (this.pagination) return this.pagination.pageSize
      else return 50
    },
    currentPage: {
      get () {
        if (this.pagination) return this.pagination.currentPage
        else return 1
      },
      set (val) {
        this.pagination.currentPage = val
        this.query(false)
      }
    },

    chartSeries () {
      return [{
        name: this.item['ccp_esc_data:device_id'],
        data: this.chartData
      }]
    },
    chartOptions () {
      return {
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth'
        },
        colors: this.themeColors,
        xaxis: {
          type: 'datetime',
          categories: this.chartCategories,
          labels: {
            formatter: function (val, timestamp) {
              return moment(timestamp).utcOffset('+0900').format('MM-DD HH:mm');
            },
            datetimeUTC: true
          },
          tickAmount: 12
        },
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
      this.$set(this, 'chartData', [])
      this.$set(this, 'chartCategories', [])

      if (rows.length > 0) {
        this.$set(this, 'item', rows[0]);
        this.widgetRefresh(rows[0]['device_id'])
      }
    },

    toGraph () {
      this.$set(this, 'item', {
        device_id: this.searchDeviceId
      });
      this.widgetRefresh(this.searchDeviceId)
    },

    widgetRefresh (deviceId) {
      this.spinner()

      ccp_data
        .details(deviceId, {
          from: moment(this.from).format('YYYYMMDD') + this.fromSuffix,
          to: moment(this.to).format('YYYYMMDD') + '235959',
          sort: 'REG_DTM',
          order: 'ASC',
          limit: -1
        })
        .then((res) => {
          this.spinner(false)
          if (res.data.data.length > 0) {
            let chartData = res.data.data.map(i => i.data)
            let chartCats = res.data.data.map(i => i.reg_dtm_parsed)
            this.$set(this, 'chartData', chartData)
            this.$set(this, 'chartCategories', chartCats)
          }
        })
        .catch((err) => {
          this.spinner(false)
          console.log(err)
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

    query() {
      this.spinner();

      let search_params = {};

      if (this.from != null) {
        search_params['from'] = this.from;
      }

      if (this.to != null) {
        search_params['to'] = this.to;
      }

      if (this.searchDeviceId != null) {
        search_params['device_id'] = this.searchDeviceId;
      }

      ccp_data
        .fetch({
          sort: 'REG_DTM',
          order: 'DESC',
          ...search_params,
          limit: this.pagination.pageSize,
          page: this.pagination.currentPage,
          latest_item: true
        })
        .then((res) => {
          this.spinner(false);
          if (res.data) {
            this.$set(this.pagination, 'total', res.data.meta.total)
            this.$set(this.pagination, 'totalPages', Math.round(res.data.meta.total / res.data.meta.per_page))
            this.$set(this, 'items', res.data.data)

            if (res.data.meta) {
              if (res.data.meta.latest_item) {
                let latestRegDtm = res.data.meta.latest_item['REG_DTM']
                // 20210104161243
                this.fromSuffix = latestRegDtm.substring(8)
              }
            }
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

    exportExcel() {
      let search_params = {};

      if (this.from != null) {
        search_params['from'] = this.from;
      }

      if (this.to != null) {
        search_params['to'] = this.to;
      }

      if (this.searchDeviceId != null) {
        search_params['device_id'] = this.searchDeviceId;
      }

      window.location.href = ccp_data.export(search_params);
    },

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-6-4"),
      });
    }
  },

  mounted () {
    this.gridApi = this.gridOptions.api
  },

  created () {
    comm_cd.fetch({ cd1: "C00" }).then((res) => {
      this.$set(this, 'devices', [{ comm2_cd: '', comm2_nm: 'All Devices' }].concat(res.data))
    });

    setTimeout(() => {
      this.query();
    }, 500);
  }
}
</script>

<style>

</style>