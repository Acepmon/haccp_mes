<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container main-card">
      <app-control>
        <template v-slot:filter>
          <span class="pt-2 px-4">문서이름</span>
          <vs-input v-model="searchNm" class="control-field-sm" />

          <span class="pt-2 px-4">업무종류</span>
          <v-select 
            class="control-field"
            :options="types" 
            :reduce="item => item.comm2_cd" 
            label="comm2_nm" 
            v-model="searchType" 
            :searchable="false" />

          <span class="pt-2 px-4">사용구분</span>
          <v-select
            class="control-field"
            :options="[{l: 'YES', v: 'Y'},{l: 'NO', v: 'N'}]" 
            :reduce="item => item.v" 
            label="l" 
            v-model="searchUseYn" 
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
            class="mx-1 invisible"
            color="primary"
            type="border"
            >{{ $t("Add") }}</vs-button
          >
          <vs-button
            @click="saveDialog()"
            class="mx-1"
            color="primary"
            type="border"
            :disabled="!item['edoc_file:doc_id']"
            >{{ $t("Save") }}</vs-button
          >
          <vs-button
            @click="removeDialog()"
            class="mx-1 invisible"
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
            v-model="item['edoc_file:doc_nm']"
            :danger="errors['edoc_file:doc_nm'] != null"
            :danger-text="errors['edoc_file:doc_nm']"
          />
        </app-form-group>

        <app-form-group required>
          <template v-slot:label>문서종류</template>

          <v-select 
            style="width: 200px;"
            :options="types" 
            :reduce="item => item.comm2_cd" 
            label="comm2_nm" 
            v-model="item['edoc_file:type_cd']"
            :searchable="false" />
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="errors['edoc_file:type_cd'] != null"
          >
            <span
              class="span-text-validation"
              v-text="errors['edoc_file:type_cd']"
            ></span>
          </div>
        </app-form-group>

        <app-form-group>
          <template v-slot:label>설명(제품명)</template>

          <vs-input
            class="w-full"
            maxlength="150"
            v-model="item['edoc_file:doc_desc']"
            :danger="errors['edoc_file:doc_desc'] != null"
            :danger-text="errors['edoc_file:doc_desc']"
          />
        </app-form-group>

        <app-form-group></app-form-group>

        <app-form-group required>
          <template v-slot:label>업무처리주기</template>

          <div class="flex flex-row">
            <v-select 
              style="width: 200px;"
              :options="periods" 
              :reduce="item => item.comm2_cd" 
              label="comm2_nm" 
              v-model="item['edoc_file:period_cd']"
              :searchable="false" />

            <div
              class="flex flex-row"
              v-if="item['edoc_file:period_cd'] == 'ED'"
            >
              <vs-button
                v-for="(item, index) in periodEdDays"
                :key="index"
                @click="toggleEd(item.value)"
                :color="selectedEdHas(item.value) ? 'primary' : 'dark'"
                class="px-2 flex-shrink-0 ml-1 py-0"
                type="border"
              >
                <vs-icon
                  v-if="selectedEdHas(item.value)"
                  icon-pack="feather"
                  icon="icon-check"
                />
                <span v-text="item.text"></span>
              </vs-button>
            </div>
          </div>
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="errors['edoc_file:period_cd'] != null"
          >
            <span
              class="span-text-validation"
              v-text="errors['edoc_file:period_cd']"
            ></span>
          </div>
        </app-form-group>

        <app-form-group required>
          <template v-slot:label>사용구분</template>

          <v-select 
            style="width: 200px;"
            :options="[{l: 'YES', v: 'Y'},{l: 'NO', v: 'N'}]" 
            :reduce="item => item.v" 
            label="l" 
            v-model="item['edoc_file:use_yn']"
            :searchable="false" />
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="errors['edoc_file:use_yn'] != null"
          >
            <span
              class="span-text-validation"
              v-text="errors['edoc_file:use_yn']"
            ></span>
          </div>
        </app-form-group>

        <app-form-group required>
          <template v-slot:label>작업자</template>

          <v-select 
            style="width: 200px;"
            :options="work_users" 
            :reduce="item => item['user:user_id']" 
            label="user:user_id" 
            v-model="item['edoc_file:work_id']"
            :searchable="false" />
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="errors['edoc_file:work_id'] != null"
          >
            <span
              class="span-text-validation"
              v-text="errors['edoc_file:work_id']"
            ></span>
          </div>
        </app-form-group>

        <app-form-group required>
          <template v-slot:label>승인자</template>

          <v-select 
            style="width: 200px;"
            :options="app_users" 
            :reduce="item => item['user:user_id']" 
            label="user:user_id" 
            v-model="item['edoc_file:app_id']"
            :searchable="false" />
          <div
            class="con-text-validation span-text-validation-danger vs-input--text-validation-span"
            v-if="errors['edoc_file:app_id'] != null"
          >
            <span
              class="span-text-validation"
              v-text="errors['edoc_file:app_id']"
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
            <vs-th sort-key="type_nm">문서종류</vs-th>
            <vs-th sort-key="doc_desc">설명(제품명)</vs-th>
            <vs-th sort-key="period_nm">업무처리주기</vs-th>
            <vs-th sort-key="period_data">주기내용</vs-th>
            <vs-th sort-key="use_yn">사용구분</vs-th>
            <vs-th sort-key="work_id">작업자</vs-th>
            <vs-th sort-key="app_id">승인자</vs-th>
          </template>

          <template slot-scope="{ data }">
            <vs-tr :data="tr" :key="index" v-for="(tr, index) in items">
              <vs-td :data="rowIndex(index)">
                {{ rowIndex(index) }}
              </vs-td>

              <vs-td :data="data[index]['edoc_file:doc_nm']">
                {{ data[index]["edoc_file:doc_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['edoc_file:type_nm']">
                {{ data[index]["edoc_file:type_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['edoc_file:doc_desc']">
                {{ data[index]["edoc_file:doc_desc"] }}
              </vs-td>

              <vs-td :data="data[index]['edoc_file:period_nm']">
                {{ data[index]["edoc_file:period_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['edoc_file:period_data']">
                {{ data[index]["edoc_file:period_data_parsed"].join(',') }}
              </vs-td>

              <vs-td :data="data[index]['edoc_file:use_yn']">
                {{ data[index]["edoc_file:use_yn"] }}
              </vs-td>

              <vs-td :data="data[index]['edoc_file:work_id']">
                {{ data[index]["edoc_file:work_id"] }}
              </vs-td>

              <vs-td :data="data[index]['edoc_file:app_id']">
                {{ data[index]["edoc_file:app_id"] }}
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
import user from "@/services/user";
import api from "@/services/edoc_file";
import { mapActions } from "vuex";
import FileSelect from "@/layouts/components/FileSelect.vue";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";

export default {
  components: {
    FileSelect,
    AppControl,
    AppForm,
    AppFormGroup
  },

  data() {
    return {
      item: {
        "edoc_file:doc_id": null,
        "edoc_file:type_cd": null,
        "edoc_file:type_nm": null,
        "edoc_file:doc_nm": null,
        "edoc_file:doc_desc": null,
        "edoc_file:doc_content": null,
        "edoc_file:doc_appdata": null,
        "edoc_file:period_cd": null,
        "edoc_file:period_nm": null,
        "edoc_file:period_data": [],
        "edoc_file:period_data_parsed": [],
        "edoc_file:use_yn": null,
        "edoc_file:work_id": null,
        "edoc_file:app_id": null,
        "edoc_file:upd_dtm": null,
      },
      errors: {
        "edoc_file:doc_id": null,
        "edoc_file:type_cd": null,
        "edoc_file:type_nm": null,
        "edoc_file:doc_nm": null,
        "edoc_file:doc_desc": null,
        "edoc_file:doc_content": null,
        "edoc_file:doc_appdata": null,
        "edoc_file:period_cd": null,
        "edoc_file:period_nm": null,
        "edoc_file:period_data": null,
        "edoc_file:use_yn": null,
        "edoc_file:work_id": null,
        "edoc_file:app_id": null,
        "edoc_file:upd_dtm": null,
      },
      items: [],
      work_users: [],
      app_users: [],
      searchNm: null,
      searchType: null,
      searchUseYn: null,
      types: [],
      periods: [],
      periodEdDays: [
        { text: "월", value: 0 },
        { text: "화", value: 1 },
        { text: "수", value: 2 },
        { text: "목", value: 3 },
        { text: "금", value: 4 },
        { text: "토", value: 5 },
        { text: "일", value: 6 },
      ],
      pagination: {
        page: 1,
        limit: 15,
        total: 0,
      },
      sorting: {
        sort: "UPD_DTM",
        order: "DESC",
      },
      required: {
        'edoc_file:type_cd': '업무종류',
        'edoc_file:doc_nm': '문서이름',
        'edoc_file:period_cd': '업무처리주기',
        'edoc_file:use_yn': '사용구분',
        'edoc_file:work_id': '작업자',
        'edoc_file:app_id': '승인자',
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
        sort: this.sorting.sort != null ? this.sorting.sort : "UPD_DTM",
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
        "edoc_file:doc_id": null,
        "edoc_file:type_cd": null,
        "edoc_file:type_nm": null,
        "edoc_file:doc_nm": null,
        "edoc_file:doc_desc": null,
        "edoc_file:doc_content": null,
        "edoc_file:doc_appdata": null,
        "edoc_file:period_cd": null,
        "edoc_file:period_nm": null,
        "edoc_file:period_data": [],
        "edoc_file:use_yn": null,
        "edoc_file:work_id": null,
        "edoc_file:app_id": null,
        "edoc_file:upd_dtm": null,
      });
    },

    clearErrors() {
      this.$set(this, "errors", {
        "edoc_file:doc_id": null,
        "edoc_file:type_cd": null,
        "edoc_file:type_nm": null,
        "edoc_file:doc_nm": null,
        "edoc_file:doc_desc": null,
        "edoc_file:doc_content": null,
        "edoc_file:doc_appdata": null,
        "edoc_file:period_cd": null,
        "edoc_file:period_nm": null,
        "edoc_file:period_data": null,
        "edoc_file:use_yn": null,
        "edoc_file:work_id": null,
        "edoc_file:app_id": null,
        "edoc_file:upd_dtm": null,
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
    },

    save() {
      this.clearErrors();
      this.spinner();

      this.$set(this.item, 'edoc_file:period_data', this.item['edoc_file:period_data'].filter(period => period != ''))

      api
        .put(this.item["edoc_file:doc_id"], this.item)
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

      if (this.searchNm != null) {
        search_params["doc_nm"] = this.searchNm;
      }

      if (this.searchType != null) {
        search_params["type_cd"] = this.searchType;
      }

      if (this.searchUseYn != null) {
        search_params["use_yn"] = this.searchUseYn;
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

    excel() {
      let search_params = {};

      if (this.searchNm != null) {
        search_params["doc_nm"] = this.searchNm;
      }

      if (this.searchType != null) {
        search_params["type_cd"] = this.searchType;
      }

      if (this.searchUseYn != null) {
        search_params["use_yn"] = this.searchUseYn;
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
        accept: () => this.removeTab("page-1-4-3"),
      });
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

    selectedEdHas(ed) {
      let parsed = "" + ed;
      return this.item["edoc_file:period_data"].includes("" + parsed);
    },

    toggleEd(ed) {
      let parsed = "" + ed;
      if (!this.selectedEdHas(parsed)) {
        this.item["edoc_file:period_data"].push(parsed);
      } else {
        let index = this.item["edoc_file:period_data"].indexOf(parsed);
        this.item["edoc_file:period_data"].splice(index, 1);
      }
    }
  },

  created() {
    comm_cd.fetch({ cd1: "A40" }).then((res) => {
      this.types = res.data;
    });

    comm_cd.fetch({ cd1: "A50" }).then((res) => {
      this.periods = res.data;
    });

    user.fetch({ appr_cd: "10", limit: -1 }).then((res) => {
      this.work_users = res.data.data;
    });

    user.fetch({ appr_cd: "20", limit: -1 }).then((res) => {
      this.app_users = res.data.data;
    });

    setTimeout(() => {
      this.query()
    }, 500)
  }
};
</script>