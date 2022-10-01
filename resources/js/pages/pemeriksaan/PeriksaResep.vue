<template>
  <v-app>
    <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen" :modules="modules"></vertical-nav-menu>
    <app-bar :isDrawerOpen="isDrawerOpen" :currentUser="currentUser" @updateNavbar="isDrawerOpen = $event"></app-bar>
    <v-main>
      <div class="app-content-container boxed-container pa-6">
        <v-form class="mx-3 my-3" ref="form" v-model="valid" lazy-validation :currentData="currentData">
          <v-container>
            <v-row>
              <v-col cols="12" sm="8">
                <v-card>
                  <v-card-text>
                    <p class="text-h6 font-weight-bold">Data Pasien</p>
                  </v-card-text>
                  <v-container>

                    <v-container>
                      <v-row>
                        <v-col class="pa-0" cols="12" sm="12">
                          <v-text-field label="ID" v-model="pasien.pasien_id" placeholder="PS001" outlined dense small
                            disabled></v-text-field>
                        </v-col>
                        <v-col class="pa-0 mr-6" cols="12" sm="6">
                          <v-text-field label="Nama" v-model="pasien.nama" placeholder="Maman Abdul" disabled outlined
                            dense small></v-text-field>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="5">
                          <v-text-field label="Umur" v-model="pasien.umur" placeholder="24" disabled outlined dense small></v-text-field>
                        </v-col>
                        <v-col cols="12" class="pa-0 mb-5" sm="12">
                          <v-btn @click.stop="dialog = true" color="success">Lihat Riwayat Rekam Medis</v-btn>
                        </v-col>
                      </v-row>
                    </v-container>

                  </v-container>
                </v-card>
                <v-card>
                  <v-card-text>
                    <p class="text-h6 font-weight-bold">
                      Rekam Medis Pasien <v-chip color="blue">P007</v-chip>
                    </p>
                  </v-card-text>
                  <v-container>

                    <v-container>
                      <v-row>
                        <v-col class="pa-0 mr-6" cols="12" sm="6">
                          <v-text-field v-model="form.rekamedis.bb" label="Berat Badan" suffix="Kg" outlined dense
                            :error-messages="errors.name" :rules="[rules.required]" small>
                          </v-text-field>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="5">
                          <v-text-field v-model="form.rekamedis.tensi" label="Tensi Darah" suffix="mmHg" outlined dense
                            :error-messages="errors.name" :rules="[rules.required]" small>
                          </v-text-field>
                        </v-col>
                        <v-col class="pa-0 mr-6" cols="12" sm="6">
                          <v-text-field v-model="form.rekamedis.tb" label="Tinggi Badan" suffix="Cm" outlined dense
                            :error-messages="errors.name" :rules="[rules.required]" small>
                          </v-text-field>
                        </v-col>
                        <!-- <v-col class="pa-0" cols="12" sm="5">
                          <v-select :items="['Ya', 'Tidak']" label="Buta Warna" dense outlined></v-select>
                        </v-col> -->
                        <v-col class="pa-0" cols="12" sm="12">
                          <v-textarea v-model="form.rekamedis.keluhan" label="Keluhan" :error-messages="errors.name"
                            :rules="[rules.required]" auto-grow outlined rows="1" row-height="15"></v-textarea>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="12">
                          <v-textarea v-model="form.rekamedis.anamnesis" :error-messages="errors.name"
                            :rules="[rules.required]" label="Anamnesis" auto-grow outlined rows="1" row-height="15">
                          </v-textarea>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="12">
                          <v-textarea v-model="form.rekamedis.diagnosa" :error-messages="errors.name"
                            :rules="[rules.required]" label="Diagnosa" auto-grow outlined rows="1" row-height="15">
                          </v-textarea>
                        </v-col>
                        <!-- <v-col class="d-flex pa-0 mr-2" cols="12" sm="4">
                          <v-select :items="tindakan.items" @input="changeID('tindakan')"
                            v-model="form.rekamedis.tindakan" label="Tindakan" dense outlined>
                          </v-select>
                        </v-col> -->
                        <v-col class="d-flex pa-0 mr-2" cols="12" sm="12">
                          <v-container fluid>
                            <v-combobox v-model="form.rekamedis.tindakan" @input="changeID('tindakan')"
                              :filter="filterTindakan" :hide-no-data="!search" :items="tindakan.items"
                              :search-input.sync="search" hide-selected label="Pilih Tindakan" multiple small-chips
                              solo>
                              <template v-slot:no-data>
                                <v-list-item>

                                  <v-chip :color="`${colors[nonce - 1]} lighten-3`" label small>
                                    {{ search }}
                                  </v-chip>
                                </v-list-item>
                              </template>
                              <template v-slot:selection="{ attrs, item, parent, selected }">
                                <v-chip v-if="item === Object(item)" v-bind="attrs" :color="`${item.color} lighten-3`"
                                  :input-value="selected" label small>
                                  <span class="pr-2">
                                    {{ item.text }}
                                  </span>
                                  <v-icon small @click="parent.selectItem(item)">
                                    $delete
                                  </v-icon>
                                </v-chip>
                              </template>
                              <template v-slot:item="{ index, item }">
                                <v-text-field v-if="editing === item" v-model="editing.text" autofocus flat
                                  background-color="transparent" hide-details solo @keyup.enter="edit(index, item)">
                                </v-text-field>
                                <v-chip v-else :color="`${item.color} lighten-3`" dark label small>
                                  {{ item.text }}
                                </v-chip>

                              </template>
                            </v-combobox>
                          </v-container>
                        </v-col>
                        <v-col class="pa-0" cols="12" sm="12">
                          <v-textarea v-model="form.rekamedis.keterangan" label="Keterangan"
                            :error-messages="errors.name" :rules="[rules.required]" auto-grow outlined rows="1"
                            row-height="15"></v-textarea>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-container>
                </v-card>
              </v-col>
              <v-col cols="12" sm="4">
                <v-card>
                  <v-card-text>
                    <p class="text-h6 font-weight-bold">
                      Rujukan
                      <v-chip class="float-end mt-2" small color="blue">1</v-chip>
                    </p>
                  </v-card-text>
                  <v-container>
                    <v-form>
                      <v-row>
                        <v-col class="pa-0" cols="12" sm="12">
                          <v-text-field label="Rumah Sakit Rujukan" v-model="form.rekamedis.rujukan"
                            :error-messages="errors.name" :rules="[rules.required]" outlined dense small>
                          </v-text-field>
                        </v-col>
                      </v-row>
                    </v-form>
                  </v-container>
                </v-card>

                <v-card>
                  <v-card-text>
                    <p class="text-h6 font-weight-bold">
                      Isi Resep
                      <v-chip class="float-end mt-2" small color="blue">1</v-chip>
                    </p>
                  </v-card-text>
                  <v-container>
                    <v-row class="mx-2 mb-5">
                      <v-col cols="12" sm="12">

                        <v-container>
                          <v-row>
                            <!-- <v-col class="pa-0 mr-2" cols="12" sm="6">
                              <v-select :items="['Ya', 'Tidak']" label="Alergi Obat" dense outlined></v-select>
                            </v-col>
                            <v-col class="pa-0 " cols="12" sm="5">
                              <v-text-field label="" outlined dense small></v-text-field>
                            </v-col> -->
                            <div v-for="(item, index) in form.obat" :key="item.name">
                              <v-col class="pa-0" cols="12" sm="12">
                                <p>Obat {{ index }}</p>
                              </v-col>

                              <!-- <v-col class="pa-0 mr-2" cols="12" sm="6">
                                <v-select v-model="form.obat[index].name" :items="obat.items"
                                  @input="changeID('obat', index)" label="Pilih Obat" outlined dense hide-no-data flat
                                  :error-messages="errors.name" :rules="[rules.required]" item-text="name"
                                  item-value="name">
                                </v-select>
                              </v-col> -->
                              <v-col cols="12" sm="6" class="pa-0 mr-2">
                                <v-autocomplete v-model="form.obat[index].name" outlined dense chips small-chips
                                  label="Obat" :error-messages="errors.parent" @input="changeID('obat', index)"
                                  :rules="[rules.required]" :items="obat.items"></v-autocomplete>
                              </v-col>
                              <v-col class="pa-0" cols="12" sm="5">
                                <v-text-field v-model="form.obat[index].total" :error-messages="errors.name"
                                  :rules="[rules.required]" label="Jumlah" outlined dense small>
                                </v-text-field>
                              </v-col>
                              <v-col class="pa-0" cols="12" sm="12">
                                <v-text-field v-model="form.obat[index].desc" :error-messages="errors.name"
                                  :rules="[rules.required]" label="aturan" outlined dense small>
                                </v-text-field>
                              </v-col>
                              <v-col class="pa-0" cols="12" sm="12">
                                <v-btn color="red" small @click="form.obat.splice(index, 1)">
                                  <v-icon small>far fa-trash</v-icon>
                                </v-btn>
                              </v-col>
                            </div>
                            <!-- <v-col class="pa-0" cols="12" sm="12">
                              <p>Obat 1</p>
                            </v-col>
                            <v-col class="pa-0 mr-2" cols="12" sm="6">
                              <v-autocomplete :items="['inza', 'bodrex', 'komik']" label="Pilih Obat" outlined dense
                                hide-no-data flat item-text="name" item-value="name">
                              </v-autocomplete>
                            </v-col>
                            <v-col class="pa-0" cols="12" sm="5">
                              <v-text-field label="Jumlah" outlined dense small>
                              </v-text-field>
                            </v-col>
                            <v-col class="pa-0" cols="12" sm="12">
                              <v-text-field label="aturan" outlined dense small>
                              </v-text-field>
                            </v-col> -->
                            <v-col cols="12" sm="3">
                              <v-btn color="red" small @click="addObat">
                                <v-icon small>far fa-plus</v-icon>
                              </v-btn>
                            </v-col>
                            <v-col cols="12" sm="8">
                              <v-btn small @click="selectStore" color="primary">
                                Simpan
                              </v-btn>
                            </v-col>
                          </v-row>
                        </v-container>

                      </v-col>
                    </v-row>
                  </v-container>
                </v-card>
              </v-col>
            </v-row>
          </v-container>
        </v-form>
      </div>
      <div>
        <confirmation-dialog :confirmationDialog="dialogConfirmation" :method="
          condition == 'store'
            ? store
            : condition == 'update'
              ? update
              : remove
        " @changeDialogState="dialogConfirmation.state = $event">
        </confirmation-dialog>
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
      param: "",
      pasien: {
        umur: 0,
      },

      tindakan: {
        items: [
          { header: 'Pilih salah satu' },
        ],
        data: {}
      },
      valid: false,
      obat: {
        items: [],
        data: {}
      },

      web: {
        isTableLoad: false,
        filterOpen: false,
      },
      form: {
        obat: [
          {
            name: "",
            total: 0,
            desc: ""
          },
        ],
        rekamedis: {},
      },
      jumlahObat: 1,
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
      errors: [],
      rules: {
        required: (v) => !!v || "Tolong isi form.",
      },
      roles: [],
      currentData: {},
      currentUser: {},
      dialog: false,
      dialogConfirmation: {
        state: false,
        message: null,
      },
      condition: "store",
      selectItem: ["10", "25", "50", "100"],
      activator: null,
      attach: null,
      colors: ['green', 'purple', 'indigo', 'cyan', 'teal', 'orange'],
      editing: null,
      editingIndex: -1,
      items: [
        { header: 'Select an option or create one' },
        {
          text: 'Foo',
          color: 'blue',
        },
        {
          text: 'Bar',
          color: 'red',
        },
      ],
      nonce: 1,
      menu: false,
      model: [
        {
          text: 'Foo',
          color: 'blue',
        },
      ],
      x: 0,
      search: null,
      y: 0,
    };
  },
  methods: {
    orderAvailable(param) {
      this.orderItem.length = 0;
      this.parentData.forEach((v, i) => {
        if (v.name == param) {
          for (let index = 0; index <= v.count; index++) {
            this.orderItem.push(index + 1);
          }
        }
      });
    },
    filterTindakan(item, queryText, itemText) {
      if (item.header) return false

      const hasValue = val => val != null ? val : ''

      const text = hasValue(itemText)
      const query = hasValue(queryText)

      return text.toString()
        .toLowerCase()
        .indexOf(query.toString().toLowerCase()) > -1
    },
    changeID(event, index = 0) {
      if (event == "tindakan") {
        let currentID = this.form.rekamedis.tindakan;
        let index = currentID.length;
        this.tindakan.data.forEach((v) => {
          // console.log(v);
          if (v.description == currentID[index].text) {
            this.form.rekamedis.tindakan[index].tindakan_id = v.id;
          }
        });
      } else if (event == "obat") {
        // console.log(`obat index = ${index}`)
        let currentID = this.from.obat[index].name;
        this.obat.data.forEach((v) => {
          if (v.nama == currentID) {
            this.from.obat[index].obat_id = v.id;
          }
        });
      }
    },
    addObat() {
      this.form.obat.push({ name: "", desc: "", total: 0 });
    },
    setSelectedPasien() {
      axios
        .get(`/api/v1/daftar-pasien?param=` + this.param)
        .then((res) => {
          if (res.status === 200) {
            // console.log(res.data.umur);
            this.pasien = res.data.data;
            this.pasien.umur = res.data.umur; 
            this.form.rekamedis.pasien_id = this.pasien.pasien_id;
            this.form.rekamedis.regis_id = this.pasien.regis_id;
          } else {
            this.makeDefaultNotification(
              response.data.status,
              response.data.message
            );
          }
        });
    },
    setSelectedObat() {
      axios.get(`/api/v1/list-obat/`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.obat.items.push(v.nama);
          });
          this.obat.data = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSelectedTindakan() {
      axios.get(`/api/v1/list-tindakan/`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.tindakan.items.push({ "text": v.description, "color": "blue" });
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
    popDialog() {
      this.dialogConfirmation.state = !this.dialogConfirmation.state;
    },
    clear() {
      this.form.rekamedis = {};
      this.form.obat = [];
      this.errors = {};
      if (this.$refs.form) this.$refs.form.resetValidation();
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
    store() {
      let req = Object.assign(this.form, this.filter);
      this.currentData = null;
      axios
        .post(this._url, req)
        .then((response) => {
          if (response.status == 200) {
            this.clear();
            this.data = response.data.data;
            this.makeDefaultNotification(
              response.data.status,
              response.data.message
            );
            this.clear();
            this.filterPage();
          }
        })
        .catch((e) => {
          this.errorState(e);
        });
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
            this.data.data = response.data.data;
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
    this._url = window.location.origin + "/api/v1/rekamedis/";
    // console.log(this.$route.params.id);
    if (
      localStorage.getItem("current_param") != null &&
      localStorage.getItem("current_param")
    ) {
      if (
        this.$route.params.id != null &&
        this.$route.params.id != localStorage.getItem("current_param")
      ) {
        localStorage.setItem("current_param", this.$route.params.id);
      }
      this.param = localStorage.getItem("current_param");
    } else {
      if (this.$route.params.id) {
        localStorage.setItem("current_param", this.$route.params.id);
        this.param = this.$route.params.id;
      } else {
        this.$router.push({ name: "rawat-jalan-detail" });
      }
    }
    this.filterPage("");
    this.setSelectedPasien();
    this.setSelectedTindakan();
    this.setSelectedObat();
    // this.setSelectedResep();
    // 
  },
  computed: {
    modelTindakan() {
      return this.form.rekamedis.tindakan;
    },
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
    modelTindakan(val, prev) {
      if (val.length === prev.length) return

      this.form.rekamedis.tindakan = val.map(v => {
        if (typeof v === 'string') {
          v = {
            text: v,
            color: this.colors[this.nonce - 1],
          }
          this.nonce++
        }
        return v
      })

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
