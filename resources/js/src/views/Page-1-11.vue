<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container main-card">
      <app-control>
        <template v-slot:filter>
          <span class="pt-2 px-4">기간</span>
          <flat-pickr
            class="control-field-dtm flex-shrink-0"
            :config="configdateTimePicker"
            v-model="searchFrom"
          ></flat-pickr>
          <span class="pt-2 px-2">~</span>
          <flat-pickr
            class="control-field-dtm flex-shrink-0"
            :config="configdateTimePicker"
            v-model="searchTo"
          ></flat-pickr>
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
          <template v-slot:label>문서이름</template>

          <vs-input
            class="control-field"
            maxlength="100"
            v-model="item['secu_doc_mgmt:doc_nm']"
            :danger="errors['secu_doc_mgmt:doc_nm'] != null"
            :danger-text="errors['secu_doc_mgmt:doc_nm']"
          />
        </app-form-group>

        <app-form-group required>
          <template v-slot:label>보고서작성일</template>

          <flat-pickr
            class="control-field-dtm"
            :config="configdateTimePicker"
            v-model="item['secu_doc_mgmt:doc_dt']"
          ></flat-pickr>
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="errors['secu_doc_mgmt:doc_dt'] != null"
          >
            <span
              class="span-text-validation"
              v-text="errors['secu_doc_mgmt:doc_dt']"
            ></span>
          </div>
        </app-form-group>

        <app-form-group required full>
          <template v-slot:label>기간</template>

          <flat-pickr
            class="control-field-dtm"
            :config="configdateTimePicker"
            v-model="item['secu_doc_mgmt:from_dt']"
          ></flat-pickr>
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="errors['secu_doc_mgmt:from_dt'] != null"
          >
            <span
              class="span-text-validation"
              v-text="errors['secu_doc_mgmt:from_dt']"
            ></span>
          </div>

          <span class="pt-2 px-2">~</span>

          <flat-pickr
            class="control-field-dtm"
            :config="configdateTimePicker"
            v-model="item['secu_doc_mgmt:to_dt']"
          ></flat-pickr>
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="errors['secu_doc_mgmt:to_dt'] != null"
          >
            <span
              class="span-text-validation"
              v-text="errors['secu_doc_mgmt:to_dt']"
            ></span>
          </div>
        </app-form-group>

        <app-form-group required full>
          <template v-slot:label>첨부화일</template>

          <div class="flex flex-row">
            <file-select
              v-model="item['secu_doc_mgmt:att']"
            ></file-select>
            <!-- <vs-button type="border" color="primary" @click.native="item['secu_doc_mgmt:att'] = null" v-if="item['secu_doc_mgmt:att']" class="ml-1 px-4">
              <vs-icon icon="close" />
            </vs-button> -->
            <vs-button
              class="ml-1"
              v-if="
                item['secu_doc_mgmt:att_file'].length > 0 &&
                item['secu_doc_mgmt:att']
              "
              color="primary"
              :href="
                '/api/doc_mgmt/' +
                item['secu_doc_mgmt:doc_id'] +
                '/att_file/' +
                item['secu_doc_mgmt:att_file'][0].att_seq +
                '/download'
              "
            >
              {{ $t("Download") }}
            </vs-button>
          </div>
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="errors['secu_doc_mgmt:att'] != null"
          >
            <span
              class="span-text-validation"
              v-text="errors['secu_doc_mgmt:att']"
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
import api from "@/services/secu_doc_mgmt";
import { mapActions } from "vuex";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import { Korean as KoreanLocale } from "flatpickr/dist/l10n/ko.js";
import FileSelect from "@/layouts/components/FileSelect.vue";
import moment from 'moment';

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
      item: {
        "secu_doc_mgmt:doc_id": null,
        "secu_doc_mgmt:doc_nm": null,
        "secu_doc_mgmt:doc_dt": moment().format('YYYY-MM-DD'),
        "secu_doc_mgmt:att_dtm": null,
        "secu_doc_mgmt:from_dt": moment().subtract(1,'months').startOf('month').format('YYYY-MM-DD'),
        "secu_doc_mgmt:to_dt": moment().subtract(1,'months').endOf('month').format('YYYY-MM-DD'),
        "secu_doc_mgmt:reg_id": null,
        "secu_doc_mgmt:reg_dtm": null,
        "secu_doc_mgmt:att": null,
        "secu_doc_mgmt:att_file": [],
      },
      errors: {
        "secu_doc_mgmt:doc_id": null,
        "secu_doc_mgmt:doc_nm": null,
        "secu_doc_mgmt:doc_dt": null,
        "secu_doc_mgmt:att_dtm": null,
        "secu_doc_mgmt:from_dt": null,
        "secu_doc_mgmt:to_dt": null,
        "secu_doc_mgmt:att": null,
        "secu_doc_mgmt:att_file": [],
      },
      items: [],
      searchFrom: null,
      searchTo: null,
      types: [],
      sorting: {
        sort: "REG_DTM",
        order: "DESC",
      },
      required: {
        'secu_doc_mgmt:doc_nm': '문서이름',
        'secu_doc_mgmt:doc_dt': '보고서작성일',
        'secu_doc_mgmt:from_dt': '기간',
        'secu_doc_mgmt:to_dt': '기간',
        'secu_doc_mgmt:att': '첨부화일',
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
        { headerName: 'No', field: 'no', filter: false, editable: false, width: 80 },
        { headerName: '문서이름', field: 'secu_doc_mgmt:doc_nm', filter: false, width: 200 },
        { headerName: '보고서작성일', field: 'secu_doc_mgmt:doc_dt', filter: false, width: 200 },
        { headerName: '기간(From)', field: 'secu_doc_mgmt:from_dt', filter: false, width: 200 },
        { headerName: '기간(To)', field: 'secu_doc_mgmt:to_dt', filter: false, width: 200 },
        { headerName: '첨부화일', field: 'secu_doc_mgmt:att_nm', filter: false, width: 200 },
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
        if (Array.isArray(this.item[key])) {
          if (this.item[key] === undefined || this.item[key].length == 0) {
            this.$set(this.errors, key, '필수항목입니다.')
            passed = false
          }
        } else {
          if (this.item[key]) {
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
      this.$set(this, "item", {
        "secu_doc_mgmt:doc_id": null,
        "secu_doc_mgmt:doc_nm": null,
        "secu_doc_mgmt:doc_dt": null,
        "secu_doc_mgmt:att_dtm": null,
        "secu_doc_mgmt:from_dt": null,
        "secu_doc_mgmt:to_dt": null,
        "secu_doc_mgmt:reg_id": null,
        "secu_doc_mgmt:reg_dtm": null,
        "secu_doc_mgmt:att": null,
        "secu_doc_mgmt:att_file": [],
      });
    },

    clearErrors() {
      this.$set(this, "errors", {
        "secu_doc_mgmt:doc_id": null,
        "secu_doc_mgmt:doc_nm": null,
        "secu_doc_mgmt:doc_dt": null,
        "secu_doc_mgmt:att_dtm": null,
        "secu_doc_mgmt:from_dt": null,
        "secu_doc_mgmt:to_dt": null,
        "secu_doc_mgmt:att": null,
        "secu_doc_mgmt:att_file": [],
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
        this.$set(this, 'item', rows[0])
        this.clearErrors();

        if (rows[0]["secu_doc_mgmt:att_file"].length > 0) {
          // this.item['secu_doc_mgmt:att'] = new File([""], rows[0]['secu_doc_mgmt:att_file'][0].att_nm)
          this.$set(
            this.item,
            "secu_doc_mgmt:att",
            new File([""], rows[0]["secu_doc_mgmt:att_file"][0].att_nm)
          );
        } else {
          this.$set(this.item, "secu_doc_mgmt:att", null);
        }
      }
    },

    add() {
      this.clearErrors();
      this.spinner();

      let formData = new FormData();
      if (this.item["secu_doc_mgmt:doc_nm"]) {
        formData.append(
          "secu_doc_mgmt:doc_nm",
          this.item["secu_doc_mgmt:doc_nm"]
        );
      }
      if (this.item["secu_doc_mgmt:doc_dt"]) {
        formData.append(
          "secu_doc_mgmt:doc_dt",
          this.item["secu_doc_mgmt:doc_dt"]
        );
      }
      if (this.item["secu_doc_mgmt:from_dt"]) {
        formData.append(
          "secu_doc_mgmt:from_dt",
          this.item["secu_doc_mgmt:from_dt"]
        );
      }
      if (this.item["secu_doc_mgmt:to_dt"]) {
        formData.append(
          "secu_doc_mgmt:to_dt",
          this.item["secu_doc_mgmt:to_dt"]
        );
      }
      if (this.item["secu_doc_mgmt:att"]) {
        formData.append("secu_doc_mgmt:att", this.item["secu_doc_mgmt:att"]);
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
      if (this.item["secu_doc_mgmt:doc_nm"]) {
        formData.append(
          "secu_doc_mgmt:doc_nm",
          this.item["secu_doc_mgmt:doc_nm"]
        );
      }
      if (this.item["secu_doc_mgmt:doc_dt"]) {
        formData.append(
          "secu_doc_mgmt:doc_dt",
          this.item["secu_doc_mgmt:doc_dt"]
        );
      }
      if (this.item["secu_doc_mgmt:from_dt"]) {
        formData.append(
          "secu_doc_mgmt:from_dt",
          this.item["secu_doc_mgmt:from_dt"]
        );
      }
      if (this.item["secu_doc_mgmt:to_dt"]) {
        formData.append(
          "secu_doc_mgmt:to_dt",
          this.item["secu_doc_mgmt:to_dt"]
        );
      }
      if (this.item["secu_doc_mgmt:att"]) {
        formData.append("secu_doc_mgmt:att", this.item["secu_doc_mgmt:att"]);
      }

      api
        .put(this.item["secu_doc_mgmt:doc_id"], formData)
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

      let search_params = {};

      if (this.searchFrom != null) {
        search_params["from_dt"] = this.searchFrom;
      }

      if (this.searchTo != null) {
        search_params["to_dt"] = this.searchTo;
      }

      api
        .fetch({
          ...this.sortParam,
          ...search_params,
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
        .delete(this.item["secu_doc_mgmt:doc_id"])
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
      let search_params = {};

      if (this.searchFrom != null) {
        search_params["from_dt"] = this.searchFrom;
      }

      if (this.searchTo != null) {
        search_params["to_dt"] = this.searchTo;
      }

      window.location.href = api.downloadUrl(search_params);
    },

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-1-4-2"),
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
    comm_cd.fetch({ cd1: "A35" }).then((res) => {
      this.types = res.data;
    });

    setTimeout(() => {
      this.query()
    }, 500)
  },
};
</script>