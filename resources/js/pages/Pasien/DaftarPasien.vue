<template>
  <v-app>
    <vertical-nav-menu
      :is-drawer-open.sync="isDrawerOpen"
      :modules="modules"
    ></vertical-nav-menu>
    <app-bar></app-bar>
    <v-main>
      <div class="app-content-container pa-6">
        <v-card class="mx-auto" max-width="97%" elevation="5">
          <v-card-text>
            <p class="text-h6 text--primary">Pasien Management</p>
          </v-card-text>
          <v-container>
            <v-row>
              <v-col class="d-flex" cols="12" sm="4">
                <v-text-field
                  outlined
                  label="Search MR"
                  append-icon="mdi-magnify"
                  small
                  dense
                ></v-text-field>
              </v-col>
              <v-col class="d-flex" cols="12" sm="4">
                <v-text-field
                  outlined
                  label="Search Nama"
                  append-icon="mdi-magnify"
                  small
                  dense
                ></v-text-field>
              </v-col>
              <v-col class="d-flex" cols="12" sm="4">
                <v-text-field
                  outlined
                  label="Search Nomor Identitas"
                  append-icon="mdi-magnify"
                  small
                  dense
                ></v-text-field>
              </v-col>

              <v-col cols="12" sm="4">
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
                      label="Tangal Lahir"
                      append-icon="mdi-calendar"
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
              <v-col class="d-flex" cols="12" sm="8">
                <v-text-field
                  outlined
                  label="Search Alamat"
                  append-icon="mdi-magnify"
                  small
                  dense
                ></v-text-field>
              </v-col>
            </v-row>
            <hr />
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
                  v-if="web.create"
                  color="primary ml-auto"
                  small
                  elevation="2"
                  @click="selectMethod(null, 'add')"
                  >Tambah Pasien</v-btn
                >
              </v-col>
            </v-row>
          </v-container>
          <v-simple-table>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left">
                    No Rekam Medis
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
                    Nomor Identitas
                    <v-icon @click="filterPage('identity_number')" x-small>{{
                      filter.sortBy == "identity_number"
                        ? filter.orderBy == "asc"
                          ? "fas fa-sort-amount-up"
                          : "fas fa-sort-amount-down"
                        : "fas fa-sort-alt"
                    }}</v-icon>
                  </th>
                  <th class="text-left">Tanggal Lahir</th>
                  <th class="text-left">Alamat</th>
                  <th class="text-left">Aksi</th>
                </tr>
              </thead>
              <tbody v-if="data.data.length > 0 && web.isTableLoad == false">
                <tr v-for="(item, index) in data.data" :key="item.name">
                  <td>{{ index + data.from }}</td>
                  <td>{{ item.name }}</td>
                  <td>{{ item.identity_number }}</td>
                  <td>{{ item.birth_date }}</td>
                  <td>{{ item.address }}</td>
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
      <form-daftar-pasien
        :dialog="dialog"
        :currentData="currentData"
        :condition="condition"
        :filter="filter"
        :pendidikan ="data.pendidikan"
        @updateDialog="dialog.state = $event"
        @updateData="changeData($event)"
      ></form-daftar-pasien>
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
      date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
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
    this._url = window.location.origin + "/api/v1/daftar-pasien/";
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
