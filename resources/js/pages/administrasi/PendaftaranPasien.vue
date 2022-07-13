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
                  <v-form v-model="valid">
                    <v-container>
                      <v-row>
                        <v-col cols="12" sm="12">
                          <p class="text-h6 text--primary">Data Pasien</p>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="12">
                          <v-text-field label="ID" placeholder="PS001" outlined dense small disabled></v-text-field>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="12">
                          <v-text-field label="Nama" placeholder="Maman Abdul" outlined dense small></v-text-field>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="12">
                          <v-text-field label="No Ktp" placeholder="088686xxxx" outlined dense small></v-text-field>
                        </v-col>
                        <v-col cols="12" class="pa-0 mr-2" sm="6" md="4">
                          <v-menu v-model="menu2" :close-on-content-click="false" :nudge-right="40"
                            transition="scale-transition" offset-y min-width="auto">
                            <template v-slot:activator="{ on, attrs }">
                              <v-text-field v-model="date" label="Picker without buttons" prepend-icon="mdi-calendar"
                                readonly v-bind="attrs" v-on="on" outlined dense></v-text-field>
                            </template>
                            <v-date-picker v-model="date" @input="menu2 = false"></v-date-picker>
                          </v-menu>
                        </v-col>
                        <v-col class="pa-0 mr-2" cols="12" sm="6">
                          <v-select :items="items" label="Jenis kelamin" dense outlined></v-select>
                        </v-col>
                        <v-col cols="12" class="pa-0" sm="12">
                          <v-text-field label="Pekerjaan" placeholder="Polisi" outlined dense small></v-text-field>
                        </v-col>
                        <v-col cols="12" class="pa-0 mr-2" sm="4">
                          <v-text-field label="No Telp/Hp" placeholder="082xxxxxxxx" outlined dense small>
                          </v-text-field>
                        </v-col>
                        <v-col class="d-flex pa-0" cols="12" sm="4">
                          <v-select :items="dokter" label="Pilih Dokter" dense outlined></v-select>
                        </v-col>
                        <v-col cols="12" class="pa-0" sm="12">
                          <v-textarea label="Alamat" auto-grow outlined rows="1" row-height="15"></v-textarea>
                        </v-col>
                        <v-col cols="12" sm="12">
                          <v-btn class="mr-4" @click="submit"> submit </v-btn>
                          <v-btn @click="clear"> clear </v-btn>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-form>
                </v-container>
              </v-card>
            </v-col>
            <v-col class="d-flex" cols="12" sm="4">
              <v-card>
                <v-container>
                  <v-row>
                    <v-col cols="12" class="mt-5" sm="12">
                      <p class="text-h6 text--primary">Daftar Antrian</p>
                    </v-col>
                    <v-col cols="12" sm="12" class="pa-0">
                      <div class="ma-2  d-block pa-2 grey lighten-4 black--text">
                        maman
                        <v-btn x-small class="float-end" color="red">
                          <v-icon x-small class="">far fa-trash</v-icon>
                        </v-btn>
                      </div>
                    </v-col>
                    <v-col cols="12" sm="12" class="pa-0">
                      <div class="ma-2  d-block pa-2 grey lighten-4 black--text">
                        maman
                        <v-btn x-small class="float-end" color="red">
                          <v-icon x-small class="">far fa-trash</v-icon>
                        </v-btn>
                      </div>
                    </v-col>
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
  components: { FormDaftarPasien },
  props: {
    modules: [],
  },
  data() {
    return {
      _url: "",
      web: {
        isTableLoad: false,
      },
      filter: {
        page: 1,
        searchQuery: "",
        limit: 25,
        sortBy: "id",
        orderBy: "asc",
      },
      isDrawerOpen: true,
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
      items: ["Pria", "Wanita"],
      dokter: ["Ahmad", "Anggun"],
      date: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
        .toISOString()
        .substr(0, 10),
      menu: false,
      modal: false,
      menu2: false,
      condition: "store",
      selectItem: ["10", "25", "50", "100"],
    };
  },
  computed: {
    computedDateFormatted() {
      return this.formatDate(this.date);
    },
  },
  methods: {
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
    formatDate(date) {
      if (!date) return null;

      const [year, month, day] = date.split("-");
      return `${month}/${day}/${year}`;
    },
    parseDate(date) {
      if (!date) return null;

      const [month, day, year] = date.split("/");
      return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
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
        this.dialog.title = "Tambah Pasien";
        this.showDialog(false);
      } else if (item == "show") {
        this.condition = "show";
        this.dialog.title = "Data Pasien";
        this.showDialog(false);
      } else if (item == "edit") {
        this.condition = "update";
        this.dialog.title = "Edit Pasien";
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

    changeData(newdata) {
      this.data = newdata;
    },
    errorState(e) {
      console.log(e.response);
      this.web.isTableLoad = false;
      this.errors = e.response.data.errors;
      if (e.response.status == 401) {
        localStorage.removeItem("token");
        this._token = "";
        this.$router.push({ name: "index" });
      } else {
        this.errorRequestState(e);
      }
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