<template>
    <v-app>
        <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen" :modules="modules"></vertical-nav-menu>
        <app-bar :isDrawerOpen="isDrawerOpen" :currentUser="currentUser" @updateNavbar="isDrawerOpen = $event">
        </app-bar>
        <v-main>
            <div class="app-content-container boxed-container pa-6">
                <v-container>
                    <v-row>
                        <v-col cols="12" sm="12">
                            <v-card>
                                <v-card-text>
                                    <p class="text-h6"> Pembayaran</p>
                                </v-card-text>
                                <v-card-text>
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
                                                    <th class="text-left">Nama Obat</th>
                                                    <th class="text-left">Harga</th>
                                                    <th class="text-left">Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item, index) in resep.data" :key="item.id">
                                                    <td>{{ index + 1 }}</td>
                                                    <td>{{ item.nama }}</td>
                                                    <td>{{ item.harga }}</td>
                                                    <td>{{ item.jumlah }}</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2">Total</td>
                                                    <td>{{ totalHarga }}</td>
                                                    <td> {{ totalObat }} Obat</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <v-btn class="mt-3" @click="selectMethod()" small
                                                            color="primary" dark>
                                                            Komfirmasi Resep Selesai
                                                        </v-btn>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </template>
                                    </v-simple-table>

                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
                <confirmation-dialog :confirmationDialog="dialogConfirmation" :method="update"
                    @changeDialogState="dialogConfirmation.state = $event"></confirmation-dialog>
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
            totalObat: 0,
            totalHarga: 0,
            web: {
                isTableLoad: false,
                filterOpen: false,
            },
            param: "",
            filter: {
                page: 1,
                searchQuery: "",
                limit: 10,
                sortBy: "id",
                orderBy: "asc",
                role: [],
            },
            resep: {
                data: {},
                items: []
            },

            isDrawerOpen: true,
            data: {
                data: {},
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
            condition: "update",
            selectItem: ["10", "25", "50", "100"],
        };
    },
    methods: {
        selectMethod(data, item) {
            // this.condition == "update"
            this.dialogConfirmation.message = "mengkonfirmasi resep";
            // this.popDialog();
            this.showDialog(true);
        },

        update() {
            let req = Object.assign(this.data.data, this.filter);
            console.log(this.data.data.id);      
            this.url = window.location.origin + "/api/v1/update-status-resep/";
            axios
                .post(`${this.url}${this.data.data.id}`, req)
                .then((response) => {
                    // console.log(response);
                    if (response.status == 200) {
                        // this.dialog.state = false;
                        this.retriveData = response.data.data;
                        this.makeDefaultNotification(
                            response.data.status,
                            response.data.message
                        );
                    }
                })
                .catch((e) => {
                    this.errorState(e);
                });

        },

        popDialog() {
            this.dialogConfirmation.state = !this.dialogConfirmation.state;
        },

        setDetailObat() {
            axios.get(`/api/v1/detail-resep/?param=` + this.param).then((res) => {
                if (res.status === 200) {
                    res.data.data.forEach((v) => {
                        this.resep.items.push(v.nama);
                        this.totalHarga += v.harga;
                        this.totalObat += v.jumlah;
                    });
                    this.resep.data = res.data.data;
                    this.data.data = res.data.value;
                } else {
                    this.makeDefaultNotification(
                        response.data.status,
                        response.data.message
                    );
                }
            });
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
            // console.log(e);
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
    created() {
        this._url = window.location.origin + "/api/v1/rekamedis/";
        console.log(this.$route.params.id);
        if (
            localStorage.getItem("current_param") != null &&
            localStorage.getItem("current_param")
        ) {
            if (
                this.$route.params.id != null &&
                this.$route.params.id != localStorage.getItem("current_param")
            ) {
                localStorage.setItem("current_param", this.$route.params.id);
            }
            this.param = localStorage.getItem("current_param");
        } else {
            if (this.$route.params.id) {
                localStorage.setItem("current_param", this.$route.params.id);
                this.param = this.$route.params.id;
            } else {
                this.$router.push({ name: "cek-resep" });
            }
        }
        this.setDetailObat();

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
