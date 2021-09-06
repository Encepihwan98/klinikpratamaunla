<template>
  <v-app>
    <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen"></vertical-nav-menu>
    <app-bar></app-bar>
    <v-main>
      <div class="app-content-container boxed-container pa-6">
        roles management
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
