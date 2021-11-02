<template>
  <div>
    <v-dialog v-model="showDialog" persistent max-width="800px">
      <v-card>
        <v-card-title>
          <span class="text-h5">Form </span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-col class="d-flex" cols="12" sm="12" md="6">
                  <v-select
                    :items="['324', '5777', '346', '123']"
                    label="Nomor Rekam Medis:"
                    outlined
                    dense
                    v-model="patien.medical_record_number"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-select>
                </v-col>
                <v-col class="d-flex" cols="12" sm="12" md="6">
                  <v-select
                    :items="education.items"
                    label="Pilih Pendidikan:"
                    placeholder="Pilih Pendidikan"
                    outlined
                    dense
                    v-model="patien.pendidikan"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    @input="changeID('education')"
                    :disabled="condition == 'show' ? true : false"
                  ></v-select>
                </v-col>

                <v-col class="d-flex" cols="12" sm="12" md="6">
                  <v-select
                    :items="identity.items"
                    label="Jenis Identitas:"
                    placeholder="Jenis Identitas"
                    outlined
                    dense
                    @input="changeID('identity')"
                    v-model="patien.identitas"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-select>
                </v-col>
                <v-col class="d-flex" cols="12" sm="12" md="6">
                  <v-select
                    :items="profession.items"
                    label="Pekerjaan:"
                    placeholder="Pekerjaan"
                    outlined
                    dense
                    v-model="patien.profesi"
                    @input="changeID('profession')"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-select>
                </v-col>

                <v-col class="d-flex" cols="12" sm="12" md="6">
                  <v-text-field
                    label="Nomor Identitas"
                    placeholder="Nomor Identitas"
                    required
                    outlined
                    dense
                    v-model="patien.identity_number"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-text-field>
                </v-col>
                <v-col class="d-flex" cols="12" sm="12" md="6">
                  <v-select
                    :items="province.items"
                    label="Provinsi:"
                    placeholder="Provinsi"
                    outlined
                    dense
                    v-model="patien.provinsi"
                    @input="changeID('province')"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-select>
                </v-col>

                <v-col class="d-flex" cols="12" sm="12" md="6">
                  <v-text-field
                    label="Nama Pasien"
                    placeholder="Nama Pasien"
                    required
                    outlined
                    dense
                    v-model="patien.name"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-textarea
                    outlined
                    rows="2"
                    label="Alamat"
                    v-model="patien.address"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-textarea>
                </v-col>

                <v-col class="d-flex" cols="12" sm="4">
                  <v-text-field
                    label="Tempat Lahir"
                    placeholder="Tempat Lahir"
                    outlined
                    dense
                    v-model="patien.birth_place"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
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
                        v-model="patien.birth_date"
                        label="Tanggal Lahir"
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
                      v-model="patien.birth_date"
                      @input="menu2 = false"
                    ></v-date-picker>
                  </v-menu>
                </v-col>
                <v-col class="d-flex" cols="12" sm="12" md="4">
                  <v-text-field
                    label="Telp/Hp"
                    placeholder="Telp/Hp"
                    required
                    outlined
                    dense
                    v-model="patien.phone_number"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-text-field>
                </v-col>
                <v-col class="d-flex" cols="12" sm="12" md="4">
                  <v-select
                    :items="['L', 'P']"
                    label="Jenis Kelamin:"
                    placeholder="Jenis Kelamin"
                    outlined
                    dense
                    v-model="patien.gender"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-select>
                </v-col>
                <v-col class="d-flex" cols="12" sm="12" md="4">
                  <v-select
                    :items="['A', 'B', 'AB', 'O']"
                    label="Golongan Darah:"
                    placeholder="Golongan Darah"
                    outlined
                    dense
                    v-model="patien.blood_group"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-select>
                </v-col>
                <v-col class="d-flex" cols="12" sm="12" md="4">
                  <v-select
                    :items="tribe.items"
                    label="Suku"
                    placeholder="Suku"
                    outlined
                    dense
                    v-model="patien.suku"
                    @input="changeID('tribe')"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-select>
                </v-col>
                <v-col class="d-flex" cols="12" sm="12" md="4">
                  <v-select
                    :items="agama.items"
                    label="Agama"
                    placeholder="Pilih Agama"
                    outlined
                    dense
                    v-model="patien.agama"
                    @input="changeID('agama')"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-select>
                </v-col>
              </v-row>

              <hr />

              <v-row>
                <v-col class="d-flex" cols="12" sm="6">
                  <v-text-field
                    label="Nama Ayah"
                    placeholder="Nama Ayah"
                    outlined
                    dense
                    v-model="patien.father_name"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-textarea
                    outlined
                    rows="1"
                    label="Alamat Keluarga"
                    placeholder="Alamat Keluarga"
                    v-model="patien.family_address"
                    :disabled="condition == 'show' ? true : false"
                  ></v-textarea>
                </v-col>
                <v-col class="d-flex" cols="12" sm="6">
                  <v-text-field
                    label="Nama Ibu"
                    placeholder="Nama Ibu"
                    outlined
                    dense
                    v-model="patien.mother_name"
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-text-field>
                </v-col>
                <v-col class="d-flex" cols="12" sm="6">
                  <v-text-field
                    label="Telp Keluarga"
                    placeholder="Telp Keluarga"
                    outlined
                    v-model="patien.family_phone_number"
                    dense
                    :disabled="condition == 'show' ? true : false"
                  ></v-text-field>
                </v-col>
                <v-col class="d-flex" cols="12" sm="6">
                  <v-select
                    :items="['Menikah', 'Belum Menikah', 'Janda', 'Duda']"
                    label="Status Pernikahan"
                    placeholder="Status Pernikahan"
                    outlined
                    v-model="patien.merriage_status"
                    dense
                    :disabled="condition == 'show' ? true : false"
                  ></v-select>
                </v-col>
                <v-col class="d-flex" cols="12" sm="6">
                  <v-text-field
                    label="Nama Pasangan"
                    placeholder="Nama Pasangan"
                    outlined
                    v-model="patien.partner_name"
                    dense
                    :disabled="condition == 'show' ? true : false"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-form>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="showDialog = false">
            Tutup
          </v-btn>
          <v-btn
            v-if="condition != 'show'"
            color="blue darken-1"
            text
            @click="selectMethod"
          >
            Simpan
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!-- akhir dialog -->
    <confirmation-dialog
      :confirmationDialog="dialogConfirmation"
      :method="condition == 'store' ? store : update"
      @changeDialogState="dialogConfirmation.state = $event"
    ></confirmation-dialog>
  </div>
</template>

<script>
import { ref } from "@vue/composition-api";
import { mdiMagnify, mdiBellOutline, mdiGithub } from "@mdi/js";

export default {
  props: {
    dialog: {
      state: false,
      title: null,
    },
    filter: {},
    pendidikan: [],
    pekerjaan: [],
    identitas: [],
    condition: null,
    currentData: {},
    dialogItems: [
      {
        name: "",
        outline: false,
        clearable: false,
        lable: "",
        value: "",
        model: "",
        type: "",
        sizeSM: "",
        sizeMD: "",
        cols: "",
      },
    ],
  },
  data() {
    return {
      _url: "",
      Id: "",
      description: {
        id: null,
      },
      education: {
        items: [],
        data: {},
      },
      identity: {
        items: [],
        data: {},
      },
      profession: {
        items: [],
        data: {},
      },
      province: {
        items: [],
        data: {},
      },
      tribe: {
        items: [],
        data: {},
      },
      agama: {
        items: [],
        data: {},
      },
      patien: {
        birth_date: new Date(
          Date.now() - new Date().getTimezoneOffset() * 60000
        )
          .toISOString()
          .substr(0, 10),
      },
      valid: false,
      data: {},
      dialogConfirmation: {
        state: false,
        message: null,
      },

      menu: false,
      modal: false,
      menu2: false,
      errors: [],
      rules: {
        required: (v) => !!v || "Tolong isi form.",
      },
    };
  },
  computed: {
    showDialog: {
      get() {
        return this.dialog.state;
      },
      set(value) {
        this.$emit("updateDialog", value);
      },
    },
    retriveData: {
      get() {
        return this.data;
      },
      set(value) {
        this.$emit("updateData", value);
      },
    },
  },
  methods: {
    changeID(event) {
      if (event == "education") {
        let currentID = this.patien.pendidikan;
        this.education.data.forEach((v) => {
          if (v.description == currentID) {
            this.patien.pendidikan_id = v.id;
          }
        });
      } else if (event == "identity") {
        let currentID = this.patien.identitas;
        this.identity.data.forEach((v) => {
          if (v.description == currentID) {
            this.patien.identity_id = v.id;
          }
        });
      } else if (event == "profession") {
        let currentID = this.patien.profesi;
        this.profession.data.forEach((v) => {
          if (v.description == currentID) {
            this.patien.profession_id = v.id;
          }
        });
      } else if (event == "province") {
        let currentID = this.patien.provinsi;
        this.province.data.forEach((v) => {
          if (v.name == currentID) {
            this.patien.province_id = v.id;
          }
        });
      } else if (event == "tribe") {
        let currentID = this.patien.suku;
        this.tribe.data.forEach((v) => {
          if (v.description == currentID) {
            this.patien.tribe_id = v.id;
          }
        });
      } else if (event == "agama") {
        let currentID = this.patien.agama;
        this.agama.data.forEach((v) => {
          if (v.description == currentID) {
            this.patien.agama_id = v.id;
          }
        });
      }
    },

    selectMethod() {
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
    setSelectedPendidikan() {
      axios.get(`/api/v1/list-pendidikan/`).then((res) => {
        console.log(res);
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.education.items.push(v.description);
          });
          this.education.data = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSelectIndentity() {
      axios.get(`/api/v1/list-identitas`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.identity.items.push(v.description);
          });
          this.identity.data = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSeletPekerjaan() {
      axios.get(`/api/v1/list-pekerjaan`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.profession.items.push(v.description);
          });
          this.profession.data = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSeletProvinsi() {
      axios.get(`/api/v1/list-provinsi`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.province.items.push(v.name);
          });
          this.province.data = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSeletSuku() {
      axios.get(`/api/v1/list-suku`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.tribe.items.push(v.description);
          });
          this.tribe.data = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSelectAgama() {
      axios.get(`/api/v1/list-agama`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.agama.items.push(v.description);
          });
          this.agama.data = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    store() {
      let req = Object.assign(this.patien, this.filter);
      axios
        .post(this._url, req)
        .then((response) => {
          if (response.status == 200) {
            this.showDialog = false;
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
    update() {
      let req = Object.assign(this.patien, this.filter);
      axios
        .put(`${this._url}${this.patien.id}`, req)
        .then((response) => {
          if (response.status == 200) {
            this.showDialog = false;
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
            this.patien = response.data.data;
            this.education.data.forEach((v) => {
              if (v.id == response.data.data.education_id) {
                this.patien.pendidikan = v.description;
                this.patien.pendidikan_id = v.id;
              }
            }); 
            this.identity.data.forEach((v) => {
              if (v.id == response.data.data.identity_number_id) {
                this.patien.identitas = v.description;
                this.patien.identity_id = v.id;
              }
            });
            this.profession.data.forEach((v) => {
              if (v.id == response.data.data.proffesion_id ) {
                this.patien.profesi = v.description;
                this.patien.profession_id = v.id;
              }
            });
            this.province.data.forEach((v) => {
              if (v.id == response.data.data.province_id ) {
                this.patien.provinsi = v.name;
                this.patien.province_id = v.id;
              }
            });
            this.tribe.data.forEach((v) => {
              if (v.id == response.data.data.tribe_id ) {
                this.patien.suku = v.description;
                this.patien.tribe_id = v.id;
              }
            });
            this.agama.data.forEach((v) => {
              if (v.id == response.data.data.agama_id ) {
                this.patien.agama = v.description;
                this.patien.agama_id = v.id;
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
      this.patien = {};
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
  },
  created() {
    this._url = window.location.origin + "/api/v1/daftar-pasien/";
  },
  watch: {
    showDialog: function (n, o) {
      this.setSelectedPendidikan();
      this.setSelectIndentity();
      this.setSeletPekerjaan();
      this.setSeletProvinsi();
      this.setSeletSuku();
      this.setSelectAgama();

      if (n && this.currentData) {
        this.show(this.currentData.id);
      } else this.clear();
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