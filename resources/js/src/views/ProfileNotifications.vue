<template>
  <vx-card id="div-with-loading" class="vs-con-loading__container main-card">
    <app-control>
      <template v-slot:filter></template>
      <template v-slot:action>
        <vs-button
          @click="query()"
          class="mx-1"
          color="dark"
          type="border"
          >{{ $t("Query") }}</vs-button
        >
        <vs-button
          @click="sendNotice()"
          class="mx-1"
          color="dark"
          type="border"
          >{{ $t("SendNotice") }}</vs-button
        >
        <vs-button
          @click="readAll()"
          class="mx-1"
          color="dark"
          type="border"
          >{{ $t("NotifReadAll") }}</vs-button
        >
        <vs-button
          @click="deleteAll()"
          class="mx-1"
          color="dark"
          type="border"
          >{{ $t("NotifDeleteAll") }}</vs-button
        >
        <vs-button
          @click="closeDialog()"
          class="mx-1"
          color="dark"
          type="border"
          >{{ $t("Close") }}</vs-button
        >
      </template>
    </app-control>

    <vs-divider />

    <app-form>
      <app-form-group required full>
        <template v-slot:label>알림제목</template>
        <vs-input class="control-field" v-model="notice.title" />
      </app-form-group>
      <app-form-group required full>
        <template v-slot:label>알림내용</template>
        <vs-textarea class="control-field-lg" v-model="notice.msg" />
      </app-form-group>
    </app-form>

    <vs-divider />

    <ag-grid-vue
      ref="agGridTable"
      :localeText="localeText"
      :gridOptions="gridOptions"
      rowSelection="single"
      @selection-changed="handleSelected"
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
</template>

<script>
import axios from "axios";
import api from "@/services/user";
import { mapActions } from "vuex";

import AppControl from "@/views/ui-elements/AppControl";
import AppForm from "@/views/ui-elements/AppForm";
import AppFormGroup from "@/views/ui-elements/AppFormGroup";

import { AgGridVue } from 'ag-grid-vue'
import AG_GRID_LOCALE_KR from '@/views/ui-elements/ag-grid-table/agGridLocaleKr.js';;
import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'

export default {
  name: 'profile-notifications',
  components: {
    AppControl,
    AppForm,
    AppFormGroup,
    AgGridVue
  },
  data() {
    return {
      notice: {
        title: null,
        msg: null
      },
      items: [],
      localeText: AG_GRID_LOCALE_KR,
      maxPageNumbers: 7,
      gridOptions: {
        rowHeight: 40,
        headerHeight: 40,
        getRowClass: (params) => {
          if (params.data['read_at'] == '' || params.data['read_at'] == null || params.data['read_at'] == undefined) {
            return 'unread-row';
          }
        }
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
        { headerName: '제목', field: 'title', filter: false, width: 200 },
        { headerName: '알림 내용', field: 'msg', filter: false, width: 600 },
        { headerName: '알림 시간', field: 'time', filter: false, width: 200 },
      ]
    };
  },
  computed: {
    activeUserInfo() {
      let loggedIn = localStorage.getItem('loggedIn')
      let json = JSON.parse(loggedIn)
      return json;
    },
    itemsComp: function () {
      return this.items.map((item, index) => {
        return {
          'no': (index + 1),
          'read_at': item.read_at,
          ...item.data,
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
  },
  methods: {
    ...mapActions({
      removeTab: "mdn/removeTab",
      fetchNotifications: "notif/fetchNotifications",
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

    clear() {
      this.$set(this, "item", {
        "user:user_id": null,
        "user:user_nm": null,
        "user:email": null,
      });
    },

    clearErrors() {
      this.$set(this, "errors", {
        "user:user_id": null,
        "user:user_nm": null,
        "user:email": null,
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
        this.$set(this, 'notice', rows[0])
      }
    },

    sendNotice () {
      axios.get('/sanctum/csrf-cookie').then(() => {
        axios.post('/api/auth/user/sendNotice', this.notice).then((res) => {
          this.$vs.notify({
            title: this.$t("SuccessAddData"),
            position: "top-right",
            color: "success"
          });
        })
      });
    },

    query () {
      this.spinner();
      axios.get('/sanctum/csrf-cookie').then(() => {
        axios.get('/api/auth/user/notifications').then((res) => {
          this.spinner(false)
          this.items = res.data.data
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
        });
      })
    },

    deleteAll () {
      this.spinner();
      axios.get('/sanctum/csrf-cookie').then(() => {
        axios.post('/api/auth/user/notifications', {_method: 'DELETE'}).then((res) => {
          this.spinner(false)
          this.query()
          this.fetchNotifications()
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
        });
      })
    },

    readAll () {
      this.spinner();
      axios.get('/sanctum/csrf-cookie').then(() => {
        axios.post('/api/auth/user/notifications').then((res) => {
          this.spinner(false)
          this.query()
          this.fetchNotifications()
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
        });
      })
    },

    closeDialog() {
      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: () => this.removeTab("profile-general"),
      });
    },

    saveDialog() {
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

  mounted () {
    this.gridApi = this.gridOptions.api
  },

  created () {
    setTimeout(() => {
      this.query();
    }, 200);
  }
};
</script>

<style>
.unread-row > .ag-cell {
  background: rgba(18, 156, 233, 0.15) !important;
}
</style>