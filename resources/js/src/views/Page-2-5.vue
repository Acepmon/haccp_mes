<template>
  <div class="job-ord-monitor">
    <div class="flex flex-row items-center justify-center my-32 mt-0">
      <div class="text-center" style="font-size: 5rem; padding: 15px; background: #0970D2; color: white;">품목별 생산공정 진행현황 : {{ monitorDate }}</div>
    </div>

    <vs-table :data="itemsComp" hoverFlat style="width: 100%;" class="mt-5">
      <template slot="thead">
        <vs-th style="pointer-events: none;" class="py-10 font-bold text-center">작업번호</vs-th>
        <vs-th style="pointer-events: none;" class="py-10 font-bold text-center">품목ID</vs-th>
        <vs-th style="pointer-events: none;" class="py-10 font-bold text-center">품목명</vs-th>
        <vs-th style="pointer-events: none;" class="py-10 font-bold text-center">지시수량</vs-th>
        <vs-th style="pointer-events: none;" class="py-10 font-bold text-center" :colspan="colSpanCount">품목별 생산공정 진행현황</vs-th>
      </template>

      <template slot-scope="{data}">
        <vs-tr :data="tr" v-for="(tr, indextr) in data" :key="indextr">
          <vs-td>{{ data[indextr]['JOB_NO'] }}</vs-td>
          <vs-td>{{ data[indextr]['ITEM_ID'] }}</vs-td>
          <vs-td>{{ data[indextr]['ITEM_NM'] }}</vs-td>
          <vs-td class="text-right">{{ data[indextr]['ORD_QTY'] }}</vs-td>
          <vs-td class="text-center" v-for="(dtlItem, dtlItemIndex) in data[indextr]['DTL']" :key="'DTL-' + dtlItemIndex" :class="data[indextr].subItemIndex == 0 ? 'dtl-td-' + dtlItem['COLOR'] : ''">
            <span v-if="data[indextr].subItemIndex == 0">
              {{ dtlItem['PROC_NM'] }}
            </span>

            <span v-else-if="data[indextr].subItemIndex == 1">
              {{ dtlItem['END_DTM'] }}
            </span>
          </vs-td>
        </vs-tr>
      </template>
    </vs-table>
  </div>
</template>

<script>
import axios from "axios";
import comm_cd from "@/services/comm_cd";
import job_ord from "@/services/job_ord";
import { mapActions } from "vuex";

import { AgGridVue } from "ag-grid-vue";
import AG_GRID_LOCALE_KR from '@/views/ui-elements/ag-grid-table/agGridLocaleKr.js';
import "@sass/vuexy/extraComponents/agGridStyleOverride.scss";
import moment from 'moment';

export default {
  name: 'page-2-5',

  components: {
    AgGridVue
  },

  data () {
    return {
      monitorDate: moment().format('YYYY-MM-DD'),

      items: {}
    }
  },

  computed: {
    colSpanCount () {
      let count = 1;
      for (const [key, item] of Object.entries(this.items)) {
        item.forEach(subItem => {
          if (subItem.DTL.length > count) {
            count = subItem.DTL.length
          }
        })
      }

      return count
    },

    itemsComp () {
      let itemsComp = []
      for (const [key, item] of Object.entries(this.items)) {
        item.forEach((subItem, subItemIndex) => {
          subItem.subItemIndex = subItemIndex
          itemsComp.push(subItem)
        });
      }
      return itemsComp
    }
  },

  methods: {
    ...mapActions({
      removeTab: "mdn/removeTab",
    }),

    query () {
      job_ord
        .monitor()
        .then((res) => {
          this.items = res.data.data;
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
  },

  created () {
    this.query()

    // setInterval(() => {
    //   this.query()
    // }, 1000 * 60 * 1)
  }
}
</script>

<style scoped>
@-webkit-keyframes dtl-td-yellow-blink {
  0%, 49% {
    background: #0970D2;
    color: white;
  }
  50%, 100% {
    background: #ffffff;
    color: black;
  }
}

.dtl-td-blue {
  background: rgba(18, 156, 233, 0.4) !important;
}

.dtl-td-yellow {
  /* background: rgba(252, 203, 78, 0.5) !important; */
  /* background: #0970D2 !important; */
  /* color: #fff !important; */

  -webkit-animation: dtl-td-yellow-blink 1.5s infinite;  /* Safari 4+ */
  -moz-animation: dtl-td-yellow-blink 1.5s infinite;  /* Fx 5+ */
  -o-animation: dtl-td-yellow-blink 1.5s infinite;  /* Opera 12+ */
  animation: dtl-td-yellow-blink 1.5s infinite;  /* IE 10+, Fx 29+ */
}

.dtl-td-orange {
  background: rgba(253, 126, 20, 0.5) !important;
}
</style>