<template>
  <vx-card id="div-with-loading" class="vs-con-loading__container main-card">
    <app-control>
      <template v-slot:filter>
        <span class="flex items-center px-5 pt-2">기간</span>
        <flat-pickr
          :config="configFromdateTimePicker"
          v-model="from"
          placeholder="시작일자"
          @on-change="onFromChange"
          class="control-field-dtm mx-1"
        />
        <span class="flex items-center px-2 pt-2">~</span>
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

    <ag-grid-vue
      ref="agGridTable"
      :localeText="localeText"
      :gridOptions="gridOptions"
      class="ag-theme-material w-100 my-4 ag-grid-table"
      style="max-height: 100%;"
      :columnDefs="columnDefs"
      :defaultColDef="defaultColDef"
      :rowData="itemsComp"
      :pagination="true"
      :paginationPageSize="paginationPageSize"
      :suppressPaginationPanel="true">
    </ag-grid-vue>

    <vs-pagination
      :total="totalPages"
      :max="maxPageNumbers"
      v-model="currentPage" />
  </vx-card>
</template>

<script>
import axios from "axios";
import comm_cd from "@/services/comm_cd";
import worker_attn from "@/services/worker_attn";
import { mapActions } from "vuex";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";

import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import { Korean as KoreanLocale } from "flatpickr/dist/l10n/ko.js"

import { AgGridVue } from "ag-grid-vue";
import AG_GRID_LOCALE_KR from '@/views/ui-elements/ag-grid-table/agGridLocaleKr.js';
import "@sass/vuexy/extraComponents/agGridStyleOverride.scss";
import moment from 'moment';

export default {
  name: 'page-2-7',

  components: {
    AppControl,
    AppForm,
    AppFormGroup,
    AgGridVue,
    flatPickr
  },

  data () {
    return {
      format: "yyyy-MM-dd",
      from: moment().format('YYYY-MM-DD'),
      to: moment().format('YYYY-MM-DD'),
      configFromdateTimePicker: {
        maxDate: null,
        locale: KoreanLocale,
      },
      configTodateTimePicker: {
        minDate: null,
        locale: KoreanLocale,
      },

      items: [],
      localeText: AG_GRID_LOCALE_KR,
      maxPageNumbers: 7,
      gridOptions: {
        rowHeight: 40,
        headerHeight: 40
      },
      gridApi: null,
      defaultColDef: {
        sortable: true,
        editable: false,
        resizable: true,
        suppressMenu: false
      },
      columnDefs: [
        { headerName: 'No', field: 'no', cellStyle: {textAlign: 'center'}, width: 50 },
        { headerName: '사번', field: 'worker_attn:emp_id', filter: false, editable: false, width: 200 },
        { headerName: '이름', field: 'worker_attn:emp_nm', filter: false, editable: false, width: 200 },
        { headerName: '출근일시', field: 'worker_attn:on_dtm_parsed', filter: false, editable: false, width: 200 },
        { headerName: '퇴근일시', field: 'worker_attn:off_dtm_parsed', filter: false, editable: false, width: 200 },
        { headerName: '근무시간', field: 'worker_attn:duration', filter: false, editable: false, width: 200 },
      ],
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
    },

    totalPages () {
      if (this.gridApi) return this.gridApi.paginationGetTotalPages()
      else return 0
    },
    paginationPageSize () {
      if (this.gridApi) return this.gridApi.paginationGetPageSize()
      else return 50
    },
    currentPage: {
      get () {
        if (this.gridApi) return this.gridApi.paginationGetCurrentPage() + 1
        else return 1
      },
      set (val) {
        this.gridApi.paginationGoToPage(val - 1)
      }
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

    onFromChange(selectedDates, dateStr, instance) {
      this.$set(this.configTodateTimePicker, "minDate", dateStr);
    },

    onToChange(selectedDates, dateStr, instance) {
      this.$set(this.configFromdateTimePicker, "maxDate", dateStr);
    },

    query (callback = Function) {
      this.spinner();

      let search_params = {};

      if (this.from != null) {
        search_params['from'] = this.from;
      }

      if (this.to != null) {
        search_params['to'] = this.to;
      }

      worker_attn
        .fetch({
          limit: -1,
          ...search_params,
          sort: 'ON_DTM',
          order: 'ASC',
        })
        .then((res) => {
          this.spinner(false);
          this.items = res.data.data;
          callback(this.items)
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

    exportExcel () {
      window.location.href = worker_attn.export({
        from: this.from,
        to: this.to
      });
    },

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-2-7"),
      });
    },
  },

  mounted () {
    this.gridApi = this.gridOptions.api
  },

  created () {
    setTimeout(() => {
      this.query()
    }, 500)
  }
}
</script>

<style>

</style>