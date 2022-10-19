<template>
  <v-app>
    <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen" :modules="modules"></vertical-nav-menu>
    <app-bar :isDrawerOpen="isDrawerOpen" :currentUser="currentUser" @updateNavbar="isDrawerOpen = $event"></app-bar>
    <v-main>
      <div class="app-content-container boxed-container pa-6">
        <v-card class="mx-auto">
          <v-card-title>
            <v-container fluid> Home </v-container>
          </v-card-title>
          <v-card-text> Dashboard </v-card-text>
          <v-row>
            <v-col class="" cols="12" sm="4">
              <v-card class="m-2" color="blue lighten-1" hover>
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon class="p-4" color="white" x-large>far fa-stethoscope</v-icon>
                  </v-list-item-icon>
                  <v-list-item-title class="text-right text-h5 font-weight-bold">{{dashboard.totalToday}}</v-list-item-title>
                </v-list-item>
                <v-card-text class="text-h6">Total Pasien Hari ini</v-card-text>
              </v-card>
            </v-col>
            <v-col class="" cols="12" sm="4">
              <v-card class="m-2" color="blue lighten-1" hover>
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon class="p-4" color="white" x-large>far fa-stethoscope</v-icon>
                  </v-list-item-icon>
                  <v-list-item-title class="text-right text-h5 font-weight-bold">{{dashboard.totalMonth}}</v-list-item-title>
                </v-list-item>
                <v-card-text class="text-h6">Total Pasien Bulan Ini</v-card-text>
              </v-card>
            </v-col>
            <v-col class="" cols="12" sm="4">
              <v-card class="m-2" color="blue lighten-1" hover>
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon class="p-4" color="white" x-large>far fa-stethoscope</v-icon>
                  </v-list-item-icon>
                  <v-list-item-title class="text-right text-h5 font-weight-bold">{{dashboard.totalAll}}</v-list-item-title>
                </v-list-item>
                <v-card-text class="text-h6">Total Pasien</v-card-text>
              </v-card>
            </v-col>
          </v-row>
          <v-row>
            <v-col class="" cols="12" sm="4">
              <v-card class="m-2" color="blue lighten-1" hover>
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon class="p-4" color="white" x-large>far fa-stethoscope</v-icon>
                  </v-list-item-icon>
                  <v-list-item-title class="text-right text-h5 font-weight-bold">{{dashboard.totalUmum}}</v-list-item-title>
                </v-list-item>
                <v-card-text class="text-h6">Total Pasien Umum</v-card-text>
              </v-card>
            </v-col>
            <v-col class="" cols="12" sm="4">
              <v-card class="m-2" color="blue lighten-1" hover>
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon class="p-4" color="white" x-large>far fa-stethoscope</v-icon>
                  </v-list-item-icon>
                  <v-list-item-title class="text-right text-h5 font-weight-bold">{{dashboard.totalBPJS}}</v-list-item-title>
                </v-list-item>
                <v-card-text class="text-h6">Total Pasien BPJS</v-card-text>
              </v-card>
            </v-col>
            <v-col class="" cols="12" sm="4">
              <v-card class="m-2" color="blue lighten-1" hover>
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon class="p-4" color="white" x-large>far fa-pills</v-icon>
                  </v-list-item-icon>
                  <v-list-item-title class="text-right text-h5 font-weight-bold">{{dashboard.totalObat}}</v-list-item-title>
                </v-list-item>
                <v-card-text class="text-h6">Total Obat</v-card-text>
              </v-card>
            </v-col>
          </v-row>
          <v-row>
            <v-col class="" cols="12" sm="4">
              <v-card class="m-2" color="blue lighten-1" hover>
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon class="p-4" color="white" x-large>far fa-money-bill</v-icon>
                  </v-list-item-icon>
                  <v-list-item-title class="text-right text-h6 font-weight-bold">Rp. {{formatPrice(dashboard.total)}}</v-list-item-title>
                </v-list-item>
                <v-card-text color="white" class="text-h6">Total Keungan</v-card-text>
              </v-card>
            </v-col>
          </v-row>
        </v-card>
      </div>
    </v-main>
    <footer></footer>
  </v-app>
</template>

<script>
export default {
  props: {
    modules: [],
  },
  data() {
    return {
      web: {
        isTableLoad: false,
        filterOpen: false,
        create: false,
        update: false,
        delete: false,
      },
      dashboard: {

      },
      isDrawerOpen: true,
      data: {
        data: [],
        current_page: 1,
      },
      currentUser: {},
    };
  },
  methods: {
    formatPrice(value) {
      let val = (value / 1).toFixed(2).replace('.', ',')
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    },
    setSelectDashboard() {
      axios.get(`/api/v1/dashboard/`).then((res) => {
        if (res.status === 200) {
          this.dashboard = res.data.data;
        } else {
          this.makeDefaultNotification(
            response.data.status,
            response.data.message
          );
        }
      });
    },
  },
  created() {
    if (this.modules.length > 0) {
      let access = this.redirectIfNotHaveAccess(this.modules, this.$route.path);
      if (Object.keys(access).length === 1 && access.constructor === Object) {
        this.$router.push({ name: access.home });
      } else {
        this.web = access;
      }
    }
    this.setSelectDashboard();
    this.currentUser = this.requestCurrentUser();
  },
  watch: {
    modules: function (n, o) {
      let access = this.redirectIfNotHaveAccess(n, this.$route.path);
      if (Object.keys(access).length === 0 && access.constructor === Object) {
        this.$router.push({ name: access.slug });
      } else {
        this.web = access;
      }
    },
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
