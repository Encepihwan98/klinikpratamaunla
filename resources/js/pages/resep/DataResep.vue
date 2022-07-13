<template>
    <v-app>
        <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen" :modules="modules"></vertical-nav-menu>
        <app-bar :isDrawerOpen="isDrawerOpen" :currentUser="currentUser" @updateNavbar="isDrawerOpen = $event">
        </app-bar>
        <v-main>
            <div class="app-content-container boxed-container pa-6">
                <v-container>
                    <v-row>
                        <v-col cols="12" sm="6">
                            <v-card>
                                <v-container>
                                    <p class="font-weight-bold">
                                        <v-icon small>far fa-edit</v-icon>Total Resep Obat
                                    </p>
                                    <p class="text-h3">2</p>
                                </v-container>
                            </v-card>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <v-card>
                                <v-container>
                                    <p class="font-weight-bold">
                                        <v-icon small>far fa-edit</v-icon>Total Resep Obat Hari ini
                                    </p>
                                    <p class="text-h3">2</p>
                                </v-container>
                            </v-card>
                        </v-col>
                        <v-col cols="12" sm="4" class="pa-0 ml-3">
                            <v-btn dense smal color="red">
                                Export To PDF
                                <v-icon right dark>
                                    far fa-file-pdf
                                </v-icon>
                            </v-btn>
                        </v-col>
                        <v-col cols="12" sm="12">
                            <v-card>
                                <v-card-text>
                                    <p class="text-h6"> Data Rekam Medis</p>
                                </v-card-text>
                                <v-row>
                                    <v-col class="d-flex" cols="12" sm="2">
                                        <v-select v-model="filter.limit" dense :items="['1', '2', '3', '4']"
                                            label="Tampilkan" outlined></v-select>
                                    </v-col>

                                    <v-col class="d-flex" cols="12" sm="8">
                                        <v-text-field v-model="filter.searchQuery" dense append-icon="far fa-search"
                                            outlined clearable label="Search" type="text"></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-simple-table dense>
                                    <template v-slot:default>
                                        <thead>
                                            <tr>
                                                <th class="text-left">No</th>
                                                <th class="text-left">Nama Pasien</th>
                                                <th class="text-left">Tgl Periksa</th>
                                                <th class="text-left">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Maman</td>
                                                <td>25-01-2022</td>
                                                <td class="center-center">
                                                    <v-btn small>
                                                        <v-icon small>far fa-print</v-icon>
                                                    </v-btn>
                                                    <v-btn small @click.stop="dialog = true">
                                                        <v-icon small>far fa-search</v-icon>
                                                    </v-btn>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </template>
                                </v-simple-table>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </div>
            <div>
                <v-dialog v-model="dialog" persistent max-width="600px">
                    <v-card>
                        <v-card-title class="text-h5"> Detail Resep </v-card-title>
                        <v-simple-table dense>
                            <template v-slot:default>
                                <thead>
                                    <tr>
                                        <th class="text-left">Tgl Resep</th>
                                        <th class="text-left">Isi Resep</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>11-07-2017</td>
                                        <td>Nama Obat : Bodrex | Jumlah : 12</td>
                                    </tr>
                                    <tr>
                                        <td>11-07-2017</td>
                                        <td>Nama Obat : Bodrex | Jumlah : 12</td>
                                    </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                        <v-col cols="12" sm="12">
                            <v-btn class="mr-4" @click="submit"> Submit </v-btn>
                            <v-btn @click="dialog = false"> Close </v-btn>
                        </v-col>
                    </v-card>
                </v-dialog>
            </div>
        </v-main>
    </v-app>
</template>

<script>
export default {
    props: {
        modules: [],
    },
    data() {
        return {
            _url: "",
            web: {
                isTableLoad: false,
                filterOpen: false,
            },
            filter: {
                page: 1,
                searchQuery: "",
                limit: 10,
                sortBy: "id",
                orderBy: "asc",
                role: [],
            },
            isDrawerOpen: true,
            data: {
                data: [],
                current_page: 1,
            },
            module: {
                create: [],
                read: [],
                update: [],
                delete: [],
                print: [],
                is_all: [],
            },
            newModule: {},
            errors: {
                role: [],
            },
            roles: [],
            currentData: {},
            currentUser: {},
            dialog: false,
            dialogConfirmation: {
                state: false,
                message: null,
            },
            condition: "store",
            selectItem: ["10", "25", "50", "100"],
        };
    },
    methods: {
        selectMethod(data, item) {
            this.currentData = data;
            if (item == "delete") {
                this.condition = item;
                this.dialogConfirmation.message = "menghapus";
                this.showDialog(true);
            } else if (item == "status") {
                this.condition = item;
                this.dialogConfirmation.message = "mengubah";
                this.showDialog(true);
            } else if (item == "add") {
                this.currentData = null;
                this.condition = "store";
                this.dialog.title = "Tambah Menu";
                this.showDialog(false);
            } else if (item == "show") {
                this.condition = "show";
                this.dialog.title = "Data Menu";
                this.showDialog(false);
            } else if (item == "edit") {
                this.condition = "update";
                this.dialog.title = "Edit Menu";
                this.showDialog(false);
            }
        },
        showDialog(isConfirmation) {
            if (isConfirmation) {
                this.dialogConfirmation.state = !this.dialogConfirmation.state;
            } else {
                this.dialog.state = !this.dialog.state;
            }
        },
        filterPage(sort_by) {
            this.web.isTableLoad = true;
            if (sort_by) {
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
                "&role=" +
                this.module.role;
            axios
                .get(url)
                .then((response) => {
                    if (response.status == 200) {
                        this.clearModules();
                        this.data.data = response.data.data;
                        response.data.data.forEach((v) => {
                            let activeAll = v.id;
                            if (v.is_home) {
                                this.module.is_home = v.id;
                                this.module.is_home_old = v.id;
                            }
                            if (v.create) this.module.create.push(v.id);
                            else activeAll = 0;
                            if (v.read) this.module.read.push(v.id);
                            else activeAll = 0;
                            if (v.update) this.module.update.push(v.id);
                            else activeAll = 0;
                            if (v.delete) this.module.delete.push(v.id);
                            else activeAll = 0;
                            if (v.print) this.module.print.push(v.id);
                            else activeAll = 0;

                            this.module.is_all.push(activeAll);
                        });
                        if (!this.module.role) this.clearModules();
                        this.filter.page = response.data.data.current_page;
                        this.web.isTableLoad = false;
                        this.currentUser = this.requestCurrentUser();
                        if (!this.roles || this.roles < 1) {
                            this.roles = this.requestRole();
                        }
                    }
                })
                .catch((e) => {
                    this.errorState(e);
                });
        },
        clearModules() {
            this.$delete(this.module, "is_home");
            this.module.is_home_old = 0;
            this.module.create = [];
            this.module.read = [];
            this.module.update = [];
            this.module.delete = [];
            this.module.print = [];
            this.module.is_all = [];
        },
        errorState(e) {
            console.log(e);
            this.web.isTableLoad = false;
            //   this.errors = e.response.data.errors;
            if (e.response.status == 401) {
                localStorage.removeItem("token");
                this._token = "";
                this.$router.push({ name: "index" });
            } else {
                this.errorRequestState(e);
            }
        },
        changeData(newdata) {
            this.data = newdata;
        },
    },

    watch: {
        modules: function (n, o) {
            let access = this.redirectIfNotHaveAccess(n, this.$route.path);
            if (Object.keys(access).length === 1 && access.constructor === Object) {
                this.$router.push({ name: access.home });
            } else {
                this.web = access;
                n.forEach((v) => {
                    if (v.url != "#") this.data.data.push(v);
                });
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
