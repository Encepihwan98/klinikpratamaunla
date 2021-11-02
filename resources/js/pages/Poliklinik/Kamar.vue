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
        <v-card class="mx-auto" max-width="97%" elevation="5">
          <v-card-text>
            <p class="text-h6 text--primary">Daftar Kamar</p>
          </v-card-text>
          <v-container>
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
                  color="primary"
                  dark
                  @click="selectMethod(null, 'add')"
                >
                  Tambah Data
                </v-btn>
              </v-col>
            </v-row>
          </v-container>
          <v-simple-table>
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
                    Uraian
                    <v-icon @click="filterPage('name')" x-small>{{
                      filter.sortBy == "name"
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
                <tr v-for="(item, index) in data.data" :key="item.description">
                  <td>{{ index + data.from }}</td>
                  <td>{{ item.name }}</td>
                  <td>
                    <v-btn
                      color="primary"
                      icon
                      @click="selectMethod(item, 'edit')"
                      v-if="web.update"
                    >
                      <v-icon small>far fa-edit</v-icon>
                    </v-btn>

                    <v-btn
                      color="primary"
                      icon
                      small
                      @click="selectMethod(item, 'delete')"
                      v-if="web.delete"
                    >
                      <v-icon small>far fa-trash</v-icon>
                    </v-btn>
                  </td>
                </tr>
                <!-- <tr
                      v-for="item in desserts"
                      :key="item.name"
                      >
                      <td>{{ item.name }}</td>
                      <td>{{ item.calories }}</td>
                      </tr> -->
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
                    <v-col class="d-flex" cols="12" sm="12">
                      <v-select
                        :items="clinicRoom.items"
                        label="ruang"
                        placeholder="Ruangan"
                        outlined
                        v-model="room.ruangan"
                        :error-messages="errors.name"
                        :rules="[rules.required]"
                        @input="changeID('clinicRoom')"
                        :disabled="condition == 'show' ? true : false"
                        dense
                      ></v-select>
                    </v-col>
                    <v-col class="d-flex" cols="12" sm="12">
                      <v-text-field
                        v-model="room.name"
                        label="name :"
                        placeholder="name"
                        outlined
                        dense
                        clearable
                        :error-messages="errors.name"
                        :rules="[rules.required]"
                        :disabled="condition == 'show' ? true : false"
                      ></v-text-field>
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
              <v-btn
                v-if="condition != 'show'"
                color="blue darken-1"
                textx
                @click="selectStore"
              >
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
  </v-app>
</template>

<script>
import { ref } from "@vue/composition-api";
import { mdiMagnify, mdiBellOutline, mdiGithub } from "@mdi/js";

export default {
  props: {
    modules: [],
  },
  data() {
    const isDrawerOpen = ref(null);
    return {
      _url: "",
      room: {},
      clinicRoom: {
        items: [],
        data: {},
      },
      grade: {
        items: [],
        data: {},
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
      selectItem: ["10", "25", "50", "100"],
      errors: [],
      rules: {
        required: (v) => !!v || "Tolong isi form.",
      },
    };
  },
  methods: {
    changeID(event) {
      if (event == "clinicRoom") {
        let currentID = this.room.ruangan;
        this.clinicRoom.data.forEach((v) => {
          if (v.name == currentID) {
            this.room.polyclinic_room_id = v.id;
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
        this.dialog.title = "Edit Role";
        this.showDialog(false);
      }
    },

    setSelectedClinic() {
      axios.get(`/api/v1/list-poliklinik-room/`).then((res) => {
        console.log(res);
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.clinicRoom.items.push(v.name);
          });
          this.clinicRoom.data = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSelectedGrade() {
      axios.get(`/api/v1/list-room-grade/`).then((res) => {
        console.log(res);
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.grade.items.push(v.description);
          });
          this.grade.data = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    store() {
      let req = Object.assign(this.room, this.filter);
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
          }
        })
        .catch((e) => {
          this.errorState(e);
        });
    },
    update() {
      let req = Object.assign(this.room, this.filter);
      axios
        .put(`${this._url}${this.room.id}`, req)
        .then((response) => {
          if (response.status == 200) {
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
          if (response.status == 200) {
            this.room = response.data.data;
            this.clinicRoom.data.forEach((v) => {
              if (v.id == response.data.data.polyclinic_room_id) {
                this.room.kamar = v.name;
                this.room.pendidikan_id = v.id;
              }
            });
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
      this.room = {};
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
            this.data = response.data.data;
            this.filter.page = response.data.data.current_page;
            this.web.isTableLoad = false;
            this.getCurrentUser();
          }
        })
        .catch((e) => {
          this.errorState(e);
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
    this._url = window.location.origin + "/api/v1/kamar/";
    this.filterPage("");
  },
  computed: {
    dialogState() {
      return this.dialog.state;
    },
  },
  watch: {
    dialogState: function (n, o) {
      console.log(n);
      this.setSelectedClinic();
      this.setSelectedGrade();
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