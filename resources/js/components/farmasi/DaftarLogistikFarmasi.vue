<template>
  <div class="app-content-container boxed-container pa-6">
    <v-container>
      <v-row>
        <v-col class="d-flex" cols="12" sm="2">
          <v-select :items="items" label="Tampilkan" dense outlined></v-select>
        </v-col>

        <v-col class="d-flex" cols="12" sm="5">
          <v-text-field
            outlined
            label="Search"
            append-icon="mdi-magnify"
            small
            dense
          ></v-text-field>
        </v-col>
        <v-col class="d-flex" cols="12" sm="3">
          <v-select
            :items="['Depo Rawat Inap', 'Depo UGD', 'Gudang Farmasi']"
            label="Total Stock"
            dense
            outlined
          ></v-select>
        </v-col>
        <v-col class="d-flex" cols="12" sm="2">
          <v-dialog v-model="dialog" persistent max-width="500px">
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark v-bind="attrs" v-on="on">
                Tambah Data
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h5">Form</span>
                <hr />
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col class="d-flex" cols="12" sm="12">
                      <v-select
                        :items="['Obat', 'ALKES', 'ATK']"
                        label="Jenis Logistik"
                        dense
                        outlined
                      ></v-select>
                    </v-col>
                    <v-col class="d-flex" cols="12" sm="12">
                      <v-text-field
                        label="Uraian :"
                        placeholder="Uraian"
                        outlined
                        dense
                      ></v-text-field>
                    </v-col>
                    <v-col class="d-flex" cols="12" sm="12">
                      <v-text-field
                        label="Satuan :"
                        placeholder="Satuan"
                        outlined
                        dense
                      ></v-text-field>
                    </v-col>
                    <v-col class="d-flex" cols="12" sm="12">
                      <v-text-field
                        label="Harga Satuan :"
                        placeholder="Harga Satuan"
                        outlined
                        dense
                      ></v-text-field>
                    </v-col>
                    <v-col class="d-flex" cols="12" sm="12">
                      <v-select
                        :items="['Generik', 'Non Generik', 'Formularium']"
                        label="Golongan"
                        dense
                        outlined
                      ></v-select>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="dialog = false">
                  Close
                </v-btn>
                <v-btn color="blue darken-1" text @click="dialog = false">
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-col>
      </v-row>
    </v-container>
    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">No</th>
            <th class="text-left">Jenis</th>
            <th class="text-left">Uraian</th>
            <th class="text-left">Satuan</th>
            <th class="text-left">Harga Satuan</th>
            <th class="text-left">Stock</th>
            <th class="text-left">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Alat Kesehatan (Alkes)</td>
            <td>ABO Test Golongan Darah (Nongenerik)</td>
            <td>Kitt/8</td>
            <td>9000</td>
            <td>90</td>

            <td>
              <v-btn color="primary" icon :to="{ name: 'rawat-jalan-detail' }">
                <v-icon small>far fa-edit</v-icon>
              </v-btn>
              <v-btn color="primary" icon :to="{ name: 'rawat-jalan-detail' }">
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
      </template>
    </v-simple-table>
  </div>
</template>

<script>
import { ref } from "@vue/composition-api";
import { mdiMagnify, mdiBellOutline, mdiGithub } from "@mdi/js";

export default {
  setup() {
    const isDrawerOpen = ref(null);

    return {
      isDrawerOpen,

      // Icons
      icons: {
        mdiMagnify,
        mdiBellOutline,
        mdiGithub,
      },
    };
  },

  data: (vm) => ({
    dialog: false,
    items: ["5", "10", "15", "20", "25", "30", "50"],
    picker: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
      .toISOString()
      .substr(0, 10),
    date: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
      .toISOString()
      .substr(0, 10),
    dateFormatted: vm.formatDate(
      new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
        .toISOString()
        .substr(0, 10)
    ),
    menu1: false,
    menu2: false,
  }),

  computed: {
    computedDateFormatted() {
      return this.formatDate(this.date);
    },
  },

  watch: {
    date(val) {
      this.dateFormatted = this.formatDate(this.date);
    },
  },

  methods: {
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
