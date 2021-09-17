<template>
  <v-app>
    <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen"></vertical-nav-menu>
    <app-bar
      :isDrawerOpen="isDrawerOpen"
      @updateNavbar="isDrawerOpen = $event"
    ></app-bar>
    <v-main>
      <div class="app-content-container boxed-container pa-6">
        <v-card class="mx-auto">
          <v-card-title>
            <v-container fluid>
              <v-row align="center">
                <v-col class="d-flex" cols="6" md="6" sm="6">
                  <p class="text-h5 text--primary">Manajemen User</p>
                </v-col>

                <v-col class="d-flex" cols="6" md="6" sm="6">
                  <v-btn
                    color="primary ml-auto"
                    small
                    elevation="2"
                    @click="add"
                    >Tambah User</v-btn
                  >
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
                      Username
                      <v-icon @click="filterPage('username')" x-small>{{
                        filter.sortBy == "username"
                          ? filter.orderBy == "asc"
                            ? "fas fa-sort-amount-up"
                            : "fas fa-sort-amount-down"
                          : "fas fa-sort-alt"
                      }}</v-icon>
                    </th>
                    <th class="text-left">Terakhir login</th>
                    <th class="text-left">Aksi</th>
                  </tr>
                </thead>
                <tbody v-if="data.data.length > 0 && web.isTableLoad == false">
                  <tr v-for="(item, index) in data.data" :key="item.name">
                    <td>{{ index + data.from }}</td>
                    <td>
                      {{ item.name }} <br />
                      <br />
                      <v-chip
                        small
                        v-for="role in item.roles"
                        :key="role"
                        color="primary"
                      >
                        {{ role }}
                      </v-chip>
                    </td>
                    <td>{{ item.username }}</td>
                    <td>{{ item.description }}</td>
                    <td>
                      <v-btn small @click="selectMethod(item, 'status')">
                        <v-icon small>{{
                          item.status == 1 ? "far fa-check" : "far fa-times"
                        }}</v-icon>
                      </v-btn>
                      <v-btn small @click="show(item)">
                        <v-icon small>far fa-eye</v-icon>
                      </v-btn>
                      <v-btn small @click="edit(item)">
                        <v-icon small>far fa-edit</v-icon>
                      </v-btn>
                      <v-btn small @click="selectMethod(item, 'delete')">
                        <v-icon small>far fa-trash</v-icon>
                      </v-btn>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else-if="web.isTableLoad == true" class="text-center">
                  <tr>
                    <td colspan="5">
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
                    <td colspan="5">Data Kosong!</td>
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
                    v-model="filter.roles"
                    outlined
                    dense
                    small-chips
                    label="Roles"
                    @input="filterPage('')"
                    :items="roles"></v-autocomplete>
            </v-container>
          </v-navigation-drawer>
        </v-card>
      </div>
      <form-dialog-user
        :dialog="dialog"
        :currentData="currentData"
        :condition="condition"
        :roles="roles"
        :filter="filter"
        @updateDialog="dialog.state = $event"
        @updateData="changeData($event)"
      ></form-dialog-user>

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
import { ref } from "@vue/composition-api";
export default {
  data() {
    const isDrawerOpen = ref(null);
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
        roles:[],
      },
      isDrawerOpen,
      data: {
        data: [],
        current_page: 1,
      },
      roles: [],
      currentData: {},
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
    show(data) {
      this.currentData = data;
      this.condition = "show";
      this.dialog.title = "Data User";
      this.showDialog(false);
    },
    edit(data) {
      this.currentData = data;
      this.condition = "update";
      this.dialog.title = "Edit User";
      this.showDialog(false);
    },
    add() {
      this.currentData = null;
      this.condition = "store";
      this.dialog.title = "Tambah User";
      this.showDialog(false);
    },
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
        .catch((err) => {
          this.web.isTableLoad = false;
          this.errors = err.response.data.errors;
          this.makeDefaultNotification(
            err.response.data.status,
            err.response.data.message
          );
        });
    },
    active() {
      this.web.isTableLoad = true;
      let req = Object.assign(
        { status: !this.currentData.status },
        this.filter
      );
      axios
        .post(`${this._url}active/${this.currentData.uuid}`, req)
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
        .catch((err) => {
          this.web.isTableLoad = false;
          this.errors = err.response.data.errors;
          this.makeDefaultNotification(
            err.response.data.status,
            err.response.data.message
          );
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
        this.filter.roles;
      axios.get(url).then((response) => {
        if (response.status == 200) {
          this.data = response.data.data;
          this.filter.page = response.data.data.current_page;
          this.web.isTableLoad = false;
        }
      });
    },
    getRoles() {
      let url = window.location.origin + "/api/v1/roles/";
      axios.get(url).then((response) => {
        if (response.status == 200) {
          this.roles = response.data.data.map(function (data) {
            return data["name"];
          });
        }
      });
    },
    changeData(newdata) {
      this.data = newdata;
    },
  },
  created() {
    this._url = window.location.origin + "/api/v1/users/";
    this.filterPage("");
    this.getRoles();
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
