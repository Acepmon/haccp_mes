<template>
  <div>
    <vx-card class="bg-primary cursor-pointer" @click="chartDialog = true">
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
    </vs-popup>
  </div>
</template>

<script>
import axios from "axios";
import comm_cd from "@/services/comm_cd";
import haccp_monitor from "@/services/haccp_monitor";
import AppControl from "@/views/ui-elements/AppControl";
import moment from 'moment';

export default {
  components: {
    AppControl
  },
  data () {
    return {
      chartDialog: false
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
    onRefresh: {
      type: Function,
      default: () => {}
    }
  }
}
</script>

<style>

</style>