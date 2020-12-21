<template>
  <div>
    <vx-card id="div-with-loading" class="vs-con-loading__container">
      <div class="flex flex-wrap mb-2">
        <div class="w-full sm:w-2/3 px-1 flex justify-end">
          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <vs-select placeholder="검색항목" v-model="searchBy">
                  <vs-select-item
                    value="doc_nm"
                    text="문서이름"
                  ></vs-select-item>
                  <vs-select-item
                    value="doc_desc"
                    text="설명(제품명)"
                  ></vs-select-item>
                </vs-select>
              </div>
              <div class="vx-col sm:w-2/3 w-full">
                <vs-input v-model="searchKeyword" />
              </div>
            </div>
          </div>
          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2">문서종류</span>
              </div>
              <div class="vx-col sm:w-2/3 w-full flex flex-row">
                <vs-select v-model="searchType">
                  <vs-select-item value="" text=" "></vs-select-item>
                  <vs-select-item
                    v-for="(type, index) in types"
                    :key="index"
                    :value="type.comm2_cd"
                    :text="type.comm2_nm"
                  ></vs-select-item>
                </vs-select>
                <vs-button
                  @click="query()"
                  class="mx-1 px-4 flex-shrink-0"
                  color="dark"
                  type="border"
                  >{{ $t("Query") }}</vs-button
                >
              </div>
            </div>
          </div>
        </div>
        <div
          class="w-full sm:w-1/3 px-1 flex justify-end"
          style="position: relative"
        >
          <vs-button
            @click="addDialog()"
            class="mx-1 px-4 flex-shrink-0"
            color="dark"
            type="border"
            >{{ $t("Add") }}</vs-button
          >
          <vs-button
            @click="saveDialog()"
            class="mx-1 px-4 flex-shrink-0"
            color="dark"
            type="border"
            >{{ $t("Save") }}</vs-button
          >
          <vs-button
            @click="removeDialog()"
            class="mx-1 px-4 flex-shrink-0"
            color="dark"
            type="border"
            >{{ $t("Delete") }}</vs-button
          >
          <vs-button
            @click="closeDialog()"
            class="mx-1 px-4 flex-shrink-0"
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
                  v-model="item['doc_mgmt:doc_nm']"
                  :danger="errors['doc_mgmt:doc_nm'] != null"
                  :danger-text="errors['doc_mgmt:doc_nm']"
                />
              </div>
            </div>
          </div>

          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2"
                  ><span class="text-danger">*</span> 문서종류</span
                >
              </div>
              <div class="vx-col sm:w-2/3 w-full">
                <vs-select
                  v-model="item['doc_mgmt:type_cd']"
                  :danger="errors['doc_mgmt:type_cd'] != null"
                  :danger-text="errors['doc_mgmt:type_cd']"
                >
                  <vs-select-item
                    v-for="(type, index) in types"
                    :key="index"
                    :value="type.comm2_cd"
                    :text="type.comm2_nm"
                  ></vs-select-item>
                </vs-select>
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-wrap">
          <div class="w-full sm:w-1/2 px-1">
            <div class="vx-row mb-2">
              <div class="vx-col sm:w-1/3 w-full flex justify-end">
                <span class="pt-2">설명(제품명)</span>
              </div>
              <div class="vx-col sm:w-2/3 w-full">
                <vs-input
                  class="w-full"
                  maxlength="150"
                  v-model="item['doc_mgmt:doc_desc']"
                  :danger="errors['doc_mgmt:doc_desc'] != null"
                  :danger-text="errors['doc_mgmt:doc_desc']"
                />
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
                  <file-select v-model="item['doc_mgmt:att']"></file-select>
                  <!-- <vs-button type="border" color="dark" @click.native="item['doc_mgmt:att'] = null" v-if="item['doc_mgmt:att']" class="ml-1 px-4">
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
            <vs-th sort-key="type_nm">문서종류</vs-th>
            <vs-th sort-key="doc_desc">설명(제품명)</vs-th>
            <vs-th>첨부문서</vs-th>
            <vs-th sort-key="reg_dtm">등록일자</vs-th>
          </template>

          <template slot-scope="{ data }">
            <vs-tr :data="tr" :key="index" v-for="(tr, index) in items">
              <vs-td :data="rowIndex(index)">
                {{ rowIndex(index) }}
              </vs-td>

              <vs-td :data="data[index]['doc_mgmt:doc_nm']">
                {{ data[index]["doc_mgmt:doc_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['doc_mgmt:type_nm']">
                {{ data[index]["doc_mgmt:type_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['doc_mgmt:doc_desc']">
                {{ data[index]["doc_mgmt:doc_desc"] }}
              </vs-td>

              <vs-td :data="data[index]['doc_mgmt:att_dtm']">
                <div class="flex flex-row">
                  <span
                    v-if="data[index]['doc_mgmt:att_file'].length > 0"
                    v-text="data[index]['doc_mgmt:att_file'][0].att_nm"
                    class="pt-1"
                  ></span>
                  <vs-button
                    color="primary"
                    class="ml-2"
                    :href="
                      '/api/doc_mgmt/' +
                      data[index]['doc_mgmt:doc_id'] +
                      '/att_file/' +
                      data[index]['doc_mgmt:att_file'][0].att_seq +
                      '/download'
                    "
                    type="flat"
                    size="small"
                    icon-pack="feather"
                    icon="icon-download"
                  ></vs-button>
                </div>
              </vs-td>

              <vs-td :data="data[index]['doc_mgmt:reg_dtm']">
                {{ data[index]["doc_mgmt:reg_dtm"] }}
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
import api from "@/services/doc_mgmt";
import { mapActions } from "vuex";
import FileSelect from "@/layouts/components/FileSelect.vue";

export default {
  components: {
    FileSelect,
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
        'doc_mgmt:type_cd': '문서종류',
        'doc_mgmt:doc_nm': '문서이름',
        'doc_mgmt:att': '첨부화일',
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

      if (tr["doc_mgmt:att_file"].length > 0) {
        // this.doc_mgmt['doc_mgmt:att'] = new File([""], tr['doc_mgmt:att_file'][0].att_nm)
        this.$set(
          this.item,
          "doc_mgmt:att",
          new File([""], tr["doc_mgmt:att_file"][0].att_nm)
        );
      } else {
        this.$set(this.item, "doc_mgmt:att", null);
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

  created() {
    comm_cd.fetch({ cd1: "A35" }).then((res) => {
      this.types = res.data;
    });
  },
};
</script>