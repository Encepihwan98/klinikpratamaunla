<template>
  <v-app>
    <vertical-nav-menu
      :is-drawer-open.sync="isDrawerOpen"
      :modules="modules"
    ></vertical-nav-menu>
    <app-bar></app-bar>
    <v-main>
      <div class="app-content-container boxed-container pa-6">
        <v-card class="mx-auto" max-width="97%" elevation="5">
          <v-card-text>
            <p class="text-h6 text--primary">Managemnt Rawat Jalan</p>
          </v-card-text>
          <v-container>
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

              <v-col class="d-flex" cols="12" sm="2">
                <v-btn 
                  depressed 
                  color="primary"
                  :to="{ name: 'reg-rawat-jalan' }"
                > 
                  Tambah Data 
                </v-btn>
              </v-col>
            </v-row>
          </v-container>
          <v-simple-table>
            <template v-slot:default>
              <thead >
                <tr>
                  <th class="text-left">
                    No
                    <v-icon @click="filterPage('id')" x-small>
                      {{
                        filter.sortBy == "id"
                          ? filter.orderBy == "asc"
                            ? "fas fa-sort-amount-up"
                            : "fas fa-sort-amount-down"
                          : "fas fa-sort-alt"
                      }}
                    </v-icon>
                  </th>
                  <th class="text-left">Nomor Kunjungan</th>
                  <th class="text-left">Pasien</th>
                  <th class="text-left">
                    Waktu Masuk
                  <v-icon @click="filterPage('id')" x-small>
                      {{
                        filter.sortBy == "id"
                          ? filter.orderBy == "asc"
                            ? "fas fa-sort-amount-up"
                            : "fas fa-sort-amount-down"
                          : "fas fa-sort-alt"
                      }}
                    </v-icon>  
                  </th>
                  <th class="text-left">Waktu Keluar</th>
                  <th class="text-left">Diagnosa Awal</th>
                  <th class="text-left">View</th>
                </tr>
              </thead>
              <tbody v-if="data.data.length > 0 && web.isTableLoad == false">
                <tr v-for="(item, index) in data.data" :key="item.description">
                  <td>{{ index + data.from }}</td>
                  <td>{{ item.medical_activity_id }}</td>
                  <td>{{ item.medical_activity_id }}</td>
                  <td>{{ item.entry_time }}</td>
                  <td>{{ item.exit_time }}</td>
                  <td>{{ item.final_condition }}</td>
                  <td>
                    <v-btn icon :to="{ name: 'rawat-jalan-detail' }">
                      <v-icon small>far fa-eye</v-icon>
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
              <tbody v-else-if="web.isTableLoad == true" class="text-center">
                <tr>
                  <td colspan="4">
                    <v-row class="app-content-container" justify="center">
                      <v-overlay :value="true" :absolute="true">
                        <v-progress-circular
                          indeterminate
                          size="50"
                          color="primary"
                        ></v-progress-circular>
                      </v-overlay>
                    </v-row>
                  </td>
                </tr>
              </tbody>
              <tbody v-else class="text-center">
                <tr>
                  <td colspan="4">Data Kosong!</td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
        </v-card>
      </div>
    </v-main>
    <footer></footer>
  </v-app>
</template>



<script>
import { ref } from "@vue/composition-api";
import { mdiMagnify, mdiBellOutline, mdiGithub } from "@mdi/js";

export default {
  props: {
    modules: [],
  },
  data() {
    const isDrawerOpen = ref(null);
    return {
      _url: "",
      pasien: {
        items: [],
        data: {},
      },
      clinic: {
        items: [],
        data: {},
      },
      reference: {
        items: [],
        data: {},
      },
      payment: {
        items: [],
        data: {},
      },
      caseType: {
        items: [],
        data: {},
      },
      registrationType: {
        items: [],
        data: {},
      },
      activity: {
        items: [],
        data: {},
      },
      dokter: {
        items: [],
        data: {},
      },
      registration: {
        entry_time: new Date(
          Date.now() - new Date().getTimezoneOffset() * 60000
        )
          .toISOString()
          .substr(0, 10),
        date_reference: new Date(
          Date.now() - new Date().getTimezoneOffset() * 60000
        )
          .toISOString()
          .substr(0, 10),
        date_SJP: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
          .toISOString()
          .substr(0, 10),
      },
      valid: false,
      data: {},
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
      currentData: {},
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
      menu2: false,
      menu3: false,
      menu4: false,
      selectItem: ["10", "25", "50", "100"],
      errors: [],
      rules: {
        required: (v) => !!v || "Tolong isi form.",
      },
    };
  },
  methods: {
    changeID(event) {
      if (event == "patien") {
        let currentID = this.pasien.data.id;
        this.registration.patien_id = currentID;
      } else if (event == "payment") {
        let currentID = this.registration.cara_bayar;
        this.payment.data.forEach((v) => {
          if (v.description == currentID) {
            this.registration.payment_id = v.id;
          }
        });
      }else if (event == "caseType") {
        let currentID = this.registration.kasus;
        this.caseType.data.forEach((v) => {
          if (v.description == currentID) {
            this.registration.case_id = v.id;
          }
        });
      }else if (event == "dokter") {
        let currentID = this.dokter.data.id;
        this.registration.dokter_id = currentID;
      } else if (event == "registrationType") {
        let currentID = this.registration.registrasi;
        this.registrationType.data.forEach((v) => {
          if (v.description == currentID) {
            this.registration.registrasi_id = v.id;
          }
        });
      } else if (event == "clinic") {
        let currentID = this.registration.poliklinik;
        this.clinic.data.forEach((v) => {
          if (v.name == currentID) {
            this.registration.polyclinic_id = v.id;
          }
        });
      } else if (event == "activity") {
        let currentID = this.registration.kegiatan;
        this.activity.data.forEach((v) => {
          if (v.description == currentID) {
            this.registration.medical_activity_id = v.id;
          }
        });
      }else if (event == "reference") {
        let currentID = this.registration.rujukan;
        this.reference.data.forEach((v) => {
          if (v.description == currentID) {
            this.registration.reference_id = v.id;
          }
        });
      }
    },
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
      let req = Object.assign(this.registration, this.filter);
      this.currentData = null;
      axios
        .post(this._url, req)
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
      let req = Object.assign(this.registration, this.filter);
      axios
        .put(`${this._url}${this.registration.id}`, req)
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
            this.registration = response.data.data;
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
      this.registration = {};
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
        this._url +
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
    setSelectedName() {
      axios.get(`/api/v1/list-pasien/`).then((res) => {
        // console.log(res);
        if (res.status === 200) {
          this.pasien.items = res.data.data;
        } else {
          7;
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSelectedDokter() {
      axios.get(`/api/v1/list-pegawai/`).then((res) => {
        if (res.status === 200) {
          this.dokter.items = res.data.data;
        } else {
          7;
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },

    setSelectedClinic() {
      axios.get(`/api/v1/list-poliklinik/`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.clinic.items.push(v.name);
          });
          this.clinic.data = res.data.data;
        } else {
          7;
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },

  },
  created() {
    if (this.modules.length > 0) {
      let access = this.redirectIfNotHaveAccess(this.modules, this.$route.path);
      if (Object.keys(access).length === 1 && access.constructor === Object) {
        this.$router.push({ name: access.home });
      } else {
        this.web = access;
      }
    }
    this._url = window.location.origin + "/api/v1/rawat-jalan/";
    this.filterPage("");
    this.setSelectedName();
    this.setSelectedReference();
    this.setSelectedPayment();
    this.setSelectedCasetype();
    this.setSelectedregistrationType();
    this.setSelectedClinic();
    this.setSelectedActivity();
    this.setSelectedDokter();
  },
  computed: {
    searchPasien() {
      return this.pasien.search;
    },
    pasienSelected() {
      return this.pasien.data;
    },
    searchDokter() {
      return this.dokter.search;
    },
    dokterSelected() {
      return this.dokter.data;
    },
  },
  watch: {
    modules: function (n, o) {
      let access = this.redirectIfNotHaveAccess(n, this.$route.fullPath);
      if (Object.keys(access).length === 1 && access.constructor === Object) {
        this.$router.push({ name: access.home });
      } else {
        this.web = access;
      }
    },
    searchPasien(val) {
      setTimeout(() => {
        this.registration = this.pasien.data.forEach((e) => {
          console.log(registration);
          return e.name == val ? e : null;
          // return (e.name || '').toLowerCase().indexOf((val.name || '').toLowerCase()) > -1
        });
        this.loading = false;
      }, 500);
    },
    searchDokter(val) {
      setTimeout(() => {
        this.registration = this.dokter.data.forEach((e) => {
          console.log(e);
          return e.name == val ? e : null;
          // return (e.name || '').toLowerCase().indexOf((val.name || '').toLowerCase()) > -1
        });
        this.loading = false;
      }, 500);
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