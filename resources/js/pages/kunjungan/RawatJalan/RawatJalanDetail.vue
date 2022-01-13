<template>
  <v-app>
    <vertical-nav-menu
      :is-drawer-open.sync="isDrawerOpen"
      :modules="modules"
    ></vertical-nav-menu>
    <app-bar></app-bar>
    <v-main>
      <v-card class="my-4 mx-4" elevation="4">
        <v-expansion-panels focusable v-model="panel">
          <v-expansion-panel>
            <v-expansion-panel-header
              >Poli Klinik Mata</v-expansion-panel-header
            >
            <v-expansion-panel-content>
              <v-from>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        label="Nama Pasien"
                        placeholder="Pasien"
                        outlined
                        dense
                        small
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        label="Tempat, Tanggal Lahir"
                        placeholder="Tempat, Tanggal Lahir"
                        outlined
                        dense
                        small
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        label="Alamat"
                        placeholder="Alamat"
                        outlined
                        dense
                        small
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

            <v-tab
              class="caption font-weight-bold"
              href="#tab-1"
              @click="isOpen = 'support'"
            >
              Penunjang
            </v-tab>

            <v-tab
              class="caption font-weight-bold"
              href="#tab-2"
              @click="isOpen = 'diagnosis'"
            >
              Diagnosa
            </v-tab>

            <v-tab
              class="caption font-weight-bold"
              href="#tab-3"
              @click="isOpen = 'action'"
            >
              Tindakan/Pemeriksaan
            </v-tab>
            <v-tab
              class="caption font-weight-bold"
              href="#tab-4"
              @click="isOpen = 'general_inspection'"
            >
              Pemeriksaan Umum
            </v-tab>
            <v-tab
              class="caption font-weight-bold"
              href="#tab-5"
              @click="isOpen = 'recipe'"
            >
              Resep
            </v-tab>
          </v-tabs>

          <v-tabs-items v-model="tab">
            <v-tab-item value="tab-1">
              <v-card flat>
                <v-card-text>
                  <penunjang 
                    :baseData="support" 
                    :isOpen="isOpen"
                    :params="param"
                  > </penunjang>
                </v-card-text>
              </v-card>
            </v-tab-item>

            <v-tab-item value="tab-2">
              <v-card flat>
                <v-card-text>
                  <diagnosa 
                    :baseData="diagnosis" 
                    :isOpen="isOpen"
                    :params="param"
                  ></diagnosa>
                </v-card-text>
              </v-card>
            </v-tab-item>

            <v-tab-item value="tab-3">
              <v-card flat>
                <v-card-text>
                  <tindakan 
                    :baseData="action" 
                    :isOpen="isOpen"
                    :params="param"
                  ></tindakan>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item value="tab-4">
              <v-card flat>
                <v-card-text>
                  <pemeriksaan-umum
                    :baseData="general_inspection"
                    :isOpen="isOpen"
                    :params="param"
                  >
                  </pemeriksaan-umum>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item value="tab-5">
              <v-card flat>
                <v-card-text>
                  <resep 
                    :baseData="recipe" 
                    :isOpen="isOpen"
                    :params="param"
                  ></resep>
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
import { mdiMagnify, mdiBellOutline, mdiGithub } from "@mdi/js";

export default {
  props: {
    modules: [],
    base: {},
  },
  data() {
    return {
      isOpen: "",
      // baseDataRoom: {},
      // baseDataActivity: {},
      param: '',
      tab: null,
      diagnosis: {
        data: {},
        items: [],
      },
      support: {
        data: {},
        items: [],
      },
      general_inspection: {
        data: {},
        items: [],
      },
      recipe: {
        data: {},
        items: [],
      },
      action: {
        data: {},
        items: [],
      },
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
    setSelectedPenujang() {
      axios.get(`/api/v1/layanan-penunjang?param=`+this.param).then((res) => {
        if (res.status === 200) {
          this.support = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },

    setSelectedDiagnosa() {
      axios.get(`/api/v1/layanan-diagnosa?param=`+this.param).then((res) => {
        if (res.status === 200) {
          this.diagnosis = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },

    setSelectedAction() {
      axios.get(`/api/v1/layanan-tindakan?param=`+this.param).then((res) => {
        if (res.status === 200) {
          this.action = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },

    setSelectedResep() {
      axios.get(`/api/v1/layanan-resep?param=`+this.param).then((res) => {
        if (res.status === 200) {
          this.recipe = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },

    setSelectedPemeriksaanUmum() {
      axios.get(`/api/v1/layanan-pemeriksaan?param=`+this.param).then((res) => {
        if (res.status === 200) {
          this.general_inspection = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
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
        "&select=all";
      axios
        .get(url)
        .then((response) => {
          // console.log(response);
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
    this._url = window.location.origin + "/api/v1/rawat-jalan-detail/";
    if (
      localStorage.getItem("current_param") != null &&
      localStorage.getItem("current_param")
    ) {
      if(this.$route.params.id != null && this.$route.params.id != localStorage.getItem("current_param")) {
        localStorage.setItem("current_param", this.$route.params.id);
      }
      this.param = localStorage.getItem("current_param");
    } else {
      if (this.$route.params.id) {
        localStorage.setItem("current_param", this.$route.params.id);
        this.param = this.$route.params.id;
      } else {
        this.$router.push({ name: "rawat-jalan-detail" });
      }
    }
    this.filterPage("");
    this.setSelectedPenujang();
    this.setSelectedDiagnosa();
    this.setSelectedAction();
    this.setSelectedPemeriksaanUmum();
    this.setSelectedResep();
  },
  // computed: {
  //   dialogState() {
  //     return this.dialog.state;
  //   },
  // },
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

