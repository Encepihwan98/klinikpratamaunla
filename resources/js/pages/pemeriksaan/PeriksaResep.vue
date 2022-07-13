<template>
  <v-app>
    <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen" :modules="modules"></vertical-nav-menu>
    <app-bar :isDrawerOpen="isDrawerOpen" :currentUser="currentUser" @updateNavbar="isDrawerOpen = $event"></app-bar>
    <v-main>
      <div class="app-content-container boxed-container pa-6">
        <v-container>
          <v-row>
            <v-col cols="12" sm="8">
              <v-card>
                <v-card-text>
                  <p class="text-h6 font-weight-bold">Data Pasien</p>
                </v-card-text>
                <v-conteiner>
                  <v-form v-model="valid" class="mx-2 my-2">
                    <v-container>
                      <v-row>
                        <v-col class="pa-0" cols="12" sm="12">
                          <v-text-field label="ID" placeholder="PS001" outlined dense small disabled></v-text-field>
                        </v-col>
                        <v-col class="pa-0 mr-6" cols="12" sm="6">
                          <v-text-field label="Nama" placeholder="Maman Abdul" outlined dense small></v-text-field>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="5">
                          <v-text-field label="Umur" placeholder="24" outlined dense small></v-text-field>
                        </v-col>
                        <v-col cols="12" class="pa-0 mb-5" sm="12">
                          <v-btn @click.stop="dialog = true" color="success">Lihat Riwayat Rekam Medis</v-btn>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-form>
                </v-conteiner>
              </v-card>
              <v-card>
                <v-card-text>
                  <p class="text-h6 font-weight-bold">
                    Rekam Medis Pasien <v-chip color="blue">P007</v-chip>
                  </p>
                </v-card-text>
                <v-conteiner>
                  <v-form v-model="valid" class="mx-2 my-2">
                    <v-container>
                      <v-row>
                        <v-col class="pa-0 mr-6" cols="12" sm="6">
                          <v-text-field label="Berat Badan" suffix="Kg" outlined dense small>
                          </v-text-field>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="5">
                          <v-text-field label="Tensi Darah" suffix="mmHg" outlined dense small>
                          </v-text-field>
                        </v-col>
                        <v-col class="pa-0 mr-6" cols="12" sm="6">
                          <v-text-field label="Tinggi Badan" suffix="Cm" outlined dense small>
                          </v-text-field>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="5">
                          <v-select :items="['Ya', 'Tidak']" label="Buta Warna" dense outlined></v-select>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="12">
                          <v-textarea label="Keluhan" auto-grow outlined rows="1" row-height="15"></v-textarea>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="12">
                          <v-textarea label="Anamnesis" auto-grow outlined rows="1" row-height="15"></v-textarea>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="12">
                          <v-textarea label="Diagnosa" auto-grow outlined rows="1" row-height="15"></v-textarea>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="12">
                          <v-textarea label="Tindakan" auto-grow outlined rows="1" row-height="15"></v-textarea>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="12">
                          <v-textarea label="Keterangan" auto-grow outlined rows="1" row-height="15"></v-textarea>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-form>
                </v-conteiner>
              </v-card>
            </v-col>
            <v-col cols="12" sm="4">
              <v-card>
                <v-card-text>
                  <p class="text-h6 font-weight-bold">
                    Isi Resep
                    <v-chip class="float-end mt-2" small color="blue">1</v-chip>
                  </p>
                </v-card-text>
                <v-conteiner>
                  <v-row class="mx-2 mb-5">
                    <v-col cols="12" sm="12">
                      <v-form>
                        <v-container>
                          <v-row>
                            <v-col class="pa-0 mr-2" cols="12" sm="6">
                              <v-select :items="['Ya', 'Tidak']" label="Alergi Obat" dense outlined></v-select>
                            </v-col>
                            <v-col class="pa-0 " cols="12" sm="5">
                              <v-text-field label="" outlined dense small></v-text-field>
                            </v-col>
                            <v-col class="pa-0" cols="12" sm="12">
                              <p>Obat 1</p>
                            </v-col>
                            <v-col class="pa-0 mr-2" cols="12" sm="6">
                              <v-autocomplete :items="['inza', 'bodrex', 'komik']" label="Pilih Obat" outlined dense
                                hide-no-data flat item-text="name" item-value="name">
                              </v-autocomplete>
                            </v-col>
                            <v-col class="pa-0" cols="12" sm="5">
                              <v-text-field label="Jumlah" outlined dense small>
                              </v-text-field>
                            </v-col>
                            <v-col class="pa-0" cols="12" sm="12">
                              <v-text-field label="aturan" outlined dense small>
                              </v-text-field>
                            </v-col>
                            <v-col cols="12" sm="3">
                              <v-btn color="red" small>
                                <v-icon small>far fa-plus</v-icon>
                              </v-btn>
                            </v-col>
                            <v-col cols="12" sm="8">
                              <v-btn small color="primary">
                                Simpan
                              </v-btn>
                            </v-col>
                          </v-row>
                        </v-container>
                      </v-form>
                    </v-col>
                  </v-row>
                </v-conteiner>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </div>
      <div>
        <v-dialog v-model="dialog" persistent max-width="550px">
          <v-card>
            <v-card-title class="text-h5"> Riwayat Rekam Medis </v-card-title>
            <hr>
            <v-container>
              <v-row class="mx-2">
                <v-simple-table>
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th class="text-left">
                          Tanggal Periksa
                        </th>
                        <th class="text-left">
                          Hasil Rekam Medis
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>2022-09-02</td>
                        <td>ini rekam medis ini rekam medis ini rekam medis ini rekam medis </td>
                      </tr>
                    </tbody>
                  </template>
                </v-simple-table>
              </v-row>
            </v-container>
            <v-col cols="12" sm="12">
              <v-btn @click="dialog = false" dense small> close </v-btn>
            </v-col>
          </v-card>
        </v-dialog>
      </div>
    </v-main>
  </v-app>
</template>

<script>
export default {
  props: {
    modules: [],
  },
  data() {
    return {
      _url: "",
      web: {
        isTableLoad: false,
        filterOpen: false,
      },
      filter: {
        page: 1,
        searchQuery: "",
        limit: 10,
        sortBy: "id",
        orderBy: "asc",
        role: [],
      },
      isDrawerOpen: true,
      data: {
        data: [],
        current_page: 1,
      },
      module: {
        create: [],
        read: [],
        update: [],
        delete: [],
        print: [],
        is_all: [],
      },
      newModule: {},
      errors: {
        role: [],
      },
      roles: [],
      currentData: {},
      currentUser: {},
      dialog: false,
      dialogConfirmation: {
        state: false,
        message: null,
      },
      condition: "store",
      selectItem: ["10", "25", "50", "100"],
    };
  },
  methods: {
    selectMethod(data, item) {
      this.currentData = data;
      if (item == "delete") {
        this.condition = item;
        this.dialogConfirmation.message = "menghapus";
        this.showDialog(true);
      } else if (item == "status") {
        this.condition = item;
        this.dialogConfirmation.message = "mengubah";
        this.showDialog(true);
      } else if (item == "add") {
        this.currentData = null;
        this.condition = "store";
        this.dialog.title = "Tambah Menu";
        this.showDialog(false);
      } else if (item == "show") {
        this.condition = "show";
        this.dialog.title = "Data Menu";
        this.showDialog(false);
      } else if (item == "edit") {
        this.condition = "update";
        this.dialog.title = "Edit Menu";
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
    filterPage(sort_by) {
      this.web.isTableLoad = true;
      if (sort_by) {
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
        "&role=" +
        this.module.role;
      axios
        .get(url)
        .then((response) => {
          if (response.status == 200) {
            this.clearModules();
            this.data.data = response.data.data;
            response.data.data.forEach((v) => {
              let activeAll = v.id;
              if (v.is_home) {
                this.module.is_home = v.id;
                this.module.is_home_old = v.id;
              }
              if (v.create) this.module.create.push(v.id);
              else activeAll = 0;
              if (v.read) this.module.read.push(v.id);
              else activeAll = 0;
              if (v.update) this.module.update.push(v.id);
              else activeAll = 0;
              if (v.delete) this.module.delete.push(v.id);
              else activeAll = 0;
              if (v.print) this.module.print.push(v.id);
              else activeAll = 0;

              this.module.is_all.push(activeAll);
            });
            if (!this.module.role) this.clearModules();
            this.filter.page = response.data.data.current_page;
            this.web.isTableLoad = false;
            this.currentUser = this.requestCurrentUser();
            if (!this.roles || this.roles < 1) {
              this.roles = this.requestRole();
            }
          }
        })
        .catch((e) => {
          this.errorState(e);
        });
    },
    clearModules() {
      this.$delete(this.module, "is_home");
      this.module.is_home_old = 0;
      this.module.create = [];
      this.module.read = [];
      this.module.update = [];
      this.module.delete = [];
      this.module.print = [];
      this.module.is_all = [];
    },
    errorState(e) {
      console.log(e);
      this.web.isTableLoad = false;
      //   this.errors = e.response.data.errors;
      if (e.response.status == 401) {
        localStorage.removeItem("token");
        this._token = "";
        this.$router.push({ name: "index" });
      } else {
        this.errorRequestState(e);
      }
    },
    changeData(newdata) {
      this.data = newdata;
    },
  },

  watch: {
    modules: function (n, o) {
      let access = this.redirectIfNotHaveAccess(n, this.$route.path);
      if (Object.keys(access).length === 1 && access.constructor === Object) {
        this.$router.push({ name: access.home });
      } else {
        this.web = access;
        n.forEach((v) => {
          if (v.url != "#") this.data.data.push(v);
        });
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
