<template>
  <v-app>
    <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen"></vertical-nav-menu>
    <app-bar :isDrawerOpen="isDrawerOpen" @updateNavbar="isDrawerOpen = $event"></app-bar>
    <v-main>
      <div class="app-content-container boxed-container pa-6">
        <v-card class="mx-auto">
          <v-card-title>
            <v-container fluid>
              <v-row align="center">
                <v-col class="d-flex" cols="6" md="6" sm="6">
                  <p class="text-h5 text--primary">Form Input</p>
                </v-col>

                <v-col class="d-flex" cols="6" md="6" sm="6">
                  <v-btn
                    color="primary ml-auto"
                    small
                    elevation="2"
                    @click="add"
                    >Tambah Roles</v-btn
                  >
                </v-col>

                <v-col class="d-flex" cols="6" sm="3" md="2">
                  <v-select
                    dense
                    :items="selectItem"
                    label="Tampilkan"
                    outlined
                  ></v-select>
                </v-col>

                <v-col class="d-flex" cols="12" sm="6">
                  <v-text-field
                    v-model="searchQuery"
                    dense
                    append-outer-icon="far fa-search"
                    outlined
                    clear-icon="fas fa-times-circle"
                    clearable
                    label="Search"
                    type="text"
                    @click:append-outer="search"
                    @click:clear="clearMessage"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-card-title>
          <v-card-text>
            <v-simple-table fixed-header>
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">
                      Nama
                      <v-icon x-small>fas fa-arrow-up</v-icon>
                      <!-- <v-icon x-small>fas fa-arrow-up</v-icon> -->
                    </th>
                    <th class="text-left">
                      Keterangan
                      <v-icon x-small>fas fa-arrow-up</v-icon>
                    </th>
                    <th class="text-left">Aksi</th>
                  </tr>
                </thead>
                <tbody v-if="data.data.length > 0">
                  <tr v-for="item in data.data" :key="item.name">
                    <td>{{ item.name }}</td>
                    <td>{{ item.description }}</td>
                    <td>
                      <v-btn small @click="show(item)">
                        <v-icon small>far fa-search-plus</v-icon>
                      </v-btn>
                      <v-btn small @click="edit(item)">
                        <v-icon small>far fa-edit</v-icon>
                      </v-btn>
                      <v-btn small @click="selectMethod(item, 'delete')">
                        <v-icon small>far fa-trash</v-icon>
                      </v-btn>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else class="text-center">
                  <tr>
                    <td colspan="3">Data Kosong!</td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </v-card-text>
          <v-card-actions class="d-flex justify-center">
            <v-pagination
              v-model="data.current_page"
              :length="data.last_page"
              :total-visible="7"
            ></v-pagination>
          </v-card-actions>
        </v-card>
      </div>
      <form-dialog-role
        :dialog="dialog"
        :currentData="currentData"
        :condition="condition"
        @updateDialog="dialog.state = $event"
        @updateData="data = $event"
      ></form-dialog-role>

      <confirmation-dialog
        :confirmationDialog="dialogConfirmation"
        :method="remove"
        @changeDialogState="dialogConfirmation.state = $event"
      ></confirmation-dialog>
    </v-main>
    <footer></footer>
  </v-app>
</template>

<script>
import { ref } from '@vue/composition-api'
export default {
  data() {
    const isDrawerOpen = ref(null);
    return {
      isDrawerOpen,
      data: {
          data: []
      },
      currentData: {},
      dialog: {
        state: false,
        title: null,
      },
      dialogConfirmation: {
        state: false,
        message: null,
      },
      condition: "store",
      searchQuery: "",
      selectItem: ["10", "25", "50", "100", "All"],
    };
  },
  methods: {
    search() {
      if (this.searchQuery == null) {
        console.log("error");
      } else {
        console.log(this.searchQuery);
      }
    },
    show(data) {
      this.currentData = data;
      this.condition = "show";
      this.dialog.title = "Data Role";
      this.showDialog(false);
    },
    edit(data) {
      this.currentData = data;
      this.condition = "update";
      this.dialog.title = "Edit Role";
      this.showDialog(false);
    },
    add() {
      this.currentData = null;
      this.condition = "store";
      this.dialog.title = "Tambah Role";
      this.showDialog(false);
    },
    remove() {
      let url =
        window.location.origin + "/api/v1/roles/" + this.currentData.uuid;
      axios.delete(url).then((response) => {
        if (response.status == 200) {
          //   this.getData();
          this.data = response.data.data;
        }
      });
    },
    selectMethod(data, item) {
      this.currentData = data;
      if (item == "delete") {
        this.condition = item;
        this.dialogConfirmation.message = "menghapus";
        this.showDialog(true);
      }
    },
    clearMessage() {
      this.searchQuery = "";
    },
    showDialog(isConfirmation) {
      if (isConfirmation) {
        this.dialogConfirmation.state = !this.dialogConfirmation.state;
      } else {
        this.dialog.state = !this.dialog.state;
      }
    },
    getData() {
      let url = window.location.origin + "/api/v1/roles";
      axios.get(url).then((response) => {
        if (response.status == 200) {
          console.log(response);
          this.data = response.data.data;
        }
      });
    },
  },
  created() {
    this.getData();
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
