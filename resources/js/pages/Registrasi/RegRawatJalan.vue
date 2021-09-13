<template>
  <v-app>
    <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen"></vertical-nav-menu>
    <app-bar></app-bar>
    <v-main>
    <div class="app-content-container pa-6">
    <v-card
    class="mx-auto"
    max-width="97%"
    elevation="5"
    >
        <v-card-text>
        <p class="text-h6 text--primary">
            Registrasi Rawat Jalan
        </p>
        </v-card-text>
        <v-form>
            <v-container>
                <v-row>
                    <v-col
                        class="d-flex"
                        cols="12"
                        md="4"
                    >
                    <v-select
                        :items="['bedah','operasi']"
                        label="Jenis Rujukan"
                        outlined
                        dense
                    ></v-select>
                    </v-col>
                    
                    <v-col
                        cols="12"
                        md="4"
                    >
                        <v-text-field 
                            label="Nomor Rekam Medis"
                            placeholder="Nomor Rekam Medis"
                            outlined
                            dense small
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="12"
                        md="4"
                    >
                        <v-text-field 
                            label="Nomor Identitas"
                            placeholder="Nomor Identitas"
                            outlined
                            dense small
                        ></v-text-field>
                    </v-col>

                    <v-col
                        cols="12"
                        md="4"
                    >
                        <v-text-field 
                            label="Tempat Tanggal Lahir"
                            placeholder="Tempat Tanggal Lahir"
                            outlined
                            dense small
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="12"
                        md="4"
                    >
                        <v-text-field 
                            label="Alamat"
                            placeholder="Alamat"
                            outlined
                            dense small
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="12"
                        md="4"
                    >
                        <v-text-field 
                            label="Telp/Hp"
                            placeholder="Telp/Hp"
                            outlined
                            dense small
                        ></v-text-field>
                    </v-col>
                </v-row>
                <hr>
                <v-row>
                     <v-col
                        cols="12"
                        md="4"
                    >
                        <v-text-field 
                            label="Nomor Kunjungan"
                            placeholder="Nomor Kunjungan dibuat secara otomatis"
                            outlined
                            dense small
                        ></v-text-field>
                    </v-col>
                    <v-col
                      cols="12"
                      md="4"
                      sm="4"
                    >
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
                            v-model="dateFormatted"
                            label="Waktu Kunjungan"
                            persistent-hint
                            append-icon="mdi-calendar"
                            v-bind="attrs"
                            @blur="date = parseDate(dateFormatted)"
                            v-on="on"
                            outlined
                            dense
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="date"
                          no-title
                          @input="menu1 = false"
                        ></v-date-picker>
                      </v-menu>
                    </v-col>

                    <v-col
                        class="d-flex"
                        cols="12"
                        md="4"
                    >
                        <v-select
                        :items="['bedah','operasi']"
                        label="Jenis Rujukan"
                        outlined
                        dense
                        ></v-select>
                    </v-col>
                    <v-col
                        cols="12"
                        md="4"
                    >
                        <v-text-field 
                            label="Nomor Rujukan"
                            placeholder="Nomor Rujukan"
                            outlined
                            dense small
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="12"
                        md="4"
                    >
                        <v-text-field 
                            label="Asal Rujukan"
                            placeholder="Asal Rujukan"
                            outlined
                            dense small
                        ></v-text-field>
                    </v-col>
                    <v-col
                      cols="12"
                      md="4"
                      sm="4"
                    >
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
                            v-model="dateFormatted"
                            label="Tanggal Rujukan"
                            persistent-hint
                            append-icon="mdi-calendar"
                            v-bind="attrs"
                            @blur="date = parseDate(dateFormatted)"
                            v-on="on"
                            outlined
                            dense
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="date"
                          no-title
                          @input="menu1 = false"
                        ></v-date-picker>
                      </v-menu>
                    </v-col>


                     <v-col
                        class="d-flex"
                        cols="12"
                        md="4"
                    >
                        <v-select
                        :items="['BPJS','UMUM']"
                        label="Cara Pembayaran"
                        outlined
                        dense
                        ></v-select>
                    </v-col>
                    <v-col
                        cols="12"
                        md="4"
                    >
                        <v-text-field 
                            label="Nomor SJP"
                            placeholder="Nomor SJP"
                            outlined
                            dense small
                        ></v-text-field>
                    </v-col>
                    <v-col
                      cols="12"
                      md="4"
                      sm="4"
                    >
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
                            v-model="dateFormatted"
                            label="Tanggal Rujukan"
                            persistent-hint
                            append-icon="mdi-calendar"
                            v-bind="attrs"
                            @blur="date = parseDate(dateFormatted)"
                            v-on="on"
                            outlined
                            dense
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="date"
                          no-title
                          @input="menu1 = false"
                        ></v-date-picker>
                      </v-menu>
                    </v-col>


                     <v-col
                        cols="12"
                        md="4"
                    >
                        <v-text-field 
                            label="Penanggung Jawab"
                            placeholder="Penanggung Jawab"
                            outlined
                            dense small
                        ></v-text-field>
                    </v-col>

                     <v-col
                        cols="12"
                        md="4"
                    >
                        <v-text-field 
                            label="Telp Penanggung Jawab"
                            placeholder="Telp Penanggung Jawab"
                            outlined
                            dense small
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        md="4"
                    >
                    <v-select
                        :items="['bedah','operasi']"
                        label="Jenis Kasus"
                        outlined
                        dense
                    ></v-select>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        md="4"
                    >
                    <v-select
                        :items="['salesma','rorombeheun']"
                        label="Diagnosa Awal"
                        outlined
                        dense
                    ></v-select>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        md="4"
                    >
                    <v-select
                        :items="['Idris','solehudin']"
                        label="Pilih Dokter"
                        outlined
                        dense
                    ></v-select>
                    </v-col>
                </v-row>
                <hr>
                <v-row>
                    <v-col
                        class="d-flex"
                        cols="12"
                        md="4"
                    >
                    <v-select
                        :items="['salesma','rorombeheun']"
                        label="Jenis Registrasi"
                        outlined
                        dense
                    ></v-select>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        md="4"
                    >
                    <v-select
                        :items="['salesma','rorombeheun']"
                        label="Poliklinik Tujuan"
                        outlined
                        dense
                    ></v-select>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        md="4"
                    >
                    <v-select
                        :items="['salesma','rorombeheun']"
                        label="Jenis Kegiatan"
                        outlined
                        dense
                    ></v-select>
                    </v-col>
                    
                </v-row>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    depressed
                    color="primary"
                  >
                    Save
                  </v-btn>
                </v-card-actions>
            </v-container>     
        </v-form>
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

   data: vm => ({
      dialog: false,
      items: ['5', '10', '15', '20','25','30','50'],
      picker: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
      date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
      dateFormatted: vm.formatDate((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)),
      menu1: false,
      menu2: false,
    }),

    computed: {
      computedDateFormatted () {
        return this.formatDate(this.date)
      },
    },

    watch: {
      date (val) {
        this.dateFormatted = this.formatDate(this.date)
      },
    },

    methods: {
      formatDate (date) {
        if (!date) return null

        const [year, month, day] = date.split('-')
        return `${month}/${day}/${year}`
      },
      parseDate (date) {
        if (!date) return null

        const [month, day, year] = date.split('/')
        return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
      },
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
