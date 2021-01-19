<template>
  <vx-card id="div-with-loading" class="vs-con-loading__container main-card">
    <app-control>
      <template v-slot:filter>
        <span class="flex items-center px-5 pt-2">CCP 장비</span>
        <v-select 
          class="control-field-lg"
          :options="[{v: 'in', l: '입고단가'}, {v: 'out', l: '출고단가'}]" 
          :reduce="item => item.v" 
          label="l" 
          v-model="division" 
          :searchable="false" />
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
          @click="saveDialog()"
          class="mx-1"
          color="primary invisible"
          type="border"
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
          @click="exportExcel()"
          class="mx-1"
          color="primary"
          type="border"
          :disabled="items.length <= 0"
          >{{ $t("ToExcel") }}</vs-button
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

    <vs-table :data="itemsComp" pagination max-items="15">
      <template slot="thead">
        <vs-th style="width: 50px;">No</vs-th>
        <vs-th style="width: 150px;">품목코드</vs-th>
        <vs-th>품목명</vs-th>
        <vs-th style="width: 150px;">일자</vs-th>
        <vs-th style="width: 150px;">단가</vs-th>
      </template>

      <template slot-scope="{data}">
        <vs-tr :key="indextr" v-for="(tr, indextr) in data">
          <vs-td :data="data[indextr].no">
            {{data[indextr].no}}
          </vs-td>

          <vs-td :data="data[indextr].ITEM_ID">
            {{data[indextr].ITEM_ID}}
          </vs-td>

          <vs-td :data="data[indextr].ITEM_NM">
            {{data[indextr].ITEM_NM}}
          </vs-td>

          <vs-td :data="data[indextr].DATE">
            {{data[indextr].DATE}}
          </vs-td>

          <vs-td :data="data[indextr].COST">
            {{data[indextr].COST}}
          </vs-td>

          <template slot="expand">
            <vs-table :data="data[indextr].SUB_ITEMS" :stripe="false" style="width: 100%;">
              <vs-tr :key="indextr2" v-for="(tr2, indextr2) in data[indextr].SUB_ITEMS">
                <td class="td-check active-expanded"><!----><i class="vs-icon notranslate icon-scale material-icons null invisible">keyboard_arrow_down</i></td>
                <vs-td style="width: 50px;" :data="tr2.no">
                  {{tr2.no}}
                </vs-td>

                <vs-td style="width: 150px;" :data="tr2.ITEM_ID">
                  <span class="invisible">{{tr2.ITEM_ID}}</span>
                </vs-td>

                <vs-td :data="tr2.ITEM_NM">
                  <span class="invisible">{{tr2.ITEM_NM}}</span>
                </vs-td>

                <vs-td style="width: 150px;" :data="tr2.DATE">
                  {{tr2.DATE}}
                </vs-td>

                <vs-td style="width: 150px;" :data="tr2.COST">
                  {{tr2.COST}}
                </vs-td>
              </vs-tr>
            </vs-table>
          </template>
        </vs-tr>
      </template>
    </vs-table>
  </vx-card>
</template>

<script>
import axios from "axios";
import comm_cd from "@/services/comm_cd";
import lot_info_cost from "@/services/lot_info_cost";
import { mapActions } from "vuex";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";

export default {
  name: 'page-4-4',

  components: {
    AppControl,
    AppForm,
    AppFormGroup,
  },

  data () {
    return {
      division: 'in',
      items: []
    }
  },

  computed: {
    itemsComp: function () {
      let itemsComp = []
      let i = 1;

      for (const [key, item] of Object.entries(this.items)) {
        let subItems = item.map((subItem, index) => {
          return {
            'no': (index + 1),
            ...subItem
          }
        })

        itemsComp.push({
          'no': i,
          'ITEM_ID': item[0]['ITEM_ID'],
          'ITEM_NM': item[0]['ITEM_NM'],
          'DATE': item[0]['DATE'],
          'COST': item[0]['COST'],
          'SUB_ITEMS': subItems
        })

        i++;
      }

      return itemsComp
    },
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

    query() {
      this.spinner();

      let search_params = {};

      if (this.division != null) {
        search_params['division'] = this.division;
      }

      lot_info_cost
        .fetch({
          limit: -1,
          ...search_params,
        })
        .then((res) => {
          this.spinner(false)

          this.$set(this, 'items', res.data.data)
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

    exportExcel() {
      let search_params = {};

      if (this.division != null) {
        search_params['division'] = this.division;
      }

      window.location.href = lot_info_cost.export(search_params);
    },

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-4-4"),
      });
    }
  },

  created () {
    this.$set(this, 'division', 'in');

    setTimeout(() => {
      this.query();
    }, 500);
  }
}
</script>
