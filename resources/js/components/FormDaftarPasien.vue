<template>
    <v-dialog
                v-model="dialog"
                persistent
                max-width="800px"
            >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                color="primary"
                dark
                v-bind="attrs"
                v-on="on"
              >
                Pasien Baru
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h5">Form </span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                   <v-col
                      class="d-flex"
                      cols="12"
                      sm="12"
                      md="6"
                    >
                      <v-select
                        :items="['Di Jampean', 'Di tiup', 'Dicabut', 'Di gunting']"
                        label="Nomor Rekam Medis:"
                        placeholder="Nomor Rekam Medis:"
                        outlined
                        dense
                      ></v-select>
                    </v-col>
                    <v-col
                      class="d-flex"
                      cols="12"
                      sm="12"
                      md="6"
                    >
                      <v-select
                        :items="['Di Jampean', 'Di tiup', 'Dicabut', 'Di gunting']"
                        label="Pilih Pendidikan:"
                        placeholder="Pilih Pendidikan"
                        outlined
                        dense
                      ></v-select>
                    </v-col>
                   
                    <v-col
                      class="d-flex"
                      cols="12"
                      sm="12"
                      md="6"
                    >
                      <v-select
                        :items="['Di Jampean', 'Di tiup', 'Dicabut', 'Di gunting']"
                        label="Jenis Identitas:"
                        placeholder="Jenis Identitas"
                        outlined
                        dense
                      ></v-select>
                    </v-col>
                    <v-col
                      class="d-flex"
                      cols="12"
                      sm="12"
                      md="6"
                    >
                      <v-select
                        :items="['Di Jampean', 'Di tiup', 'Dicabut', 'Di gunting']"
                        label="Pekerjaan:"
                        placeholder="Pekerjaan"
                        outlined
                        dense
                      ></v-select>
                    </v-col>

                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="12"
                        md="6"
                    >
                        <v-text-field
                            label="Nomor Identitas"
                            placeholder="Nomor Identitas"
                            required
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                      class="d-flex"
                      cols="12"
                      sm="12"
                      md="6"
                    >
                      <v-select
                        :items="['Di Jampean', 'Di tiup', 'Dicabut', 'Di gunting']"
                        label="Provinsi:"
                        placeholder="Provinsi"
                        outlined
                        dense
                      ></v-select>
                    </v-col>

                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="12"
                        md="6"
                    >
                        <v-text-field
                            label="Nama Pasien"
                            placeholder="Nama Pasien"
                            required
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="12"
                        md="6"
                    >
                        <v-textarea
                        outlined
                        rows="2"
                        label="Alamat"
                        ></v-textarea>
                    </v-col>
                    
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="4"
                    >
                        <v-text-field
                            label="Tempat Lahir"
                            placeholder="Tempat Lahir"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    
                    <v-col
                      cols="12"
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
                            dense
                            v-model="dateFormatted"
                            label="Tanggal Lahir"
                            persistent-hint
                            append-icon="mdi-calendar"
                            v-bind="attrs"
                            @blur="date = parseDate(dateFormatted)"
                            v-on="on"
                            outlined
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
                        sm="12"
                        md="4"
                    >
                        <v-text-field
                            label="Telp/Hp"
                            placeholder="Telp/Hp"
                            required
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                      class="d-flex"
                      cols="12"
                      sm="12"
                      md="4"
                    >
                      <v-select
                        :items="['Laki - Laki', 'Perempuan']"
                        label="Jenis Kelamin:"
                        placeholder="Jenis Kelamin"
                        outlined
                        dense
                      ></v-select>
                    </v-col>
                    <v-col
                      class="d-flex"
                      cols="12"
                      sm="12"
                      md="4"
                    >
                      <v-select
                        :items="['A', 'B','AB','O']"
                        label="Golongan Darah:"
                        placeholder="Golongan Darah"
                        outlined
                        dense
                      ></v-select>
                    </v-col>
                    <v-col
                      class="d-flex"
                      cols="12"
                      sm="12"
                      md="4"
                    >
                      <v-select
                        :items="['Sunda', 'Batak','Jawa','Madura','Badui']"
                        label="Suku"
                        placeholder="Suku"
                        outlined
                        dense
                      ></v-select>
                    </v-col>
                    <v-col
                      class="d-flex"
                      cols="12"
                      sm="12"
                      md="4"
                    >
                      <v-select
                        :items="['Islam', 'Muslim','Kristen','Hindu','Budha']"
                        label="Agama"
                        placeholder="Pilih Agama"
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
                        sm="6"
                    >
                        <v-text-field
                            label="Nama Ayah"
                            placeholder="Nama Ayah"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="12"
                        md="6"
                    >
                        <v-textarea
                        outlined
                        rows="1"
                        label="Alamat Keluarga"
                        placeholder="Alamat Keluarga"
                        ></v-textarea>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="6"
                    >
                        <v-text-field
                            label="Nama Ibu"
                            placeholder="Nama Ibu"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="6"
                    >
                        <v-text-field
                            label="Telp Keluarga"
                            placeholder="Telp Keluarga"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                      class="d-flex"
                      cols="12"
                      sm="6"
                    >
                      <v-select
                        :items="['Menikah', 'Belum Menikah','Janda','Duda']"
                        label="Status Pernikahan"
                        placeholder="Status Pernikahan"
                        outlined
                        dense
                      ></v-select>
                    </v-col>
                    <v-col
                        class="d-flex"
                        cols="12"
                        sm="6"
                    >
                        <v-text-field
                            label="Nama Pasangan"
                            placeholder="Nama Pasangan"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="blue darken-1"
                  text
                  @click="dialog = false"
                >
                  Close
                </v-btn>
                <v-btn
                  color="blue darken-1"
                  text
                  @click="dialog = false"
                >
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <!-- akhir dialog -->
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