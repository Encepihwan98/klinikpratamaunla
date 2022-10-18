<template>
  <v-app>
    <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen" :modules="modules"></vertical-nav-menu>
    <app-bar></app-bar>
    <v-main>
      <div class="app-content-container pa-6">
        <v-card-text>
          <p class="text-h6 text--primary">Pasien Management</p>
        </v-card-text>
        <v-container>
          <v-row>
            <v-col class="" cols="12" sm="8">
              <v-card>
                <v-container>
                  <v-form ref="form" v-model="valid" lazy-validation :currentData="currentData">
                    <v-container>
                      <v-row>
                        <v-col cols="12" sm="12">
                          <p class="text-h6 text--primary">Data Pasien</p>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="12">
                          <v-text-field label="ID" v-model="pasien.id" placeholder="PS0001" outlined dense small
                            disabled></v-text-field>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="12">
                          <v-text-field label="Nama" placeholder="Maman Abdul" :error-messages="errors.name"
                            :rules="[rules.required]" v-model="pasien.nama" outlined dense small></v-text-field>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="12">
                          <v-text-field label="No Ktp" :error-messages="errors.name" :maxlength="max" :rules="[rules.ruleLength]"
                            v-model="pasien.no_ktp" placeholder="3210002xxx"  outlined dense small></v-text-field>
                        </v-col>
                        <v-col cols="12" class="pa-0 mr-2" sm="6" md="4">
                          <v-menu v-model="menu2" :close-on-content-click="false" :nudge-right="40"
                            transition="scale-transition" offset-y min-width="auto">
                            <template v-slot:activator="{ on, attrs }">
                              <v-text-field v-model="pasien.tgl_lahir" label="Tanggal Lahir" prepend-icon="mdi-calendar"
                                readonly v-bind="attrs" v-on="on" outlined dense></v-text-field>
                            </template>
                            <v-date-picker v-model="pasien.tgl_lahir" @input="menu2 = false"></v-date-picker>
                          </v-menu>
                        </v-col>
                        <v-col class="pa-0 mr-2" cols="12" sm="6">
                          <v-select :items="['laki-laki', 'perempuan']" :error-messages="errors.name"
                            :rules="[rules.required]" v-model="pasien.jenis_kelamin" label="Jenis kelamin" dense
                            outlined>
                          </v-select>
                        </v-col>
                        <v-col cols="12" class="pa-0" sm="12">
                          <v-text-field label="Pekerjaan" :error-messages="errors.name" :rules="[rules.required]"
                            v-model="pasien.pekerjaan" placeholder="Polisi" outlined dense small></v-text-field>
                        </v-col>
                        <v-col cols="12" class="pa-0 mr-2" sm="4">
                          <v-text-field label="No Telp/Hp" :error-messages="errors.name" :rules="[rules.mustNumber,rules.required]"
                            v-model="pasien.no_hp" placeholder="082xxxxxxxx" outlined dense small>
                          </v-text-field>
                        </v-col>
                        <v-col class="d-flex pa-0 mr-2" cols="12" sm="4">
                          <v-select :items="dokter.items" @input="changeID('dokter')" :error-messages="errors.name"
                            :rules="[rules.required]" v-model="pasien.dokter" label="Pilih Dokter" dense outlined>
                          </v-select>
                        </v-col>
                        <v-col class="d-flex pa-0" cols="12" sm="3">
                          <v-select :items="['BPJS', 'Umum']" :error-messages="errors.name" :rules="[rules.required]"
                            v-model="pasien.jenis_pembayaran" label="Jenis Pembayaran" dense outlined></v-select>
                        </v-col>
                        <v-col cols="12" class="pa-0" sm="12">
                          <v-textarea label="Alamat" :error-messages="errors.name" :rules="[rules.required]"
                            v-model="pasien.alamat" auto-grow outlined rows="1" row-height="15"></v-textarea>
                        </v-col>
                        <v-col cols="12" sm="12">
                          <v-btn class="mr-4" @click="selectStore"> submit </v-btn>
                          <v-btn @click="clear"> clear </v-btn>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-form>
                </v-container>
              </v-card>
              <confirmation-dialog :confirmationDialog="dialogConfirmation"
                :method="condition == 'store' ? store : update" @changeDialogState="dialogConfirmation.state = $event">
              </confirmation-dialog>
            </v-col>
            <v-col class="d-flex" cols="12" sm="4">
              <v-card>
                <v-container>
                  <v-row>
                    <v-col cols="12" class="mt-5" sm="12">
                      <p class="text-h6 text--primary">Daftar Antrian</p>
                    </v-col>
                    <v-col v-for="(item, index) in statusPasien.data " :key="item.nama" cols="12" sm="12"
                      class="pa-0">
                      <div class="ma-2  d-block pa-2 grey lighten-4 black--text">
                        {{ index + 1 }}.{{ item.nama }} 
                        <v-btn x-small @click="update(item)" class="float-end" color="red">
                          <v-icon x-small class="">far fa-trash</v-icon>
                        </v-btn>
                      </div>
                    </v-col>
                    <!--  -->
                  </v-row>
                </v-container>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </div>

    </v-main>
  </v-app>
</template>
<script>
import { ref } from "@vue/composition-api";
import { mdiMagnify, mdiBellOutline, mdiGithub } from "@mdi/js";
import FormDaftarPasien from "../../components/FormDaftarPasien.vue";

export default {
  props: {
    modules: [],
  },
  data() {
    const isDrawerOpen = ref(null);
    return {
      max: 16,
      _url: "",
      url: "",
      statusPasien: {
        items: [],
        data: {},
      },
      dokter: {
        items: [],
        data: {},
      },
      pasien: {
        tgl_lahir: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
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
      menu: false,
      modal: false,
      selectItem: ["10", "25", "50", "100"],
      errors: [],
      rules: {
        required: (v) => !!v || "Tolong isi form.",
        ruleLength : (v) => v.length > 15 || "harus 16 digit",
        mustNumber : v => (v.length > 0 && /^[0-9]+$/.test(v)) || "harus angka"
      },
    };
  },
  methods: {
    changeID(event) {
      if (event == "dokter") {
        let currentID = this.pasien.dokter_id;
        this.dokter.data.forEach((v) => {
          if (v.nama == currentID) {
            this.pasien.dokter_id = v.id;
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
        this.dialog.title = "Edit";
        this.showDialog(false);
      }
    },
    store() {
      let req = Object.assign(this.pasien, this.filter);
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
            this.clear();
            this.filterPage();
          }
        })
        .catch((e) => {
          this.errorState(e);
        });
    },
    update(data, item) {
      this.pasien = data;
      let req = Object.assign(this.pasien, this.filter);
      // console.log(req);      
      this.url = window.location.origin + "/api/v1/remove-status-pasien/";
      axios
        .post(`${this.url}${this.pasien.id}`, req)
        .then((response) => {
        // console.log(response); 
          if (response.status == 'success') {
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
          if (response.status == 'success') {
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
      this.pasien = {};
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
          if (response.status == 'success') {
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
            console.log(response);
            this.data.data = response.data.data;
            this.pasien.id = response.data.id;
            this.filter.page = response.data.data.current_page;
            this.web.isTableLoad = false;
            this.getCurrentUser();
          }
        })
        .catch((e) => {
          this.errorState(e);
        });
    },
    setStatusPasien() {
      axios.get(`/api/v1/status-pasien-antri/`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.statusPasien.items.push(v.nama);
          });
          this.statusPasien.data = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
   
    setSelectedDokter() {
      axios.get(`/api/v1/list-dokter/`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.dokter.items.push(v.name);
          });
          this.dokter.data = res.data.data;
        } else {
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
    this._url = window.location.origin + "/api/v1/daftar-pasien/";
    this.filterPage("");
    this.setSelectedDokter();
    // this.setStatusPasien();

    setInterval(() => {
      this.setStatusPasien();
    }, 30000);
    
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
        this.clear();
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