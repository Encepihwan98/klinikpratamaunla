<template>
  <v-app>
    <vertical-nav-menu
      :is-drawer-open.sync="isDrawerOpen"
      :modules="modules"
    ></vertical-nav-menu>
    <app-bar
      :isDrawerOpen="isDrawerOpen"
      :currentUser="currentUser"
      @updateNavbar="isDrawerOpen = $event"
    ></app-bar>
    <v-main>
      <div class="app-content-container boxed-container pa-6">
        <v-card class="mx-auto">
          <v-card-title>
            <v-container fluid>
              <v-row align="center">
                <v-col class="d-flex" cols="12" md="12" sm="12">
                  <p class="text-h5 text--primary">Manajemen Menu</p>
                </v-col>

                <v-col class="d-flex" cols="6" sm="3" md="2">
                  <v-select
                    v-model="filter.limit"
                    dense
                    :items="selectItem"
                    label="Tampilkan"
                    @input="filterPage('')"
                    outlined
                  ></v-select>
                </v-col>

                <v-col class="d-flex" cols="6" sm="3" md="2">
                  <v-select
                    v-model="module.role"
                    dense
                    :items="roles"
                    :error-messages="errors.role"
                    @input="filterPage('')"
                    label="Role"
                    outlined
                  ></v-select>
                </v-col>

                <v-col class="d-flex" cols="12" sm="6" md="6">
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

                <v-col class="d-flex mb-auto ml-auto" cols="12" sm="1" md="1">
                  <v-btn
                    :loading="web.filterOpen"
                    :disabled="web.filterOpen"
                    color="primary"
                    small
                    @click="web.filterOpen = !web.filterOpen"
                  >
                    <v-icon small dark> far fa-filter </v-icon>
                  </v-btn>
                </v-col>
              </v-row>
            </v-container>
          </v-card-title>
          <v-card-text>
            <v-simple-table fixed-header>
              <template v-slot:default>
                <thead>
                  <tr>
                    <th rowspan="2" class="text-left">
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
                    <th rowspan="2" class="text-left">
                      Title
                      <v-icon @click="filterPage('name')" x-small>{{
                        filter.sortBy == "name"
                          ? filter.orderBy == "asc"
                            ? "fas fa-sort-amount-up"
                            : "fas fa-sort-amount-down"
                          : "fas fa-sort-alt"
                      }}</v-icon>
                    </th>
                    <th rowspan="2" class="text-left">
                      Url
                      <v-icon @click="filterPage('url')" x-small>{{
                        filter.sortBy == "url"
                          ? filter.orderBy == "asc"
                            ? "fas fa-sort-amount-up"
                            : "fas fa-sort-amount-down"
                          : "fas fa-sort-alt"
                      }}</v-icon>
                    </th>
                    <th rowspan="2" class="text-center">Home</th>
                    <th rowspan="2" class="text-center">
                      Aktifkan Semua Akses
                    </th>
                    <th colspan="5" class="text-center">Akses</th>
                  </tr>
                  <tr>
                    <th class="text-left">Create</th>
                    <th class="text-left">Read</th>
                    <th class="text-left">Update</th>
                    <th class="text-left">Delete</th>
                    <th class="text-left">Print</th>
                  </tr>
                </thead>
                <tbody v-if="data.data.length > 0 && web.isTableLoad == false">
                  <tr v-for="(item, index) in data.data" :key="item.name">
                    <td>{{ index + 1 }}</td>
                    <td>
                      {{ item.name }}
                    </td>
                    <td>{{ item.url }}</td>
                    <td class="text-center">
                      <v-checkbox
                        v-if="web.update"
                        v-model="module.is_home"
                        :value="item.id"
                        @click="active(item.id, 'is_home')"
                      ></v-checkbox>
                    </td>
                    <td class="mx-auto">
                      <v-checkbox
                        v-if="web.update"
                        v-model="module.is_all"
                        :value="item.id"
                        @click="active(item.id, 'is_all')"
                      ></v-checkbox>
                    </td>
                    <td>
                      <v-checkbox
                        v-if="web.update"
                        v-model="module.create"
                        :value="item.id"
                        @click="active(item.id, 'create')"
                      ></v-checkbox>
                    </td>
                    <td>
                      <v-checkbox
                        v-if="web.update"
                        v-model="module.read"
                        :value="item.id"
                        @click="active(item.id, 'read')"
                      ></v-checkbox>
                    </td>
                    <td>
                      <v-checkbox
                        v-if="web.update"
                        v-model="module.update"
                        :value="item.id"
                        @click="active(item.id, 'update')"
                      ></v-checkbox>
                    </td>
                    <td>
                      <v-checkbox
                        v-if="web.update"
                        v-model="module.delete"
                        :value="item.id"
                        @click="active(item.id, 'delete')"
                      ></v-checkbox>
                    </td>
                    <td>
                      <v-checkbox
                        v-if="web.update"
                        v-model="module.print"
                        :value="item.id"
                        @click="active(item.id, 'print')"
                      ></v-checkbox>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else-if="web.isTableLoad == true" class="text-center">
                  <tr>
                    <td colspan="8">
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
                    <td colspan="8">Data Kosong!</td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </v-card-text>
          <v-card-actions class="d-flex justify-center">
            <v-pagination
              v-model="filter.page"
              :length="data.last_page"
              :total-visible="7"
              @input="filterPage('')"
            ></v-pagination>
          </v-card-actions>
          <v-navigation-drawer
            v-model="web.filterOpen"
            absolute
            temporary
            right
          >
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title class="text-center text-h6">
                  Filter
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-container fluid>
              <v-autocomplete
                class="ma-2"
                v-model="filter.role"
                outlined
                dense
                small-chips
                label="Roles"
                @input="filterPage('')"
                :items="roles"
              ></v-autocomplete>
            </v-container>
          </v-navigation-drawer>
        </v-card>
      </div>
      <form-dialog-menu
        :dialog="dialog"
        :currentData="currentData"
        :condition="condition"
        :roles="roles"
        :filter="filter"
        :parentData="data.parentData"
        :parentName="data.parentName"
        @updateDialog="dialog.state = $event"
        @updateData="changeData($event)"
      ></form-dialog-menu>

      <confirmation-dialog
        :confirmationDialog="dialogConfirmation"
        :method="condition == 'delete' ? remove : active"
        @changeDialogState="dialogConfirmation.state = $event"
      ></confirmation-dialog>
    </v-main>
    <footer></footer>
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
    active(id, event) {
      if (this.module.role) {
        this.errors = {};
        this.newModule = {};
        this.newModule.role = this.module.role;
        this.newModule.state = event;

        if (event == "is_home") {
          let home = this.module.is_home;
          this.$delete(this.module, "is_home");
          this.module.is_home = home;
          this.newModule.is_home = home;
          this.newModule.is_home_old = this.module.is_home_old;
        }
        if (event == "is_all") {
          this.newModule["id"] = id;
          this.newModule["status"] =
            this.module.create.indexOf(id) > -1 &&
            this.module.read.indexOf(id) > -1 &&
            this.module.update.indexOf(id) > -1 &&
            this.module.delete.indexOf(id) > -1 &&
            this.module.print.indexOf(id) > -1;
        }
        if (event == "create") {
          this.newModule.create = {
            id: id,
            status: this.module.create.indexOf(id) > -1,
          };
        }
        if (event == "read") {
          this.newModule.read = {
            id: id,
            status: this.module.read.indexOf(id) > -1,
          };
        }
        if (event == "update") {
          this.newModule.update = {
            id: id,
            status: this.module.update.indexOf(id) > -1,
          };
        }
        if (event == "delete") {
          this.newModule.delete = {
            id: id,
            status: this.module.delete.indexOf(id) > -1,
          };
        }
        if (event == "print") {
          this.newModule.print = {
            id: id,
            status: this.module.print.indexOf(id) > -1,
          };
        }
        axios
          .post(`${this._url}`, this.newModule)
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
              this.web.isTableLoad = false;
              this.filter.page = response.data.data.current_page;
              this.makeDefaultNotification(
                response.data.status,
                response.data.message
              );
            }
            this.web.isTableLoad = false;
          })
          .catch((e) => {
            this.errorState(e);
          });
      } else {
        this.clearModules();
        this.errors.role.push("Tolong pilih role terlebih dahulu");
        this.makeDefaultNotification(
          "error",
          "Tolong pilih role terlebih dahulu"
        );
      }
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
              this.roles = this.requestRole()
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
  created() {
    if (this.modules.length > 0) {
      let access = this.redirectIfNotHaveAccess(this.modules, this.$route.path);
      if (Object.keys(access).length === 1 && access.constructor === Object) {
        this.$router.push({ name: access.home });
      } else {
        this.web = access;
      }
    }
    this._url = window.location.origin + "/api/v1/r-modules/";
    this.filterPage("");
    this.modules.forEach((v) => {
      if (v.url != "#") this.data.data.push(v);
    });
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
