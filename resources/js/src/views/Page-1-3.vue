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
          <template v-slot:label>사원번호</template>

          <vs-input class="control-field" maxlength="15" v-model="worker['worker:emp_id']" :danger="errors['worker:emp_id'] != null" :danger-text="errors['worker:emp_id']" />
        </app-form-group>

        <app-form-group>
          <template v-slot:label>이름</template>

          <vs-input class="control-field" maxlength="20" v-model="worker['worker:emp_nm']" :danger="errors['worker:emp_nm'] != null" :danger-text="errors['worker:emp_nm']" />
        </app-form-group>

        <app-form-group> 
          <template v-slot:label>직책</template>

          <v-select class="control-field" :options="duties" :reduce="item => item.comm2_cd" label="comm2_nm"  v-model="worker['worker:duty_cd']" :searchable="false" />
          <div class="con-text-validation span-text-validation-danger vs-input--text-validation-span" v-if="errors['worker:duty_cd'] != null">
            <span class="span-text-validation" v-text="errors['worker:duty_cd']"></span>
          </div>
        </app-form-group>
        <app-form-group>
          <template v-slot:label>부서</template>

          <v-select class="control-field" :options="depts" :reduce="item => item.comm2_cd" label="comm2_nm"  v-model="worker['worker:dept_cd']" :searchable="false" />
          <div class="con-text-validation span-text-validation-danger vs-input--text-validation-span" v-if="errors['worker:dept_cd'] != null">
            <span class="span-text-validation" v-text="errors['worker:dept_cd']"></span>
          </div>
        </app-form-group>
        
        <app-form-group>
          <template v-slot:label>비밀번호</template>

          <vs-input class="control-field" maxlength="10" v-model="worker['worker:pass_no']" :danger="errors['worker:pass_no'] != null" :danger-text="errors['worker:pass_no']" />
        </app-form-group>

        <app-form-group>
          <template v-slot:label>전화번호</template>

          <vs-input class="control-field" maxlength="20" v-model="worker['worker:mob_no']" :danger="errors['worker:mob_no'] != null" :danger-text="errors['worker:mob_no']" />
        </app-form-group>


        <app-form-group>
          <template v-slot:label>입사일자</template>

          <flat-pickr class="control-field-dtm" :config="configdateTimePicker" v-model="worker['worker:in_dt']"></flat-pickr>
          <div class="con-text-validation span-text-validation-danger vs-input--text-validation-span"  v-if="errors['worker:in_dt'] != null">
            <span class="span-text-validation" v-text="errors['worker:in_dt']"></span>
          </div>
        </app-form-group>

        <app-form-group>
          <template v-slot:label>퇴사일자</template>

          <flat-pickr class="control-field-dtm" :config="configdateTimePicker" v-model="worker['worker:out_dt']"></flat-pickr>
          <div class="con-text-validation span-text-validation-danger vs-input--text-validation-span"  v-if="errors['worker:out_dt'] != null">
            <span class="span-text-validation" v-text="errors['worker:out_dt']"></span>
          </div>
        </app-form-group>

        <app-form-group>
          <template v-slot:label>주민번호</template>

          <vs-input class="control-field" maxlength="20" v-model="worker['worker:jumin_no']" :danger="errors['worker:jumin_no'] != null" :danger-text="errors['worker:jumin_no']" />
        </app-form-group>

        <app-form-group>
          <template v-slot:label>생년월일</template>

          <flat-pickr class="control-field-dtm" :config="configdateTimePicker" v-model="worker['worker:birth_dt']"></flat-pickr>
          <div class="con-text-validation span-text-validation-danger vs-input--text-validation-span"  v-if="errors['worker:birth_dt'] != null">
            <span class="span-text-validation" v-text="errors['worker:birth_dt']"></span>
          </div>
        </app-form-group>

        <app-form-group>
          <template v-slot:label>은행명</template>

          <vs-input class="control-field" maxlength="20" v-model="worker['worker:bank_nm']" :danger="errors['worker:bank_nm'] != null" :danger-text="errors['worker:bank_nm']" />
        </app-form-group>

        <app-form-group>
          <template v-slot:label>계좌번호</template>

          <vs-input class="control-field" maxlength="30" v-model="worker['worker:acct_no']" :danger="errors['worker:acct_no'] != null" :danger-text="errors['worker:acct_no']" />
        </app-form-group>

        <app-form-group>
          <template v-slot:label>주소</template>

          <vs-input class="control-field-lg" maxlength="100" v-model="worker['worker:address']" :danger="errors['worker:address'] != null" :danger-text="errors['worker:address']" />
        </app-form-group>

        <app-form-group>
          <template v-slot:label>이메일</template>

          <vs-input class="control-field" maxlength="30" v-model="worker['worker:email']" :danger="errors['worker:email'] != null" :danger-text="errors['worker:email']" />
        </app-form-group>

        <app-form-group>
          <template v-slot:label>주요업무</template>

          <vs-input class="control-field-lg" maxlength="100" v-model="worker['worker:main_job']" :danger="errors['worker:main_job'] != null" :danger-text="errors['worker:main_job']" />
        </app-form-group>

        <app-form-group>
          <template v-slot:label>보건증일자</template>

          <flat-pickr class="control-field-dtm" :config="configdateTimePicker" v-model="worker['worker:health_chk_dt']"></flat-pickr>
          <div class="con-text-validation span-text-validation-danger vs-input--text-validation-span"  v-if="errors['worker:health_chk_dt'] != null">
            <span class="span-text-validation" v-text="errors['worker:health_chk_dt']"></span>
          </div>
        </app-form-group>

        <app-form-group>
          <template v-slot:label>HACCP 문서관리</template>

          <vs-input class="control-field-lg" maxlength="100" v-model="worker['worker:haccp_doc']" :danger="errors['worker:haccp_doc'] != null" :danger-text="errors['worker:haccp_doc']" />
        </app-form-group>

        <app-form-group>
          <template v-slot:label>정/부구분</template>

          <v-select class="control-field" :options="roles" :reduce="item => item.comm2_cd" label="comm2_nm"  v-model="worker['worker:role_cd']" :searchable="false" />
          <div class="con-text-validation span-text-validation-danger vs-input--text-validation-span" v-if="errors['worker:role_cd'] != null">
            <span class="span-text-validation" v-text="errors['worker:role_cd']"></span>
          </div>
        </app-form-group>

        <app-form-group>
          <template v-slot:label>HACCP 담당역할</template>

          <vs-input class="control-field-lg" maxlength="100" v-model="worker['worker:haccp_role']" :danger="errors['worker:haccp_role'] != null" :danger-text="errors['worker:haccp_role']" />
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
        style="height: auto;"
        :columnDefs="columnDefs"
        :defaultColDef="defaultColDef"
        :rowData="itemsComp"
        @first-data-rendered="onFirstDataRendered"
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
        dateFormat: 'Ymd',
        altFormat: 'Y-m-d',
        altInput: true
      },
      worker: {
        "worker:emp_id": null,
        "worker:emp_nm": null,
        "worker:duty_cd": null,
        "worker:duty_cd_nm": null,
        "worker:mob_no": null,
        "worker:pass_no": null,
        "worker:dept_cd": null,
        "worker:dept_cd_nm": null,
        "worker:in_dt": null,
        "worker:out_dt": null,
        "worker:jumin_no": null,
        "worker:birth_dt": null,
        "worker:bank_nm": null,
        "worker:acct_no": null,
        "worker:address": null,
        "worker:email": null,
        "worker:main_job": null,
        "worker:health_chk_dt": null,
        "worker:health_chk_dt_parsed": null,
        "worker:haccp_doc": null,
        "worker:role_cd": null,
        "worker:role_cd_nm": null,
        "worker:haccp_role": null,
        "worker:reg_id": null,
        "worker:reg_dtm": null,
        "worker:reg_dtm_parsed": null,
      },
      errors: {
        "worker:emp_id": null,
        "worker:emp_nm": null,
        "worker:duty_cd": null,
        "worker:duty_cd_nm": null,
        "worker:mob_no": null,
        "worker:pass_no": null,
        "worker:dept_cd": null,
        "worker:dept_cd_nm": null,
        "worker:in_dt": null,
        "worker:out_dt": null,
        "worker:jumin_no": null,
        "worker:birth_dt": null,
        "worker:bank_nm": null,
        "worker:acct_no": null,
        "worker:address": null,
        "worker:email": null,
        "worker:main_job": null,
        "worker:health_chk_dt": null,
        "worker:health_chk_dt_parsed": null,
        "worker:haccp_doc": null,
        "worker:role_cd": null,
        "worker:role_cd_nm": null,
        "worker:haccp_role": null,
        "worker:reg_id": null,
        "worker:reg_dtm": null,
        "worker:reg_dtm_parsed": null,
      },
      duties: [],
      depts: [],
      roles: [],
      workers: [],

      sorting: {
        sort: "REG_DTM",
        order: "DESC",
      },
      required: {
        'worker:emp_id': '사원번호',
      },

      localeText: AG_GRID_LOCALE_KR,
      maxPageNumbers: 7,
      gridOptions: {
        rowHeight: 40,
        headerHeight: 40,
        domLayout: 'autoHeight'
      },
      gridApi: null,
      defaultColDef: {
        sortable: true,
        editable: false,
        resizable: true,
        suppressMenu: false
      },
      columnDefs: [
        { headerName: 'No', field: 'no', cellStyle: {textAlign: 'center'}, /* width: 50 */ },
        { headerName: '사원번호', field: 'worker:emp_id', filter: false, /* width: 100 */ },
        { headerName: '이름', field: 'worker:emp_nm', filter: false, /* width: 100 */ },
        { headerName: '직책', field: 'worker:duty_cd_nm', filter: false, /* width: 100 */ },
        { headerName: '부서명', field: 'worker:dept_cd_nm', filter: false, /* width: 100 */ },
        { headerName: '전화번호', field: 'worker:mob_no', filter: false, /* width: 100 */ },
        { headerName: '비밀번호', field: 'worker:pass_no', filter: false, /* width: 100 */ },
        { headerName: '입사일자', field: 'worker:in_dt_parsed', filter: false, /* width: 100 */ },
        { headerName: '퇴사일자', field: 'worker:out_dt_parsed', filter: false, /* width: 100 */ },
        { headerName: '주민번호', field: 'worker:jumin_no', filter: false, /* width: 100 */ },
        { headerName: '생년월일', field: 'worker:birth_dt_parsed', filter: false, /* width: 100 */ },
        { headerName: '은행명', field: 'worker:bank_nm', filter: false, /* width: 100 */ },
        { headerName: '계좌번호', field: 'worker:acct_no', filter: false, /* width: 100 */ },
        { headerName: '주소', field: 'worker:address', filter: false, /* width: 150 */ },
        { headerName: '이메일', field: 'worker:email', filter: false, /* width: 100 */ },
        { headerName: '주요업무', field: 'worker:main_job', filter: false, /* width: 100 */ },
        { headerName: '보건증일자', field: 'worker:health_chk_dt_parsed', filter: false, /* width: 100 */ },
        { headerName: 'HACCP 문서관리', field: 'worker:haccp_doc', filter: false, /* width: 100 */ },
        { headerName: '정/부구분', field: 'worker:role_cd_nm', filter: false, /* width: 100 */ },
        { headerName: 'HACCP 담당역할', field: 'worker:haccp_role', filter: false, /* width: 100 */ },
        //{ headerName: 'reg_id', field: 'worker:reg_id', filter: false, width: 100 },
        //{ headerName: 'reg_dtm', field: 'worker:reg_dtm_parsed', filter: false, width: 100 },
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
      for (const [key, value] of Object.entries(this.worker)) {
        this.$set(this.worker, key, null)
      }
    },

    clearErrors() {
      for (const [key, value] of Object.entries(this.errors)) {
        this.$set(this.errors, key, null)
      }
    },

    displayErrors(errors) {
      for (const [key, value] of Object.entries(errors)) {
        this.$set(this.errors, key, Array.isArray(value) ? value[0] : value);
      }
    },

    onFirstDataRendered(params) {
      params.api.sizeColumnsToFit()
      setTimeout(() => {
        const colIds = params.columnApi.getAllColumns().map(c => c.colId)
        const skipHeader = true
        params.columnApi.autoSizeColumns(colIds, skipHeader)
      }, 50)
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
        .put(this.worker["worker:emp_id"], this.worker)
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

    query(callback = Function) {
      this.spinner();

      api
        .fetch({
          ...this.sortParam,
          limit: -1
        })
        .then((res) => {
          this.spinner(false);
          this.workers = res.data.data;
          callback(this.workers)
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
        .delete(this.worker["worker:emp_id"])
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
    comm_cd.fetch({ cd1: "W30" }).then((res) => {
      this.duties = res.data;
    });

    comm_cd.fetch({ cd1: "W40" }).then((res) => {
      this.depts = res.data;
    });

    comm_cd.fetch({ cd1: "A05" }).then((res) => {
      this.roles = res.data;
    });

    setTimeout(() => {
      this.query((workers) => {
        if (this.$route.query.emp_id) {
          let emp_id = this.$route.query.emp_id
          let filtered = this.workers.filter(worker => worker['worker:emp_id'] == emp_id)
          if (filtered.length > 0) {
            this.$set(this, 'worker', filtered[0])
          }
        }
      });
    }, 500);
  },
};
</script>