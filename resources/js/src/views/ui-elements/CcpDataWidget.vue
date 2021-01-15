<template>
  <div>
    <vx-card class="bg-primary-gradient cursor-pointer" @click="data.chart_dialog = true; onPopupOpen(data);">
      <div class="h1 py-2 font-bold text-white text-center">
        {{ data.device_nm }}: <span class="px-8">{{ data.data }}℃</span>
      </div>
      <div class="h2 py-2 text-warning text-right">
        <span class="px-2">일일 최소: {{ data.min }}</span>
        <span class="px-2">최대: {{ data.max }}</span>
        <span class="px-2">평균: {{ data.avg }}</span>
      </div>
      <div class="h3 py-2 text-white text-right">
        <span>최종측정시간: {{ data.reg_dtm_parsed }}</span>
      </div>
    </vx-card>

    <vs-popup fullscreen :title="data.device_nm" :active.sync="data.chart_dialog" button-close-hidden>
      <app-control filterClass="sm:w-4/12" actionClass="sm:w-8/12 content-start">
        <template v-slot:filter>
          <vx-card class="bg-primary">
            <div class="h1 py-2 font-bold text-white text-center">
              {{ data.device_nm }}: <span class="px-8">{{ data.data }}℃</span>
            </div>
            <div class="h2 py-2 text-warning text-right">
              <span class="px-2">일일 최소: {{ data.min }}</span>
              <span class="px-2">최대: {{ data.max }}</span>
              <span class="px-2">평균: {{ data.avg }}</span>
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
            @click="data.chart_dialog = false; onPopupClose(data)"
            class="mx-1 flex-shrink-0"
            color="primary"
            type="border"
            >{{ $t("Close") }}</vs-button
          >
        </template>
      </app-control>

      <vs-divider />

      <vue-apex-charts type="area" height="350" :options="chartOptions" :series="chartSeries" v-if="chartSeries.length > 0"></vue-apex-charts>
    </vs-popup>
  </div>
</template>

<script>
import axios from "axios";
import comm_cd from "@/services/comm_cd";
import ccp_data from "@/services/ccp_data";
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
      themeColors: ['#129CE9', '#46D465', '#E26B6D'],
    }
  },
  props: {
    data: {
      type: Object,
      required: true,
      default: () => {
        return {
          device_id: null,
          device_nm: null,
          chart_dialog: false,
          ccp_seq: null,
          data: null,
          min: null,
          max: null,
          avg: null,
          reg_dtm: null,
          reg_dtm_parsed: null
        }
      }
    },
    chartData: {
      type: Array,
      required: false,
      default: () => {
        return []
      }
    },
    chartCategories: {
      type: Array,
      required: false,
      default: () => {
        return []
      }
    },
    onRefresh: {
      type: Function,
      default: () => {}
    },
    onPopupOpen: {
      type: Function,
      default: () => {}
    },
    onPopupClose: {
      type: Function,
      default: () => {}
    }
  },
  computed: {
    chartSeries () {
      return [{
        name: this.data.device_nm,
        data: this.chartData
      }]
    },
    chartOptions () {
      return {
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
            formatter: function (val, timestamp) {
              return moment(timestamp).utcOffset('+0900').format('MM-DD hh:mm');
            },
            datetimeUTC: true
          },
          tickAmount: 12
        },
      }
    }
  }
}
</script>

<style>

</style>