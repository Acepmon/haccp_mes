<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container main-card">
      <app-control>
        <template v-slot:filter>
          <v-select 
            class="control-field"
            :placeholder="'검색항목'" 
            :options="[{label: '문서이름', value: 'doc_nm'}, {label: '설명(제품명)', value: 'doc_desc'}]" 
            :reduce="item => item.value" 
            label="label" 
            v-model="searchBy" 
            :searchable="false" />
          <vs-input v-model="searchKeyword" class="control-field ml-2" />

          <span class="pt-2 px-4">문서종류</span>
          <v-select 
            class="control-field"
            :options="types" 
            :reduce="item => item.comm2_cd" 
            label="comm2_nm" 
            v-model="searchType" 
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
            maxlength="100"
            v-model="item['doc_mgmt:doc_nm']"
            :danger="errors['doc_mgmt:doc_nm'] != null"
            :danger-text="errors['doc_mgmt:doc_nm']"
          />
        </app-form-group>

        <app-form-group required>
          <template v-slot:label>문서종류</template>

          <v-select 
            style="width: 200px;"
            :options="types" 
            :reduce="item => item.comm2_cd" 
            label="comm2_nm" 
            v-model="item['doc_mgmt:type_cd']" 
            :searchable="false" />
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="errors['doc_mgmt:type_cd'] != null"
          >
            <span
              class="span-text-validation"
              v-text="errors['doc_mgmt:type_cd']"
            ></span>
          </div>
        </app-form-group>

        <app-form-group>
          <template v-slot:label>설명(제품명)</template>

          <vs-input
            class="w-full"
            maxlength="150"
            v-model="item['doc_mgmt:doc_desc']"
            :danger="errors['doc_mgmt:doc_desc'] != null"
            :danger-text="errors['doc_mgmt:doc_desc']"
          />
        </app-form-group>

        <app-form-group></app-form-group>

        <app-form-group required>
          <template v-slot:label>첨부화일</template>

          <div class="flex flex-row">
            <file-select v-model="item['doc_mgmt:att']"></file-select>
            <!-- <vs-button type="border" color="primary" @click.native="item['doc_mgmt:att'] = null" v-if="item['doc_mgmt:att']" class="ml-1 px-4">
              <vs-icon icon="close" />
            </vs-button> -->
            <vs-button
              class="ml-1"
              v-if="
                item['doc_mgmt:att_file'].length > 0 &&
                item['doc_mgmt:att']
              "
              color="primary"
              :href="
                '/api/doc_mgmt/' +
                item['doc_mgmt:doc_id'] +
                '/att_file/' +
                item['doc_mgmt:att_file'][0].att_seq +
                '/download'
              "
            >
              {{ $t("Download") }}
            </vs-button>
          </div>
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="errors['doc_mgmt:att'] != null"
          >
            <span
              class="span-text-validation"
              v-text="errors['doc_mgmt:att']"
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
import api from "@/services/doc_mgmt";
import { mapActions } from "vuex";
import FileSelect from "@/layouts/components/FileSelect.vue";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";
import { AgGridVue } from 'ag-grid-vue';

import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'

export default {
  components: {
    FileSelect,
    AppControl,
    AppForm,
    AppFormGroup,
    AgGridVue
  },

  data() {
    return {
      item: {
        "doc_mgmt:doc_id": null,
        "doc_mgmt:type_cd": null,
        "doc_mgmt:type_nm": null,
        "doc_mgmt:doc_nm": null,
        "doc_mgmt:doc_desc": null,
        "doc_mgmt:att_dtm": null,
        "doc_mgmt:reg_id": null,
        "doc_mgmt:reg_dtm": null,
        "doc_mgmt:att": null,
        "doc_mgmt:att_file": [],
        "doc_mgmt:att_nm": null,
      },
      errors: {
        "doc_mgmt:doc_id": null,
        "doc_mgmt:type_cd": null,
        "doc_mgmt:type_nm": null,
        "doc_mgmt:doc_nm": null,
        "doc_mgmt:doc_desc": null,
        "doc_mgmt:att_dtm": null,
        "doc_mgmt:att": null,
      },
      items: [],
      searchBy: null,
      searchKeyword: null,
      searchType: null,
      types: [],

      sorting: {
        sort: "REG_DTM",
        order: "DESC",
      },
      required: {
        'doc_mgmt:type_cd': '문서종류',
        'doc_mgmt:doc_nm': '문서이름',
        'doc_mgmt:att': '첨부화일',
      },

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
        { headerName: '문서이름', field: 'doc_mgmt:doc_nm', filter: false, width: 200 },
        { headerName: '문서종류', field: 'doc_mgmt:type_nm', filter: false, width: 200 },
        { headerName: '설명(제품명)', field: 'doc_mgmt:doc_desc', filter: false, width: 200 },
        { headerName: '첨부문서', field: 'doc_mgmt:att_nm', filter: false, width: 200 },
        { headerName: '등록일자', field: 'doc_mgmt:reg_dtm', filter: false, width: 200 },
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
        "doc_mgmt:doc_id": null,
        "doc_mgmt:type_cd": null,
        "doc_mgmt:type_nm": null,
        "doc_mgmt:doc_nm": null,
        "doc_mgmt:doc_desc": null,
        "doc_mgmt:att_dtm": null,
        "doc_mgmt:reg_id": null,
        "doc_mgmt:reg_dtm": null,
        "doc_mgmt:att": null,
        "doc_mgmt:att_file": [],
      });
    },

    clearErrors() {
      this.$set(this, "errors", {
        "doc_mgmt:doc_id": null,
        "doc_mgmt:type_cd": null,
        "doc_mgmt:type_nm": null,
        "doc_mgmt:doc_nm": null,
        "doc_mgmt:doc_desc": null,
        "doc_mgmt:att_dtm": null,
        "doc_mgmt:att": null,
      });
    },

    displayErrors(errors) {
      for (const [key, value] of Object.entries(errors)) {
        this.$set(this.errors, key, Array.isArray(value) ? value[0] : value);
      }
    },

    rowIndex: function (index) {
      return (
        this.pagination.page * this.pagination.limit -
        this.pagination.limit +
        index +
        1
      );
    },

    handleSelected () {
      let rows = this.gridApi.getSelectedRows()

      if (rows.length > 0) {
        this.$set(this, 'item', rows[0])
        this.clearErrors();

        if (rows[0]["doc_mgmt:att_file"].length > 0) {
          // this.doc_mgmt['doc_mgmt:att'] = new File([""], rows[0]['doc_mgmt:att_file'][0].att_nm)
          this.$set(
            this.item,
            "doc_mgmt:att",
            new File([""], rows[0]["doc_mgmt:att_file"][0].att_nm)
          );
        } else {
          this.$set(this.item, "doc_mgmt:att", null);
        }
      }
    },

    add() {
      this.clearErrors();
      this.spinner();

      let formData = new FormData();
      if (this.item["doc_mgmt:doc_nm"]) {
        formData.append("doc_mgmt:doc_nm", this.item["doc_mgmt:doc_nm"]);
      }
      if (this.item["doc_mgmt:type_cd"]) {
        formData.append("doc_mgmt:type_cd", this.item["doc_mgmt:type_cd"]);
      }
      if (this.item["doc_mgmt:doc_desc"]) {
        formData.append("doc_mgmt:doc_desc", this.item["doc_mgmt:doc_desc"]);
      }
      if (this.item["doc_mgmt:att"]) {
        formData.append("doc_mgmt:att", this.item["doc_mgmt:att"]);
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
      if (this.item["doc_mgmt:doc_nm"]) {
        formData.append("doc_mgmt:doc_nm", this.item["doc_mgmt:doc_nm"]);
      }
      if (this.item["doc_mgmt:type_cd"]) {
        formData.append("doc_mgmt:type_cd", this.item["doc_mgmt:type_cd"]);
      }
      if (this.item["doc_mgmt:doc_desc"]) {
        formData.append("doc_mgmt:doc_desc", this.item["doc_mgmt:doc_desc"]);
      }
      if (this.item["doc_mgmt:att"]) {
        formData.append("doc_mgmt:att", this.item["doc_mgmt:att"]);
      }

      api
        .put(this.item["doc_mgmt:doc_id"], formData)
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

      if (this.searchKeyword != null) {
        search_params[this.searchBy] = this.searchKeyword;
      }

      if (this.searchType != null) {
        search_params["type_cd"] = this.searchType;
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
        .catch(() => {
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
        .delete(this.item["doc_mgmt:doc_id"])
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

      if (this.searchKeyword != null) {
        search_params[this.searchBy] = this.searchKeyword;
      }

      if (this.searchType != null) {
        search_params["type_cd"] = this.searchType;
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