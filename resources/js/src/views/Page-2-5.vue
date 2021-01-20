<template>
  <div>
    <h1 class="text-center">Monitoring of Job Order Processing : {{ monitorDate }}</h1>

    <vs-table :datas="[]" hoverFlat style="width: 100%;" class="mt-5">
      <vs-tr>
        <vs-th style="pointer-events: none;" class="h5 py-2 font-bold text-center">작업번호</vs-th>
        <vs-th style="pointer-events: none;" class="h5 py-2 font-bold text-center">품목ID</vs-th>
        <vs-th style="pointer-events: none;" class="h5 py-2 font-bold text-center">품목명</vs-th>
        <vs-th style="pointer-events: none;" class="h5 py-2 font-bold text-center">지시수량</vs-th>
        <vs-th style="pointer-events: none;" class="h5 py-2 font-bold text-center" :colspan="colSpanCount">품목별 생산공정 진행현황</vs-th>
      </vs-tr>

      <template v-for="(item) in items">
        <template v-for="(subItem, subItemIndex) in item">
          <vs-tr :key="subItem['ITEM_ID'] + '-' + subItemIndex">
            <vs-td>{{ subItem['JOB_NO'] }}</vs-td>
            <vs-td>{{ subItem['ITEM_ID'] }}</vs-td>
            <vs-td>{{ subItem['ITEM_NM'] }}</vs-td>
            <vs-td>{{ subItem['ORD_QTY'] }}</vs-td>
            <vs-td v-for="(dtlItem, dtlItemIndex) in subItem['DTL']" :key="'DTL-' + dtlItemIndex" :class="subItemIndex == 0 ? 'dtl-td-' + dtlItem['COLOR'] : ''">
              <span v-if="subItemIndex == 0">
                {{ dtlItem['PROC_NM'] }}
              </span>

              <span v-else-if="subItemIndex == 1">
                {{ dtlItem['END_DTM'] }}
              </span>
            </vs-td>
          </vs-tr>
        </template>
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

    setInterval(() => {
      this.query()
    }, 1000 * 60 * 1)
  }
}
</script>

<style>
.dtl-td-blue {
  background: rgba(18, 156, 233, 0.2) !important;
}

.dtl-td-yellow {
  background: rgba(252, 203, 78, 0.2) !important;
}

.dtl-td-orange {
  background: rgba(253, 126, 20, 0.2) !important;
}
</style>