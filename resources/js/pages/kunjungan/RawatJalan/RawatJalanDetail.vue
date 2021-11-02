<template>
  <v-app>
    <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen" :modules="modules"></vertical-nav-menu>
    <app-bar></app-bar>
    <v-main>
        <v-card
            class="my-4 mx-4"
            elevation="4"
        >
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

        <v-card elevation="4" class="mt-9">
            <v-tabs
                v-model="tab"
                background-color="grey lighten-3"
                lefted
                icons-and-text
            >
            <v-tabs-slider></v-tabs-slider>

            <v-tab class="caption font-weight-bold" href="#tab-1">
                Penunjang
            </v-tab>

            <v-tab class="caption font-weight-bold" href="#tab-2">
                Diagnosa
            </v-tab>

            <v-tab class="caption font-weight-bold" href="#tab-3">
                Tindakan/Pemeriksaan
            </v-tab>
            <v-tab class="caption font-weight-bold" href="#tab-4">
                Pemeriksaan Umum
            </v-tab>
            <v-tab class="caption font-weight-bold" href="#tab-5">
                Resep
            </v-tab>
            </v-tabs>

            <v-tabs-items v-model="tab">
            <v-tab-item
                value="tab-1"
            >
                <v-card flat>
                <v-card-text>
                    <penunjang></penunjang>
                </v-card-text>
                </v-card>
            </v-tab-item>

            <v-tab-item
                value="tab-2"
            >
                <v-card flat>
                <v-card-text>
                    <diagnosa></diagnosa>
                </v-card-text>
                </v-card>
            </v-tab-item>

            <v-tab-item
                value="tab-3"
                
            >
                <v-card flat>
                <v-card-text>
                    <tindakan></tindakan>
                </v-card-text>
                </v-card>
            </v-tab-item>
            <v-tab-item
                value="tab-4"
            >
                <v-card flat>
                <v-card-text>
                    <pemeriksaan-umum></pemeriksaan-umum>
                </v-card-text>
                </v-card>
            </v-tab-item>
            <v-tab-item
                value="tab-5"
            >
                <v-card flat>
                <v-card-text>
                    <resep></resep>
                </v-card-text>
                </v-card>
            </v-tab-item>
            </v-tabs-items>
        </v-card>
        </v-card>
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
import Diagnosa from '../../../components/kunjungan/Diagnosa.vue';
import Tindakan from '../../../components/kunjungan/Tindakan.vue';
import Resep from '../../../components/kunjungan/Resep.vue';

export default {
  props: {
    modules: [],
  },
  components: { Diagnosa, Tindakan, Resep },
  setup() {
    const isDrawerOpen = ref(null);

    return {
      isDrawerOpen,
      panel: [1, 1],

      // Icons
      icons: {
        mdiMagnify,
        mdiBellOutline,
        mdiGithub
      },
    };
  },

  data () {
      return {
        tab: null,
        text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
      }
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
