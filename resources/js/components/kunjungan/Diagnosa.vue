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
        <v-btn color="primary" dark @click="selectMethod(null, 'add')">
          Tambah Data
        </v-btn>
      </v-col>
    </v-row>

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
            <th class="text-left">Waktu Diagnosa</th>
            <th class="text-left">Penyakit</th>
            <th class="text-left">Lama Menderita</th>
            <th class="text-left">Petugas</th>
            <th class="text-left">Aksik</th>
          </tr>
        </thead>
        <tbody
          v-if="
            (baseData.data.length > 0 && web.isTableLoad == false) ||
            (data.data.length > 0 && web.isTableLoad == false)"
        >
          <tr v-for="(item, index) in usedData" :key="item.index">
            <td>{{ index + (!data.from ? baseData.from:data.from) }}</td>
            <td>{{ item.treatment_time }}</td>
            <td>{{ item.description }}</td>
            <td>{{ item.long_suffering }}</td>
            <td>{{ item.name }}</td>
            <td>
               <v-btn 
                icon
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
        :length="!data.last_page ? baseData.last_page : data.last_page"
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
              <v-container>
                <v-row>
                  <v-col class="d-flex" cols="12" sm="12" md="12">
                    <v-select
                      :items="disease.items"
                      label="Penyakit :"
                      dense
                      outlined
                      @input="changeID('disease')"
                      v-model="diagnosis.disease"
                    ></v-select>
                  </v-col>

                  <v-col cols="12" sm="12" md="12">
                    <v-text-field
                      label="Lama Menderita"
                      required
                      outlined
                      v-model="diagnosis.long_suffering"
                    ></v-text-field>
                  </v-col>

                  <v-col class="d-flex" cols="12" sm="12" md="6">
                    <v-select
                      :items="typeDiagnosa.items"
                      label="Tipe"
                      dense
                      outlined
                      @input="changeID('type')"
                      v-model="diagnosis.type"
                    ></v-select>
                  </v-col>
                  <v-col class="d-flex" cols="12" sm="12" md="6">
                    <v-select
                      :items="Case.items"
                      label="Kasus"
                      dense
                      outlined
                      v-model="diagnosis.cases"
                      @input="changeID('kasus')"
                    ></v-select>
                  </v-col>

                  <v-col class="d-flex" cols="12" sm="12" md="12">
                    <v-select
                      :items="officer.items"
                      label="Pilih Petugas"
                      dense
                      outlined
                      v-model="diagnosis.officer"
                      @input="changeID('officer')"
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
                          v-model="diagnosis.diagnostic_time"
                          label="Waktu Dignosa"
                          persistent-hint
                          append-icon="mdi-calendar"
                          v-bind="attrs"
                          v-on="on"
                          dense
                          :disabled="condition == 'show' ? true : false"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="diagnosis.diagnostic_time"
                        no-title
                        @input="menu1 = false"
                      ></v-date-picker>
                    </v-menu>
                  </v-col>
                </v-row>
              </v-container>
            </v-form>
            <small>*indicates required field</small>
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
        :method="condition == 'store' ? store : remove"
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
    baseData: {},
  },
  data() {
    const isDrawerOpen = ref(null);
    return {
      _url: "",
      diagnosis: {
        diagnostic_time: new Date(
          Date.now() - new Date().getTimezoneOffset() * 60000
        )
          .toISOString()
          .substr(0, 10),
      },
      disease: {
        data: {},
        items: [],
      },
      officer: {
        data: {},
        items: [],
      },
      typeDiagnosa: {
        data: {},
        items: [],
      },
      Case:   {
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
      support: {},
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
      if (event == "disease") {
        let currentID = this.diagnosis.disease;
        this.disease.data.forEach((v) => {
          if (v.description == currentID) {
            this.diagnosis.disease_id = v.id;
          }
        });
      } else if (event == "officer") {
        let currentID = this.diagnosis.officer;
        this.officer.data.forEach((v) => {
          if (v.name == currentID) {
            this.diagnosis.officer_id = v.id;
          }
        });
      }else if (event == "type") {
        let currentID = this.diagnosis.type;
        this.typeDiagnosa.data.forEach((v) => {
          if (v.description == currentID) {
            this.diagnosis.diagnostic_type_id = v.id;
          }
        });
      }else if (event == "kasus") {
        let currentID = this.diagnosis.cases;
        this.Case.data.forEach((v) => {
          if (v.description == currentID) {
            this.diagnosis.case_id = v.id;
          }
        });
      }
    },
    setSeletPenyakit() {
      axios.get(`/api/v1/list-penyakit`).then((res) => {
        // console.log(res);
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.disease.items.push(v.description);
          });
          this.disease.data = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSeletTypediagnosa() {
      axios.get(`/api/v1/list-diagnosa`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.typeDiagnosa.items.push(v.description);
          });
          this.typeDiagnosa.data = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSeletKasus() {
      axios.get(`/api/v1/list-kasus`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.Case.items.push(v.description);
          });
          this.Case.data = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSeletPetugas() {
      axios.get(`/api/v1/list-pegawai`).then((res) => {
        // console.log(res);
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
      let req = Object.assign(this.diagnosis, this.filter);
      this.currentData = null;
      axios
        .post(window.location.origin + "/api/v1/layanan-diagnosa/", req)
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
      let req = Object.assign(this.diagnosis, this.filter);
      axios
        .put(
          `${window.location.origin + "/api/v1/layanan-diagnosa/"}${
            this.diagnosis.id
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
      let url = `${window.location.origin + "/api/v1/layanan-diagnosa/"}${id}`;
      axios
        .get(url)
        .then((response) => {
          if (response.status == 200) {
            this.diagnosis = response.data.data;
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
        .delete(`${window.location.origin + "/api/v1/layanan-diagnosa/"}${this.currentData.id}`, { data: this.filter })
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
        "/api/v1/layanan-diagnosa/" +
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
          // console.log(response);
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
    // this._url = window.location.origin + "/api/v1/layanan-diagnosa/";
    this.filterPage("");
  },
  computed: {
    dialogState() {
      return this.dialog.state;
    },
    usedData() {
      return this.data.data.length > 0 ? this.data.data : this.baseData.data;
    },
  },
  watch: {
    dialogState: function (n, o) {
      this.setSeletPenyakit();
      this.setSeletPetugas();
      this.setSeletTypediagnosa();
      this.setSeletKasus();

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