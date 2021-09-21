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
            Pasien Operasi Management
        </p>
        </v-card-text>
        <v-container>
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
                sm="10"
            >
                <v-text-field
                    outlined
                    label="Search"
                    append-icon="mdi-magnify"
                    small
                    dense
                ></v-text-field>
            </v-col>
        </v-row>
        </v-container>        
            <v-simple-table>
                <template v-slot:default>
                <thead>
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
                        Poli Klinik Asal
                    </th>
                    <th class="text-left">
                        Fasilitas Tujuan
                    </th>
                    <th class="text-left">
                        Waktu
                    </th>
                    <th class="text-left">
                        View 
                    </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>08786</td>
                        <td>Maman</td>
                        <td>10/10/2010</td>
                        <td>11/10/2010</td>
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
