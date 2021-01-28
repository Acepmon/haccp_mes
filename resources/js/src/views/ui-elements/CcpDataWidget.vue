<template>
  <div>
    <vx-card class="cursor-pointer ccp-data-widget" :class="{'ccp-data-widget-blink': ccpEscDataBlink, 'bg-primary-gradient': !ccpEscDataBlink}" @click="data.chart_dialog = true; onPopupOpen(data);">
      <div class="h3 py-1 font-bold text-center" :class="{'blink-text': ccpEscDataBlink, 'text-white': !ccpEscDataBlink}">
        {{ data.device_nm }}: <span class="px-8">{{ data.data }}{{ unit }}</span>
      </div>
      <div class="h3 py-1 text-warning text-right">
        <span class="pl-2">일일 최소: {{ data.min }}</span>
        <span class="pl-2">최대: {{ data.max }}</span>
        <span class="pl-2">평균: {{ data.avg }}</span>
      </div>
      <div class="h4 py-1 text-right" :class="{'blink-text': ccpEscDataBlink, 'text-white': !ccpEscDataBlink}">
        <span>최종측정시간: {{ data.reg_dtm_parsed }}</span>
      </div>
    </vx-card>

    <vs-popup fullscreen :title="data.device_nm" :active.sync="data.chart_dialog" button-close-hidden>
      <app-control filterClass="sm:w-8/12" actionClass="sm:w-4/12 content-start">
        <template v-slot:filter>
          <vx-card class="bg-primary" style="width: 500px;">
            <div class="h3 py-1 font-bold text-white text-center">
              {{ data.device_nm }}: <span class="px-8">{{ data.data }}{{ unit }}</span>
            </div>
            <div class="h3 py-1 text-warning text-right">
              <span class="pl-2">일일 최소: {{ data.min }}</span>
              <span class="pl-2">최대: {{ data.max }}</span>
              <span class="pl-2">평균: {{ data.avg }}</span>
            </div>
            <div class="h4 py-1 text-white text-right">
              <span>최종측정시간: {{ data.reg_dtm_parsed }}</span>
            </div>
          </vx-card>
          <vs-table :data="limits" class="ml-4">
            <template slot="thead">
              <vs-th sort-key="ccp_limit:src_cd">CCP 재료명</vs-th>
              <vs-th sort-key="ccp_limit:lmt_up">상한 값</vs-th>
              <vs-th sort-key="ccp_limit:lmt_dn">하한 값</vs-th>
              <vs-th sort-key="ccp_limit:use_yn">사용구분</vs-th>
            </template>

            <template slot-scope="{data}">
              <vs-tr :key="indextr" v-for="(tr, indextr) in limits">
                <vs-td :data="data[indextr]['ccp_limit:src_cd']">{{ data[indextr]['ccp_limit:src_nm'] }}</vs-td>
                <vs-td :data="data[indextr]['ccp_limit:lmt_up']">{{ data[indextr]['ccp_limit:lmt_up'] }}</vs-td>
                <vs-td :data="data[indextr]['ccp_limit:lmt_dn']">{{ data[indextr]['ccp_limit:lmt_dn'] }}</vs-td>
                <vs-td :data="data[indextr]['ccp_limit:use_yn']">{{ data[indextr]['ccp_limit:use_yn'] }}</vs-td>
              </vs-tr>
            </template>
          </vs-table>
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
import ccp_limit from "@/services/ccp_limit";
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
      selected_limit: null,
    }
  },
  props: {
    limits: {
      type: Array,
      required: false,
      default: () => {
        return []
      }
    },
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
          reg_dtm_parsed: null,
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
    },
    onLimitSelected: {
      type: Function,
      default: () => {}
    },
    blink: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    unit ()  {
      if (['CHUMI1', 'RHUMI1', 'SIRIH1'].includes(this.data.device_id)) {
        return '%'
      }
      return '℃'
    },
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
              return moment(timestamp).utcOffset('+0900').format('MM-DD HH:mm');
            },
            datetimeUTC: true
          },
          tickAmount: 12
        },
      }
    },
    handleLimitSelect () {
      this.$emit('input', this.selected_limit)
      this.onLimitSelected(this.selected_limit)
    },
    ccpEscDataBlink () {
      if (this.blink) {
        if (this.data.ccp_esc_data && this.data.ccp_esc_data != null) {
          let srt_dtm = this.data.ccp_esc_data['ccp_esc_data:srt_dtm']
          srt_dtm = srt_dtm.substring(0, 10)
          if (this.data.reg_dtm.substring(0, 10) == srt_dtm) {
            return true
          }
        }
      }
      return false
    }
  }
}
</script>

<style scoped>
@-webkit-keyframes ccpDataWidgetBlink {
  0%, 49% {
    background: linear-gradient(118deg, rgba(var(--vs-primary), 1), rgba(var(--vs-primary), .7));
  }
  50%, 100% {
    background: #ffffff;
  }
}
@-webkit-keyframes ccpDataWidgetBlinkColor {
  0%, 49% {
    color: white;
  }
  50%, 100% {
    color: #129CE9;
  }
}
.ccp-data-widget .vx-card__body {
  padding: 0.5rem !important;
}
.ccp-data-widget-blink {
  -webkit-animation: ccpDataWidgetBlink 1.5s infinite;  /* Safari 4+ */
  -moz-animation: ccpDataWidgetBlink 1.5s infinite;  /* Fx 5+ */
  -o-animation: ccpDataWidgetBlink 1.5s infinite;  /* Opera 12+ */
  animation: ccpDataWidgetBlink 1.5s infinite;  /* IE 10+, Fx 29+ */
}
.ccp-data-widget-blink .blink-text {
  -webkit-animation: ccpDataWidgetBlinkColor 1.5s infinite;  /* Safari 4+ */
  -moz-animation: ccpDataWidgetBlinkColor 1.5s infinite;  /* Fx 5+ */
  -o-animation: ccpDataWidgetBlinkColor 1.5s infinite;  /* Opera 12+ */
  animation: ccpDataWidgetBlinkColor 1.5s infinite;  /* IE 10+, Fx 29+ */
}
</style>