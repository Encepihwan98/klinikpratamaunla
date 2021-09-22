<template>
    <v-app>
        <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen"></vertical-nav-menu>
        <app-bar
          :isDrawerOpen="isDrawerOpen"
          :currentUser="currentUser"
          @updateNavbar="isDrawerOpen = $event"
        ></app-bar>
        <v-main>
            <div class="app-content-container boxed-container pa-6">
            <v-card
                class="mx-auto"
                max-width="97%"
                elevation="5"
            >

            <v-card-text>
            <p class="text-h6 text--primary">
                Daftar Agama
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
                sm="8"
                >
                <v-text-field
                    outlined
                    label="Search"
                    append-icon="mdi-magnify"
                    small
                    dense
                ></v-text-field>
                </v-col>

                <v-col
                class="d-flex"
                cols="12"
                sm="2"
                >
                <v-dialog
                    v-model="dialog"
                    persistent
                    max-width="500px"
                >
                    <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        color="primary"
                        dark
                        v-bind="attrs"
                        v-on="on"
                    >
                        Tambah Data
                    </v-btn>
                    </template>
                    <v-card>
                    <v-card-title>
                        <span class="text-h5">Form</span>
                        <hr>
                    </v-card-title>
                    <v-card-text>
                      <v-form v-model="valid" lazy-validation>
                        <v-container>
                        <v-row>
                            <v-col
                            class="d-flex"
                            cols="12"
                            sm="12"
                            >
                                <v-text-field
                                    v-model="agama.description"
                                    label="Uraian :"
                                    placeholder="Uraian"
                                    outlined
                                    dense
                                ></v-text-field>
                            </v-col>
                            
                        </v-row>
                        </v-container>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                        color="blue darken-1"
                        text
                        @click="dialog = false"
                        >
                        Close
                        </v-btn>
                        <v-btn
                        color="blue darken-1"
                        text
                        @click="dialog = false"
                        >
                        Save
                        </v-btn>
                    </v-card-actions>
                    </v-card>
                </v-dialog>
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
                                Uraian
                            </th>
                            <th class="text-left">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Islam</td>
                            <td>
                                <v-btn color="primary" icon :to="{name:'rawat-jalan-detail'}">
                                    <v-icon small>far fa-edit</v-icon>
                                </v-btn>
                                <v-btn color="primary" icon :to="{name:'rawat-jalan-detail'}">
                                    <v-icon small>far fa-trash</v-icon>
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

  data() {
    return {
      _url: "",
      agama: {},
      valid: false,
      data: {},
      dialogConfirmation: {
        state: false,
        message: null,
      },
      errors: [],
      rules: {
        required: (v) => !!v || "Tolong isi form.",
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