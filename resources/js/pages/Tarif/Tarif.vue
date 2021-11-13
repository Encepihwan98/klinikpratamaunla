<template>
  <v-app>
    <vertical-nav-menu
      :is-drawer-open.sync="isDrawerOpen"
      :modules="modules"
    ></vertical-nav-menu>
    <app-bar></app-bar>
    <v-main>
      <v-card class="my-4 mx-4" elevation="4">
        <v-card elevation="4" class="mt-9">
          <v-tabs v-model="tab" background-color="grey lighten-3" lefted>
            <v-tabs-slider></v-tabs-slider>

            <v-tab
              class="caption font-weight-bold"
              href="#tab-1"
              @click="isOpen = 'roomRate'"
            >
              Ruangan
            </v-tab>

            <v-tab
              class="caption font-weight-bold"
              href="#tab-2"
              @click="isOpen = 'activityRate'"
            >
              Kegiatan
            </v-tab>

            <v-tab class="caption font-weight-bold" href="#tab-3" @click="isOpen = 'actionRate'">
              Tindakan/Pemeriksaan
            </v-tab>
            <!-- <v-tab class="caption font-weight-bold" href="#tab-4">
              Visite
            </v-tab>
            <v-tab class="caption font-weight-bold" href="#tab-5">
              Perawatan Khusu
            </v-tab>
            <v-tab class="caption font-weight-bold" href="#tab-6">
              Oksigen
            </v-tab>
            <v-tab class="caption font-weight-bold" href="#tab-7"> Gizi </v-tab>
            <v-tab class="caption font-weight-bold" href="#tab-8">
              Insenerator
            </v-tab>
            <v-tab class="caption font-weight-bold" href="#tab-9">
              UTDRS
            </v-tab>
            <v-tab class="caption font-weight-bold" href="#tab-10">
              Kamar Jenazah
            </v-tab>
            <v-tab class="caption font-weight-bold" href="#tab-11">
              Registrasi
            </v-tab> -->
          </v-tabs>

          <v-tabs-items v-model="tab">
            <v-tab-item value="tab-1">
              <v-card flat>
                <v-card-text>
                  <tarif-ruangan :baseData="data.PolyclinicRoom">
                  </tarif-ruangan>
                </v-card-text>
              </v-card>
            </v-tab-item>

            <v-tab-item value="tab-2">
              <v-card flat>
                <v-card-text>
                  <tarif-kegiatan :baseData="data.MedicalActivity">
                  </tarif-kegiatan>
                </v-card-text>
              </v-card>
            </v-tab-item>

            <v-tab-item value="tab-3">
              <v-card flat>
                <v-card-text>
                  <tarif-tindakan :baseData="data.Tindakan"></tarif-tindakan>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <!-- <v-tab-item value="tab-4">
              <v-card flat>
                <v-card-text>
                  <tarif-visite></tarif-visite>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item value="tab-5">
              <v-card flat>
                <v-card-text>
                  <tarif-perawatan-khusus></tarif-perawatan-khusus>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item value="tab-6">
              <v-card flat>
                <v-card-text>
                  <tarif-oksigen></tarif-oksigen>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item value="tab-7">
              <v-card flat>
                <v-card-text>
                  <tarif-oksigen></tarif-oksigen>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item value="tab-8">
              <v-card flat>
                <v-card-text>
                  <tarif-insenerator></tarif-insenerator>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item value="tab-9">
              <v-card flat>
                <v-card-text>
                  <tarif-utdrs></tarif-utdrs>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item value="tab-10">
              <v-card flat>
                <v-card-text>
                  <tarif-kamar-jenazah></tarif-kamar-jenazah>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item value="tab-11">
              <v-card flat>
                <v-card-text>
                  <tarif-registrasi></tarif-registrasi>
                </v-card-text>
              </v-card>
            </v-tab-item> -->
          </v-tabs-items>
        </v-card>
      </v-card>
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
  },
  data() {
    return {
      isOpen: "",
      // baseDataRoom: {},
      // baseDataActivity: {},
      tab: null,
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
    filterPage(sort_by) {
      if (sort_by != "" && sort_by != null && sort_by != "undefined") {
        this.filter.sortBy == sort_by
          ? this.filter.orderBy == "asc"
            ? (this.filter.orderBy = "desc")
            : (this.filter.orderBy = "asc")
          : (this.filter.sortBy = sort_by);
      }
      let url =
        window.location.origin +
        "/api/v1/tarif/" +
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
          if (response.status == 200) {
            this.data = response.data.data;
            // console.log(this.data);
          }
        })
        .catch((e) => {
          this.errorState(e);
        });
    },
  },
  created() {
    console.log("component created");
    this.filterPage("");
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
