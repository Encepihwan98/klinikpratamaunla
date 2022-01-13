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

            <v-tab
              class="caption font-weight-bold"
              href="#tab-3"
              @click="isOpen = 'GeneralExamination'"
            >
              Tindakan/Pemeriksaan
            </v-tab>
            <v-tab
              class="caption font-weight-bold"
              href="#tab-4"
              @click="isOpen = 'VisitType'"
            >
              Visite
            </v-tab>
            <v-tab
              class="caption font-weight-bold"
              href="#tab-5"
              @click="isOpen = 'SpecialTreatment'"
            >
              Perawatan Khusu
            </v-tab>
            <v-tab
              class="caption font-weight-bold"
              href="#tab-6"
              @click="isOpen = 'Oxygen'"
            >
              Oksigen
            </v-tab>
            <v-tab
              class="caption font-weight-bold"
              href="#tab-7"
              @click="isOpen = 'DaftarGizi'"
            >
              Gizi
            </v-tab>
            <v-tab
              class="caption font-weight-bold"
              href="#tab-8"
              @click="isOpen = 'Incinerator'"
            >
              Insenerator
            </v-tab>
            <v-tab
              class="caption font-weight-bold"
              href="#tab-9"
              @click="isOpen = 'UTDRS'"
            >
              UTDRS
            </v-tab>
            <v-tab
              class="caption font-weight-bold"
              href="#tab-10"
              @click="isOpen = 'ExaminationAction'"
            >
              Kamar Jenazah
            </v-tab>
            <v-tab class="caption font-weight-bold" href="#tab-11">
              Registrasi
            </v-tab>
          </v-tabs>

          <v-tabs-items v-model="tab">
            <v-tab-item value="tab-1">
              <v-card flat>
                <v-card-text>
                  <tarif-ruangan
                    :baseData="data.PolyclinicRoom"
                    :isOpen="isOpen"
                  >
                  </tarif-ruangan>
                </v-card-text>
              </v-card>
            </v-tab-item>

            <v-tab-item value="tab-2">
              <v-card flat>
                <v-card-text>
                  <tarif-kegiatan
                    :baseData="data.MedicalActivity"
                    :isOpen="isOpen"
                  >
                  </tarif-kegiatan>
                </v-card-text>
              </v-card>
            </v-tab-item>

            <v-tab-item value="tab-3">
              <v-card flat>
                <v-card-text>
                  <tarif-tindakan
                    :baseData="data.GeneralExamination"
                    :isOpen="isOpen"
                  ></tarif-tindakan>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item value="tab-4">
              <v-card flat>
                <v-card-text>
                  <tarif-visite
                    :baseData="data.VisitType"
                    :isOpen="isOpen"
                  ></tarif-visite>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item value="tab-5">
              <v-card flat>
                <v-card-text>
                  <tarif-perawatan-khusus
                    :baseData="data.SpecialTreatment"
                    :isOpen="isOpen"
                  ></tarif-perawatan-khusus>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item value="tab-6">
              <v-card flat>
                <v-card-text>
                  <tarif-oksigen
                    :baseData="data.Oxygen"
                    :isOpen="isOpen"
                  ></tarif-oksigen>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item value="tab-7">
              <v-card flat>
                <v-card-text>
                  <tarif-oksigen
                    :baseData="data.DaftarGizi"
                    :isOpen="isOpen"
                  ></tarif-oksigen>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item value="tab-8">
              <v-card flat>
                <v-card-text>
                  <tarif-insenerator
                    :baseData="data.Incinerator"
                    :isOpen="isOpen"
                  ></tarif-insenerator>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item value="tab-9">
              <v-card flat>
                <v-card-text>
                  <tarif-utdrs
                    :baseData="data.UTDRS"
                    :isOpen="isOpen"
                  ></tarif-utdrs>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item>
              <v-card flat>
                <v-card-text>
                  <tarif-kamar-jenazah
                    :baseData="data.ExaminationAction"
                    :isOpen="isOpen"
                  ></tarif-kamar-jenazah>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item value="tab-11">
              <v-card flat>
                <v-card-text>
                  <tarif-registrasi></tarif-registrasi>
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



// <script>
// import { ref } from "@vue/composition-api";
// import { mdiMagnify, mdiBellOutline, mdiGithub } from "@mdi/js";

// export default {
//   props: {
//     modules: [],
//   },
//   data() {
//     return {
//       isOpen: "",
//       // baseDataRoom: {},
//       // baseDataActivity: {},
//       tab: null,
//       data: {},
//       filter: {
//         page: 1,
//         searchQuery: "",
//         limit: 10,
//         sortBy: "id",
//         orderBy: "asc",
//       },
//       text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
//     };
//   },
//   setup() {
//     const isDrawerOpen = ref(null);

//     return {
//       isDrawerOpen,
//       panel: [1, 1],

//       // Icons
//       icons: {
//         mdiMagnify,
//         mdiBellOutline,
//         mdiGithub,
//       },
//     };
//   },
//   methods: {
//     Filterpage(sort_by) {
//       if (sort_by != "" && sort_by != null && sort_by != "undefined") {
//         this.filter.sortBy == sort_by
//           ? this.filter.orderBy == "asc"
//             ? (this.filter.orderBy = "desc")
//             : (this.filter.orderBy = "asc")
//           : (this.filter.sortBy = sort_by);
//       }
//       let url =
//         window.location.origin +
//         "/api/v1/tarif/" +
//         "?page=" +
//         this.filter.page +
//         "&limit=" +
//         this.filter.limit +
//         "&searchQuery=" +
//         this.filter.searchQuery +
//         "&sortBy=" +
//         this.filter.sortBy +
//         "&orderBy=" +
//         this.filter.orderBy +
//         "&select=all";
//       axios
//         .get(url)
//         .then((response) => {
//            if (response.status == 200) {
//             this.data = response.data.data;
//             this.filter.page = response.data.data.current_page;
//             this.getCurrentUser();
//           }
//         })
//         .catch((e) => {
//           this.errorState(e);
//         });
//     },
//   },
//   created() {
//     console.log("component created");
//     this.filterPage("");
//   },
// };
// </script>

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
        this._url +
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
        "&select=all";;
      axios
        .get(url)
        .then((response) => {
          console.log(response);
          if (response.status == 200) {
            this.data = response.data.data;
            this.filter.page = response.data.data.current_page;
            this.getCurrentUser();
          }
        })
        .catch((e) => {
          this.errorState(e);
        });
    },
  },
  created() {
    this._url = window.location.origin + "/api/v1/tarif/";
    this.filterPage("");
  },
  computed: {
    dialogState() {
      return this.dialog.state;
    },
  },
  // watch: {
  //   dialogState: function (n, o) {
  //     console.log(n);
  //     if (n && this.currentData) this.show(this.currentData.id);
  //     else this.clear();
  //   },
  //   modules: function (n, o) {
  //     let access = this.redirectIfNotHaveAccess(n, this.$route.fullPath);
  //     if (Object.keys(access).length === 1 && access.constructor === Object) {
  //       this.$router.push({ name: access.home });
  //     } else {
  //       this.web = access;
  //     }
  //   },
  // },
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
