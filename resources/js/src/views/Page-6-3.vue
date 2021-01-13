<template>
  <vx-card id="div-with-loading" class="vs-con-loading__container main-card">
    <app-control>
      <template v-slot:filter>
        <span class="flex items-center px-5">발생기간</span>
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
        <span class="flex items-center px-5">CCP 장비</span>
        <vs-input
          class="control-field-sm"
          v-model="lmt_up"
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
          class="mx-1"
          color="primary invisible"
          type="border"
          >{{ $t("Add") }}</vs-button
        >
        <vs-button
          @click="saveDialog()"
          class="mx-1"
          color="primary"
          type="border"
          :disabled="item['ccp_esc_data:device_id'] == null"
          >{{ $t("Save") }}</vs-button
        >
        <vs-button
          @click="removeDialog()"
          class="mx-1"
          color="primary invisible"
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

    <vue-apex-charts type="area" height="350" :options="chartOptions" :series="chartSeries" v-if="item['ccp_esc_data:device_id'] != null && chartSeries.length > 0"></vue-apex-charts>

    <app-form v-if="item['ccp_esc_data:device_id'] != null">
      <app-form-group full>
        <template v-slot:label>발생사유</template>

        <vs-input
          class="control-field-lg"
          v-model="item['ccp_esc_data:reason']"
        />
      </app-form-group>
    </app-form>

    <ag-grid-vue
      ref="agGridTable"
      :localeText="localeText"
      rowSelection="single"
      @selection-changed="handleSelected"
      :gridOptions="gridOptions"
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
import ccp_esc_data from "@/services/ccp_esc_data";
import haccp_monitor from "@/services/haccp_monitor";
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
  name: 'page-6-3',
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
      from: null,
      to: null,
      configFromdateTimePicker: {
        maxDate: null,
        locale: KoreanLocale,
      },
      configTodateTimePicker: {
        minDate: null,
        locale: KoreanLocale,
      },
      lmt_up: null,

      item: {
        'ccp_esc_data:device_id': null,
        'ccp_esc_data:srt_dtm': null,
        'ccp_esc_data:end_dtm': null,
        'ccp_esc_data:reason': null,
      },
      required: {
      },
      items: [],
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
      columnDefs: [
        { headerName: 'No', field: 'no', cellStyle: {textAlign: 'center'}, width: 50 },
        { headerName: '발생일시', field: 'ccp_esc_data:srt_dtm_parsed', filter: false, width: 200 },
        { headerName: '종료일시', field: 'ccp_esc_data:end_dtm_parsed', filter: false, width: 200 },
        { headerName: 'CCP 장비', field: 'ccp_esc_data:device_nm', filter: false, width: 200 },
        { headerName: '상한값', field: 'ccp_limit:lmt_up', filter: false, type: 'numericColumn', width: 100 },
        { headerName: '하한값', field: 'ccp_limit:lmt_dn', filter: false, type: 'numericColumn', width: 100 },
        { headerName: '발생사유', field: 'ccp_esc_data:reason', filter: false, width: 200 },
      ],

      themeColors: ['#129CE9', '#46D465', '#E26B6D'],
      chartData: [],
      chartCategories: [],
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
    },

    chartSeries () {
      return [{
        name: this.item['ccp_esc_data:device_id'],
        data: this.chartData
      }]
    },
    chartOptions () {
      return {
        annotations: {
          yaxis: [
            {
              y: this.item['ccp_limit:lmt_up'],
              borderColor: '#E26B6D',
              borderWidth: 2,
              label: {
                show: true,
                text: 'CCP 장비: ' + this.item['ccp_limit:lmt_up'],
                style: {
                  color: "#fff",
                  background: '#E26B6D'
                }
              }
            },
            {
              y: this.item['ccp_limit:lmt_dn'],
              borderColor: '#129CE9',
              borderWidth: 2,
              label: {
                show: true,
                text: '하한값: ' + this.item['ccp_limit:lmt_dn'],
                style: {
                  color: "#fff",
                  background: '#129CE9'
                }
              }
            }
          ]
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        colors: this.themeColors,
        xaxis: {
          type: 'datetime',
          categories: this.chartCategories,
          labels: {
            format: 'MM-dd HH:MM',
            formatter: function (val, timestamp) {
              return moment(timestamp).utcOffset('+0900').format('MM-DD HH:mm')
            },
            datetimeUTC: true
          },
          tickAmount: 2
        },
        tooltip: {
          x: {
            format: 'MM-dd HH:MM'
          },
        }
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

    validateRequired() {
      let passed = true
      for (const [key, value] of Object.entries(this.required)) {
        if (Array.isArray(this.item[key])) {
          if (this.item[key] === undefined || this.item[key].length == 0) {
            this.$set(this.errors, key, '필수항목입니다.')
            passed = false
          }
        } else {
          if (this.item[key]) {
          } else {
            this.$set(this.errors, key, '필수항목입니다.')
            passed = false
          }
        }
      }

      return passed
    },

    handleSelected () {
      let rows = this.gridApi.getSelectedRows()
      this.$set(this, 'chartData', [])
      this.$set(this, 'chartCategories', [])

      if (rows.length > 0) {
        this.$set(this, 'item', rows[0]);
        this.queryChartData(rows[0]['ccp_esc_data:device_id'])
      }
    },

    onFromChange(selectedDates, dateStr, instance) {
      this.$set(this.configTodateTimePicker, "minDate", dateStr);
    },

    onToChange(selectedDates, dateStr, instance) {
      this.$set(this.configFromdateTimePicker, "maxDate", dateStr);
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

      if (this.lmt_up != null) {
        search_params['lmt_up'] = this.lmt_up;
      }

      ccp_esc_data
        .fetch({
          sort: 'SRT_DTM',
          order: 'DESC',
          limit: -1,
          with: 'ccp_limit,device',
          ...search_params,
        })
        .then((res) => {
          this.spinner(false);
          this.items = res.data.data;
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

    queryChartData (deviceId) {
      this.spinner()

      let search_params = {};

      if (this.item['ccp_esc_data:srt_dtm'] != null) {
        search_params['from'] = this.item['ccp_esc_data:srt_dtm'];
      }

      if (this.item['ccp_esc_data:end_dtm'] != null) {
        search_params['to'] = this.item['ccp_esc_data:end_dtm'];
      }

      haccp_monitor
        .ccp_data_details(deviceId, {
          ...search_params,
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

    save () {
      this.spinner();

      ccp_esc_data
        .put(this.item["ccp_esc_data:device_id"], this.item)
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
            // this.clear()
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
      if (this.validateRequired()) {
        this.$vs.dialog({
          type: "confirm",
          color: "success",
          title: this.$t("Confirmation"),
          text: this.$t("SaveData"),
          acceptText: this.$t("Accept"),
          cancelText: this.$t("Cancel"),
          accept: () => this.save(),
        });
      }
    },

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-6-3"),
      });
    }
  },

  mounted () {
    this.gridApi = this.gridOptions.api
  },

  created () {
    setTimeout(() => {
      this.query();
    }, 200);
  }
}
</script>

<style>

</style>