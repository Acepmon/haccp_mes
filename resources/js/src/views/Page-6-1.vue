<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container pt-0">
      <app-control>
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
        <div class="w-full sm:w-1/2 px-5 my-5" v-for="(item, index) in itemsComp" :key="index">
          <ccp-data-widget :data="item" :onRefresh="widgetRefresh" :chartSeries="item.series"></ccp-data-widget>
        </div>
      </div>
    </vx-card>
  </div>
</template>

<script>
import axios from "axios";
import comm_cd from "@/services/comm_cd";
import haccp_monitor from "@/services/haccp_monitor";
import { mapActions } from "vuex";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";
import CcpDataWidget from '@/views/ui-elements/CcpDataWidget';

import moment from 'moment';

export default {
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

    refresh () {
      this.spinner()

      haccp_monitor
        .ccp_data({
          device_id: this.devices.map(item => item.comm2_cd).join(','),
          sort: 'DEVICE',
          order: 'ASC',
          reg_dtm: moment().format('YYYYMMDD')
        })
        .then((res) => {
          this.spinner(false)

          if (res.data.data.length > 0) {
            res.data.data.forEach(device => {
              this.$set(this.items, device.device_id, {
                ...device,
                series: [],
                device_nm: this.devices.filter(d => d.comm2_cd == device.device_id)[0].comm2_nm
              })
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

    widgetRefresh (data) {
      let reg_dtm = moment().format('YYYYMMDD');

      haccp_monitor
        .ccp_data({
          device_id: data.device_id,
          reg_dtm: reg_dtm,
          sort: 'REG_DTM',
          order: 'DESC',
          stats: true,
          limit: 1
        })
        .then((res) => {
          if (res.data.data.length > 0) {
            this.$set(this.items, data.device_id, {
              ...res.data.data[0],
              device_nm: data.device_nm
            })
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

      haccp_monitor
        .ccp_data_details(data.device_id, {
          from: moment().subtract(24, 'hours').format('YYYYMMDDHHmm'),
          sort: 'REG_DTM',
          order: 'ASC',
          limit: -1
        })
        .then((res) => {
          if (res.data.data.length > 0) {
            let device_id = res.data.data[0].device_id
            this.$set(this.items[device_id], 'series', this.formatDatasToSeries(res.data.data))
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

    formatDatasToSeries(datas) {
      let device_nm = 'test'

      return [
        {
          name: device_nm,
          data: []
        }
      ]
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
    }
  },

  created () {
    comm_cd.fetch({cd1: 'C00'}).then((res) => {
      this.$set(this, 'devices', res.data)
      this.refresh()
    })
  }
}
</script>

<style>

</style>