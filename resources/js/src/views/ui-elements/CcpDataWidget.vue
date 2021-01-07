<template>
  <div>
    <vx-card class="bg-primary-gradient cursor-pointer" @click="chartDialog = true">
      <div class="h1 py-2 font-bold text-white text-center">
        {{ data.device_nm }}: <span class="px-8">{{ data.data.toFixed(2) }}℃</span>
      </div>
      <div class="h2 py-2 text-warning text-right">
        <span class="px-2">금일 최소: {{ data.min.toFixed(2) }}</span>
        <span class="px-2">최대: {{ data.max.toFixed(2) }}</span>
        <span class="px-2">평균: {{ data.avg.toFixed(2) }}</span>
      </div>
      <div class="h3 py-2 text-white text-right">
        <span>최종측정시간: {{ data.reg_dtm_parsed }}</span>
      </div>
    </vx-card>

    <vs-popup fullscreen :title="data.device_nm" :active.sync="chartDialog" button-close-hidden>
      <app-control filterClass="sm:w-4/12" actionClass="sm:w-8/12 content-start">
        <template v-slot:filter>
          <vx-card class="bg-primary">
            <div class="h1 py-2 font-bold text-white text-center">
              {{ data.device_nm }}: <span class="px-8">{{ data.data.toFixed(2) }}℃</span>
            </div>
            <div class="h2 py-2 text-warning text-right">
              <span class="px-2">금일 최소: {{ data.min.toFixed(2) }}</span>
              <span class="px-2">최대: {{ data.max.toFixed(2) }}</span>
              <span class="px-2">평균: {{ data.avg.toFixed(2) }}</span>
            </div>
            <div class="h3 py-2 text-white text-right">
              <span>최종측정시간: {{ data.reg_dtm_parsed }}</span>
            </div>
          </vx-card>
        </template>

        <template v-slot:action>
          <vs-button
            @click="onRefresh(data)"
            class="mx-1 flex-shrink-0"
            color="primary"
            type="border"
            >{{ $t("Refresh") }}</vs-button
          >
          <vs-button
            @click="chartDialog = false"
            class="mx-1 flex-shrink-0"
            color="primary"
            type="border"
            >{{ $t("Close") }}</vs-button
          >
        </template>
      </app-control>

      <vs-divider />

      <vue-apex-charts type="area" height="350" :options="lineAreaChartSpline.chartOptions" :series="chartSeries"></vue-apex-charts>
    </vs-popup>
  </div>
</template>

<script>
import axios from "axios";
import comm_cd from "@/services/comm_cd";
import haccp_monitor from "@/services/haccp_monitor";
import AppControl from "@/views/ui-elements/AppControl";
import moment from 'moment';
import VueApexCharts from 'vue-apexcharts'

export default {
  components: {
    AppControl,
    VueApexCharts
  },
  data () {
    return {
      chartDialog: false,
      themeColors: ['#7367F0', '#28C76F', '#EA5455', '#FF9F43', '#1E1E1E'],
      lineAreaChartSpline: {
        series: [{
            name: 'series1',
            data: [31, 40, 28, 51, 42, 109, 100]
          }
        ],
        chartOptions: {
          dataLabels: {
            enabled: false
          },
          stroke: {
            curve: 'straight'
          },
          colors: this.themeColors,
          xaxis: {
            type: 'datetime',
            categories: ["2018-09-19T00:00:00", "2018-09-19T01:30:00", "2018-09-19T02:30:00",
              "2018-09-19T03:30:00", "2018-09-19T04:30:00", "2018-09-19T05:30:00",
              "2018-09-19T06:30:00"
            ],
          },
          tooltip: {
            x: {
              format: 'dd/MM/yy HH:mm'
            },
          }
        }
      }
    }
  },
  props: {
    data: {
      type: Object,
      required: true,
      default: {
        device_id: null,
        device_nm: null,
        ccp_seq: null,
        data: null,
        min: null,
        max: null,
        avg: null,
        reg_dtm: null,
        reg_dtm_parsed: null
      }
    },
    chartSeries: {
      type: Array,
      required: true
    },
    onRefresh: {
      type: Function,
      default: () => {}
    }
  }
}
</script>

<style>

</style>