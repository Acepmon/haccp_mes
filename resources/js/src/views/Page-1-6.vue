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
                    value="item_nm"
                    text="품목명"
                  ></vs-select-item>
                  <vs-select-item
                    value="item_id"
                    text="품목 ID"
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
        <div class="w-full sm:w-1/3 px-1 flex justify-end">
          <import-excel :onSuccess="loadDataInTable" v-model="importFile"></import-excel>
          <div>
            <vs-button
              @click="closeDialog()"
              class="mx-1 flex-shrink-0 py-3"
              color="dark"
              type="border"
              >{{ $t("Close") }}</vs-button
            >
          </div>
        </div>
      </div>

      <vs-divider />

      <div class="flex flex-wrap justify-end mb-2">
        <vs-button
          @click="exportExcel()"
          class="mx-1"
          color="dark"
          type="border"
          :disabled="items.length <= 0"
          >{{ $t("ToExcel") }}</vs-button
        >
      </div>

      <div class="overflow-y-auto" style="max-height: 500px">
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
        >
          <template slot="thead">
            <vs-th>No</vs-th>
            <vs-th sort-key="item_id">목ID</vs-th>
            <vs-th sort-key="item_nm">품목명</vs-th>
            <vs-th sort-key="spec">규격명</vs-th>
            <vs-th sort-key="unit">단위</vs-th>
            <vs-th sort-key="qty1">당수량(분자)</vs-th>
            <vs-th sort-key="qty2">봉수량</vs-th>
            <vs-th sort-key="conn_no">대표품목 환산수량</vs-th>
            <vs-th sort-key="conn_qty">연결품목 환산수량</vs-th>
            <vs-th sort-key="in_amt">입고가</vs-th>
            <vs-th sort-key="out_amt">출고가</vs-th>
            <vs-th sort-key="item_cd">품목</vs-th>
            <vs-th sort-key="grp1_cd">그룹1</vs-th>
            <vs-th sort-key="grp2_cd">그룹2</vs-th>
            <vs-th sort-key="grp3_cd">그룹3</vs-th>
            <vs-th sort-key="use_yn">사용</vs-th>
            <vs-th sort-key="process_cd">생산공정</vs-th>
          </template>

          <template slot-scope="{ data }">
            <vs-tr :data="tr" :key="index" v-for="(tr, index) in items">

              <vs-td :data="rowIndex(index)">
                {{ rowIndex(index) }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:item_id']">
                {{ data[index]["item_mst:item_id"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:item_nm']">
                {{ data[index]["item_mst:item_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:spec']">
                {{ data[index]["item_mst:spec"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:unit']">
                {{ data[index]["item_mst:unit"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:qty1']" class="text-right">
                {{ data[index]["item_mst:qty1"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:qty2']" class="text-right">
                {{ data[index]["item_mst:qty2"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:conn_no']" class="text-right">
                {{ data[index]["item_mst:conn_no"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:conn_qty']" class="text-right">
                {{ data[index]["item_mst:conn_qty"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:in_amt']" class="text-right">
                {{ data[index]["item_mst:in_amt"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:out_amt']" class="text-right">
                {{ data[index]["item_mst:out_amt"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:item_cd']">
                {{ data[index]["item_mst:item_cd_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:grp1_cd']">
                {{ data[index]["item_mst:grp1_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:grp2_cd']">
                {{ data[index]["item_mst:grp2_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:grp3_cd']">
                {{ data[index]["item_mst:grp3_nm"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:use_yn']">
                {{ data[index]["item_mst:use_yn"] }}
              </vs-td>

              <vs-td :data="data[index]['item_mst:process_cd']">
                {{ data[index]["item_mst:process_nm"] }}
              </vs-td>

            </vs-tr>
          </template>
        </vs-table>
      </div>
    </vx-card>

    <vs-popup fullscreen :title="$t('UploadExcel')" :active.sync="importDialog" button-close-hidden>
      <div class="flex flex-wrap mb-2">
        <div class="w-full sm:w-1/2 px-1 flex justify-end"></div>
        <div class="w-full sm:w-1/2 px-1 flex justify-end">
          <vs-button
            @click="importExcelDialog()"
            class="mx-1"
            color="dark"
            type="border"
            >{{ $t("Save") }}</vs-button
          >
          <vs-button
            @click="importDialog = false"
            class="mx-1"
            color="dark"
            type="border"
            >{{ $t("Close") }}</vs-button
          >
        </div>
      </div>

      <vs-table stripe pagination :max-items="30" search :data="tableData">
        <template slot="header">
          <h4>{{ sheetName }}</h4>
        </template>

        <template slot="thead">
          <vs-th :sort-key="heading" v-for="heading in header" :key="heading">{{ heading }}</vs-th>
        </template>

        <template slot-scope="{data}">
          <!-- eslint-disable-next-line -->
          <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data" v-if="indextr != 0">
            <vs-td :data="col" v-for="(col, indexcol) in data[indextr]" :key="indexcol + col">
              {{ col }}
            </vs-td>
          </vs-tr>
        </template>
      </vs-table>
    </vs-popup>
  </div>
</template>

<script>
import axios from "axios";
import comm_cd from "@/services/comm_cd";
import api from "@/services/item_mst";
import { mapActions } from "vuex";
import ImportExcel from '@/components/excel/ImportExcel.vue'

export default {
  components: {
    ImportExcel
  },

  data () {
    return {
      items: [],
      types: [],
      searchBy: 'item_nm',
      searchKeyword: null,
      searchType: '',
      importFile: null,
      importDialog: false,
      pagination: {
        page: 1,
        limit: 15,
        total: 0,
      },
      sorting: {
        sort: "reg_dtm",
        order: "desc",
      },

      tableData: [],
      header: [],
      sheetName: ''
    }
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
        sort: this.sorting.sort != null ? this.sorting.sort : "upd_dtm",
        order: this.sorting.order != null ? this.sorting.order : "desc",
      };
    },
  },

  methods: {
    ...mapActions({
      removeTab: "mdn/removeTab",
    }),

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

    handleChangePage(page) {
      this.pagination.page = page;
      this.query();
    },

    handleSort(sort, order) {
      this.sorting.sort = sort;
      this.sorting.order = order;
      this.query();
    },

    loadDataInTable ({ results, header, meta }) {
      this.header = header
      this.tableData = results
      this.sheetName = meta.sheetName
      this.$set(this, 'importDialog', true)
    },

    rowIndex: function (index) {
      return (
        this.pagination.page * this.pagination.limit -
        this.pagination.limit +
        index +
        1
      );
    },

    query() {
      this.spinner();

      let search_params = {};

      if (this.searchKeyword != null) {
        search_params[this.searchBy] = this.searchKeyword;
      }

      if (this.searchType != null) {
        search_params["item_cd"] = this.searchType;
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

    importExcelDialog () {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("ImportExcel"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.importExcel(),
      });
    },

    importExcel () {
      this.spinner()

      let formData = new FormData();
      if (this.importFile) {
        formData.append("file", this.importFile);
      }

      api
        .import(formData)
        .then((res) => {
          this.spinner(false)

          if (res.data.success) {
            this.$vs.notify({
              title: this.$t("SuccessSaveData"),
              position: "top-right",
              color: "success",
              text: res.data.message,
              time: 5000,
            });
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
          this.spinner(false);
          this.$vs.notify({
            title: this.$t("Error"),
            position: "top-right",
            color: "warning",
            iconPack: "feather",
            icon: "icon-alert-circle",
            text: err.response.data.message,
          });
        })
    },

    exportExcel () {
      let search_params = {};

      if (this.searchKeyword != null) {
        search_params[this.searchBy] = this.searchKeyword;
      }

      if (this.searchType != null) {
        search_params["item_cd"] = this.searchType;
      }

      window.location.href = api.export(search_params);
    },

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("page-1-6"),
      });
    },
  },

  created() {
    comm_cd.fetch({ cd1: "B10" }).then((res) => {
      this.types = res.data;
    });
  },
};
</script>

<style scoped>
.vs-popup--background {
  pointer-events: none;
}
</style>