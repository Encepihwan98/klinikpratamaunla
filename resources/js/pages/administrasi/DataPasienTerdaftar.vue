<template>
  <v-app>
    <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen" :modules="modules"></vertical-nav-menu>
    <app-bar></app-bar>
    <v-main>
      <div class="app-content-container pa-6">
        <!-- <v-row>
          <v-col cols="12" sm="4">
            <v-card>
              <v-container>
                <p class="font-weight-bold">
                  <v-icon small>far fa-edit</v-icon>Total Pasien
                </p>
                <p class="text-h3">3</p>
              </v-container>
            </v-card>
          </v-col>
          <v-col cols="12" sm="4">
            <v-card>
              <v-container>
                <p class="font-weight-bold">
                  <v-icon small>far fa-edit</v-icon>Pasien Bulan Ini
                </p>
                <p class="text-h3">3</p>
              </v-container>
            </v-card>
          </v-col>
          <v-col cols="12" sm="4">
            <v-card>
              <v-container>
                <p class="font-weight-bold">Pasien Hari ini</p>
                <p class="text-h3">0</p>
              </v-container>
            </v-card>
          </v-col>
        </v-row> -->
        <v-row>
          <v-col cols="12" sm="12">
            <v-card>
              <v-card-text>
                <p class="text-h6"> Data Pasien Terdaftar</p>
              </v-card-text>
              <v-row>
                <v-col class="d-flex" cols="12" sm="2">
                  <v-select v-model="filter.limit" dense :items="selectItem" label="Tampilkan" @input="filterPage('')"
                    outlined>
                  </v-select>
                </v-col>

                <v-col class="d-flex" cols="12" sm="8">
                  <v-text-field v-model="filter.searchQuery" dense append-icon="far fa-search" outlined clearable
                    label="Search" type="text" @click:append="filterPage('')" @input="filterPage('')"></v-text-field>
                </v-col>
                <v-col cols="12" sm="2" class="">
                  <v-btn dense smal @click="printLaporan" color="red">
                    Export To PDF
                    <v-icon right dark>
                      far fa-file-pdf
                    </v-icon>
                  </v-btn>
                </v-col>
              </v-row>
              <v-simple-table dense>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-left">No</th>
                      <th class="text-left">ID</th>
                      <th class="text-left">Name</th>
                      <th class="text-left">Alamat</th>
                      <th class="text-left">Jenis Kelamin</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in data.data" :key="item.name">
                      <td>{{ index + data.from }}</td>
                      <td>{{ item.pasien_id }}</td>
                      <td>{{ item.nama }}</td>
                      <td>{{ item.alamat }}</td>
                      <td>{{ item.jenis_kelamin }}</td>
                      <td class="center-center">
                        <v-btn small @click="selectMethod(item, 'edit')">
                          <v-icon small>far fa-edit</v-icon>
                        </v-btn>
                        <v-btn small @click="selectMethod(item, 'delete')">
                          <v-icon small>far fa-trash</v-icon>
                        </v-btn>
                        <v-btn small @click="selectMethod(item, 'add')">
                          <v-icon small>far fa-plus</v-icon>
                        </v-btn>
                        <v-btn small @click="selectMethod(item, 'sehat')">
                          <v-icon small>far fa-tablets</v-icon>
                        </v-btn>
                        <v-btn small @click="selectMethod(item, 'sakit')">
                          <v-icon small>far fa-viruses</v-icon>
                        </v-btn>
                        <a :href="`/api/v1/print-kartuberobat/${item.pasien_id}`">
                          <v-btn small>
                            <v-icon small>far fa-print</v-icon>
                          </v-btn>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
              <v-card-actions class="d-flex justify-center">
                <v-pagination v-model="filter.page" :length="data.last_page" :total-visible="7" @input="filterPage('')">
                </v-pagination>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </div>
      <div>
        <v-dialog v-model="dialogs.dialogDataPasien.state" persistent max-width="600px">
          <v-card>
            <v-card-title class="text-h5"> Edit Data </v-card-title>

            <v-form ref="form" v-model="valid" class="mx-3 my-3">
              <v-container>
                <v-row>
                  <v-col class="pa-0" cols="12" sm="12">
                    <v-text-field label="ID" v-model="pasien.pasien_id" outlined dense small disabled></v-text-field>
                  </v-col>
                  <v-col class="pa-0" cols="12" sm="12">
                    <v-text-field label="Nama" v-model="pasien.nama" placeholder="Maman Abdul" outlined dense small>
                    </v-text-field>
                  </v-col>
                  <v-col class="pa-0" cols="12" sm="12">
                    <v-text-field label="No Ktp" v-model="pasien.no_ktp" placeholder="088686xxxx" outlined dense small>
                    </v-text-field>
                  </v-col>
                  <v-col cols="12" class="pa-0 mr-2" sm="6" md="4">
                    <v-menu v-model="menu2" :close-on-content-click="false" :nudge-right="40"
                      transition="scale-transition" offset-y min-width="auto">
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field v-model="pasien.tgl_lahir" label="Tanggal Lahir" prepend-icon="mdi-calendar"
                          readonly v-bind="attrs" v-on="on" outlined dense></v-text-field>
                      </template>
                      <v-date-picker v-model="pasien.tgl_lahir" @input="menu2 = false"></v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col class="pa-0 mr-6" cols="12" sm="12">
                    <v-select :items="['laki-laki', 'perempuan']" v-model="pasien.jenis_kelamin" label="Jenis Kelamin"
                      dense outlined></v-select>
                  </v-col>
                  <v-col cols="12" class="pa-0" sm="12">
                    <v-text-field label="Pekerjaan" v-model="pasien.pekerjaan" placeholder="Polisi" outlined dense
                      small></v-text-field>
                  </v-col>
                  <v-col cols="12" class="pa-0 mr-2" sm="4">
                    <v-text-field label="No Telp/Hp" v-model="pasien.no_hp" placeholder="082xxxxxxxx" outlined dense
                      small></v-text-field>
                  </v-col>
                  <v-col class="d-flex pa-0 mr-2" cols="12" sm="4">
                    <v-select :items="dokter.items" @input="changeID('dokter')" v-model="pasien.user_nama"
                      label="Pilih Dokter" dense outlined>
                    </v-select>
                  </v-col>
                  <v-col cols="12" class="pa-0" sm="12">
                    <v-textarea label="Alamat" v-model="pasien.alamat" auto-grow outlined rows="1" row-height="15">
                    </v-textarea>
                  </v-col>
                  <v-col cols="12" sm="12">
                    <v-btn class="mr-4" @click="selectStore"> Submit </v-btn>
                    <v-btn @click="dialogs.dialogDataPasien.state = false"> Close </v-btn>
                  </v-col>
                </v-row>
              </v-container>
            </v-form>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogs.dialogAntrian.state" persistent max-width="500px">
          <v-card>
            <v-card-title class="text-h5"> Registrasi Pasien </v-card-title>

            <v-form ref="form" v-model="valid" class="mx-3 my-3 mb-2">
              <v-container>
                <v-row>
                  <v-col class="pa-0" cols="12" sm="12">
                    <v-text-field label="ID Pasien" placeholder="PS001" v-model="pasien.pasien_id" outlined dense small
                      disabled></v-text-field>
                  </v-col>
                  <v-col class="pa-0" cols="12" sm="12">
                    <v-text-field label="Nama Pasien" placeholder="nama" v-model="pasien.nama" outlined dense small
                      disabled></v-text-field>
                  </v-col>
                  <v-col class="d-flex pa-0" cols="12" sm="12">
                    <v-select :items="dokter.items" v-model="pasien.dokter" @click="changeID('dokter')"
                      label="Pilih Dokter" dense outlined></v-select>
                  </v-col>
                  <v-col class="d-flex pa-0" cols="12" sm="12">
                    <v-select :items="['BPJS', 'Umum']" v-model="pasien.jenis_pembayaran" label="Jenis Pembayaran" dense
                      outlined></v-select>
                  </v-col>
                  <v-col class="mb-2" cols="12" sm="12">
                    <v-btn class="mr-4" @click="selectStore">
                      Tambah Ke antrian
                    </v-btn>
                    <v-btn @click="dialogs.dialogAntrian.state = false"> close </v-btn>
                  </v-col>
                </v-row>
              </v-container>
            </v-form>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogs.dialogSehat.state" persistent max-width="500px">
          <v-card>
            <v-card-title class="text-h5"> Surat Sehat Pasien </v-card-title>

            <v-form ref="form" v-model="valid" class="mx-3 my-3 mb-2">
              <v-container>
                <v-row>
                  <v-col class="pa-0" cols="12" sm="12">
                    <v-text-field label="Keperluan" placeholder="keperluan" v-model="sehat.keperluan" outlined dense
                      small></v-text-field>
                  </v-col>
                  <v-col class="mb-2" cols="12" sm="12">
                    <a :href="`/api/v1/surat-keterangan/${sehat.pasien_id}?sehat=1&keperluan=${sehat.keperluan}`">
                      <v-btn class="mr-4">
                        Print
                      </v-btn>
                    </a>
                    <v-btn @click="dialogs.dialogSehat.state = false"> close </v-btn>
                  </v-col>
                </v-row>
              </v-container>
            </v-form>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogs.dialogSakit.state" persistent max-width="500px">
          <v-card>
            <v-card-title class="text-h5"> Surat Sakit Pasien </v-card-title>

            <v-form ref="form" v-model="valid" class="mx-3 my-3 mb-2">
              <v-container>
                <v-row>
                  <v-col class="pa-0" cols="12" sm="12">
                    <v-text-field label="Jumlah Istirahat" placeholder="1 Hari" v-model="sakit.jumlah" outlined dense
                      small></v-text-field>
                  </v-col>
                  <v-col class="pa-0" cols="12" sm="5">
                    <v-menu outlined v-model="menu4" :close-on-content-click="false" :nudge-right="40"
                      transition="scale-transition" offset-y min-width="auto">
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field outlined dense v-model="sakit.date" label="Pilih Tanggal"
                          prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on">
                        </v-text-field>
                      </template>
                      <v-date-picker v-model="sakit.date" @input="menu4 = false">
                      </v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col class="pa-0" cols="12" sm="2">
                    <p class="text-center mt-3">s/d</p>
                  </v-col>
                  <v-col class="pa-0" cols="12" sm="5">
                    <v-menu v-model="menu3" :close-on-content-click="false" :nudge-right="40"
                      transition="scale-transition" offset-y min-width="auto">
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field outlined dense v-model="sakit.date1" label="Pilih Tanggal"
                          prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on">
                        </v-text-field>
                      </template>
                      <v-date-picker v-model="sakit.date1" @input="menu3 = false">
                      </v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col class="mb-2" cols="12" sm="12">
                    <a
                      :href="`/api/v1/surat-keterangan/${sakit.pasien_id}?sakit=1&jumlahIstirahat=${sakit.jumlah}&from=${sakit.date}&to=${sakit.date1}`">
                      <v-btn class="mr-4">
                        Print
                      </v-btn>
                    </a>
                    <v-btn @click="dialogs.dialogSakit.state = false"> close </v-btn>
                  </v-col>
                </v-row>
              </v-container>
            </v-form>
          </v-card>
        </v-dialog>

        <v-dialog v-model="dialogs.dialogLaporan.state" persistent max-width="400px">
          <v-card>
            <v-card-title class="text-h5"> Laporan Data Pasien </v-card-title>
            <v-form class="mx-3 my-3" ref="form" v-model="valid" lazy-validation :currentData="currentData">
              <v-container>
                <v-row>
                  <v-col class="pa-0" cols="12" sm="5">
                    <v-menu v-model="menu5" :close-on-content-click="false" :nudge-right="40"
                      transition="scale-transition" offset-y min-width="auto">
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field v-model="laporan.date" label="Pilih Tanggal" prepend-icon="mdi-calendar" readonly
                          v-bind="attrs" v-on="on">
                        </v-text-field>
                      </template>
                      <v-date-picker v-model="laporan.date" @input="menu5 = false">
                      </v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col class="pa-0" cols="12" sm="2">
                    <p class="text-center mt-3">s/d</p>
                  </v-col>
                  <v-col class="pa-0" cols="12" sm="5">
                    <v-menu v-model="menu6" :close-on-content-click="false" :nudge-right="40"
                      transition="scale-transition" offset-y min-width="auto">
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field v-model="laporan.date1" label="Pilih Tanggal" prepend-icon="mdi-calendar" readonly
                          v-bind="attrs" v-on="on">
                        </v-text-field>
                      </template>
                      <v-date-picker v-model="laporan.date1" @input="menu6 = false">
                      </v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col cols="12" sm="12">
                    <!-- <v-btn class="mr-4" @click="selectPrint"> Print </v-btn> -->
                    <v-btn>
                      <a :href="`/api/v1/laporan-pasien/?awal=${laporan.date}&akhir=${laporan.date1}`" class="mr-4"
                        download> Print </a>
                    </v-btn>
                    <v-btn @click="dialogs.dialogLaporan.state = false"> Close </v-btn>
                  </v-col>
                </v-row>
              </v-container>
            </v-form>
          </v-card>
        </v-dialog>
        <confirmation-dialog :confirmationDialog="dialogConfirmation" :method="
          condition == 'store'
            ? store
            : condition == 'update'
              ? update
              : remove
        " @changeDialogState="dialogConfirmation.state = $event"></confirmation-dialog>
      </div>
    </v-main>
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
      laporan: {
        date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        date1: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
      },
      valid: false,
      sakit: {
        date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        date1: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
      },
      sehat: {},
      menu3: false,
      menu4: false,
      menu5: false,
      menu6: false,
      pasien: {
        tgl_lahir: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
          .toISOString()
          .substr(0, 10),
      },
      antri: "/?status=antri",
      dokter: {
        items: [],
        data: {},
      },
      dialogs: {
        dialogAntrian: {
          state: false,
          title: null,
        },
        dialogDataPasien: {
          state: false,
          title: null,
        },
        dialogSehat: {
          state: false,
          title: null,
        },
        dialogSakit: {
          state: false,
          title: null,
        },
        dialogLaporan: {
          state: false,
          title: null,
        }
      },
      dialog: false,
      _url: "",
      urlStatus: "",
      urlPrint: "",
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
      // dialog: {
      //   state: false,
      //   title: null,
      // },
      dialogConfirmation: {
        state: false,
        message: null,
      },
      items: ["Pria", "Wanita"],
      menu: false,
      modal: false,
      menu2: false,
      condition: "store",
      selectItem: ["10", "25", "50", "100"],
    };
  },

  methods: {
    printLaporan() {
      this.condition = "laporan";
      this.showDialog(false);
    },
    printPdf(data, item) {
      this.pasien = data;
      let req = Object.assign(this.pasien, this.filter);
      console.log(this.pasien.pasien_id);
      this.urlPrint = window.location.origin + "/api/v1/print-kartuberobat/";
      axios
        .get(`${this.urlPrint}${this.pasien.pasien_id}`, req)
        .then((response) => {
          if (response.status == 'success') {
            // this.dialogs.dialogDataPasien.state = false;
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
    setSelectedDokter() {
      axios.get(`/api/v1/list-dokter/`).then((res) => {
        if (res.status === 200) {
          res.data.data.forEach((v) => {
            this.dokter.items.push(v.name);
          });
          this.dokter.data = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    changeID(event) {
      if (event == "dokter") {
        let currentID = this.pasien.dokter;
        this.dokter.data.forEach((v) => {
          if (v.nama == currentID) {
            this.pasien.dokter_id = v.id;
          }
        });
      }
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
        this.condition = "delete";
        // console.log("ini untuk remove");
        this.dialogConfirmation.message = "menghapus";
        this.showDialog(true);
      } else if (item == "add") {
        this.pasien = data;
        this.currentData = null;
        this.condition = "store";
        this.dialogs.dialogAntrian.title = "Tambah Data";
        this.showDialog(false);
      } else if (item == "show") {
        this.condition = "show";
        this.dialogs.dialogDataPasien.title = "Data Pasien";
        this.showDialog(false);
      } else if (item == "edit") {
        this.pasien = data;
        this.condition = "update";
        this.dialogs.dialogDataPasien.title = "Edit Pasien";
        this.showDialog(false);
      } else if (item == 'sehat') {
        this.sehat = data;
        this.condition = "sehat";
        this.dialogs.dialogDataPasien.title = "Surat Sehat Pasien";
        this.showDialog(false);
      } else if (item == 'sakit') {
        this.sakit = data;
        this.condition = "sakit";
        this.dialogs.dialogDataPasien.title = "Surat Sehat Pasien";
        this.showDialog(false);
      } 
    },
    store() {
      let req = Object.assign(this.pasien, this.filter);
      this.urlStatus = window.location.origin + "/api/v1/update-status-pasien/";
      this.currentData = null;
      axios
        .post(`${this.urlStatus}`, req)
        .then((response) => {
          if (response.status == 200) {
            this.dialogs.dialogAntrian.state = false;
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
      let req = Object.assign(this.pasien, this.filter);
      axios
        .put(`${this._url}${this.pasien.pasien_id}`, req)
        .then((response) => {
          console.log(response);
          this.dialogs.dialogDataPasien.state = false;
          this.retriveData = response.data.data;
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );

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
          if (response.status == 'success') {
            this.pasien = response.data.data;
          }
        })
        .catch((e) => {
          this.errorState(e);
        });
    },
    popDialog() {
      this.dialogConfirmation.state = !this.dialogConfirmation.state;
    },
    remove() {
      this.web.isTableLoad = true;
      // console.log("ini untuk remove");
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
      this.dialogs.dialogDataPasien.title = "Edit";
      this.showDialog(false);
    },
    add() {
      this.currentData = null;
      this.condition = "store";
      this.dialogs.dialogDataPasien.title = "Tambah Data";
      this.showDialog(false);
    },
    showDialog(isConfirmation) {
      if (isConfirmation) {
        this.dialogConfirmation.state = !this.dialogConfirmation.state;
      } else {
        if (this.condition == "store") {
          this.dialogs.dialogAntrian.state = !this.dialogs.dialogAntrian.state;
        } else if (this.condition == "sehat") {
          this.dialogs.dialogSehat.state = !this.dialogs.dialogSehat.state;
        } else if (this.condition == "sakit") {
          this.dialogs.dialogSakit.state = !this.dialogs.dialogSakit.state;
        } else if (this.condition == "laporan") {
          this.dialogs.dialogLaporan.state = !this.dialogs.dialogLaporan.state;
        } else {
          this.dialogs.dialogDataPasien.state = !this.dialogs.dialogDataPasien.state;
        }
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

    updateStatus(data, item) {
      this.pasien = data;
      let req = Object.assign(this.pasien, this.filter);
      console.log(this.pasien);
      this.urlStatus = window.location.origin + "/api/v1/update-status-pasien/" + this.pasien.pasien_id + "?status=" + this.antri;
      // console.log(this.urlStatus); 
      axios
        .post(this.urlStatus)
        .then((response) => {
          // console.log(response); 
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

    changeData(newdata) {
      this.data = newdata;
    },
    errorState(e) {
      // console.log(e.response);
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
    this.setSelectedDokter();
  },
  computed: {
    computedDateFormatted() {
      return this.formatDate(this.date);
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