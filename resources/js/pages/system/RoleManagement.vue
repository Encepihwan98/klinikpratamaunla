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
                <v-col class="d-flex" cols="6" md="6" sm="6">
                  <p class="text-h5 text--primary">Manajemen Role</p>
                </v-col>

                <v-col class="d-flex" cols="6" md="6" sm="6">
                  <v-btn
                    v-if="web.create"
                    color="primary ml-auto"
                    small
                    elevation="2"
                    @click="selectMethod(null, 'add')"
                    >Tambah Roles</v-btn>
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

                <v-col class="d-flex" cols="12" sm="6">
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
            </v-container>
          </v-card-title>
          <v-card-text>
            <v-simple-table fixed-header>
              <template v-slot:default>
                <thead>
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
                    <th class="text-left">
                      Nama
                      <v-icon @click="filterPage('name')" x-small>{{
                        filter.sortBy == "name"
                          ? filter.orderBy == "asc"
                            ? "fas fa-sort-amount-up"
                            : "fas fa-sort-amount-down"
                          : "fas fa-sort-alt"
                      }}</v-icon>
                    </th>
                    <th class="text-left">
                      Keterangan
                      <v-icon @click="filterPage('description')" x-small>{{
                        filter.sortBy == "description"
                          ? filter.orderBy == "asc"
                            ? "fas fa-sort-amount-up"
                            : "fas fa-sort-amount-down"
                          : "fas fa-sort-alt"
                      }}</v-icon>
                    </th>
                    <th class="text-left">Aksi</th>
                  </tr>
                </thead>
                <tbody v-if="data.data.length > 0 && web.isTableLoad == false">
                  <tr v-for="(item, index) in data.data" :key="item.name">
                    <td>{{ index + data.from }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.description }}</td>
                    <td>
                      <v-btn small @click="selectMethod(item, 'show')">
                        <v-icon small>far fa-eye</v-icon>
                      </v-btn>
                      <v-btn
                        small
                        @click="selectMethod(item, 'edit')"
                        v-if="web.update"
                      >
                        <v-icon small>far fa-edit</v-icon>
                      </v-btn>
                      <v-btn
                        small
                        @click="selectMethod(item, 'delete')"
                        v-if="web.delete"
                      >
                        <v-icon small>far fa-trash</v-icon>
                      </v-btn>
                    </td>
                  </tr>
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
          </v-card-text>
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
      <form-dialog-role
        :dialog="dialog"
        :currentData="currentData"
        :condition="condition"
        :filter="filter"
        @updateDialog="dialog.state = $event"
        @updateData="changeData($event)"
      ></form-dialog-role>

      <confirmation-dialog
        :confirmationDialog="dialogConfirmation"
        :method="remove"
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
      condition: "store",
      selectItem: ["10", "25", "50", "100"],
    };
  },
  methods: {
    remove() {
      this.web.isTableLoad = true;
      axios
        .delete(`${this._url}${this.currentData.uuid}`, { data: this.filter })
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
            this.currentUser = this.requestCurrentUser();
          }
        })
        .catch((e) => {
          this.errorState(e);
        });
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
  created() {
    if (this.modules.length > 0) {
      let access = this.redirectIfNotHaveAccess(this.modules, this.$route.path);
      if (Object.keys(access).length === 1 && access.constructor === Object) {
        this.$router.push({ name: access.home });
      } else {
        this.web = access;
      }
    }
    this._url = window.location.origin + "/api/v1/roles/";
    this.filterPage("");
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
