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
          <template v-slot:label>개정번호</template>

          <vs-input
            maxlength="10"
            v-model="haccp_mst_file['haccp_mst_file:rev_no']"
            :danger="errors['haccp_mst_file:rev_no'] != null"
            :danger-text="errors['haccp_mst_file:rev_no']"
          />
        </app-form-group>

        <app-form-group required>
          <template v-slot:label>개정일자</template>

          <flat-pickr
            style="width: 120px"
            class="text-center"
            :config="configdateTimePicker"
            v-model="haccp_mst_file['haccp_mst_file:rev_dt']"
          ></flat-pickr>
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="errors['haccp_mst_file:rev_dt'] != null"
          >
            <span
              class="span-text-validation"
              v-text="errors['haccp_mst_file:rev_dt']"
            ></span>
          </div>
        </app-form-group>

        <app-form-group>
          <template v-slot:label>개정내용</template>

          <vs-input
            class="w-full"
            maxlength="100"
            v-model="haccp_mst_file['haccp_mst_file:rev_content']"
            :danger="errors['haccp_mst_file:rev_content'] != null"
            :danger-text="errors['haccp_mst_file:rev_content']"
          />
        </app-form-group>

        <app-form-group></app-form-group>

        <app-form-group>
          <template v-slot:label>개정사유</template>

          <vs-input
            class="w-full"
            maxlength="100"
            v-model="haccp_mst_file['haccp_mst_file:rev_reason']"
            :danger="errors['haccp_mst_file:rev_reason'] != null"
            :danger-text="errors['haccp_mst_file:rev_reason']"
          />
        </app-form-group>

        <app-form-group></app-form-group>

        <app-form-group required>
          <template v-slot:label>첨부화일</template>

          <div class="flex flex-row">
            <file-select
              v-model="haccp_mst_file['haccp_mst_file:att']"
            ></file-select>
            <vs-button
              class="ml-1"
              v-if="
                haccp_mst_file['haccp_mst_file:att_file'].length > 0 &&
                haccp_mst_file['haccp_mst_file:att']
              "
              color="primary"
              :href="
                '/api/haccp_mst_file/' +
                haccp_mst_file['haccp_mst_file:rev_seq'] +
                '/att_file/' +
                haccp_mst_file['haccp_mst_file:att_file'][0].att_seq +
                '/download'
              "
            >
              {{ $t("Download") }}
            </vs-button>
          </div>
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="errors['haccp_mst_file:att'] != null"
          >
            <span
              class="span-text-validation"
              v-text="errors['haccp_mst_file:att']"
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
            :disabled="items.length <= 0"
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
import api from "@/services/haccp_mst_file";
import { mapActions } from "vuex";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import { Korean as KoreanLocale } from "flatpickr/dist/l10n/ko.js";
import FileSelect from "@/layouts/components/FileSelect.vue";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";
import { AgGridVue } from 'ag-grid-vue'
import AG_GRID_LOCALE_KR from '@/views/ui-elements/ag-grid-table/agGridLocaleKr.js';;

import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'
export default {
  components: {
    flatPickr,
    FileSelect,
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
      haccp_mst_file: {
        "haccp_mst_file:rev_seq": null,
        "haccp_mst_file:rev_no": null,
        "haccp_mst_file:rev_dt": null,
        "haccp_mst_file:att_dtm": null,
        "haccp_mst_file:rev_content": null,
        "haccp_mst_file:rev_reason": null,
        "haccp_mst_file:reg_id": null,
        "haccp_mst_file:reg_dtm": null,
        "haccp_mst_file:att": null,
        "haccp_mst_file:att_file": [],
      },
      errors: {
        "haccp_mst_file:rev_no": null,
        "haccp_mst_file:rev_dt": null,
        "haccp_mst_file:att_dtm": null,
        "haccp_mst_file:rev_content": null,
        "haccp_mst_file:rev_reason": null,
        "haccp_mst_file:att": null,
      },
      items: [],
      pagination: {
        page: 1,
        limit: 15,
        total: 0,
      },
      sorting: {
        sort: "REG_DTM",
        order: "DESC",
      },
      required: {
        'haccp_mst_file:rev_no': '개정번호',
        'haccp_mst_file:rev_dt': '개정일자',
        'haccp_mst_file:att': '첨부화일',
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
        { headerName: '개정번호', field: 'haccp_mst_file:rev_no', filter: false, width: 200 },
        { headerName: '등록일자', field: 'haccp_mst_file:rev_dt', filter: false, width: 200 },
        { headerName: '개정내용', field: 'haccp_mst_file:rev_content', filter: false, width: 200 },
        { headerName: '개정사유', field: 'haccp_mst_file:rev_reason', filter: false, width: 200 },
        { headerName: '첨부화일', field: 'haccp_mst_file:att_nm', filter: false, width: 200 },
      ]
    };
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
        if (Array.isArray(this.haccp_mst_file[key])) {
          if (this.haccp_mst_file[key] === undefined || this.haccp_mst_file[key].length == 0) {
            this.$set(this.errors, key, '필수항목입니다.')
            passed = false
          }
        } else {
          if (this.haccp_mst_file[key]) {
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
      this.$set(this, "haccp_mst_file", {
        "haccp_mst_file:rev_seq": null,
        "haccp_mst_file:rev_no": null,
        "haccp_mst_file:rev_dt": null,
        "haccp_mst_file:att_dtm": null,
        "haccp_mst_file:rev_content": null,
        "haccp_mst_file:rev_reason": null,
        "haccp_mst_file:reg_id": null,
        "haccp_mst_file:reg_dtm": null,
        "haccp_mst_file:att": null,
        "haccp_mst_file:att_file": [],
      });
    },

    clearErrors() {
      this.$set(this, "errors", {
        "haccp_mst_file:rev_no": null,
        "haccp_mst_file:rev_dt": null,
        "haccp_mst_file:att_dtm": null,
        "haccp_mst_file:rev_content": null,
        "haccp_mst_file:rev_reason": null,
        "haccp_mst_file:att": null,
      });
    },

    displayErrors(errors) {
      for (const [key, value] of Object.entries(errors)) {
        this.$set(this.errors, key, Array.isArray(value) ? value[0] : value);
      }
    },

    handleSelected () {
      let rows = this.gridApi.getSelectedRows()

      if (rows.length > 0) {
        this.$set(this, 'haccp_mst_file', rows[0])
        this.clearErrors();

        if (rows[0]["haccp_mst_file:att_file"].length > 0) {
          // this.haccp_mst_file['haccp_mst_file:att'] = new File([""], rows[0]['haccp_mst_file:att_file'][0].att_nm)
          this.$set(
            this.haccp_mst_file,
            "haccp_mst_file:att",
            new File([""], rows[0]["haccp_mst_file:att_file"][0].att_nm)
          );
        } else {
          this.$set(this.haccp_mst_file, "haccp_mst_file:att", null);
        }
      }
    },

    add() {
      this.clearErrors();
      this.spinner();

      let formData = new FormData();
      if (this.haccp_mst_file["haccp_mst_file:rev_no"]) {
        formData.append(
          "haccp_mst_file:rev_no",
          this.haccp_mst_file["haccp_mst_file:rev_no"]
        );
      }
      if (this.haccp_mst_file["haccp_mst_file:rev_dt"]) {
        formData.append(
          "haccp_mst_file:rev_dt",
          this.haccp_mst_file["haccp_mst_file:rev_dt"]
        );
      }
      if (this.haccp_mst_file["haccp_mst_file:rev_content"]) {
        formData.append(
          "haccp_mst_file:rev_content",
          this.haccp_mst_file["haccp_mst_file:rev_content"]
        );
      }
      if (this.haccp_mst_file["haccp_mst_file:rev_reason"]) {
        formData.append(
          "haccp_mst_file:rev_reason",
          this.haccp_mst_file["haccp_mst_file:rev_reason"]
        );
      }
      if (this.haccp_mst_file["haccp_mst_file:att"]) {
        formData.append(
          "haccp_mst_file:att",
          this.haccp_mst_file["haccp_mst_file:att"]
        );
      }

      api
        .post(formData)
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

      let formData = new FormData();
      if (this.haccp_mst_file["haccp_mst_file:rev_no"]) {
        formData.append(
          "haccp_mst_file:rev_no",
          this.haccp_mst_file["haccp_mst_file:rev_no"]
        );
      }
      if (this.haccp_mst_file["haccp_mst_file:rev_dt"]) {
        formData.append(
          "haccp_mst_file:rev_dt",
          this.haccp_mst_file["haccp_mst_file:rev_dt"]
        );
      }
      if (this.haccp_mst_file["haccp_mst_file:rev_content"]) {
        formData.append(
          "haccp_mst_file:rev_content",
          this.haccp_mst_file["haccp_mst_file:rev_content"]
        );
      }
      if (this.haccp_mst_file["haccp_mst_file:rev_reason"]) {
        formData.append(
          "haccp_mst_file:rev_reason",
          this.haccp_mst_file["haccp_mst_file:rev_reason"]
        );
      }
      if (this.haccp_mst_file["haccp_mst_file:att"]) {
        formData.append(
          "haccp_mst_file:att",
          this.haccp_mst_file["haccp_mst_file:att"]
        );
      }

      api
        .put(this.haccp_mst_file["haccp_mst_file:rev_seq"], formData)
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
          this.items = res.data.data;
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

    remove() {
      this.clearErrors();
      this.spinner();

      api
        .delete(this.haccp_mst_file["haccp_mst_file:rev_seq"])
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

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-1-4-1"),
      });
    },
  },

  mounted () {
    this.gridApi = this.gridOptions.api
  },

  created() {
    setTimeout(() => {
      this.query();
    }, 200);
  },
};
</script>