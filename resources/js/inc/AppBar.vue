<template>
  <v-app-bar app flat absolute color="transparent">
    <div class="boxed-container w-full">
      <div class="d-flex align-center mx-6">
        <!-- Left Content -->
        <v-app-bar-nav-icon
          class="d-block d-lg-none me-2"
          @click="showNavBar = !isDrawerOpen"
        ></v-app-bar-nav-icon>
        <v-text-field
          rounded
          dense
          outlined
          prepend-inner-icon="far fa-search"
          class="app-bar-search flex-grow-0"
          hide-details
        ></v-text-field>
        <v-spacer></v-spacer>
        <theme-switcher></theme-switcher>
        <v-btn icon small class="ms-3">
          <v-icon>
            far fa-bell
          </v-icon>
        </v-btn>

        <app-bar-user-menu :currentUser="user"></app-bar-user-menu>
      </div>
    </div>
  </v-app-bar>
</template>

<script>
export default {
  props: {
    isDrawerOpen: false,
    currentUser: {},
  },
  data() {
      return {
          user: null,
      }
  },
  computed: {
    showNavBar: {
      get() {
        return this.isDrawerOpen;
      },
      set(value) {
        this.$emit("updateNavbar", value);
      },
    },
  },
  watch: {
      currentUser(v) {
          this.user = v[0]
      }
  }
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
