<template>
  <v-app>
    <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen"></vertical-nav-menu>
    <app-bar></app-bar>
    <v-main>
        <div class="app-content-container boxed-container pa-6">
        <v-card 
            class="my-4 mx-4"
            elevation="4"
        >

        <v-card elevation="4" class="mt-9">
            <v-tabs
            v-model="tab"
            background-color="grey lighten-3"
            lefted
            >
            <v-tabs-slider></v-tabs-slider>

            <v-tab class="caption font-weight-bold" href="#tab-1">
                Penerimaan
            </v-tab>

            <v-tab class="caption font-weight-bold" href="#tab-2">
                Transaksi Penerimaan
            </v-tab>
            </v-tabs>

            <v-tabs-items v-model="tab">
            <v-tab-item
                value="tab-1"
            >
                <v-card flat>
                <v-card-text>
                    <penerimaan></penerimaan>
                </v-card-text>
                </v-card>
            </v-tab-item>

            <v-tab-item
                value="tab-2"
            >
                <v-card flat>
                <v-card-text>
                    <transaksi-penerimaan></transaksi-penerimaan>
                </v-card-text>
                </v-card>
            </v-tab-item>
            </v-tabs-items>
        </v-card>
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
import Diagnosa from '../../components/kunjungan/Diagnosa.vue';
import Tindakan from '../../components/kunjungan/Tindakan.vue';
import Resep from '../../components/kunjungan/Resep.vue';
import TarifTindakan from '../../components/Tarif/TarifTindakan.vue';
import TarifOksigen from '../../components/Tarif/TarifOksigen.vue';
import TarifInsenerator from '../../components/Tarif/TarifInsenerator.vue';
import TarifUtdrs from '../../components/Tarif/TarifUtdrs.vue';
import TarifKamarJenazah from '../../components/Tarif/TarifKamarJenazah.vue';
import TransaksiPenerimaan from '../../components/farmasi/TransaksiPenerimaan.vue';

export default {
  components: { Diagnosa, Tindakan, Resep, TarifTindakan, TarifOksigen, TarifInsenerator, TarifUtdrs, TarifKamarJenazah, TransaksiPenerimaan },
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
