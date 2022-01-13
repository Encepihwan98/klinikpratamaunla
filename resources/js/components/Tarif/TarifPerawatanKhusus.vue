<template>
  <div>
    <div class="app-content-container boxed-container pa-6">
      <v-row>
        <v-col class="d-flex" cols="12" sm="2">
          <v-select
            v-model="filter.limit"
            dense
            :items="selectItem"
            label="Tampilkan"
            @input="filterPage('')"
            outlined
          ></v-select>
        </v-col>

        <v-col class="d-flex" cols="12" sm="8">
          <v-text-field
            v-model="filter.searchQuery"
            dense
            append-icon="far fa-search"
            outlined
            clearable
            label="Search"
            type="text"
            @click:append="filterPage('')"
            @input="filterPage('')"
          ></v-text-field>
        </v-col>
      </v-row>

      <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left">
                <v-icon @click="filterPage('id')" x-small>
                  {{
                    filter.sortBy == "id"
                      ? filter.orderBy == "asc"
                        ? "fas fa-sort-amount-up"
                        : "fas fa-sort-amount-down"
                      : "fas fa-sort-alt"
                  }}
                </v-icon>
                No
              </th>
              <th class="text-left">
                Uraian
                <v-icon @click="filterPage('service_rate')" x-small>{{
                  filter.sortBy == "service_rate"
                    ? filter.orderBy == "asc"
                      ? "fas fa-sort-amount-up"
                      : "fas fa-sort-amount-down"
                    : "fas fa-sort-alt"
                }}</v-icon>
              </th>
              <!-- <th class="text-left">Kode</th> -->
              <th class="text-left">Ubah Tarif</th>
            </tr>
          </thead>
          <tbody v-if="baseData.data.length > 0 && web.isTableLoad == false">
            <tr v-for="(item, index) in baseData.data" :key="item.id">
              <td>{{ index + 1 }}</td>
              <td>{{ item.service_name }}</td>
              <td>
                <v-btn color="primary" @click="selectMethod(index, 'edit')">
                  <v-icon small>far fa-edit</v-icon>
                </v-btn>
              </td>
            </tr>
            <!-- <tr
                v-for="item in desserts"
                :key="item.name"
                >
                <td>{{ item.name }}</td>
                <td>{{ item.calories }}</td>
                </tr> -->
          </tbody>
        </template>
      </v-simple-table>
    </div>
    <div>
      <v-dialog v-model="dialog.state" persistent max-width="700px">
        <v-card>
          <v-card-title>
            <span class="text-h5">Form</span>
            <v-icon class="ml-auto" @click="dialog.state = false" color="red"
              >fas fa-times-circle</v-icon
            >
          </v-card-title>
          <v-card-text>
            <v-form
              ref="form"
              v-model="valid"
              lazy-validation
              :currentData="currentData"
            >
              <v-container>
                <v-row>
                  <v-col class="d-flex" cols="12" sm="12">
                    <v-text-field
                      label="Ank VIP :"
                      placeholder="Anak VIP"
                      outlined
                      dense
                    ></v-text-field> </v-col
                ></v-row>
                <hr class="mt-n6" />
                <!-- <v-baner>Kelas VIP</v-baner> -->
                <div
                  v-for="(value, key, index) in SpecialTreatment[currentData]"
                  :key="index"
                >
                  <span class="font-weight-bold mt-n4 mb-2">{{ key }}</span>
                  <v-row>
                    <v-col class="d-flex" cols="12" sm="4">
                      <v-text-field
                        label="Tarif Sarana"
                        v-model="value.SARANA"
                        :placeholder="value.SARANA"
                        outlined
                        dense
                      ></v-text-field>
                    </v-col>
                    <v-col class="d-flex" cols="12" sm="4">
                      <v-text-field
                        label="Tarif Pelayanan"
                        v-model="value.PELAYANAN"
                        :placeholder="value.PELAYANAN"
                        outlined
                        dense
                      ></v-text-field>
                    </v-col>
                    <v-col class="d-flex" cols="12" sm="4">
                      <v-text-field
                        label="Tarif BHP"
                        :placeholder="value.BHP"
                        v-model="value.BHP"
                        outlined
                        dense
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </div>
              </v-container>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="dialog.state = false">
              Tutup
            </v-btn>
            <v-btn
              v-if="condition != 'show'"
              color="blue darken-1"
              textx
              @click="selectStore"
            >
              Simpan
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <confirmation-dialog
        :confirmationDialog="dialogConfirmation"
        :method="condition == 'update'"
        @changeDialogState="dialogConfirmation.state = $event"
      ></confirmation-dialog>
    </div>
  </div>
</template>

<script>
import { ref } from "@vue/composition-api";
import { mdiMagnify, mdiBellOutline, mdiGithub } from "@mdi/js";

export default {
  props: {
    modules: [],
    isOpen: "",
    baseData: {},
  },
  data() {
    const isDrawerOpen = ref(null);
    return {
      _url: "",
      SpecialTreatment: [],
      valid: false,
      data: {},
      data1: {},
      test: {},
      web: {
        isTableLoad: false,
      },
      filter: {
        page: 1,
        searchQuery: "",
        limit: 10,
        sortBy: "id",
        orderBy: "asc",
      },
      isDrawerOpen,
      data: {
        data: [],
        current_page: 1,
      },

      currentData: 0,
      currentUser: {},
      dialog: {
        state: false,
        title: null,
      },
      dialogConfirmation: {
        state: false,
        message: null,
      },
      condition: "store",
      selectItem: ["10", "25", "50", "100"],
      errors: [],
      rules: {
        required: (v) => !!v || "Tolong isi form.",
      },
    };
  },
  methods: {
    selectStore() {
      if (this.$refs.form.validate()) {
        if (this.condition == "store") {
          this.dialogConfirmation.message = "menyimpan";
          this.popDialog();
        } else {
          this.dialogConfirmation.message = "mengubah";
          this.popDialog();
        }
      }
    },
    selectMethod(data, item) {
      this.currentData = data;
      if (item == "delete") {
        this.condition = item;
        this.dialogConfirmation.message = "menghapus";
        this.showDialog(true);
      } else if (item == "add") {
        this.currentData = null;
        this.condition = "store";
        this.dialog.title = "Tambah Role";
        this.showDialog(false);
      } else if (item == "show") {
        this.condition = "show";
        this.dialog.title = "Data Role";
        this.showDialog(false);
      } else if (item == "edit") {
        this.condition = "update";
        this.dialog.title = "Edit Role";
        this.showDialog(false);
      }
    },
    store() {
      let url = window.location.origin + "/api/v1/tarif/";
      let req = Object.assign(this.SpecialTreatment, this.filter, {
        module: "tarif",
      });
      this.currentData = null;
      axios
        .post(url, req)
        .then((response) => {
          if (response.status == 200) {
            this.dialog.state = false;
            this.data = response.data.data;
            this.makeDefaultNotification(
              response.data.status,
              response.data.message
            );
          }
        })
        .catch((e) => {
          this.errorState(e);
        });
    },
    update() {
      let req = Object.assign(this.data, this.filter);
      axios

        .put(`${this._url}${this.SpecialTreatment.id}`, req)
        .then((response) => {
          if (response.status == 200) {
            this.dialog.state = false;
            this.retriveData = response.data.data;
            this.makeDefaultNotification(
              response.data.status,
              response.data.message
            );
          }
        })
        .catch((e) => {
          this.errorState(e);
        });
    },
    show(id) {
      let url = `${this._url}${id}`;
      axios
        .get(url)
        .then((response) => {
          if (response.status == 200) {
            this.SpecialTreatment = response.data.data;
            // console.log(this.rateRoom);
          }
        })
        .catch((e) => {
          this.errorState(e);
        });
    },
    popDialog() {
      this.dialogConfirmation.state = !this.dialogConfirmation.state;
    },
    clear() {
      //   this.VisitService = [];
      this.errors = {};
      if (this.$refs.form) this.$refs.form.resetValidation();
    },
    errorState(e) {
      if (e.response.status == 401) {
        localStorage.removeItem("token");
        this._token = "";
        this.$router.push({ name: "index" });
      } else {
        if (e.response.data.errors) {
          this.errors = e.response.data.errors;
        } else {
          this.showDialog = false;
        }

        this.errorRequestState(e);
      }
    },
    remove() {
      this.web.isTableLoad = true;
      axios
        .delete(`${this._url}${this.currentData.id}`, { data: this.filter })
        .then((response) => {
          if (response.status == 200) {
            this.web.isTableLoad = false;
            this.data = response.data.data;
            this.filter.page = response.data.data.current_page;
            this.makeDefaultNotification(
              response.data.status,
              response.data.message
            );
          }
        })
        .catch((e) => {
          this.errorState(e);
        });
    },
    edit(data) {
      this.currentData = data;
      this.condition = "update";
      this.dialog.title = "Edit Role";
      this.showDialog(false);
    },
    add() {
      this.currentData = null;
      this.condition = "store";
      this.dialog.title = "Tambah Data";
      this.showDialog(false);
    },
    showDialog(isConfirmation) {
      if (isConfirmation) {
        this.dialogConfirmation.state = !this.dialogConfirmation.state;
      } else {
        this.dialog.state = !this.dialog.state;
      }
    },
    filterPage(sort_by) {
      this.web.isTableLoad = true;
      if (sort_by != "" && sort_by != null && sort_by != "undefined") {
        this.filter.sortBy == sort_by
          ? this.filter.orderBy == "asc"
            ? (this.filter.orderBy = "desc")
            : (this.filter.orderBy = "asc")
          : (this.filter.sortBy = sort_by);
      }
      let url =
        window.location.origin +
        "/api/v1/tarif/" +
        "?page=" +
        this.filter.page +
        "&limit=" +
        this.filter.limit +
        "&searchQuery=" +
        this.filter.searchQuery +
        "&sortBy=" +
        this.filter.sortBy +
        "&orderBy=" +
        this.filter.orderBy;
      axios
        .get(url)
        .then((response) => {
          if (response.status == 200) {
            this.test = response.data.data;
            // console.log(this.test);
            this.data = response.data.data;

            this.filter.page = response.data.data.current_page;
            this.web.isTableLoad = false;
            this.getCurrentUser();
          }
        })
        .catch((e) => {
          this.errorState(e);
        });
    },
  },
  created() {
    if (this.baseData && this.baseData.data.length > 0) {
      // this.filterPage("")
      this.data = this.baseData;
      this.baseData.data.forEach((val) => {
        this.SpecialTreatment.push(val.service_rate);
      });
    }
    
  },
  computed: {
    dialogState() {
      return this.dialog.state;
    },
  },
  watch: {
    dialogState: function (n, o) {
      // console.log(n && this.currentData);
      //   if (n && this.currentData) this.show(this.currentData.id);
      //   else
      this.clear();
    },
    baseData(v) {
      this.data = v;
      v.data.forEach((val) => {
        this.SpecialTreatment.push(val.service_rate);
      });
    },
    isOpen(v) {
      console.log(v);
      if (v == "VisitType") {
        this.data = this.baseData;
        this.baseData.data.forEach((val) => {
          this.SpecialTreatment.push(val.service_rate);
        });
      }
    },
    modules: function (n, o) {
      let access = this.redirectIfNotHaveAccess(n, this.$route.fullPath);
      if (Object.keys(access).length === 1 && access.constructor === Object) {
        this.$router.push({ name: access.home });
      } else {
        this.web = access;
      }
    },
  },
};
</script>



<style lang="scss" scoped>
@import "./resources/js/plugins/vuetify/default-preset/preset/variables.scss";

.v-app-bar ::v-deep {
  .v-toolbar__content {
    padding: 0;

    .app-bar-search {
      .v-input__slot {
        padding-left: 18px;
      }
    }
  }
}

.boxed-container {
  max-width: 1440px;
  margin-left: auto;
  margin-right: auto;
}

.user-profile-menu-content {
  .v-list-item {
    min-height: 2.5rem !important;
  }
}
</style>