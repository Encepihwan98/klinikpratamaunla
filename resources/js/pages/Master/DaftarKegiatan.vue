<template>
  <v-app>
    <vertical-nav-menu 
      :is-drawer-open.sync="isDrawerOpen"
      :modules="modules"
    ></vertical-nav-menu>
    <app-bar></app-bar>
    <v-main>
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

            <v-tab class="caption font-weight-bold" href="#tab-1" @click="isOpen='kategori'">
                Kategori Kegiatan
            </v-tab>

            <v-tab class="caption font-weight-bold" href="#tab-2" @click="isOpen='kegiatan'">
                Kegiatan
            </v-tab>
            </v-tabs>

            <v-tabs-items v-model="tab">
            <v-tab-item
                value="tab-1"
            >
                <v-card flat>
                <v-card-text>
                    <kategori-kegiatan :baseData="baseDataKategori" :isOpen="isOpen"></kategori-kegiatan>
                </v-card-text>
                </v-card>
            </v-tab-item>

            <v-tab-item
                value="tab-2"
            >
                <v-card flat>
                <v-card-text>
                   <kegiatan :isOpen="isOpen" :baseData="baseDataKegiatan"></kegiatan>
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
import Diagnosa from '../../components/kunjungan/Diagnosa.vue';
import Tindakan from '../../components/kunjungan/Tindakan.vue';
import Resep from '../../components/kunjungan/Resep.vue';
import TarifTindakan from '../../components/tarif/TarifTindakan.vue';
import TarifOksigen from '../../components/tarif/TarifOksigen.vue';
import TarifInsenerator from '../../components/tarif/TarifInsenerator.vue';
import TarifUtdrs from '../../components/tarif/TarifUtdrs.vue';
import TarifKamarJenazah from '../../components/tarif/TarifKamarJenazah.vue';

export default {
  props: {
    modules: [],
  },
  components: { Diagnosa, Tindakan, Resep, TarifTindakan, TarifOksigen, TarifInsenerator, TarifUtdrs, TarifKamarJenazah },
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
  methods: {
    filterPageKegiatan(sort_by) {
      if (sort_by != "" && sort_by != null && sort_by != "undefined") {
        this.filter.sortBy == sort_by
          ? this.filter.orderBy == "asc"
            ? (this.filter.orderBy = "desc")
            : (this.filter.orderBy = "asc")
          : (this.filter.sortBy = sort_by);
      }
      let url =
        window.location.origin + "/api/v1/daftar-kegiatan/" +
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
            this.baseDataKegiatan = response.data.data;
          }
        })
        .catch((e) => {
          this.errorState(e);
        });
    },
    filterPageKategori(sort_by) {
      if (sort_by != "" && sort_by != null && sort_by != "undefined") {
        this.filter.sortBy == sort_by
          ? this.filter.orderBy == "asc"
            ? (this.filter.orderBy = "desc")
            : (this.filter.orderBy = "asc")
          : (this.filter.sortBy = sort_by);
      }
      let url =
        window.location.origin + "/api/v1/kategori-kegiatan/" +
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
        "&module=" +
        'daftar-kegiatan';
      axios
        .get(url)
        .then((response) => {
          if (response.status == 200) {
            this.baseDataKategori = response.data.data;
          }
        })
        .catch((e) => {
          this.errorState(e);
        });
    },
  },
  data () {
      return {
        isOpen: '',
        baseDataKegiatan:{},
        baseDataKategori:{},
        tab: null,
        filter: {
        page: 1,
        searchQuery: "",
        limit: 10,
        sortBy: "id",
        orderBy: "asc",
      },
        text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
      }
    },
  created() {
    console.log('component created');
    this.filterPageKegiatan('')
    this.filterPageKategori('')
  }
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
