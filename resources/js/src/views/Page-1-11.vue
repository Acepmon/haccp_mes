<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container">
      <div class="flex flex-wrap mb-2">
        <div class="w-full sm:w-1/2 px-1 flex justify-start">
          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2">기간</span>
              </div>
              <div class="vx-col sm:w-2/3 w-full flex">
                <flat-pickr
                  style="width: 120px"
                  class="text-center flex-shrink-0"
                  :config="configdateTimePicker"
                  v-model="searchFrom"
                ></flat-pickr>

                <span
                  class="mx-5 flex justify-center content-center flex-shrink-0"
                  >~</span
                >

                <flat-pickr
                  style="width: 120px"
                  class="text-center flex-shrink-0"
                  :config="configdateTimePicker"
                  v-model="searchTo"
                ></flat-pickr>

                <vs-button
                  @click="query()"
                  class="ml-5 flex-shrink-0"
                  color="dark"
                  type="border"
                  >{{ $t("Query") }}</vs-button
                >
              </div>
            </div>
          </div>
        </div>
        <div
          class="w-full sm:w-1/2 px-1 flex justify-end"
          style="position: relative"
        >
          <vs-button
            @click="addDialog()"
            class="mx-1"
            color="dark"
            type="border"
            >{{ $t("Add") }}</vs-button
          >
          <vs-button
            @click="saveDialog()"
            class="mx-1"
            color="dark"
            type="border"
            >{{ $t("Save") }}</vs-button
          >
          <vs-button
            @click="removeDialog()"
            class="mx-1"
            color="dark"
            type="border"
            >{{ $t("Delete") }}</vs-button
          >
          <vs-button
            @click="closeDialog()"
            class="mx-1"
            color="dark"
            type="border"
            >{{ $t("Close") }}</vs-button
          >
        </div>
      </div>

      <vs-divider />

      <form action="#">
        <div class="flex flex-wrap">
          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2"
                  ><span class="text-danger">*</span> 문서이름</span
                >
              </div>
              <div class="vx-col sm:w-2/3 w-full">
                <vs-input
                  maxlength="100"
                  v-model="item['secu_doc_mgmt:doc_nm']"
                  :danger="errors['secu_doc_mgmt:doc_nm'] != null"
                  :danger-text="errors['secu_doc_mgmt:doc_nm']"
                />
              </div>
            </div>
          </div>

          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2"
                  ><span class="text-danger">*</span> 보고서작성일</span
                >
              </div>
              <div class="vx-col sm:w-2/3 w-full">
                <flat-pickr
                  style="width: 120px"
                  class="text-center"
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
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-wrap">
          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2"
                  ><span class="text-danger">*</span> 기간</span
                >
              </div>
              <div class="vx-col sm:w-2/3 w-full flex">
                <flat-pickr
                  style="width: 120px"
                  class="text-center"
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

                <span class="mx-5 flex justify-center content-center">~</span>

                <flat-pickr
                  style="width: 120px"
                  class="text-center"
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
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-wrap">
          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2"
                  ><span class="text-danger">*</span> 첨부화일</span
                >
              </div>
              <div class="vx-col sm:w-2/3 w-full">
                <div class="flex flex-row">
                  <file-select
                    v-model="item['secu_doc_mgmt:att']"
                  ></file-select>
                  <!-- <vs-button type="border" color="dark" @click.native="item['secu_doc_mgmt:att'] = null" v-if="item['secu_doc_mgmt:att']" class="ml-1 px-4">
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
              </div>
            </div>
          </div>
        </div>
      </form>

      <vs-divider />

      <div class="flex flex-wrap justify-end mb-2">
        <vs-button
          @click="excel()"
          class="mx-1"
          color="dark"
          type="border"
          :disabled="items.length <= 0"
          >{{ $t("ToExcel") }}</vs-button
        >
      </div>

      <div class="overflow-y-auto" style="max-height: 300px">
        <vs-table
          stripe
          pagination
          description
          sst
          :max-items="pagination.limit"
          :data="items"
          :total="pagination.total"
          @change-page="handleChangePage"
          @sort="handleSort"
          v-model="item"
          @selected="handleSelected"
        >
          <template slot="thead">
            <vs-th>No</vs-th>
            <vs-th sort-key="doc_nm">문서이름</vs-th>
            <vs-th sort-key="doc_dt">보고서작성일</vs-th>
            <vs-th sort-key="from_dt">기간(From)</vs-th>
            <vs-th sort-key="to_dt">기간(To)</vs-th>
            <vs-th>첨부화일</vs-th>
          </template>

          <template slot-scope="{ data }">
            <vs-tr :data="tr" :key="index" v-for="(tr, index) in items">
              <vs-td :data="rowIndex(index)">
                {{ rowIndex(index) }}
              </vs-td>

              <vs-td :data="data[index]['secu_doc_mgmt:doc_nm']">
                {{ data[index]["secu_doc_mgmt:doc_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['secu_doc_mgmt:doc_dt']">
                {{ data[index]["secu_doc_mgmt:doc_dt"] }}
              </vs-td>

              <vs-td :data="data[index]['secu_doc_mgmt:from_dt']">
                {{ data[index]["secu_doc_mgmt:from_dt"] }}
              </vs-td>

              <vs-td :data="data[index]['secu_doc_mgmt:to_dt']">
                {{ data[index]["secu_doc_mgmt:to_dt"] }}
              </vs-td>

              <vs-td :data="data[index]['secu_doc_mgmt:att_dtm']">
                <div class="flex flex-row">
                  <span
                    v-if="data[index]['secu_doc_mgmt:att_file'].length > 0"
                    v-text="data[index]['secu_doc_mgmt:att_file'][0].att_nm"
                    class="pt-1"
                  ></span>
                  <!-- <vs-button
                    color="primary"
                    class="ml-2"
                    :href="
                      '/api/doc_mgmt/' +
                      data[index]['secu_doc_mgmt:doc_id'] +
                      '/att_file/' +
                      data[index]['secu_doc_mgmt:att_file'][0].att_seq +
                      '/download'
                    "
                    type="flat"
                    size="small"
                    icon-pack="feather"
                    icon="icon-download"
                  ></vs-button> -->
                </div>
              </vs-td>
            </vs-tr>
          </template>
        </vs-table>
      </div>
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

export default {
  components: {
    flatPickr,
    FileSelect,
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
      pagination: {
        page: 1,
        limit: 15,
        total: 0,
      },
      sorting: {
        sort: "reg_dtm",
        order: "desc",
      },
      required: {
        'secu_doc_mgmt:doc_nm': '문서이름',
        'secu_doc_mgmt:doc_dt': '보고서작성일',
        'secu_doc_mgmt:from_dt': '기간',
        'secu_doc_mgmt:to_dt': '기간',
        'secu_doc_mgmt:att': '첨부화일',
      }
    };
  },

  computed: {
    paginationParam: function () {
      return {
        page: this.pagination.page,
        limit: this.pagination.limit,
      };
    },

    sortParam: function () {
      return {
        sort: this.sorting.sort != null ? this.sorting.sort : "reg_dtm",
        order: this.sorting.order != null ? this.sorting.order : "desc",
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
            this.$set(this.errors, key, 'The ' + value + ' field is required.')
            passed = false
          }
        } else {
          if (this.item[key]) {
          } else {
            this.$set(this.errors, key, 'The ' + value + ' field is required.')
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

    rowIndex: function (index) {
      return (
        this.pagination.page * this.pagination.limit -
        this.pagination.limit +
        index +
        1
      );
    },

    handleChangePage(page) {
      this.pagination.page = page;
      this.query();
    },

    handleSort(sort, order) {
      this.sorting.sort = sort;
      this.sorting.order = order;
      this.query();
    },

    handleSelected(tr) {
      this.clearErrors();

      if (tr["secu_doc_mgmt:att_file"].length > 0) {
        // this.item['secu_doc_mgmt:att'] = new File([""], tr['secu_doc_mgmt:att_file'][0].att_nm)
        this.$set(
          this.item,
          "secu_doc_mgmt:att",
          new File([""], tr["secu_doc_mgmt:att_file"][0].att_nm)
        );
      } else {
        this.$set(this.item, "secu_doc_mgmt:att", null);
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
          ...this.paginationParam,
          ...this.sortParam,
          ...search_params,
        })
        .then((res) => {
          this.spinner(false);
          this.items = res.data.data;
          this.pagination.total = res.data.meta.total;
          this.pagination.page = res.data.meta.current_page;
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

  created() {
    comm_cd.fetch({ cd1: "A35" }).then((res) => {
      this.types = res.data;
    });
  },
};
</script>