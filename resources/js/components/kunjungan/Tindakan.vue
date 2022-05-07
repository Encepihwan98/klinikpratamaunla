<template>
  <div class="app-content-container boxed-container pa-6">
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
        <v-btn v-if="exit_time == null" color="primary" dark @click="selectMethod(null, 'add')">
          Tambah Data
        </v-btn>
        <div v-else></div>
      </v-col>
    </v-row>

    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">No</th>
            <th class="text-left">Waktu Pemeriksaan</th>
            <th class="text-left">Tindakan Pemeriksaan</th>
            <th class="text-left">Tarif Pelayanan</th>
            <th class="text-left">Petugas</th>
            <th class="text-left">Aksik</th>
          </tr>
        </thead>
        <tbody
          v-if="
            (baseData.data.length > 0 && web.isTableLoad == false) ||
            (data.data.length > 0 && web.isTableLoad == false)
          "
        >
          <tr v-for="(item, index) in dataUse" :key="item.index">
            <td>{{ index + (!data.from ? baseData.from : data.from) }}</td>
            <td>{{ item.treatment_time }}</td>
            <td>{{ item.description }}</td>
            <td>{{ item.amount }}</td>
            <td>{{ item.name }}</td>
            <td>
              <v-btn 
                small
                @click="selectMethod(item, 'delete')"
              >
                <v-icon small >far fa-trash</v-icon>
              </v-btn>
            </td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
    <v-card-actions class="d-flex justify-center">
      <v-pagination
        v-model="filter.page"
        :length="paginateUse.last_page"
        :total-visible="7"
        @input="filterPage('')"
      ></v-pagination>
    </v-card-actions>
    <div>
      <v-dialog v-model="dialog.state" persistent max-width="500px">
        <v-card>
          <v-card-title>
            <span class="text-h5">Rujuk Ke Fasilitas Penunjang</span>
          </v-card-title>
          <v-card-text>
            <v-form
              ref="form"
              v-model="valid"
              lazy-validation
              :currentData="currentData"
            >
              <v-contaFiner>
                <v-row>
                  <v-col class="d-flex" cols="12" sm="12" md="8">
                    <v-select
                      outlined
                      :items="tindakan.items"
                      label="Tindakan/Permeriksaan"
                      dense
                      v-model="action.tindakan"
                      @input="changeID('tindakan')"
                      clearable
                      :error-messages="errors.name"
                      :rules="[rules.required]"
                      :disabled="condition == 'show' ? true : false"
                    ></v-select>
                  </v-col>

                  <v-col class="d-flex" cols="12" sm="12" md="4">
                    <v-text-field
                      label="Jumlah"
                      required
                      dense
                      outlined
                      v-model="action.amount"
                    ></v-text-field>
                  </v-col>

                  <v-col class="d-flex" cols="12" sm="12" md="12">
                    <v-select
                      :items="officer.items"
                      label="Pilih Petugas"
                      dense
                      outlined
                      v-model="action.petugas"
                      @input="changeID('officer')"
                      clearable
                      :error-messages="errors.name"
                      :rules="[rules.required]"
                      :disabled="condition == 'show' ? true : false"
                    ></v-select>
                  </v-col>

                  <v-col cols="12" lg="12">
                    <v-menu
                      ref="menu1"
                      v-model="menu1"
                      :close-on-content-click="false"
                      transition="scale-transition"
                      offset-y
                      max-width="290px"
                      min-width="auto"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          outlined
                          v-model="action.treatment_time"
                          label="Waktu Tindakan"
                          persistent-hint
                          prepend-icon="mdi-calendar"
                          v-bind="attrs"
                          dense
                          @blur="date = parseDate(dateFormatted)"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="action.treatment_time"
                        no-title
                        @input="menu1 = false"
                      ></v-date-picker>
                    </v-menu>
                  </v-col>
                </v-row>
              </v-contaFiner>
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
              text
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
          condition == 'store' ? store : condition == 'update' ? update : remove
        "
        @changeDialogState="dialogConfirmation.state = $event"
      ></confirmation-dialog>
    </div>
  </div>
</template>

<script>
import { ref } from "@vue/composition-api";
import { mdiMagnify, mdiBellOutline, mdiGithub } from "@mdi/js";

export default {
  props: {
    modules: [],
    isOpen: "",
    exit_time: "",
    baseData: {},
    params: {},
  },
  data() {
    const isDrawerOpen = ref(null);
    return {
      _url: "",
      Polyclinic: {
        data: {},
        items: [],
      },
      officer: {
        data: {},
        items: [],
      },
      tindakan: {
        data: {},
        items: [],
      },
      valid: false,

      web: {
        isTableLoad: false,
      },
      menu: false,
      modal: false,
      menu1: false,
      action: {
        referral_time: new Date(
          Date.now() - new Date().getTimezoneOffset() * 60000
        )
          .toISOString()
          .substr(0, 10),
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
      if (event == "tindakan") {
        let currentID = this.action.tindakan;
        this.tindakan.data.forEach((v) => {
          if (v.description == currentID) {
            this.action.examination_action_id = v.id;
          }
        });
      } else if (event == "officer") {
        let currentID = this.action.petugas;
        this.officer.data.forEach((v) => {
          // console.log(v);
          if (v.name == currentID) {
            this.action.officer_id = v.id;
          }
        });
      }
    },
    setSeletPetugas() {
      axios.get(`/api/v1/list-pegawai`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.officer.items.push(v.name);
          });
          this.officer.data = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSeleTindakan() {
      axios.get(`/api/v1/list-tindakan`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.tindakan.items.push(v.description);
          });
          this.tindakan.data = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
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
        this.dialog.title = "Tambah Data";
        this.showDialog(false);
      } else if (item == "show") {
        this.condition = "show";
        this.dialog.title = "Data";
        this.showDialog(false);
      } else if (item == "edit") {
        this.condition = "update";
        this.dialog.title = "Edit Data";
        this.showDialog(false);
      }
    },
    store() {
      let req = Object.assign(this.action, this.filter);
      this.currentData = null;
      axios
        .post(window.location.origin + "/api/v1/layanan-tindakan/", req)
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
      let req = Object.assign(this.support, this.filter);
      axios
        .put(
          `${window.location.origin + "/api/v1/layanan-tindakan/"}${
            this.support.id
          }`,
          req
        )
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
      let url = `${window.location.origin + "/api/v1/layanan-tindakan/"}${id}`;
      axios
        .get(url)
        .then((response) => {
          if (response.status == 200) {
            this.support = response.data.data;
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
      this.support = {};
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
        .delete(`${window.location.origin + "/api/v1/layanan-tindakan/"}${this.currentData.id}`, { data: this.filter })
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
        window.location.origin +
        "/api/v1/layanan-tindakan/" +
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
    // this._url = window.location.origin + "/api/v1/layanan-penunjang/";
    this.filterPage("");
  },
  computed: {
    dialogState() {
      return this.dialog.state;
    },
    dataUse() {
      return this.data.data.length > 0 ? this.data.data : this.baseData.data;
    },
    paginateUse() {
      return this.data.data.length > 0 ? this.data : this.baseData;
    },
  },
  watch: {
    dialogState: function (n, o) {
      this.setSeletPetugas();
      this.setSeleTindakan();
      this.action.param = this.params;
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