<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container main-card pt-0">
      <app-control>
        <template v-slot:filter> </template>

        <template v-slot:action>
          <vs-button
            @click="query()"
            class="mx-1 mr-16"
            color="primary"
            type="border"
            >{{ $t("Query") }}</vs-button
          >
          <vs-button
            @click="add()"
            class="mx-1"
            color="primary"
            type="border"
            >{{ $t("Add") }}</vs-button
          >
          <vs-button
            @click="save()"
            class="mx-1"
            color="primary"
            type="border"
            >{{ $t("Save") }}</vs-button
          >
          <vs-button
            @click="remove()"
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
          <template v-slot:label>휴대폰번호(ID)</template>

          <vs-input
            maxlength="15"
            v-model="selected['user:user_id']"
            :danger="errors['user:user_id'] != null"
            :danger-text="errors['user:user_id']"
          />
        </app-form-group>

        <app-form-group required>
          <template v-slot:label>이름</template>

          <vs-input
            maxlength="20"
            v-model="selected['user:user_nm']"
            :danger="errors['user:user_nm'] != null"
            :danger-text="errors['user:user_nm']"
          />
        </app-form-group>

        <app-form-group required>
          <template v-slot:label>비밀번호</template>

          <vs-input
            v-model="selected['user:user_pw']"
            type="password"
            :danger="errors['user:user_pw'] != null"
            :danger-text="errors['user:user_pw']"
          />
        </app-form-group>

        <app-form-group>
          <template v-slot:label>비밀번호확인</template>

          <vs-input
            v-model="selected['user:user_pw_confirmation']"
            type="password"
            :danger="
              errors['user:user_pw_confirmation'] != null &&
              ['user:user_pw_confirmation'] != ''
            "
            :danger-text="errors['user:user_pw_confirmation']"
          />
        </app-form-group>

        <app-form-group>
          <template v-slot:label>이메일</template>

          <vs-input
            maxlength="50"
            v-model="selected['user:email']"
            type="email"
            :danger="errors['user:email'] != null"
            :danger-text="errors['user:email']"
          />
        </app-form-group>

        <app-form-group></app-form-group>

        <app-form-group required>
          <template v-slot:label>메뉴접근권한</template>

          <div class="flex flex-row flex-wrap">
            <vs-button
              v-for="(role, index) in roles"
              :key="index"
              @click="toggleRole(role.comm2_cd)"
              :color="selectedRoleHas(role.comm2_cd) ? 'primary' : 'dark'"
              class="px-3 mt-1 flex-shrink-0"
              :class="{ 'ml-1': index != 0 }"
              type="border"
            >
              <vs-icon
                v-if="selectedRoleHas(role.comm2_cd)"
                icon-pack="feather"
                icon="icon-check"
              />
              <span v-text="role.comm2_nm"></span>
            </vs-button>
          </div>
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="
              errors['user:role_cd'] != null && errors['user:role_cd'] != ''
            "
          >
            <span
              class="span-text-validation"
              v-text="errors['user:role_cd']"
            ></span>
          </div>
        </app-form-group>

        <app-form-group></app-form-group>

        <app-form-group>
          <template v-slot:label>담당업무</template>

          <div class="flex flex-row flex-wrap">
            <vs-button
              v-for="(appr, index) in approvals"
              :key="index"
              @click="toggleApproval(appr.comm2_cd)"
              :color="selectedApprovalHas(appr.comm2_cd) ? 'primary' : 'dark'"
              class="px-3 mt-1 flex-shrink-0"
              :class="{ 'ml-1': index != 0 }"
              type="border"
            >
              <vs-icon
                v-if="selectedApprovalHas(appr.comm2_cd)"
                icon-pack="feather"
                icon="icon-check"
              />
              <span v-text="appr.comm2_nm"></span>
            </vs-button>
          </div>
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="
              errors['user:appr_cd'] != null && errors['user:appr_cd'] != ''
            "
          >
            <span
              class="span-text-validation"
              v-text="errors['user:appr_cd']"
            ></span>
          </div>
        </app-form-group>

        <app-form-group></app-form-group>

        <app-form-group required>
          <template v-slot:label>업무권한</template>

          <v-select
            style="width: 200px"
            :options="jobs"
            :reduce="(item) => item.comm2_cd"
            label="comm2_nm"
            v-model="selected['user:job_cd']"
            :searchable="false"
          />
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="errors['user:job_cd'] != null && errors['user:job_cd'] != ''"
          >
            <span
              class="span-text-validation"
              v-text="errors['user:job_cd']"
            ></span>
          </div>
        </app-form-group>

        <app-form-group required>
          <template v-slot:label>사용여부</template>

          <v-select
            style="width: 200px"
            :options="status"
            :reduce="(item) => item.value"
            label="text"
            v-model="selected['user:user_sts_yn']"
            :searchable="false"
          />
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="
              errors['user:user_sts_yn'] != null &&
              errors['user:user_sts_yn'] != ''
            "
          >
            <span
              class="span-text-validation"
              v-text="errors['user:user_sts_yn']"
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
            :disabled="datas.length <= 0"
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
import api from "@/services/user";
import { mapActions } from "vuex";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";
import { AgGridVue } from 'ag-grid-vue';

import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'
export default {
  components: {
    AppControl,
    AppForm,
    AppFormGroup,
    AgGridVue
  },
  data() {
    return {
      roles: [],
      approvals: [],
      jobs: [],
      status: [
        { text: "YES", value: "Y" },
        { text: "NO", value: "N" },
      ],
      selected: {
        "user:user_id": null,
        "user:user_pw": null,
        "user:user_pw_confirmation": null,
        "user:user_nm": null,
        "user:email": null,
        "user:role_cd": [],
        "user:appr_cd": [],
        "user:job_cd": null,
        "user:user_sts_yn": "Y",
      },
      errors: {
        "user:user_id": null,
        "user:user_pw": null,
        "user:user_pw_confirmation": null,
        "user:user_nm": null,
        "user:email": null,
        "user:role_cd": null,
        "user:appr_cd": null,
        "user:job_cd": null,
        "user:user_sts_yn": null,
      },
      datas: [],

      sorting: {
        sort: "REG_DTM",
        order: "DESC",
      },
      required: {
        "user:user_id": "휴대폰번호(ID)",
        "user:user_pw": "비밀번호",
        "user:user_nm": "이름",
        "user:role_cd": "메뉴접근권한",
        // "user:appr_cd": "담당업무",
        "user:job_cd": "업무권한",
        "user:user_sts_yn": "사용여부",
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
        { headerName: '사용자 ID', field: 'user:user_id', filter: false, width: 200 },
        { headerName: '이름', field: 'user:user_nm', filter: false, width: 200 },
        { headerName: '이메일', field: 'user:email', filter: false, width: 200 },
        { headerName: '담당업무', field: 'user:appr_nm', filter: false, width: 200 },
        { headerName: '메뉴접근권한', field: 'user:role_nm', filter: false, width: 200 },
        { headerName: '등록일시', field: 'user:reg_dtm', filter: false, width: 200 }
      ],
    };
  },
  computed: {
    itemsComp: function () {
      return this.datas.map((item, index) => {
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

    validEmail() {
      return this.selected["user:email"] != null
        ? /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(
            this.selected["user:email"]
          )
        : false;
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

    validateRequired(except = []) {
      let passed = true;
      for (const [key, value] of Object.entries(this.required)) {
        if (except.includes(key)) {
          continue;
        }

        if (Array.isArray(this.selected[key])) {
          if (
            this.selected[key] === undefined ||
            this.selected[key].length == 0
          ) {
            this.$set(this.errors, key, '필수항목입니다.')
            passed = false;
          }
        } else {
          if (this.selected[key]) {
          } else {
            this.$set(this.errors, key, '필수항목입니다.')
            passed = false;
          }
        }
      }

      return passed;
    },

    handleSelected () {
      let rows = this.gridApi.getSelectedRows()

      if (rows.length > 0) {
        this.$set(this, 'selected', rows[0])
        this.clearErrors();
      }
    },

    selectedRoleHas(comm2_cd) {
      return this.selected["user:role_cd"].includes(comm2_cd);
    },

    toggleRole(comm2_cd) {
      if (!this.selectedRoleHas(comm2_cd)) {
        this.selected["user:role_cd"].push(comm2_cd);
      } else {
        let index = this.selected["user:role_cd"].indexOf(comm2_cd);
        this.selected["user:role_cd"].splice(index, 1);
      }
    },

    selectedApprovalHas(comm2_cd) {
      return this.selected["user:appr_cd"].includes(comm2_cd);
    },

    toggleApproval(comm2_cd) {
      if (!this.selectedApprovalHas(comm2_cd)) {
        this.selected["user:appr_cd"].push(comm2_cd);
      } else {
        let index = this.selected["user:appr_cd"].indexOf(comm2_cd);
        this.selected["user:appr_cd"].splice(index, 1);
      }
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
      this.$set(this, "selected", {
        "user:user_id": null,
        "user:user_pw": null,
        "user:user_pw_confirmation": null,
        "user:user_nm": null,
        "user:email": null,
        "user:role_cd": [],
        "user:appr_cd": [],
        "user:job_cd": null,
        "user:user_sts_yn": "Y",
      });
    },

    clearErrors() {
      this.$set(this, "errors", {
        "user:user_id": null,
        "user:user_pw": null,
        "user:user_pw_confirmation": null,
        "user:user_nm": null,
        "user:email": null,
        "user:role_cd": null,
        "user:appr_cd": null,
        "user:job_cd": null,
        "user:user_sts_yn": null,
      });
    },

    displayErrors(errors) {
      for (const [key, value] of Object.entries(errors)) {
        this.$set(this.errors, key, Array.isArray(value) ? value[0] : value);
      }
    },

    add() {
      if (this.validateRequired()) {
        this.$vs.dialog({
          type: "confirm",
          color: "primary",
          title: this.$t("Confirmation"),
          text: this.$t("AddData"),
          acceptText: this.$t("Accept"),
          cancelText: this.$t("Cancel"),
          accept: () => {
            this.clearErrors();
            this.spinner();

            api
              .post(this.selected)
              .then((res) => {
                this.spinner(false);
                if (res.data.success) {
                  this.$vs.notify({
                    color: "success",
                    position: "top-right",
                    title: this.$t("SuccessAddData"),
                    text: res.data.message,
                  });
                  this.query();
                  // this.clear()
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
        });
      }
    },

    save() {
      if (this.validateRequired(["user:user_pw"])) {
        this.$vs.dialog({
          type: "confirm",
          color: "success",
          title: this.$t("Confirmation"),
          text: this.$t("SaveData"),
          acceptText: this.$t("Accept"),
          cancelText: this.$t("Cancel"),
          accept: () => {
            this.clearErrors();
            this.spinner();

            api
              .put(this.selected["user:user_id"], this.selected)
              .then((res) => {
                this.spinner(false);
                if (res.data.success) {
                  this.$vs.notify({
                    color: "success",
                    position: "top-right",
                    title: this.$t("SuccessSaveData"),
                    text: res.data.message,
                  });
                  this.query();
                  // this.clear()
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
        });
      }
    },

    query() {
      this.spinner();

      api
        .fetch({
          ...this.sortParam,
          limit: -1,
          with: 'role,appr,job'
        })
        .then((res) => {
          this.spinner(false);
          this.datas = res.data.data;
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

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-1-2"),
      });
    },

    remove() {
      var sUserId = this.selected["user:user_id"];
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("Confirmation"),
        text: this.$t("DeleteData"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => {
          this.clearErrors();
          this.spinner();

          api
            .delete(sUserId)
            .then((res) => {
              this.spinner(false);
              if (res.data.success) {
                this.clear();
                this.query();

                this.$vs.notify({
                  color: "success",
                  position: "top-right",
                  title: this.$t("SuccessDeleteData"),
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
      });
    },

    excel() {
      window.location.href = api.downloadUrl();
    },
  },

  mounted () {
    this.gridApi = this.gridOptions.api
  },

  created() {
    comm_cd.fetch({ cd1: "A10" }).then((res) => {
      this.roles = res.data;
    });

    comm_cd.fetch({ cd1: "A20" }).then((res) => {
      this.approvals = res.data;
    });

    comm_cd.fetch({ cd1: "A30" }).then((res) => {
      this.jobs = res.data;
    });

    setTimeout(() => {
      this.query();
    }, 200);
  },
};
</script>