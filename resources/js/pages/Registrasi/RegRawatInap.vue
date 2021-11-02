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
            <v-row>
              <v-col cols="12" sm="10">
                <p class="text-h6 text--primary">Registrasi Rawat Inap</p>
              </v-col>
              <v-col cols="12" sm="2">
                <v-btn depressed color="primary" :to="{ name: 'rawat-jalan' }">
                  Pasien Baru
                </v-btn>
              </v-col>
            </v-row>
          </v-card-text>
          <v-form
            ref="form"
            v-model="valid"
            lazy-validation
            :currentData="currentData"
          >
            <v-container>
              <v-row>
                <v-col class="d-flex" cols="12" md="4">
                  <v-autocomplete
                    :items="pasien.items"
                    label="Nama Pasien"
                    outlined
                    dense
                    hide-no-data
                    flat
                    return-object
                    v-model="pasien.data"
                    item-text="name"
                    item-value="name"
                    @input="changeID('patien')"
                    :search-input.sync="pasien.search"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                  ></v-autocomplete>
                </v-col>

                <v-col cols="12" md="4">
                  <v-text-field
                    label="Nomor Rekam Medis"
                    placeholder="Nomor Rekam Medis"
                    outlined
                    dense
                    small
                    v-model="pasien.data.medical_record_number"
                    disabled
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-text-field
                    label="Nomor Identitas"
                    placeholder="Nomor Identitas"
                    outlined
                    dense
                    small
                    v-model="pasien.data.identity_number"
                    disabled
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="4">
                  <v-text-field
                    label="Tempat Tanggal Lahir"
                    placeholder="Tempat Tanggal Lahir"
                    outlined
                    dense
                    small
                    disabled
                    v-model="pasien.data.birth_date"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-text-field
                    label="Alamat"
                    placeholder="Alamat"
                    outlined
                    dense
                    small
                    disabled
                    v-model="pasien.data.address"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-text-field
                    label="Telp/Hp"
                    placeholder="Telp/Hp"
                    outlined
                    dense
                    small
                    disabled
                    v-model="pasien.data.phone_number"
                  ></v-text-field>
                </v-col>
              </v-row>
              <hr />
              <v-row>
                <v-col cols="12" md="4">
                  <v-text-field
                    label="Nomor Kunjungan"
                    placeholder="Nomor Kunjungan dibuat secara otomatis"
                    outlined
                    dense
                    small
                    v-model="registration.visit_number"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4" sm="4">
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
                        v-model="registration.entry_time"
                        label="Waktu Kunjungan"
                        append-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        outlined
                        dense
                        :disabled="condition == 'show' ? true : false"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="registration.entry_time"
                      @input="menu2 = false"
                    ></v-date-picker>
                  </v-menu>
                </v-col>

                <v-col class="d-flex" cols="12" md="4">
                  <v-select
                    :items="reference.items"
                    label="Jenis Rujukan"
                    outlined
                    dense
                    @input="changeID('reference')"
                    v-model="registration.rujukan"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                  ></v-select>
                </v-col>
                <v-col cols="12" md="4">
                  <v-text-field
                    label="Nomor Rujukan"
                    placeholder="Nomor Rujukan"
                    outlined
                    dense
                    v-model="registration.no_rujukan"
                    :error-messages="errors.name"
                    small
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-text-field
                    label="Asal Rujukan"
                    placeholder="Asal Rujukan"
                    outlined
                    dense
                    small
                    v-model="registration.asal_rujukan"
                    :error-messages="errors.name"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4" sm="4">
                  <v-menu
                    v-model="menu3"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        v-model="registration.date_reference"
                        label="Tanggal Rujukan"
                        append-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        outlined
                        dense
                        :disabled="condition == 'show' ? true : false"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="registration.date_reference"
                      @input="menu3 = false"
                    ></v-date-picker>
                  </v-menu>
                </v-col>

                <v-col class="d-flex" cols="12" md="4">
                  <v-select
                    :items="payment.items"
                    label="Cara Pembayaran"
                    outlined
                    dense
                    @input="changeID('payment')"
                    v-model="registration.cara_bayar"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                  ></v-select>
                </v-col>
                <v-col cols="12" md="4">
                  <v-text-field
                    label="Nomor SJP"
                    placeholder="Nomor SJP"
                    outlined
                    dense
                    small
                    v-model="registration.no_sjp"
                    :error-messages="errors.name"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="4" sm="4">
                  <v-menu
                    v-model="menu4"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        v-model="registration.date_SJP"
                        label="Tanggal SJP"
                        append-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        outlined
                        dense
                        :disabled="condition == 'show' ? true : false"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="registration.date_SJP"
                      @input="menu4 = false"
                    ></v-date-picker>
                  </v-menu>
                </v-col>

                <v-col cols="12" md="4">
                  <v-text-field
                    label="Penanggung Jawab"
                    placeholder="Penanggung Jawab"
                    outlined
                    dense
                    small
                    v-model="registration.pj_name"
                    :error-messages="errors.name"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="4">
                  <v-text-field
                    label="Telp Penanggung Jawab"
                    placeholder="Telp Penanggung Jawab"
                    outlined
                    dense
                    small
                    v-model="registration.pj_phone_number"
                    :error-messages="errors.name"
                  ></v-text-field>
                </v-col>
                <v-col class="d-flex" cols="12" md="4">
                  <v-select
                    :items="caseType.items"
                    label="Jenis Kasus"
                    outlined
                    dense
                    @input="changeID('caseType')"
                    v-model="registration.kasus"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                  ></v-select>
                </v-col>
                <v-col class="d-flex" cols="12" md="4">
                  <v-select
                    :items="['salesma', 'rorombeheun']"
                    label="Diagnosa Awal"
                    outlined
                    dense
                  ></v-select>
                </v-col>
                <v-col class="d-flex" cols="12" md="4">
                  <v-autocomplete
                    :items="dokter.items"
                    label="Pilih Dokter"
                    outlined
                    dense
                    hide-no-data
                    flat
                    return-object
                    v-model="dokter.data"
                    @input="changeID('dokter')"
                    item-text="name"
                    item-value="name"
                    :search-input.sync="dokter.search"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                  ></v-autocomplete>
                </v-col>
              </v-row>
              <hr />
              <v-row>
                <v-col class="d-flex" cols="12" md="4">
                  <v-select
                    :items="registrationType.items"
                    label="Jenis Registrasi"
                    outlined
                    dense
                    v-model="registration.registrasi"
                    @input="changeID('registrationType')"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                  ></v-select>
                </v-col>
                <v-col class="d-flex" cols="12" md="4">
                  <v-select
                    :items="clinic.items"
                    label="Poliklinik Tujuan"
                    outlined
                    dense
                    v-model="registration.poliklinik"
                    @input="changeID('clinic')"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                  ></v-select>
                </v-col>
                <v-col class="d-flex" cols="12" md="4">
                  <v-select
                    :items="activity.items"
                    label="Jenis Kegiatan"
                    outlined
                    dense
                    v-model="registration.kegiatan"
                    @input="changeID('activity')"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                  ></v-select>
                </v-col>
                <v-col class="d-flex" cols="12" md="4">
                  <v-select
                    :items="inPatientRoom.items"
                    label="Ruang Rawat Inap"
                    outlined
                    dense
                    v-model="registration.ruangan"
                    @input="changeID('inPatientRoom')"
                  ></v-select>
                </v-col>
                <v-col class="d-flex" cols="12" md="4">
                  <v-select
                    :items="room.items"
                    label="Kamar"
                    outlined
                    dense
                  ></v-select>
                </v-col>
                <v-col class="d-flex" cols="12" md="4">
                  <v-select
                    :items="['salesma', 'rorombeheun']"
                    label="Ranjang"
                    outlined
                    dense
                  ></v-select>
                </v-col>

                <v-col class="d-flex" cols="12" md="4">
                  <v-select
                    :items="['salesma', 'rorombeheun']"
                    label="Cara Penerimaan"
                    outlined
                    dense
                  ></v-select>
                </v-col>
                <v-col class="d-flex" cols="12" md="4">
                  <v-select
                    :items="['salesma', 'rorombeheun']"
                    label="Aktifitas"
                    outlined
                    dense
                  ></v-select>
                </v-col>
              </v-row>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn depressed color="primary" text @click="selectStore">
                  Simpan
                </v-btn>
              </v-card-actions>
            </v-container>
          </v-form>
        </v-card>
        <confirmation-dialog
          :confirmationDialog="dialogConfirmation"
          :method="condition == 'store' ? store : update"
          @changeDialogState="dialogConfirmation.state = $event"
        ></confirmation-dialog>
      </div>
    </v-main>
    <footer></footer>
  </v-app>
</template>



<script>
import { ref } from "@vue/composition-api";
import { mdiMagnify, mdiBellOutline, mdiGithub } from "@mdi/js";
import FormDaftarPasien from "../../components/FormDaftarPasien.vue";

export default {
  props: {
    modules: [],
  },
  data() {
    const isDrawerOpen = ref(null);
    return {
      _url: "",
      pasien: {
        items: [],
        data: {},
      },
      clinic: {
        items: [],
        data: {},
      },
      reference: {
        items: [],
        data: {},
      },
      payment: {
        items: [],
        data: {},
      },
      caseType: {
        items: [],
        data: {},
      },
      inPatientRoom: {
        items: [],
        data: {},
      },
      registrationType: {
        items: [],
        data: {},
      },
      activity: {
        items: [],
        data: {},
      },
      dokter: {
        items: [],
        data: {},
      },
      room: {
        items:[],
        data:{},
      },
      registration: {
        entry_time: new Date(
          Date.now() - new Date().getTimezoneOffset() * 60000
        )
          .toISOString()
          .substr(0, 10),
        date_reference: new Date(
          Date.now() - new Date().getTimezoneOffset() * 60000
        )
          .toISOString()
          .substr(0, 10),
        date_SJP: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
          .toISOString()
          .substr(0, 10),
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
      menu2: false,
      menu3: false,
      menu4: false,
      selectItem: ["10", "25", "50", "100"],
      errors: [],
      rules: {
        required: (v) => !!v || "Tolong isi form.",
      },
    };
  },
  methods: {
    changeID(event) {
      if (event == "patien") {
        let currentID = this.pasien.data.id;
        this.registration.patien_id = currentID;
      } else if (event == "payment") {
        let currentID = this.registration.cara_bayar;
        this.payment.data.forEach((v) => {
          if (v.description == currentID) {
            this.registration.payment_id = v.id;
          }
        });
      } else if (event == "caseType") {
        let currentID = this.registration.kasus;
        this.caseType.data.forEach((v) => {
          if (v.description == currentID) {
            this.registration.case_id = v.id;
          }
        });
      } else if (event == "dokter") {
        let currentID = this.dokter.data.id;
        this.registration.dokter_id = currentID;
      } else if (event == "registrationType") {
        let currentID = this.registration.registrasi;
        this.registrationType.data.forEach((v) => {
          if (v.description == currentID) {
            this.registration.registrasi_id = v.id;
          }
        });
      } else if (event == "clinic") {
        let currentID = this.registration.poliklinik;
        this.clinic.data.forEach((v) => {
          if (v.name == currentID) {
            this.registration.polyclinic_id = v.id;
          }
        });
      } else if (event == "activity") {
        let currentID = this.registration.kegiatan;
        this.activity.data.forEach((v) => {
          if (v.description == currentID) {
            this.registration.medical_activity_id = v.id;
          }
        });
      } else if (event == "reference") {
        let currentID = this.registration.rujukan;
        this.reference.data.forEach((v) => {
          if (v.description == currentID) {
            this.registration.reference_id = v.id;
          }
        });
      } else if (event == "inPatientRoom") {
        let currentID = this.registration.ruangan;
        this.inPatientRoom.data.forEach((v) => {
          if (v.name == currentID) {
            this.registration.inPatientRoom_id = v.id;
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
    store() {
      let req = Object.assign(this.registration, this.filter);
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
      let req = Object.assign(this.registration, this.filter);
      axios
        .put(`${this._url}${this.registration.id}`, req)
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
            this.registration = response.data.data;
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
      this.registration = {};
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
    setSelectedName() {
      axios.get(`/api/v1/list-pasien/`).then((res) => {
        // console.log(res);
        if (res.status === 200) {
          this.pasien.items = res.data.data;
        } else {
          7;
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSelectedDokter() {
      axios.get(`/api/v1/list-pegawai/`).then((res) => {
        if (res.status === 200) {
          this.dokter.items = res.data.data;
        } else {
          7;
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },

    setSelectedClinic() {
      axios.get(`/api/v1/list-poliklinik/`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.clinic.items.push(v.name);
          });
          this.clinic.data = res.data.data;
        } else {
          7;
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },

    setSelectedReference() {
      axios.get(`/api/v1/list-rujukan/`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.reference.items.push(v.description);
          });
          this.reference.data = res.data.data;
        } else {
          7;
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSelectedActivity() {
      axios.get(`/api/v1/list-kegiatan/`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.activity.items.push(v.description);
          });
          this.activity.data = res.data.data;
          7;
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSelectedregistrationType() {
      axios.get(`/api/v1/list-registrasi/`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.registrationType.items.push(v.description);
          });
          this.registrationType.data = res.data.data;
        } else {
          7;
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSelectedPayment() {
      axios.get(`/api/v1/list-cara-pembayaran/`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.payment.items.push(v.description);
          });
          this.payment.data = res.data.data;
        } else {
          7;
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSelectedCasetype() {
      axios.get(`/api/v1/list-kasus/`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.caseType.items.push(v.description);
          });
          this.caseType.data = res.data.data;
        } else {
          7;
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSelectedinPatientRoom() {
      axios.get(`/api/v1/list-poliklinik-room/`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.inPatientRoom.items.push(v.name);
          });
          this.inPatientRoom.data = res.data.data;
        } else {
          7;
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },

    setSelectedRoom() {
      axios.get(`/api/v1/select-room/`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.room.items.push(v.name);
          });
          this.room.data = res.data.data;
        } else {
          7;
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
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
    this._url = window.location.origin + "/api/v1/reg-rawat-inap/";
    this.filterPage("");
    this.setSelectedName();
    this.setSelectedReference();
    this.setSelectedPayment();
    this.setSelectedCasetype();
    this.setSelectedregistrationType();
    this.setSelectedClinic();
    this.setSelectedActivity();
    this.setSelectedDokter();
    this.setSelectedinPatientRoom();
    this.setSelectedRoom();
  },
  computed: {
    searchPasien() {
      return this.pasien.search;
    },
    pasienSelected() {
      return this.pasien.data;
    },
    searchDokter() {
      return this.dokter.search;
    },
    dokterSelected() {
      return this.dokter.data;
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
    searchPasien(val) {
      setTimeout(() => {
        this.registration = this.pasien.data.forEach((e) => {
          console.log(registration);
          return e.name == val ? e : null;
          // return (e.name || '').toLowerCase().indexOf((val.name || '').toLowerCase()) > -1
        });
        this.loading = false;
      }, 500);
    },
    searchDokter(val) {
      setTimeout(() => {
        this.registration = this.dokter.data.forEach((e) => {
          console.log(e);
          return e.name == val ? e : null;
          // return (e.name || '').toLowerCase().indexOf((val.name || '').toLowerCase()) > -1
        });
        this.loading = false;
      }, 500);
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
