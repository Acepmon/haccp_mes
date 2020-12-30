<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container">
      <div class="flex flex-wrap mb-2">
        <div class="w-full sm:w-1/2 px-1 flex justify-end"></div>
        <div class="w-full sm:w-1/2 px-1 flex justify-end">
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
        </div>
      </div>

      <form action="#">
        <div class="flex flex-wrap">
          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2"
                  ><span class="text-danger">*</span> 개정번호</span
                >
              </div>
              <div class="vx-col sm:w-2/3 w-full">
                <vs-input
                  maxlength="10"
                  v-model="haccp_mst_file['haccp_mst_file:rev_no']"
                  :danger="errors['haccp_mst_file:rev_no'] != null"
                  :danger-text="errors['haccp_mst_file:rev_no']"
                />
              </div>
            </div>
          </div>

          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2"
                  ><span class="text-danger">*</span> 개정일자</span
                >
              </div>
              <div class="vx-col sm:w-2/3 w-full">
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
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-wrap">
          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2">개정내용</span>
              </div>
              <div class="vx-col sm:w-2/3 w-full">
                <vs-input
                  class="w-full"
                  maxlength="100"
                  v-model="haccp_mst_file['haccp_mst_file:rev_content']"
                  :danger="errors['haccp_mst_file:rev_content'] != null"
                  :danger-text="errors['haccp_mst_file:rev_content']"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-wrap">
          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2">개정사유</span>
              </div>
              <div class="vx-col sm:w-2/3 w-full">
                <vs-input
                  class="w-full"
                  maxlength="100"
                  v-model="haccp_mst_file['haccp_mst_file:rev_reason']"
                  :danger="errors['haccp_mst_file:rev_reason'] != null"
                  :danger-text="errors['haccp_mst_file:rev_reason']"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-wrap">
          <div class="w-full sm:w-2/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/6 w-full flex justify-end">
                <span class="pt-2"
                  ><span class="text-danger">*</span> 첨부화일</span
                >
              </div>
              <div class="vx-col sm:w-5/6 w-full">
                <div class="flex flex-row">
                  <file-select
                    v-model="haccp_mst_file['haccp_mst_file:att']"
                  ></file-select>
                  <vs-button
                    type="border"
                    color="primary"
                    @click.native="haccp_mst_file['haccp_mst_file:att'] = null"
                    v-if="haccp_mst_file['haccp_mst_file:att']"
                    class="ml-1 px-4"
                  >
                    <vs-icon icon="close" />
                  </vs-button>
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
          color="primary"
          type="border"
          :disabled="haccp_mst_files.length <= 0"
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
          :data="haccp_mst_files"
          :total="pagination.total"
          @change-page="handleChangePage"
          @sort="handleSort"
          v-model="haccp_mst_file"
          @selected="handleSelected"
        >
          <template slot="thead">
            <vs-th>No</vs-th>
            <vs-th sort-key="rev_no">개정번호</vs-th>
            <vs-th sort-key="rev_dt">등록일자</vs-th>
            <vs-th sort-key="rev_content">개정내용</vs-th>
            <vs-th sort-key="rev_reason">개정사유</vs-th>
            <vs-th>첨부화일</vs-th>
          </template>

          <template slot-scope="{ data }">
            <vs-tr
              :data="tr"
              :key="index"
              v-for="(tr, index) in haccp_mst_files"
            >
              <vs-td :data="rowIndex(index)">
                {{ rowIndex(index) }}
              </vs-td>

              <vs-td :data="data[index]['haccp_mst_file:rev_no']">
                {{ data[index]["haccp_mst_file:rev_no"] }}
              </vs-td>

              <vs-td :data="data[index]['haccp_mst_file:rev_dt']">
                {{ data[index]["haccp_mst_file:rev_dt"] }}
              </vs-td>

              <vs-td :data="data[index]['haccp_mst_file:rev_content']">
                {{ data[index]["haccp_mst_file:rev_content"] }}
              </vs-td>

              <vs-td :data="data[index]['haccp_mst_file:rev_reason']">
                {{ data[index]["haccp_mst_file:rev_reason"] }}
              </vs-td>

              <vs-td :data="data[index]['haccp_mst_file:att_dtm']">
                <div class="flex flex-row">
                  <span
                    v-if="data[index]['haccp_mst_file:att_file'].length > 0"
                    v-text="data[index]['haccp_mst_file:att_file'][0].att_nm"
                    class="pt-1"
                  ></span>
                  <!-- <vs-button
                    color="primary"
                    class="ml-2"
                    :href="
                      '/api/haccp_mst_file/' +
                      data[index]['haccp_mst_file:rev_seq'] +
                      '/att_file/' +
                      data[index]['haccp_mst_file:att_file'][0].att_seq +
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
import api from "@/services/haccp_mst_file";
import { mapActions } from "vuex";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import { Korean as KoreanLocale } from "flatpickr/dist/l10n/ko.js";
import FileSelect from "@/layouts/components/FileSelect.vue";

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
      haccp_mst_files: [],
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
        'haccp_mst_file:rev_no': '개정번호',
        'haccp_mst_file:rev_dt': '개정일자',
        'haccp_mst_file:att': '첨부화일',
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
        sort: this.sorting.sort != null ? this.sorting.sort : "login_dtm",
        order: this.sorting.order != null ? this.sorting.order : "asc",
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
            this.$set(this.errors, key, '')
            passed = false
          }
        } else {
          if (this.haccp_mst_file[key]) {
          } else {
            this.$set(this.errors, key, '')
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

      if (tr["haccp_mst_file:att_file"].length > 0) {
        // this.haccp_mst_file['haccp_mst_file:att'] = new File([""], tr['haccp_mst_file:att_file'][0].att_nm)
        this.$set(
          this.haccp_mst_file,
          "haccp_mst_file:att",
          new File([""], tr["haccp_mst_file:att_file"][0].att_nm)
        );
      } else {
        this.$set(this.haccp_mst_file, "haccp_mst_file:att", null);
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
          ...this.paginationParam,
          ...this.sortParam,
        })
        .then((res) => {
          this.spinner(false);
          this.haccp_mst_files = res.data.data;
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

  created() {
    setTimeout(() => {
      this.query();
    }, 200);
  },
};
</script>