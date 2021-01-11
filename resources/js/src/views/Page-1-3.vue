<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container main-card">
      <app-control>
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
            color="primary"
            type="border"
            >{{ $t("Add") }}</vs-button
          >
          <vs-button
            @click="saveDialog()"
            class="mx-1"
            color="primary"
            type="border"
            >{{ $t("Save") }}</vs-button
          >
          <vs-button
            @click="removeDialog()"
            class="mx-1"
            color="primary"
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

      <app-form>
        <app-form-group required>
          <template v-slot:label>이름</template>

          <vs-input
            class="control-field"
            maxlength="60"
            v-model="worker['worker:worker_nm']"
            :danger="errors['worker:worker_nm'] != null"
            :danger-text="errors['worker:worker_nm']"
          />
        </app-form-group>

        <app-form-group required>
          <template v-slot:label>휴대폰번호</template>

          <vs-input
            class="control-field"
            maxlength="20"
            v-model="worker['worker:tel_no']"
            :danger="errors['worker:tel_no'] != null"
            :danger-text="errors['worker:tel_no']"
          />
        </app-form-group>

        <app-form-group>
          <template v-slot:label>정/부구분</template>

          <v-select 
            class="control-field"
            :options="works" 
            :reduce="item => item.comm2_cd" 
            label="comm2_nm" 
            v-model="worker['worker:work_cd']" 
            :searchable="false" />
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="errors['worker:work_cd'] != null"
          >
            <span
              class="span-text-validation"
              v-text="errors['worker:work_cd']"
            ></span>
          </div>
        </app-form-group>

        <app-form-group>
          <template v-slot:label>업무내용</template>

          <vs-input
            class="control-field"
            maxlength="100"
            v-model="worker['worker:remark']"
            :danger="errors['worker:remark'] != null"
            :danger-text="errors['worker:remark']"
          />
        </app-form-group>

        <app-form-group>
          <template v-slot:label>보건증갱신일자</template>

          <flat-pickr
            class="control-field-dtm"
            :config="configdateTimePicker"
            v-model="worker['worker:health_chk_dt']"
          ></flat-pickr>
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="errors['worker:health_chk_dt'] != null"
          >
            <span
              class="span-text-validation"
              v-text="errors['worker:health_chk_dt']"
            ></span>
          </div>
        </app-form-group>

        <app-form-group>
          <template v-slot:label>업무 구분</template>

          <v-select 
            class="control-field"
            :options="roles" 
            :reduce="item => item.comm2_cd" 
            label="comm2_nm" 
            v-model="worker['worker:role_cd']" 
            :searchable="false" />
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="errors['worker:role_cd'] != null"
          >
            <span
              class="span-text-validation"
              v-text="errors['worker:role_cd']"
            ></span>
          </div>
        </app-form-group>
      </app-form>

      <vs-divider />

      <app-control>
        <template v-slot:action>
          <vs-button
            @click="excel()"
            class="mx-1"
            color="primary"
            type="border"
            :disabled="workers.length <= 0"
            >{{ $t("ToExcel") }}</vs-button
          >
        </template>
      </app-control>

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
    </vx-card>
  </div>
</template>

<script>
import axios from "axios";
import comm_cd from "@/services/comm_cd";
import api from "@/services/worker";
import { mapActions } from "vuex";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import { Korean as KoreanLocale } from "flatpickr/dist/l10n/ko.js";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";
import { AgGridVue } from 'ag-grid-vue'
import AG_GRID_LOCALE_KR from '@/views/ui-elements/ag-grid-table/agGridLocaleKr.js';;

import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'
export default {
  name: 'page-1-3',
  components: {
    flatPickr,
    AppControl,
    AppForm,
    AppFormGroup,
    AgGridVue
  },

  data() {
    return {
      configdateTimePicker: {
        locale: KoreanLocale,
      },
      worker: {
        "worker:worker_id": null,
        "worker:worker_nm": null,
        "worker:tel_no": null,
        "worker:work_cd": null,
        "worker:health_chk_dt": null,
        "worker:role_cd": null,
        "worker:remark": null,
        "worker:reg_id": null,
        "worker:reg_dtm": null,
      },
      errors: {
        "worker:worker_id": null,
        "worker:worker_nm": null,
        "worker:tel_no": null,
        "worker:work_cd": null,
        "worker:health_chk_dt": null,
        "worker:role_cd": null,
        "worker:remark": null,
      },
      roles: [],
      works: [],
      workers: [],

      sorting: {
        sort: "REG_DTM",
        order: "DESC",
      },
      required: {
        'worker:worker_nm': '이름',
        'worker:tel_no': '휴대폰번호',
      },

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
        { headerName: '이름', field: 'worker:worker_nm', filter: false, width: 200 },
        { headerName: '휴대폰번호', field: 'worker:tel_no', filter: false, width: 150 },
        { headerName: '정/부구분', field: 'worker:work_nm', filter: false, width: 150 },
        { headerName: '업무내용', field: 'worker:remark', filter: false, width: 250 },
        { headerName: '보건증갱신일자', field: 'worker:health_chk_dt', filter: false, width: 150 },
        { headerName: '업무구분', field: 'worker:role_nm', filter: false, width: 150 },
        { headerName: '등록일시', field: 'worker:reg_dtm', filter: false, width: 150 }
      ]
    };
  },

  computed: {
    itemsComp: function () {
      return this.workers.map((item, index) => {
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

    sortParam: function () {
      return {
        sort: this.sorting.sort != null ? this.sorting.sort : "REG_DTM",
        order: this.sorting.order != null ? this.sorting.order : "DESC",
      };
    },
  },

  methods: {
    ...mapActions({
      removeTab: "mdn/removeTab",
    }),

    validateRequired() {
      let passed = true
      for (const [key, value] of Object.entries(this.required)) {
        if (Array.isArray(this.worker[key])) {
          if (this.worker[key] === undefined || this.worker[key].length == 0) {
            this.$set(this.errors, key, '필수항목입니다.')
            passed = false
          }
        } else {
          if (this.worker[key]) {
          } else {
            // this.$set(this.errors, key, '필수항목입니다.')
            this.$set(this.errors, key, '필수항목입니다.')
            passed = false
          }
        }
      }

      return passed
    },

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

    clear() {
      this.$set(this, "worker", {
        worker_id: null,
        worker_nm: null,
        tel_no: null,
        work_cd: null,
        health_chk_dt: null,
        role_cd: null,
        remark: null,
        reg_id: null,
        reg_dtm: null,
      });
    },

    clearErrors() {
      this.$set(this, "errors", {
        worker_id: null,
        worker_nm: null,
        tel_no: null,
        work_cd: null,
        health_chk_dt: null,
        role_cd: null,
        remark: null,
      });
    },

    displayErrors(errors) {
      for (const [key, value] of Object.entries(errors)) {
        this.$set(this.errors, key, Array.isArray(value) ? value[0] : value);
      }
    },

    add() {
      this.clearErrors();
      this.spinner();

      api
        .post(this.worker)
        .then((res) => {
          this.spinner(false);

          if (res.data.success) {
            this.$vs.notify({
              title: this.$t("SuccessAddData"),
              position: "top-right",
              color: "success",
              text: res.data.message,
            });
            this.query();
            // this.clear()
          } else {
            this.$vs.notify({
              title: this.$t("Error"),
              position: "top-right",
              color: "warning",
              iconPack: "feather",
              icon: "icon-alert-circle",
              text: res.data.message,
            });
          }
        })
        .catch((err) => {
          this.displayErrors(
            err.response.data.hasOwnProperty("errors")
              ? err.response.data.errors
              : null
          );
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

    save() {
      this.clearErrors();
      this.spinner();

      api
        .put(this.worker["worker:worker_id"], this.worker)
        .then((res) => {
          this.spinner(false);

          if (res.data.success) {
            this.$vs.notify({
              title: this.$t("SuccessSaveData"),
              position: "top-right",
              color: "success",
              text: res.data.message,
            });
            this.query();
            // this.clear()
          } else {
            this.$vs.notify({
              title: this.$t("Error"),
              position: "top-right",
              color: "warning",
              iconPack: "feather",
              icon: "icon-alert-circle",
              text: res.data.message,
            });
          }
        })
        .catch((err) => {
          this.displayErrors(
            err.response.data.hasOwnProperty("errors")
              ? err.response.data.errors
              : null
          );
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

    query() {
      this.spinner();

      api
        .fetch({
          ...this.sortParam,
          limit: -1
        })
        .then((res) => {
          this.spinner(false);
          this.workers = res.data.data;
        })
        .catch((err) => {
          this.displayErrors(
            err.response.data.hasOwnProperty("errors")
              ? err.response.data.errors
              : null
          );
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

    handleSelected () {
      let rows = this.gridApi.getSelectedRows()

      if (rows.length > 0) {
        this.$set(this, 'worker', rows[0])
        this.clearErrors();
      }
    },

    remove() {
      this.clearErrors();
      this.spinner();

      api
        .delete(this.worker["worker:worker_id"])
        .then((res) => {
          this.spinner(false);

          if (res.data.success) {
            this.$vs.notify({
              title: this.$t("SuccessDeleteData"),
              position: "top-right",
              color: "success",
              text: res.data.message,
            });
            this.clear();
            this.query();
          } else {
            this.$vs.notify({
              title: this.$t("Error"),
              position: "top-right",
              color: "warning",
              iconPack: "feather",
              icon: "icon-alert-circle",
              text: res.data.message,
            });
          }
        })
        .catch((err) => {
          this.displayErrors(
            err.response.data.hasOwnProperty("errors")
              ? err.response.data.errors
              : null
          );
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

    excel() {
      window.location.href = api.downloadUrl();
    },

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-1-3"),
      });
    },

    addDialog() {
      if (this.validateRequired()) {
        this.$vs.dialog({
          type: "confirm",
          color: "primary",
          title: this.$t("Confirmation"),
          text: this.$t("AddData"),
          acceptText: this.$t("Accept"),
          cancelText: this.$t("Cancel"),
          accept: () => this.add(),
        });
      }
    },

    saveDialog() {
      if (this.validateRequired()) {
        this.$vs.dialog({
          type: "confirm",
          color: "success",
          title: this.$t("Confirmation"),
          text: this.$t("SaveData"),
          acceptText: this.$t("Accept"),
          cancelText: this.$t("Cancel"),
          accept: () => this.save(),
        });
      }
    },

    removeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("Confirmation"),
        text: this.$t("DeleteData"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.remove(),
      });
    },
  },

  mounted () {
    this.gridApi = this.gridOptions.api
  },

  created() {
    comm_cd.fetch({ cd1: "A00" }).then((res) => {
      this.roles = res.data;
    });

    comm_cd.fetch({ cd1: "A05" }).then((res) => {
      this.works = res.data;
    });

    setTimeout(() => {
      this.query();
    }, 200);
  },
};
</script>