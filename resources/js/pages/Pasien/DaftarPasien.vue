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
            Pasien Management
        </p>
        </v-card-text>
        <v-container>
        <v-row>
            <v-col
                class="d-flex"
                cols="12"
                sm="4"
            >
                <v-text-field
                    outlined
                    label="Search MR"
                    append-icon="mdi-magnify"
                    small
                    dense
                ></v-text-field>
            </v-col>
            <v-col
                class="d-flex"
                cols="12"
                sm="4"
            >
                <v-text-field
                    outlined
                    label="Search Nama"
                    append-icon="mdi-magnify"
                    small
                    dense
                ></v-text-field>
            </v-col>
            <v-col
                class="d-flex"
                cols="12"
                sm="4"
            >
                <v-text-field
                    outlined
                    label="Search Nomor Identitas"
                    append-icon="mdi-magnify"
                    small
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
                    v-model="dateFormatted"
                    label="Tanggal Lahir"
                    persistent-hint
                    append-icon="mdi-calendar"
                    v-bind="attrs"
                    @blur="date = parseDate(dateFormatted)"
                    v-on="on"
                    dense
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
                sm="8"
            >
                <v-text-field
                    outlined
                    label="Search Alamat"
                    append-icon="mdi-magnify"
                    small
                    dense
                ></v-text-field>
            </v-col>
        </v-row>
        <hr>
        <v-row>
            <v-col
                class="d-flex"
                cols="12"
                sm="2"
            >
                <v-select 
                    :items="items"
                    label="Tampilkan"
                    dense
                    outlined
                    chips
                    small-chips
                ></v-select>
            </v-col>

            <v-col
                class="d-flex"
                cols="12"
                sm="8"
            >
                <v-text-field
                    outlined
                    label="Search"
                    append-icon="mdi-magnify"
                    small
                    dense
                ></v-text-field>
            </v-col>
            <v-col
                class="d-flex"
                cols="12"
                sm="2"
            >
              <form-daftar-pasien></form-daftar-pasien>
            </v-col>
        </v-row>
        </v-container>        
            <v-simple-table>
                <template v-slot:default>
                <thead>
                    <tr>
                    <th class="text-left">
                        No Rekam Medis
                    </th>
                    <th class="text-left">
                        Nama
                    </th>
                    <th class="text-left">
                        Nomor Identitas
                    </th>
                    <th class="text-left">
                        Tanggal Lahir
                    </th>
                    <th class="text-left">
                        Alamat
                    </th>
                    <th class="text-left">
                        Aksi 
                    </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>08786</td>
                        <td>Maman</td>
                        <td>10/10/2010</td>
                        <td>Dahlian</td>
                        <td>
                        <v-btn icon :to="{name:'rawat-darurat-detail'}">
                            <v-icon small>far fa-search-plus</v-icon>
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
