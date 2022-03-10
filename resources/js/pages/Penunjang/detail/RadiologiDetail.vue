<template>
  <v-app>
    <vertical-nav-menu
      :is-drawer-open.sync="isDrawerOpen"
      :modules="modules"
    ></vertical-nav-menu>
    <app-bar></app-bar>
    <v-main>
      <div class="app-content-container pa-6">
        <v-expansion-panels focusable v-model="panel">
          <v-expansion-panel>
            <v-expansion-panel-header
              >Poli Klinik Mata</v-expansion-panel-header
            >
            <v-expansion-panel-content>
              <v-from>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        label="Nama Pasien"
                        placeholder="Pasien"
                        outlined
                        dense
                        small
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        label="Tempat, Tanggal Lahir"
                        placeholder="Tempat, Tanggal Lahir"
                        outlined
                        dense
                        small
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        label="Alamat"
                        placeholder="Alamat"
                        outlined
                        dense
                        small
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-from>
            </v-expansion-panel-content>
          </v-expansion-panel>
        </v-expansion-panels>

        <v-card class="mx-auto mt-9" elevation="5">
          <v-card-text>
            <p class="text-h6 text--primary">Tindakan Pemeriksaan</p>
          </v-card-text>
          <v-container>
            <v-row>
              <v-col class="d-flex" cols="12" sm="2">
                <v-select
                  :items="selectItem"
                  label="Tampilkan"
                  dense
                  outlined
                  chips
                  small-chips
                ></v-select>
              </v-col>

              <v-col class="d-flex" cols="12" sm="8">
                <v-text-field
                  outlined
                  label="Search"
                  append-icon="mdi-magnify"
                  small
                  dense
                ></v-text-field>
              </v-col>
              <v-col class="d-flex" cols="12" sm="2">
                <v-btn color="primary" dark @click="selectMethod(null, 'add')">
                  Tambah Data
                </v-btn>
              </v-col>
            </v-row>
          </v-container>
          <v-simple-table>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left">No</th>
                  <th class="text-left">Waktu Pemeriksaan</th>
                  <th class="text-left">Tindakan</th>
                  <th class="text-left">Tarif Sarana</th>
                  <th class="text-left">Tarif Pelayanan</th>
                  <th class="text-left">Tarif BPH</th>
                  <th class="text-left">Catatan</th>
                  <th class="text-left">View</th>
                </tr>
              </thead>
              <tbody v-if="data.data.length > 0 && web.isTableLoad == false">
                <tr v-for="(item, index) in data.data" :key="item.note">
                  <td>{{ index + data.from }}</td>
                  <td>{{item.action_time}}</td>
                  <td>{{item.note}}</td>
                  <td v-for="rates in item.rate" :key="rates">
                    {{rates}}
                  </td>
                    <!-- <td>{{item.rate.BPH}}</td>
                    <td></td>
                    <td></td> -->
                  
                  <td>{{item.note}}</td>
                  <td>
                    <v-btn 
                      icon  small
                      @click="selectMethod(item, 'delete')"
                    >
                      <v-icon small>far fa-trash</v-icon>
                    </v-btn>
                  </td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
          <v-card-actions class="d-flex justify-center">
            <v-pagination
              v-model="filter.page"
              :length="data.last_page"
              :total-visible="7"
              @input="filterPage('')"
            ></v-pagination>
          </v-card-actions>
        </v-card>
      </div>
      <div>
        <v-dialog v-model="dialog.state" persistent max-width="500px">
          <v-card>
            <v-card-title>
              <span class="text-h5">Form</span>
              <hr />
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
                    <v-col class="d-flex" cols="12" sm="12" md="8">
                      <v-select
                        :items="activity.items"
                        label="Tindakan/Pemeriksaan"
                        dense
                        v-model="lab.tindakan"
                        outlined
                        @input="changeID('tindakan')"
                        :error-messages="errors.name"
                        :rules="[rules.required]"
                      ></v-select>
                    </v-col>
                    <v-col class="d-flex" cols="12" sm="4">
                      <v-text-field
                        v-model="lab.amount"
                        label="Jumlah :"
                        placeholder="Jumlah"
                        outlined
                        dense
                        clearable
                        :error-messages="errors.name"
                        :rules="[rules.required]"
                        :disabled="condition == 'show' ? true : false"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12" md="12">
                      <v-text-field
                        label="Catatan"
                        required
                        outlined
                        v-model="lab.note"
                      ></v-text-field>
                    </v-col>
                    <v-col class="d-flex" cols="12" sm="12" md="12">
                      <v-select
                        :items="officer.items"
                        label="Petugas"
                        dense
                        v-model="lab.petugas"
                        outlined
                        @input="changeID('officer')"
                        :error-messages="errors.name"
                        :rules="[rules.required]"
                      ></v-select>
                    </v-col>
                    <v-col cols="12" lg="12">
                      <v-menu
                        v-model="menu2"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <v-text-field
                            v-model="lab.action_time"
                            label="Waktu Rujukan"
                            append-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            outlined
                            dense
                            :disabled="condition == 'show' ? true : false"
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="lab.action_time"
                          @input="menu2 = false"
                        ></v-date-picker>
                      </v-menu>
                    </v-col>
                  </v-row>
                </v-container>
              </v-form>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="dialog.state = false">
                Tutup
              </v-btn>
              <v-btn color="blue darken-1" text @click="selectStore">
                Simpan
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <confirmation-dialog
          :confirmationDialog="dialogConfirmation"
          :method="
            condition == 'store'
              ? store
              : condition == 'update'
              ? update
              : remove
          "
          @changeDialogState="dialogConfirmation.state = $event"
        ></confirmation-dialog>
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
    base: {},
  },
  data() {
    const isDrawerOpen = ref(null);
    return {
      _url: "",
      valid: false,
      param: "",
      web: {
        isTableLoad: false,
      },
      menu2: false,
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
      officer: {
        data: {},
        items: [],
      },
      activity: {
        data: {},
        items: [],
      },
      currentData: {},
      currentUser: {},
      dialog: {
        state: false,
        title: null,
      },
      lab: {
        action_time: new Date(
        Date.now() - new Date().getTimezoneOffset() * 60000
      )
        .toISOString()
        .substr(0, 10),
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
    changeID(event) {
      if (event == "tindakan") {
        let currentID = this.lab.tindakan;
        this.activity.data.forEach((v) => {
          if (v.description == currentID) {
            this.lab.action_id = v.id;
          }
        });
      } else if (event == "officer") {
        let currentID = this.lab.petugas;
        this.officer.data.forEach((v) => {
          // console.log(v);
          if (v.name == currentID) {
            this.lab.officer_id = v.id;
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

    setSeletPetugas() {
      axios.get(`/api/v1/list-pegawai`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.officer.items.push(v.name);
          });
          this.officer.data = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },

    setSeletActivity() {
      axios.get(`/api/v1/daftar-kegiatan`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.activity.items.push(v.description);
          });
          this.activity.data = res.data.data;
          this.lab.param = this.param;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
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

    showDialog(isConfirmation) {
      if (isConfirmation) {
        this.dialogConfirmation.state = !this.dialogConfirmation.state;
      } else {
        this.dialog.state = !this.dialog.state;
      }
    },
    store() {
      let req = Object.assign(this.lab, this.filter, this.param);
      this.currentData = null;
      axios
        .post(this._url, req)
        .then((response) => {
          if (response.status == 200) {
            this.dialog.state = false;
            
            this.data = response.data.data;
            // console.log(data);
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
    popDialog() {
      this.dialogConfirmation.state = !this.dialogConfirmation.state;
    },
    clear() {
      this.lab = {};
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
    add() {
      this.currentData = null;
      this.condition = "store";
      this.dialog.title = "Tambah Data";
      this.showDialog(false);
    },

    filterPage(sort_by) {
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
        this.filter.orderBy +
        "&select=all" +
        "&param=" + this.param;;
      axios
        .get(url)
        .then((response) => {
          // console.log(response);
          if (response.status == 200) {
            this.data = response.data.data;
            this.filter.page = response.data.data.current_page;
            this.getCurrentUser();
            console.log(this.$route.params.id);
            localStorage.setItem("current_param", this.$route.params.id);
          }
        })
        .catch((e) => {
          this.errorState(e);
        });
    },
  },
  created() {
    this._url = window.location.origin + "/api/v1/penunjang-tindakan/";
    if (
      localStorage.getItem("current_param") != null &&
      localStorage.getItem("current_param")
    ) {
      if (
        this.$route.params.id != null &&
        this.$route.params.id != localStorage.getItem("current_param")
      ) {
        localStorage.setItem("current_param", this.$route.params.id);
      }
      this.param = localStorage.getItem("current_param");
    } else {
      if (this.$route.params.id) {
        localStorage.setItem("current_param", this.$route.params.id);
        this.param = this.$route.params.id;
      } else {
        this.$router.push({ name: "rawat-jalan-detail" });
      }
    }
    this.filterPage("");
    // this.setSeletPetugas();
    //   this.setSeletActivity();
  },

  computed: {
    dialogState() {
      return this.dialog.state;
    },
  },

  watch: {
    dialogState: function (n, o) {
      
      this.setSeletPetugas();
      this.setSeletActivity();
      this.lab.params = this.param;
      console.log(this.$route.params.id);
      // console.log(lab.param);
      if (n && this.currentData) this.show(this.currentData.id);
      else this.clear();
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
