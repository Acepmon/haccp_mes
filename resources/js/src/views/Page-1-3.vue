<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container">
      <div class="flex flex-wrap mb-2">
        <div class="w-full sm:w-1/2 px-1 flex justify-end"></div>
        <div class="w-full sm:w-1/2 px-1 flex justify-end">
          <vs-button
            @click="query()"
            class="mx-1 mr-16"
            color="dark"
            type="border"
            >{{ $t("Query") }}</vs-button
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

      <form action="#">
        <div class="flex flex-wrap">
          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2"
                  ><span class="text-danger">*</span> 이름</span
                >
              </div>
              <div class="vx-col sm:w-2/3 w-full">
                <vs-input
                  maxlength="60"
                  v-model="worker['worker:worker_nm']"
                  :danger="errors['worker:worker_nm'] != null"
                  :danger-text="errors['worker:worker_nm']"
                />
              </div>
            </div>
          </div>

          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2"
                  ><span class="text-danger">*</span> 휴대폰번호</span
                >
              </div>
              <div class="vx-col sm:w-2/3 w-full">
                <vs-input
                  maxlength="20"
                  v-model="worker['worker:tel_no']"
                  :danger="errors['worker:tel_no'] != null"
                  :danger-text="errors['worker:tel_no']"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-wrap">
          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2">업무구분</span>
              </div>
              <div class="vx-col sm:w-2/3 w-full">
                <v-select :options="works" :reduce="item => item.comm2_cd" label="comm2_nm" v-model="worker['worker:work_cd']" />
                <div
                  class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
                  v-if="errors['worker:work_cd'] != null"
                >
                  <span
                    class="span-text-validation"
                    v-text="errors['worker:work_cd']"
                  ></span>
                </div>
              </div>
            </div>
          </div>

          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2">업무내용</span>
              </div>
              <div class="vx-col sm:w-2/3 w-full">
                <vs-input
                  maxlength="100"
                  v-model="worker['worker:remark']"
                  :danger="errors['worker:remark'] != null"
                  :danger-text="errors['worker:remark']"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-wrap">
          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2">보건증갱신일자</span>
              </div>
              <div class="vx-col sm:w-2/3 w-full">
                <flat-pickr
                  style="width: 120px"
                  class="text-center"
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
              </div>
            </div>
          </div>

          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2">정/부 구분</span>
              </div>
              <div class="vx-col sm:w-2/3 w-full">
                <v-select :options="roles" :reduce="item => item.comm2_cd" label="comm2_nm" v-model="worker['worker:role_cd']" />
                <div
                  class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
                  v-if="errors['worker:role_cd'] != null"
                >
                  <span
                    class="span-text-validation"
                    v-text="errors['worker:role_cd']"
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
          :disabled="workers.length <= 0"
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
          :data="workers"
          :total="pagination.total"
          @change-page="handleChangePage"
          @sort="handleSort"
          @selected="handleSelected"
          v-model="worker"
        >
          <template slot="thead">
            <vs-th>No</vs-th>
            <vs-th sort-key="worker_nm">이름</vs-th>
            <vs-th sort-key="tel_no">휴대폰번호</vs-th>
            <vs-th sort-key="work_cd">업무구분</vs-th>
            <vs-th sort-key="remark">업무내용</vs-th>
            <vs-th sort-key="health_chk_dt">보건증갱신일자</vs-th>
            <vs-th sort-key="role_cd">정/부</vs-th>
            <vs-th sort-key="reg_dtm">등록일시</vs-th>
          </template>

          <template slot-scope="{ data }">
            <vs-tr :data="tr" :key="index" v-for="(tr, index) in workers">
              <vs-td :data="rowIndex(index)">
                {{ rowIndex(index) }}
              </vs-td>

              <vs-td :data="data[index]['worker:worker_nm']">
                {{ data[index]["worker:worker_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['worker:tel_no']">
                {{ data[index]["worker:tel_no"] }}
              </vs-td>

              <vs-td :data="data[index]['worker:work_nm']">
                {{ data[index]["worker:work_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['worker:remark']">
                {{ data[index]["worker:remark"] }}
              </vs-td>

              <vs-td :data="data[index]['worker:health_chk_dt']">
                {{ data[index]["worker:health_chk_dt"] }}
              </vs-td>

              <vs-td :data="data[index]['worker:role_nm']">
                {{ data[index]["worker:role_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['worker:reg_dtm']">
                {{ data[index]["worker:reg_dtm"] }}
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
import api from "@/services/worker";
import { mapActions } from "vuex";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import { Korean as KoreanLocale } from "flatpickr/dist/l10n/ko.js";

export default {
  components: {
    flatPickr,
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
        'worker:worker_nm': '이름',
        'worker:tel_no': '휴대폰번호',
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
        if (Array.isArray(this.worker[key])) {
          if (this.worker[key] === undefined || this.worker[key].length == 0) {
            this.$set(this.errors, key, 'The ' + value + ' field is required.')
            passed = false
          }
        } else {
          if (this.worker[key]) {
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

    rowIndex: function (index) {
      return (
        this.pagination.page * this.pagination.limit -
        this.pagination.limit +
        index +
        1
      );
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
          ...this.paginationParam,
          ...this.sortParam,
        })
        .then((res) => {
          this.spinner(false);
          this.workers = res.data.data;
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

    handleSelected: function (tr) {
      this.clearErrors()
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