<template>
  <v-app>
    <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen" :modules="modules"></vertical-nav-menu>
    <app-bar></app-bar>
    <v-main>
      <div class="app-content-container boxed-container pa-6">
          <v-expansion-panels 
            focusable
            v-model="panel"
        >
            <v-expansion-panel>
                <v-expansion-panel-header>Poli Klinik Mata</v-expansion-panel-header>
                <v-expansion-panel-content>
                    <v-from>
                        <v-container>
                            <v-row>
                                <v-col
                                    cols="12"
                                    sm="6"
                                    md="4"
                                >
                                    <v-text-field 
                                        label="Nama Pasien"
                                        placeholder="Pasien"
                                        outlined
                                        dense small
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    sm="6"
                                    md="4"
                                >
                                    <v-text-field 
                                        label="Tempat, Tanggal Lahir"
                                        placeholder="Tempat, Tanggal Lahir"
                                        outlined
                                        dense small
                                    ></v-text-field>
                                </v-col>    
                                <v-col
                                    cols="12"
                                    sm="6"
                                    md="4"
                                >
                                    <v-text-field 
                                        label="Alamat"
                                        placeholder="Alamat"
                                        outlined
                                        dense small
                                    ></v-text-field>
                                </v-col>             
                            </v-row>
                        </v-container>
                    </v-from>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </v-expansion-panels>

        <v-card
            elevation="4"
        >
            <div class="d-flex flex-column mt-9">
            <v-card
                class="pa-2"
                outlined
                tile
            >
                Rincian Transaksi
            </v-card>
            </div>

        <v-simple-table >
            
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
                    <td class="font-weight-bold text-center"  rowspan="2">Layanan</td>
                    <td class="font-weight-bold text-center" rowspan="2">Jumlah</td>
                    <td class="font-weight-bold text-center" colspan="4">Tarif</td>
                    <td class="font-weight-bold text-center" rowspan="2">Tangguangn</td>
                    <td class="font-weight-bold text-center" rowspan="2">Total</td>
                </tr>
                <tr>
                    <td>Saran</td>
                    <td>Pelayanan</td>
                    <td>BPH</td>
                    <td>Total</td>
                </tr>
                <tr>
                    <td class="font-weight-bold text-center" colspan="8">Registrasi</td>
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
                    <td class="font-weight-bold text-center" colspan="8">Tindakan Pemeriksaan</td>
                </tr>
                <tr>
                    <td>Kumbah Lambung</td>
                    <td>1</td>
                    <td>2500</td>
                    <td>2000</td>
                    <td>0</td>
                    <td>4500</td>
                    <td>0</td>
                    <td>4500</td>
                </tr>
                <tr>
                    <td class="font-weight-bold text-center" colspan="7">Total</td>
                    <td>12000</td>
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
  import {
  mdiMagnify,
  mdiBellOutline,
  mdiGithub
} from "@mdi/js";

export default {
    props: {
    modules: [],
  },
  setup() {
    const isDrawerOpen = ref(null);

    return {
      isDrawerOpen,

      // Icons
      icons: {
        mdiMagnify,
        mdiBellOutline,
        mdiGithub
      },
    };
  },
};

</script>



<style lang="scss" scoped>
@import './resources/js/plugins/vuetify/default-preset/preset/variables.scss';

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
