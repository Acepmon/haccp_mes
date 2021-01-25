<template>
  <div class="job-ord-monitor">
    <div class="flex flex-row items-center justify-center my-32 mt-0">
      <div class="text-center" style="font-size: 5rem; padding: 15px; background: #0970D2; color: white;">CCP 장비 모니터링 현황</div>
    </div>

    <div class="flex flex-wrap mt-5">
      <div class="w-full md:w-1/3 px-4 my-1" v-for="(item, index) in itemsComp" :key="index">
        <div class="w-full flex flex-row">
          <ccp-data-widget :data="item" style="flex: 1; pointer-events: none;" class="ccp-data-monitor-popup-widget"></ccp-data-widget>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import comm_cd from "@/services/comm_cd";
import ccp_data from "@/services/ccp_data";
import { mapActions } from "vuex";

import CcpDataWidget from '@/views/ui-elements/CcpDataWidget';

import moment from 'moment';

export default {
  name: 'page-2-6',

  components: {
    CcpDataWidget
  },

  data () {
    return {
      items: [],
      devices: []
    }
  },

  computed: {
    itemsComp () {
      return Object.entries(this.items).map((item) => {
        return item[1]
      })
    }
  },

  methods: {
    ...mapActions({
      removeTab: "mdn/removeTab",
    }),

    init () {
      ccp_data
        .dashboard({
          device_id: this.devices.map(item => item.comm2_cd).join(','),
          sort: 'DEVICE',
          order: 'ASC',
          // reg_dtm: moment().format('YYYYMMDD')
          from: moment().subtract(24, 'hours').format('YYYYMMDDHHmmss'),
        })
        .then((res) => {
          if (res.data.data.length > 0) {
            res.data.data.forEach(device => {
              let device_nm = this.devices.filter(d => d.comm2_cd == device.device_id)

              this.$set(this.items, device.device_id, {
                'device_id': device.device_id,
                'device_nm': device_nm[0].comm2_nm,
                'chart_dialog': false,
                'data': device.data.toFixed(2),
                'min': device.min.toFixed(2),
                'max': device.max.toFixed(2),
                'avg': device.avg.toFixed(2),
                'reg_dtm': device.reg_dtm,
                'reg_dtm_parsed': device.reg_dtm_parsed,
                'chartData': [],
                'chartCats': [],
                'limits': []
              })
            });
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
        })
    },

    refresh () {
      ccp_data
        .dashboard({
          device_id: this.devices.map(item => item.comm2_cd).join(','),
          sort: 'DEVICE',
          order: 'ASC',
          // reg_dtm: moment().format('YYYYMMDD')
          from: moment().subtract(24, 'hours').format('YYYYMMDDHHmmss'),
        })
        .then((res) => {
          if (res.data.data.length > 0) {
            res.data.data.forEach(device => {
              this.$set(this.items[device.device_id], 'data', device.data.toFixed(2))
              this.$set(this.items[device.device_id], 'min', device.min.toFixed(2))
              this.$set(this.items[device.device_id], 'max', device.max.toFixed(2))
              this.$set(this.items[device.device_id], 'avg', device.avg.toFixed(2))
              this.$set(this.items[device.device_id], 'reg_dtm', device.reg_dtm)
              this.$set(this.items[device.device_id], 'reg_dtm_parsed', device.reg_dtm_parsed)
            });
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
        })
    },
  },

  created () {
    comm_cd.fetch({cd1: 'C00'}).then((res) => {
      this.$set(this, 'devices', res.data)
      this.init()
    })

    setInterval(() => {
      this.refresh(() => {
        this.itemsComp.forEach((data) => {
          if (data.chart_dialog) {
            this.widgetRefresh(data)
          }
        })
      })
    }, 1000 * 60 * 1)
  }
}
</script>

<style>

</style>