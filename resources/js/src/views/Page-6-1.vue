<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container main-card">
      <app-control>
        <template v-slot:filter>
          <vs-button
            @click="allOffDialog()"
            class="mx-1"
            color="primary"
            type="border"
            >전체끄기</vs-button
          >
          <vs-button
            @click="allOnDialog()"
            class="mx-1"
            color="primary"
            type="border"
            >전체켜기</vs-button
          >
        </template>
        <template v-slot:action>
          <vs-button
            @click="refresh()"
            class="mx-1"
            color="primary"
            type="border"
            >{{ $t("Refresh") }}</vs-button
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

      <div class="flex flex-wrap">
        <div class="w-full md:w-1/2 px-5 my-5" v-for="(item, index) in itemsComp" :key="index">
          <div class="w-full flex flex-row">
            <ccp-data-widget 
              style="flex: 4"
              :limits="item.limits"
              :data="item" 
              :onRefresh="widgetRefresh" 
              :onPopupOpen="widgetPopupOpen"
              :onPopupClose="widgetPopupClose"
              :onLimitSelected="widgetLimitSelected"
              :chartData="item.chartData" 
              :chartCategories="item.chartCats"></ccp-data-widget>

            <vs-button color="warning" class="ml-3 vs-con-loading__container" style="flex: 1" @click="toggleOnDialog(item)">
              <span class="h1 uppercase">{{ $t('On') }}</span>
            </vs-button>
          </div>
        </div>
      </div>
    </vx-card>
  </div>
</template>

<script>
import axios from "axios";
import comm_cd from "@/services/comm_cd";
import ccp_data from "@/services/ccp_data";
import ccp_limit from "@/services/ccp_limit";
import { mapActions } from "vuex";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";
import CcpDataWidget from '@/views/ui-elements/CcpDataWidget';

import moment from 'moment';

export default {
  name: 'page-6-1',
  components: {
    AppControl,
    AppForm,
    AppFormGroup,
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

    init (callback = Function) {
      this.spinner()

      ccp_data
        .fetch({
          device_id: this.devices.map(item => item.comm2_cd).join(','),
          sort: 'DEVICE',
          order: 'ASC',
          // reg_dtm: moment().format('YYYYMMDD')
          from: moment().subtract(24, 'hours').format('YYYYMMDDHHmmss'),
        })
        .then((res) => {
          this.spinner(false)
          if (res.data.data.length > 0) {
            res.data.data.forEach(device => {
              let device_nm = this.devices.filter(d => d.comm2_cd == device.device_id)
              console.log(device)

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

            callback(res.data.data)
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

    refresh (callback = Function) {
      ccp_data
        .fetch({
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

            callback()
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

    widgetRefresh (data) {
      ccp_data
        .details(data.device_id, {
          from: moment().subtract(24, 'hours').format('YYYYMMDDHHmmss'),
          sort: 'REG_DTM',
          order: 'ASC',
          limit: -1
        })
        .then((res) => {
          if (res.data.data.length > 0) {
            let device_id = res.data.data[0].device_id
            let chartData = res.data.data.map(i => i.data)
            let chartCats = res.data.data.map(i => i.reg_dtm_parsed)
            this.$set(this.items[device_id], 'chartData', chartData)
            this.$set(this.items[device_id], 'chartCats', chartCats)
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

    fetchLimits (deviceId) {
      ccp_limit
        .fetch({
          limit: -1,
          device_id: deviceId,
          with: 'src'
        })
        .then((res) => {
          if (res.data.data.length > 0) {
            this.$set(this.items[deviceId], 'limits', res.data.data)
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

    widgetPopupOpen (data) {
      this.widgetRefresh(data)
      this.fetchLimits(data.device_id)
    },

    widgetPopupClose (data) {
      this.$set(this.items[data.device_id], 'chartData', [])
      this.$set(this.items[data.device_id], 'chartCats', [])
    },

    widgetLimitSelected (limit) {
      console.log(limit)
    },

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-6-1"),
      });
    },

    allOn() {
      console.log('all on')
    },

    allOnDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("AllCcpToggleOn"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.allOn(),
      });
    },

    allOff() {
      console.log('all off')
    },

    allOffDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("AllCcpToggleOff"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.allOff(),
      });
    },

    onOff(item) {
      console.log('toggle on/off ' + item.device_id)
    },

    onOffDialog(item) {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CcpToggleOn"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.onOff(item),
      });
    }
  },

  created () {
    comm_cd.fetch({cd1: 'C00'}).then((res) => {
      this.$set(this, 'devices', res.data)
      this.init((items) => {
        this.itemsComp.forEach((data) => {
          // get info
        })
      })
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