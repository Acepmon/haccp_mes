<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container pt-0">
      <app-control>
        <template v-slot:filter>
          <span class="flex items-center px-5">기간</span>
          <flat-pickr
            :config="configFromdateTimePicker"
            v-model="from"
            placeholder="시작일자"
            @on-change="onFromChange"
            class="control-field-dtm mx-1"
          />
          <span class="flex items-center px-2">~</span>
          <flat-pickr
            :config="configTodateTimePicker"
            v-model="to"
            placeholder="종료일자"
            @on-change="onToChange"
            class="control-field-dtm mx-1"
          />
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
            @click="addDialog()"
            class="mx-1 invisible"
            color="primary"
            type="border"
            >{{ $t("Add") }}</vs-button
          >
          <vs-button
            @click="saveDialog()"
            class="mx-1 invisible"
            color="primary"
            type="border"
            >{{ $t("Save") }}</vs-button
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

    </vx-card>
  </div>
</template>

<script>
import axios from "axios";
import comm_cd from "@/services/comm_cd";
import job_ord from "@/services/job_ord";
import { mapActions } from "vuex";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";
import ImportExcel from "@/components/excel/ImportExcel.vue";

import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import { Korean as KoreanLocale } from "flatpickr/dist/l10n/ko.js"

import { AgGridVue } from "ag-grid-vue";

import "@sass/vuexy/extraComponents/agGridStyleOverride.scss";

export default {
  components: {
    AppControl,
    AppForm,
    AppFormGroup,
    ImportExcel,
    AgGridVue,
    flatPickr
  },

  data () {
    return {
      format: "yyyy-MM-dd",
      from: null,
      to: null,
      configFromdateTimePicker: {
        maxDate: null,
        locale: KoreanLocale,
      },
      configTodateTimePicker: {
        minDate: null,
        locale: KoreanLocale,
      },
      importFile: null,
      items: []
    }
  },

  computed: {
    itemsComp: function () {
      return this.items.map((item, index) => {
        return {
          'no': (index + 1),
          ...item
        } 
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

    query () {
      // 
    },

    addDialog () {
      // 
    },

    exportExcel () {
      // 
    },

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-1-6"),
      });
    },
  }
};
</script>

<style>
</style>