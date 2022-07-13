<template>
  <v-app>
    <vertical-nav-menu
      :is-drawer-open.sync="isDrawerOpen"
      :modules="modules"
    ></vertical-nav-menu>
    <app-bar></app-bar>
    <v-main>
      <div class="app-content-container pa-6">
        <v-row>
          <v-col cols="12" sm="4">
            <v-card>
              <v-container>
                <p class="font-weight-bold">
                  <v-icon small>far fa-edit</v-icon>Total Pasien
                </p>
                <p class="text-h3">2</p>
              </v-container>
            </v-card>
          </v-col>
          <v-col cols="12" sm="4">
            <v-card>
              <v-container>
                <p class="font-weight-bold">
                  <v-icon small>far fa-edit</v-icon>Pasien Bulan Ini
                </p>
                <p class="text-h3">2</p>
              </v-container>
            </v-card>
          </v-col>
          <v-col cols="12" sm="4">
            <v-card>
              <v-container>
                <p class="font-weight-bold">Pasien Hari ini</p>
                <p class="text-h3">2</p>
              </v-container>
            </v-card>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="12">
            <v-card>
              <v-row>
                <v-col class="d-flex" cols="12" sm="2">
                  <v-select
                    v-model="filter.limit"
                    dense
                    :items="['1', '2', '3', '4']"
                    label="Tampilkan"
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
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-simple-table dense>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-left">No</th>
                      <th class="text-left">ID</th>
                      <th class="text-left">Name</th>
                      <th class="text-left">Alamat</th>
                      <th class="text-left">Tgl Periksa</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>P001</td>
                      <td>Maman</td>
                      <td>Jl Buah batu</td>
                      <td>25-01-2022</td>
                      <td class="center-center">
                        <v-btn small @click.stop="dialog1 = true">
                          <v-icon small>far fa-edit</v-icon>
                        </v-btn>
                        <v-btn small>
                          <v-icon small>far fa-trash</v-icon>
                        </v-btn>
                        <v-btn small @click.stop="dialog = true">
                          <v-icon small>far fa-plus</v-icon>
                        </v-btn>
                      </td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
            </v-card>
          </v-col>
        </v-row>
      </div>
      <div>
        <v-dialog v-model="dialog1" persistent max-width="600px">
          <v-card>
            <v-card-title class="text-h5"> Edit Data </v-card-title>

            <form class="mx-3 my-3">
              <v-container>
                <v-row>
                  <v-col class="pa-0" cols="12" sm="12">
                    <v-text-field
                      label="ID"
                      placeholder="PS001"
                      outlined
                      dense
                      small
                      disabled
                    ></v-text-field>
                  </v-col>
                  <v-col class="pa-0" cols="12" sm="12">
                    <v-text-field
                      label="Nama"
                      placeholder="Maman Abdul"
                      outlined
                      dense
                      small
                    ></v-text-field>
                  </v-col>
                  <v-col class="pa-0" cols="12" sm="12">
                    <v-text-field
                      label="No Ktp"
                      placeholder="088686xxxx"
                      outlined
                      dense
                      small
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" class="pa-0 mr-2" sm="6" md="4">
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
                          v-model="date"
                          label="Picker without buttons"
                          prepend-icon="mdi-calendar"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                          outlined
                          dense
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="date"
                        @input="menu2 = false"
                      ></v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col class="pa-0 mr-2" cols="12" sm="6">
                    <v-select
                      :items="items"
                      label="Jenis kelamin"
                      dense
                      outlined
                    ></v-select>
                  </v-col>
                  <v-col cols="12" class="pa-0" sm="12">
                    <v-text-field
                      label="Pekerjaan"
                      placeholder="Polisi"
                      outlined
                      dense
                      small
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" class="pa-0 mr-2" sm="4">
                    <v-text-field
                      label="No Telp/Hp"
                      placeholder="082xxxxxxxx"
                      outlined
                      dense
                      small
                    ></v-text-field>
                  </v-col>
                  <v-col class="d-flex pa-0" cols="12" sm="4">
                    <v-select
                      :items="dokter"
                      label="Pilih Dokter"
                      dense
                      outlined
                    ></v-select>
                  </v-col>
                  <v-col cols="12" class="pa-0" sm="12">
                    <v-textarea
                      label="Alamat"
                      auto-grow
                      outlined
                      rows="1"
                      row-height="15"
                    ></v-textarea>
                  </v-col>
                  <v-col cols="12" sm="12">
                    <v-btn class="mr-4" @click="submit"> Submit </v-btn>
                    <v-btn @click="dialog1 = false"> Close </v-btn>
                  </v-col>
                </v-row>
              </v-container>
            </form>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialog" persistent max-width="500px">
          <v-card>
            <v-card-title class="text-h5"> Edit Data </v-card-title>

            <form class="mx-3 my-3 mb-2">
              <v-container>
                <v-row>
                  <v-col class="pa-0" cols="12" sm="12">
                    <v-text-field
                      label="ID Pasien"
                      placeholder="PS001"
                      outlined
                      dense
                      small
                      disabled
                    ></v-text-field>
                  </v-col>
                  <v-col class="pa-0" cols="12" sm="12">
                    <v-text-field
                      label="Nama Pasien"
                      placeholder="nama"
                      outlined
                      dense
                      small
                      disabled
                    ></v-text-field>
                  </v-col>
                  <v-col class="d-flex pa-0" cols="12" sm="12">
                    <v-select
                      :items="dokter"
                      label="Pilih Dokter"
                      dense
                      outlined
                    ></v-select>
                  </v-col>
                  <v-col class="mb-2" cols="12" sm="12">
                    <v-btn class="mr-4" @click="submit">
                      Tambah Ke antrian
                    </v-btn>
                    <v-btn @click="dialog = false"> close </v-btn>
                  </v-col>
                </v-row>
              </v-container>
            </form>
          </v-card>
        </v-dialog>
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
      dialog: false,
      dialog1: false,
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
      // dialog: {
      //   state: false,
      //   title: null,
      // },
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