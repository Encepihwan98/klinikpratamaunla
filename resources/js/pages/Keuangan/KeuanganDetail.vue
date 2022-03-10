<template>
  <v-app>
    <vertical-nav-menu
      :is-drawer-open.sync="isDrawerOpen"
      :modules="modules"
    ></vertical-nav-menu>
    <app-bar></app-bar>
    <v-main>
      <div class="app-content-container boxed-container pa-6">
        <v-expansion-panels focusable v-model="panel">
          <v-expansion-panel>
            <v-expansion-panel-header
              >Poli Klinik Mata</v-expansion-panel-header
            >
            <v-expansion-panel-content>
              <v-from>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        label="Nama Pasien"
                        placeholder="Pasien"
                        outlined
                        dense
                        small
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        label="Tempat, Tanggal Lahir"
                        placeholder="Tempat, Tanggal Lahir"
                        outlined
                        dense
                        small
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        label="Alamat"
                        placeholder="Alamat"
                        outlined
                        dense
                        small
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-from>
            </v-expansion-panel-content>
          </v-expansion-panel>
        </v-expansion-panels>

        <v-card elevation="4">
          <div class="d-flex flex-column mt-9">
            <v-card class="pa-2" outlined tile> Rincian Transaksi </v-card>
          </div>

          <v-simple-table>
            <template v-slot:default>
              <!-- <thead>
                <tr>
                <th class="text-left">
                    No
                </th>
                <th class="text-left">
                    Nomor Kunjungan
                </th>
                <th class="text-left">
                    Pasien
                </th>
                <th class="text-left">
                    Waktu Masuk
                </th>
                <th class="text-left">
                    Waktu Keluar
                </th>
                <th class="text-left">
                    Diagnosa Awal
                </th>
                <th class="text-left">
                    View 
                </th>
                </tr>
            </thead> -->
              <tbody>
                <tr>
                  <td class="font-weight-bold text-center" rowspan="2">
                    Layanan
                  </td>
                  <td class="font-weight-bold text-center" rowspan="2">
                    Jumlah
                  </td>
                  <td class="font-weight-bold text-center" colspan="4">
                    Tarif
                  </td>
                  <td class="font-weight-bold text-center" rowspan="2">
                    Tangguangn
                  </td>
                  <td class="font-weight-bold text-center" rowspan="2">
                    Total
                  </td>
                </tr>
                <tr>
                  <td>Saran</td>
                  <td>Pelayanan</td>
                  <td>BHP</td>
                  <td>Total</td>
                </tr>
                <tr>
                  <td class="font-weight-bold text-center" colspan="8">
                    Registrasi
                  </td>
                </tr>
                <tr>
                  <td>Unit Rawat Darurat</td>
                  <td>1</td>
                  <td>2500</td>
                  <td>2000</td>
                  <td>0</td>
                  <td>4500</td>
                  <td>0</td>
                  <td>4500</td>
                </tr>
                <tr>
                  <td class="font-weight-bold text-center" colspan="8">IGD</td>
                </tr>
                <tr>
                  <td class="font-weight-bold text-center" colspan="8">
                    Tindakan Pemeriksaan
                  </td>
                </tr>

                <tr v-for="(value, key, index) in post" :key="index">
                  <td>{{ value.description }}</td>
                  <td>1</td>
                  <td>
                    {{ Intl.NumberFormat("en-US").format(value.rate.SARANA) }}
                  </td>
                  <td>
                    {{
                      Intl.NumberFormat("en-US").format(value.rate.PELAYANAN)
                    }}
                  </td>
                  <td>
                    {{ Intl.NumberFormat("en-US").format(value.rate.BHP) }}
                  </td>
                  <td>
                    {{
                      Intl.NumberFormat("en-US").format(
                        parseInt(value.rate.SARANA) +
                          parseInt(value.rate.PELAYANAN) +
                          parseInt(value.rate.BHP)
                      )
                    }}
                  </td>
                  <td>0</td>
                  <td>
                    {{
                      Intl.NumberFormat("en-US").format(
                        parseInt(value.rate.BHP) +
                          parseInt(value.rate.PELAYANAN) +
                          parseInt(value.rate.SARANA)
                      )
                    }}
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold text-center" colspan="8">
                    Layanan Laboratorium
                  </td>
                </tr>
                <tr
                  v-for="(nilai, key, index) in layananLaboratorium"
                  :key="index"
                >
                  <td>Laboratorium</td>
                  <td>1</td>
                  <td>{{ Intl.NumberFormat("en-US").format(nilai.SARANA) }}</td>
                  <td>{{ Intl.NumberFormat("en-US").format(nilai.BHP) }}</td>
                  <td>
                    {{ Intl.NumberFormat("en-US").format(nilai.PELAYANAN) }}
                  </td>
                  <td>
                    {{
                      Intl.NumberFormat("en-US").format(
                        parseInt(nilai.SARANA) +
                          parseInt(nilai.BHP) +
                          parseInt(nilai.PELAYANAN)
                      )
                    }}
                  </td>
                  <td></td>
                  <td>
                    {{
                      Intl.NumberFormat("en-US").format(
                        parseInt(nilai.SARANA) +
                          parseInt(nilai.BHP) +
                          parseInt(nilai.PELAYANAN)
                      )
                    }}
                  </td>
                </tr>
                <tr v-if="layananInsenerator != null">
                  <td class="font-weight-bold text-center" colspan="8">
                    Layanan Insenerator
                  </td>
                </tr>
                <tr
                  v-for="(nilai, key, index) in layananInsenerator"
                  :key="index"
                >
                  <td>insenerator</td>
                  <td>1</td>
                  <td>{{ Intl.NumberFormat("en-US").format(nilai.SARANA) }}</td>
                  <td>{{ Intl.NumberFormat("en-US").format(nilai.BHP) }}</td>
                  <td>
                    {{ Intl.NumberFormat("en-US").format(nilai.PELAYANAN) }}
                  </td>
                  <td>
                    {{
                      Intl.NumberFormat("en-US").format(
                        parseInt(nilai.SARANA) +
                          parseInt(nilai.BHP) +
                          parseInt(nilai.PELAYANAN)
                      )
                    }}
                  </td>
                  <td></td>
                  <td>
                    {{
                      Intl.NumberFormat("en-US").format(
                        parseInt(nilai.SARANA) +
                          parseInt(nilai.BHP) +
                          parseInt(nilai.PELAYANAN)
                      )
                    }}
                  </td>
                </tr>
                <tr v-if="layananOperasi != null">
                  <td class="font-weight-bold text-center" colspan="8">
                    Layanan Operasi
                  </td>
                </tr>
                <tr v-for="(nilai, key, index) in layananOperasi" :key="index">
                  <td>Operasi</td>
                  <td>1</td>
                  <td>{{ Intl.NumberFormat("en-US").format(nilai.SARANA) }}</td>
                  <td>{{ Intl.NumberFormat("en-US").format(nilai.BHP) }}</td>
                  <td>
                    {{ Intl.NumberFormat("en-US").format(nilai.PELAYANAN) }}
                  </td>
                  <td>
                    {{
                      Intl.NumberFormat("en-US").format(
                        parseInt(nilai.SARANA) +
                          parseInt(nilai.BHP) +
                          parseInt(nilai.PELAYANAN)
                      )
                    }}
                  </td>
                  <td></td>
                  <td>
                    {{
                      Intl.NumberFormat("en-US").format(
                        parseInt(nilai.SARANA) +
                          parseInt(nilai.BHP) +
                          parseInt(nilai.PELAYANAN)
                      )
                    }}
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold text-center" colspan="8">
                    Layanan Radiologi
                  </td>
                </tr>
                <tr
                  v-for="(nilai, key, index) in layananRadiologi"
                  :key="index"
                >
                  <td>Radiologi</td>
                  <td>1</td>
                  <td>{{ Intl.NumberFormat("en-US").format(nilai.SARANA) }}</td>
                  <td>{{ Intl.NumberFormat("en-US").format(nilai.BHP) }}</td>
                  <td>
                    {{ Intl.NumberFormat("en-US").format(nilai.PELAYANAN) }}
                  </td>
                  <td>
                    {{
                      Intl.NumberFormat("en-US").format(
                        parseInt(nilai.SARANA) +
                          parseInt(nilai.BHP) +
                          parseInt(nilai.PELAYANAN)
                      )
                    }}
                  </td>
                  <td></td>
                  <td>
                    {{
                      Intl.NumberFormat("en-US").format(
                        parseInt(nilai.SARANA) +
                          parseInt(nilai.BHP) +
                          parseInt(nilai.PELAYANAN)
                      )
                    }}
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold text-center" colspan="8">
                    Layanan UTDRS
                  </td>
                </tr>
                <tr v-for="(nilai, key, index) in layananUtdrs" :key="index">
                  <td>UTDRS</td>
                  <td>1</td>
                  <td>{{ Intl.NumberFormat("en-US").format(nilai.SARANA) }}</td>
                  <td>{{ Intl.NumberFormat("en-US").format(nilai.BHP) }}</td>
                  <td>
                    {{ Intl.NumberFormat("en-US").format(nilai.PELAYANAN) }}
                  </td>
                  <td>
                    {{
                      Intl.NumberFormat("en-US").format(
                        parseInt(nilai.SARANA) +
                          parseInt(nilai.BHP) +
                          parseInt(nilai.PELAYANAN)
                      )
                    }}
                  </td>
                  <td></td>
                  <td>
                    {{
                      Intl.NumberFormat("en-US").format(
                        parseInt(nilai.SARANA) +
                          parseInt(nilai.BHP) +
                          parseInt(nilai.PELAYANAN)
                      )
                    }}
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold text-center" colspan="8">
                    Layanan Kamar Jenazah
                  </td>
                </tr>
                <tr
                  v-for="(nilai, key, index) in layananKamarJenazah"
                  :key="index"
                >
                  <td>Kamar Jenazah</td>
                  <td>1</td>
                  <td>{{ Intl.NumberFormat("en-US").format(nilai.SARANA) }}</td>
                  <td>{{ Intl.NumberFormat("en-US").format(nilai.BHP) }}</td>
                  <td>
                    {{ Intl.NumberFormat("en-US").format(nilai.PELAYANAN) }}
                  </td>
                  <td>
                    {{
                      Intl.NumberFormat("en-US").format(
                        parseInt(nilai.SARANA) +
                          parseInt(nilai.BHP) +
                          parseInt(nilai.PELAYANAN)
                      )
                    }}
                  </td>
                  <td></td>
                  <td>
                    {{
                      Intl.NumberFormat("en-US").format(
                        parseInt(nilai.SARANA) +
                          parseInt(nilai.BHP) +
                          parseInt(nilai.PELAYANAN)
                      )
                    }}
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold text-center" colspan="7">
                    Total
                  </td>
                  <td>{{ Intl.NumberFormat("en-US").format(total) }}</td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
        </v-card>
      </div>
    </v-main>
    <footer></footer>
  </v-app>
</template>



<script>
import { ref } from "@vue/composition-api";
import { mdiMagnify, mdiBellOutline, mdiGithub } from "@mdi/js";

export default {
  props: {
    modules: [],
    base: {},
  },
  data() {
    return {
      isOpen: "",
      // baseDataRoom: {},
      // baseDataActivity: {},
      param: "",
      tab: null,
      diagnosis: {
        data: {},
        items: [],
      },
      rate: [],
      layananLaboratorium: [],
      layananOperasi: [],
      layananRadiologi: [],
      layananInsenerator: [],
      layananUtdrs: [],
      layananKamarJenazah: [],
      layanan: {},
      support: {
        data: {},
        items: [],
      },
      general_inspection: {
        data: {},
        items: [],
      },
      currentData: 0,
      recipe: {
        data: {},
        items: [],
      },
      totalLaboratorium: 0,
      totalOperasi: 0,
      totalRadiologi: 0,
      totalInsenerator: 0,
      totalUtdrs: 0,
      totalKamarJenazah: 0,
      totalTindakan: 0,
      total: 0,
      action: [],
      post: [],
      data: {},
      filter: {
        page: 1,
        searchQuery: "",
        limit: 10,
        sortBy: "id",
        orderBy: "asc",
      },
      text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
    };
  },

  setup() {
    const isDrawerOpen = ref(null);

    return {
      isDrawerOpen,
      panel: [1, 1],

      // Icons
      icons: {
        mdiMagnify,
        mdiBellOutline,
        mdiGithub,
      },
    };
  },

  methods: {
    setSelectedPemeriksaanUmum() {
      axios
        .get(`/api/v1/layanan-pemeriksaan?param=` + this.param)
        .then((res) => {
          if (res.status === 200) {
            this.general_inspection = res.data.data;
          } else {
            this.makeDefaultNotification(
              response.data.status,
              response.data.message
            );
          }
        });
    },
    setSelectedResep() {
      axios.get(`/api/v1/layanan-resep?param=` + this.param).then((res) => {
        if (res.status === 200) {
          this.recipe = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
    setSelectedLayanan() {
      axios
        .get(`/api/v1/penunjang-tindakan?param=` + this.param)
        .then((res) => {
          // console.log(res.data.data[1]['rate']);
          this.action.push(res.data.data);
          this.layanan = res.data.data;
          // console.log(this.layanan);
          res.data.data.forEach((v) => {
            if (v.polyclinic == "laboratorium") {
              this.layananLaboratorium.push(
                res.data.data[this.currentData]["rate"]
              );
            } else if (v.polyclinic == "operasi") {
              this.layananOperasi.push(res.data.data[this.currentData]["rate"]);
            } else if (v.polyclinic == "radiologi") {
              this.layananRadiologi.push(
                res.data.data[this.currentData]["rate"]
              );
              // for(int i = 0; i < this.layananRadiologi.length; i++);
            } else if (v.polyclinic == "insenerator") {
              this.layananInsenerator.push(
                res.data.data[this.currentData]["rate"]
              );
            } else if (v.polyclinic == "UTDRS") {
              this.layananUtdrs.push(res.data.data[this.currentData]["rate"]);
            } else if (v.polyclinic == "Kamar Jenazah") {
              this.layananKamarJenazah.push(
                res.data.data[this.currentData]["rate"]
              );
            }
          });
          this.totalLaboratorium = this.layananLaboratorium.reduce(function (
            accumulator,
            item
          ) {
            return (
              accumulator +
              parseInt(item.PELAYANAN) +
              parseInt(item.SARANA) +
              parseInt(item.BHP)
            );
          },
          0);
          this.totalOperasi = this.layananOperasi.reduce(function (
            accumulator,
            item
          ) {
            return (
              accumulator +
              parseInt(item.PELAYANAN) +
              parseInt(item.SARANA) +
              parseInt(item.BHP)
            );
          },
          0);
          this.totalRadiologi = this.layananRadiologi.reduce(function (
            accumulator,
            item
          ) {
            return (
              accumulator +
              parseInt(item.PELAYANAN) +
              parseInt(item.SARANA) +
              parseInt(item.BHP)
            );
          },
          0);
          this.totalInsenerator = this.layananInsenerator.reduce(function (
            accumulator,
            item
          ) {
            return (
              accumulator +
              parseInt(item.PELAYANAN) +
              parseInt(item.SARANA) +
              parseInt(item.BHP)
            );
          },
          0);
          this.totalUtdrs = this.layananUtdrs.reduce(function (
            accumulator,
            item
          ) {
            return (
              accumulator +
              parseInt(item.PELAYANAN) +
              parseInt(item.SARANA) +
              parseInt(item.BHP)
            );
          },
          0);
          this.totalKamarJenazah = this.layananKamarJenazah.reduce(function (
            accumulator,
            item
          ) {
            return ( accumulator + parseInt(item.PELAYANAN) + parseInt(item.SARANA) + parseInt(item.BHP)
            );
          },
          0);
          this.total =
            this.totalLaboratorium + this.totalOperasi + this.totalTindakan + this.totalRadiologi 
            + this.totalInsenerator + this.totalUtdrs + this.totalKamarJenazah;
        });
    },

    setSelectedAction() {
      axios
        .get(`/api/v1/layanan-tindakan-rate?param=` + this.param)
        .then((res) => {
          // console.log(res.data.data[1]['rate']);
          this.action.push(res.data.data);
          this.post = res.data.data;
          this.post.forEach((v) => {
            this.rate.push(res.data.data[this.currentData]["rate"]);
          });
          this.totalTindakan = this.rate.reduce(function (accumulator, item) {
            return (
              accumulator +
              parseInt(item.PELAYANAN) +
              parseInt(item.SARANA) +
              parseInt(item.BHP)
            );
          }, 0);
        });
    },

    setSelectedDiagnosa() {
      axios.get(`/api/v1/layanan-diagnosa?param=` + this.param).then((res) => {
        if (res.status === 200) {
          this.diagnosis = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },

    setSelectedPenujang() {
      axios.get(`/api/v1/layanan-penunjang?param=` + this.param).then((res) => {
        if (res.status === 200) {
          this.support = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },

    setSelectedTarifKeungan() {
      axios
        .get(
          `/api/v1/tarif-keuangan?param=` +
            this.param +
            this.filter.orderBy +
            "&select=all"
        )
        .then((res) => {
          if (res.status === 200) {
            this.support = res.data.data;
          } else {
            this.makeDefaultNotification(
              response.data.status,
              response.data.message
            );
          }
        });
    },

    filterPage(sort_by) {
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
        this.filter.orderBy +
        "&select=all";
      axios
        .get(url)
        .then((response) => {
          // console.log(response);
          if (response.status == 200) {
            this.data = response.data.data;
            this.filter.page = response.data.data.current_page;
            this.getCurrentUser();
          }
        })
        .catch((e) => {
          this.errorState(e);
        });
    },
  },
  created() {
    this._url = window.location.origin + "/api/v1/keungan-detail/";
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
    this.setSelectedPemeriksaanUmum();
    this.setSelectedResep();
    this.setSelectedDiagnosa();
    this.setSelectedPenujang;
    this.setSelectedAction();
    this.setSelectedTarifKeungan();
    this.setSelectedLayanan();
  },
  // computed: {
  //   dialogState() {
  //     return this.dialog.state;
  //   },
  // },
  // watch: {
  //   dialogState: function (n, o) {
  //     console.log(n);
  //     if (n && this.currentData) this.show(this.currentData.id);
  //     else this.clear();
  //   },
  //   modules: function (n, o) {
  //     let access = this.redirectIfNotHaveAccess(n, this.$route.fullPath);
  //     if (Object.keys(access).length === 1 && access.constructor === Object) {
  //       this.$router.push({ name: access.home });
  //     } else {
  //       this.web = access;
  //     }
  //   },
  // },
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
