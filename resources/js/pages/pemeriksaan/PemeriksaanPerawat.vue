<template>
    <v-app>
      <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen" :modules="modules"></vertical-nav-menu>
      <app-bar :isDrawerOpen="isDrawerOpen" :currentUser="currentUser" @updateNavbar="isDrawerOpen = $event"></app-bar>
      <v-main>
        <div class="app-content-container boxed-container pa-6">
          <v-container>
            <v-row>
              <v-col cols="12" sm="4">
                <v-card>
                  <v-card-text>
                    <p class="text-h6 font-weight-bold">
                      Daftar Antrian Pasien
                      <v-chip class="float-end mt-2" small color="red">1</v-chip>
                    </p>
  
                  </v-card-text>
                  <v-container>
                    <v-row class="mx-2 mb-5">
                      <v-col v-for="(item, index) in status.periksa.data" :key="item.nama" cols="12" sm="12" class="pa-0">
                        <div class="ma-2 d-block pa-2 grey lighten-4 black--text">
                          {{index + 1}} {{item.nama}}
                          <v-btn :to="{ name: 'pemeriksaan-pasien-perawat', params: { id: item.id } }" x-small class="float-end" color="green">
                            periksa
                          </v-btn>
                        </div>
                      </v-col>
                      <!-- <v-col cols="12" sm="12" class="pa-0">
                        <div class="ma-2 d-block pa-2 grey lighten-4 black--text">
                          maman 2
                          <v-btn x-small class="float-end" color="green">
                            periksa
                          </v-btn>
                        </div>
                      </v-col> -->
                    </v-row>
                  </v-container>
                </v-card>
              </v-col>
              <v-col cols="12" sm="4">
                <v-card>
                  <v-card-text>
                    <p class="text-h6 font-weight-bold">
                      Pasien Sudah Diperiksa
                      <v-chip class="float-end mt-2" small color="green">1</v-chip>
                    </p>
                  </v-card-text>
                  <v-container>
                    <v-row class="mx-2 mb-5">
                      <v-col v-for="(item, index) in status.selesai.data" :key="item.nama" cols="12" sm="12" class="pa-0">
                        <div class="ma-2 d-block pa-2 grey lighten-4 black--text">
                          {{index + 1}} {{item.nama}}
                          <!-- <p class="float-end" color="green">
                            (1 second ago)
                          </p> -->
                        </div>
                      </v-col>
                      <!-- <v-col cols="12" sm="12" class="pa-0">
                        <div class="ma-2 d-block pa-2 grey lighten-4 black--text">
                          maman
                          <p class="float-end" color="green">
                            (1 second ago)
                          </p>
                        </div>
                      </v-col> -->
                    </v-row>
                  </v-container>
                </v-card>
              </v-col>
              <v-col cols="12" sm="4">
                <v-card>
                  <v-card-text>
                    <p class="text-h6 font-weight-bold">
                      Daftar Pasien Hari ini
                      <v-chip class="float-end mt-2" small color="blue">1</v-chip>
                    </p>
                  </v-card-text>
                  <v-container>
                    <v-row class="mx-2 mb-5">
                      <v-col v-for="(item, index) in status.data" :key="item.nama" cols="12" sm="12" class="pa-0">
                        <div class="ma-2 d-block pa-2  grey lighten-4 black--text">
                          {{index + 1}} {{item.nama}}
                          <v-btn x-small class="float-end" color="red">
                            {{item.status}}
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
  export default {
    props: {
      modules: [],
    },
    data() {
      return {
        _url: "",
        status: {
          periksa: {
            items: [],
            data: {}
          },
          selesai: {
            items: [],
            data: {},
          },
          items: [],
          data: {},
        },
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
      };
    },
    methods: {
      setStatusPasien() {
        axios.get(`/api/v1/status-pasien/`).then((res) => {
          if (res.status === 200) {
            this.status.data = res.data.data;
          } else {
            this.makeDefaultNotification(
              response.data.status,
              response.data.message
            );
          }
        });
      },
      setStatusPasienAntri() {
        axios.get(`/api/v1/status-pasien-antri/`).then((res) => {
          if (res.status === 200) {
            this.status.periksa.data = res.data.data;
          } else {
            this.makeDefaultNotification(
              response.data.status,
              response.data.message
            );
          }
        });
      },
      setStatusPasienSelesai() {
        axios.get(`/api/v1/status-pasien-selesai/`).then((res) => {
          if (res.status === 200) {
            this.status.selesai.data = res.data.data;
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
        // console.log(e);
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
      this.setStatusPasien();
      this.setStatusPasienAntri();
      this.setStatusPasienSelesai();
  
      setInterval(() => {
        this.setStatusPasien(), this.setStatusPasienAntri(), this.setStatusPasienSelesai();
      }, 30000);
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
  