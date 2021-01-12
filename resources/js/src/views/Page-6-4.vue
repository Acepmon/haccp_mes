<template>
  <vx-card id="div-with-loading" class="vs-con-loading__container main-card">
    <app-control>
      <template v-slot:filter>
        <span class="flex items-center px-5">작성기간</span>
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
        <span class="flex items-center px-5">문서명</span>
        <vs-input
          class="control-field-sm"
          v-model="doc_nm"
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
          class="mx-1"
          color="primary invisible"
          type="border"
          >{{ $t("Add") }}</vs-button
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
          @click="closeDialog()"
          class="mx-1"
          color="primary"
          type="border"
          >{{ $t("Close") }}</vs-button
        >
      </template>
    </app-control>

    <vs-divider />

    <ag-grid-vue
      ref="agGridTable"
      :localeText="localeText"
      rowSelection="single"
      @selection-changed="handleSelected"
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

    <vs-popup fullscreen title="문서확인" :active.sync="detailDialog">
      <iframe style="width: 100%; height: calc(100vh - 150px);" class="iframe-placeholder" v-if="item['edoc_file_haccp:doc_id'] != null" :src="'/api/edoc_file_haccp/' + item['edoc_file_haccp:doc_id'] + '/preview'" frameborder="0"></iframe>
    </vs-popup>
  </vx-card>
</template>

<script>
import axios from "axios";
import comm_cd from "@/services/comm_cd";
import edoc_file_haccp from "@/services/edoc_file_haccp";
import { mapActions } from "vuex";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";

import { AgGridVue } from 'ag-grid-vue'
import AG_GRID_LOCALE_KR from '@/views/ui-elements/ag-grid-table/agGridLocaleKr.js';;
import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'

import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import { Korean as KoreanLocale } from "flatpickr/dist/l10n/ko.js"

import moment from 'moment';

export default {
  name: 'page-6-4',
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
      doc_nm: null,

      detailDialog: false,

      item: {
        'edoc_file_haccp:haccp_seq': null,
        'edoc_file_haccp:doc_id': null,
        'edoc_file_haccp:apr_cd': null,
        'edoc_file_haccp:app_data': null,
        'edoc_file_haccp:remark': null,
        'edoc_file_haccp:use_yn': null,
        'edoc_file_haccp:work_id': null,
        'edoc_file_haccp:work_dtm': null,
        'edoc_file_haccp:app_id': null,
        'edoc_file_haccp:app_dtm': null,
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
        { headerName: '작성일시', field: 'edoc_file_haccp:work_dtm', filter: false, width: 200 },
        { headerName: '문서명', field: 'edoc_file:doc_nm', filter: false, width: 200 },
        { headerName: '승인상태', field: 'edoc_file_haccp:apr_cd', filter: false, width: 200 },
        { headerName: '작성자', field: 'edoc_file_haccp:work_id', filter: false, width: 200 },
        { headerName: '승인일시', field: 'edoc_file_haccp:app_dtm', filter: false, width: 200 },
        { headerName: '승인자', field: 'edoc_file_haccp:app_id', filter: false, width: 200 },
        { headerName: '비고', field: 'edoc_file_haccp:remark', filter: false, width: 200 },
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

    handleSelected () {
      let rows = this.gridApi.getSelectedRows()
      this.$set(this, 'detailDialog', true)

      if (rows.length > 0) {
        this.$set(this, 'item', rows[0]);
      }
    },

    onFromChange(selectedDates, dateStr, instance) {
      this.$set(this.configTodateTimePicker, "minDate", dateStr);
    },

    onToChange(selectedDates, dateStr, instance) {
      this.$set(this.configFromdateTimePicker, "maxDate", dateStr);
    },

    query () {
      this.spinner();

      let search_params = {};

      if (this.from != null) {
        search_params['from'] = this.from;
      }

      if (this.to != null) {
        search_params['to'] = this.to;
      }

      if (this.doc_nm != null) {
        search_params['doc_nm'] = this.doc_nm;
      }

      edoc_file_haccp
        .fetch({
          sort: 'WORK_DTM',
          order: 'DESC',
          limit: -1,
          with: 'edoc_file,apr',
          ...search_params,
        })
        .then((res) => {
          this.spinner(false);
          this.items = res.data.data;
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

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-6-4"),
      });
    }
  },

  mounted () {
    this.gridApi = this.gridOptions.api
  },

  created () {
    setTimeout(() => {
      this.query();
    }, 200);
  }
}
</script>

<style scoped>
.iframe-placeholder {
  background: url('data:image/svg+xml;charset=utf-8,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 100% 100%"><text fill="%23C0C9CE" x="50%" y="50%" font-family="\'Lucida Grande\', sans-serif" font-size="14" text-anchor="middle">loading...</text></svg>') 0px 0px no-repeat;
}
</style>