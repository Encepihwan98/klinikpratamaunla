<template>
    <v-app>
        <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen" :modules="modules"></vertical-nav-menu>
        <app-bar :isDrawerOpen="isDrawerOpen" :currentUser="currentUser" @updateNavbar="isDrawerOpen = $event">
        </app-bar>
        <v-main>
            <div class="app-content-container boxed-container pa-6">
                <v-card class="mx-auto">
                    <v-card-text>
                        <v-card-text>
                            <p class="text-h6"> Data Rujukan</p>
                        </v-card-text>
                        <v-row>
                            <v-col class="d-flex" cols="12" sm="2">
                                <v-select v-model="filter.limit" dense :items="['1', '2', '3', '4']" label="Tampilkan"
                                    outlined></v-select>
                            </v-col>

                            <v-col class="d-flex" cols="12" sm="8">
                                <v-text-field v-model="filter.searchQuery" dense append-icon="far fa-search" outlined
                                    clearable label="Search" type="text"></v-text-field>
                            </v-col>
                        </v-row>
                        <v-simple-table dense>
                            <template v-slot:default>
                                <thead>
                                    <tr>
                                        <th class="text-left">No</th>
                                        <th class="text-left">Nama Pasien</th>
                                        <th class="text-left">Tgl Periksa</th>
                                        <th class="text-left">Rujukan</th>
                                        <th class="text-left">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in data.data" :key="item.nama">
                                        <td>{{ index + data.from }}</td>
                                        <td>{{ item.nama }}</td>
                                        <td>{{ item.tgl }}</td>
                                        <td>{{ item.rujukan }}</td>
                                        <td class="center-center">
                                            <!-- <v-btn @click="printSurat(item)" small>
                                                <v-icon small>far fa-print</v-icon>
                                            </v-btn> -->
                                            <a :href="`/api/v1/surat-rujukan/${item.id}`">
                                                <v-btn small>
                                                    <v-icon small>far fa-print</v-icon>
                                                </v-btn>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                        <v-card-actions class="d-flex justify-center">
                            <v-pagination v-model="filter.page" :length="data.last_page" :total-visible="7"
                                @input="filterPage('')"></v-pagination>
                        </v-card-actions>
                    </v-card-text>
                </v-card>
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
            rujukan : {},
            _url: "",
            obatMasuk: {
                tgl: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
                    .toISOString()
                    .substr(0, 10),
            },
            menu: false,
            modal: false,
            menu2: false,
            obat: {
                data: {},
                items: []
            },
            suplier: {
                data: {},
                items: []
            },
            urlPrint:"",
            valid: false,
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
            users: {
                items: [],
                data: {},
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
            dialog: {
                state: false,
                title: null,
            },
            dialogConfirmation: {
                state: false,
                message: null,
            },
            condition: "store",
            selectItem: ["10", "25", "50", "100"],
            errors: [],
            rules: {
                required: (v) => !!v || "Tolong isi form.",
            },
        };
    },
    methods: {
        printSurat(data, item) {
            this.rujukan = data;
            let req = Object.assign(this.rujukan, this.filter);
            console.log(this.rujukan.id);
            this.urlPrint = window.location.origin + "/api/v1/surat-rujukan/";
            axios
                .get(`${this.urlPrint}${this.rujukan.id}`, req)
                .then((response) => {
                    if (response.status == 'success') {
                        // this.dialogs.dialogDataPasien.state = false;
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
                this.dialog.title = "Tambah ";
                this.showDialog(false);
            } else if (item == "show") {
                this.condition = "show";
                this.dialog.title = "Data ";
                this.showDialog(false);
            } else if (item == "edit") {
                this.condition = "update";
                this.dialog.title = "Edit ";
                this.showDialog(false);
            }
        },
        store() {
            let req = Object.assign(this.obatMasuk, this.filter);
            this.currentData = null;
            axios
                .post(this._url, req)
                .then((response) => {
                    if (response.status == 200) {
                        this.dialog.state = false;
                        this.data = response.data.data;
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
        update() {
            let req = Object.assign(this.obatMasuk, this.filter);
            axios
                .put(`${this._url}${this.obatMasuk.id}`, req)
                .then((response) => {
                    if (response.status == 200) {
                        console.log(response);
                        this.dialog.state = false;
                        this.retriveData = response.data.data;
                        // this.data = response.data.data;
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
        show(id) {
            let url = `${this._url}${id}`;
            axios
                .get(url)
                .then((response) => {
                    if (response.status == 200) {
                        this.obatMasuk = response.data.data;
                    }
                })
                .catch((e) => {
                    this.errorState(e);
                });
        },
        popDialog() {
            this.dialogConfirmation.state = !this.dialogConfirmation.state;
        },
        clear() {
            this.obatMasuk = {};
            this.errors = {};
            if (this.$refs.form) this.$refs.form.resetValidation();
        },

        changeData(newdata) {
            this.data = newdata;
        },

        errorState(e) {
            if (e.response.status == 401) {
                localStorage.removeItem("token");
                this._token = "";
                this.$router.push({ name: "index" });
            } else {
                if (e.response.data.errors) {
                    this.errors = e.response.data.errors;
                } else {
                    this.showDialog = false;
                }

                this.errorRequestState(e);
            }
        },
        remove() {
            this.web.isTableLoad = true;
            axios
                .delete(`${this._url}${this.currentData.id}`, { data: this.filter })
                .then((response) => {
                    if (response.status == 200) {
                        this.web.isTableLoad = false;
                        this.data = response.data.data;
                        this.filter.page = response.data.data.current_page;
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
        edit(data) {
            this.currentData = data;
            this.condition = "update";
            this.dialog.title = "Edit Role";
            this.showDialog(false);
        },
        add() {
            this.currentData = null;
            this.condition = "store";
            this.dialog.title = "Tambah Data";
            this.showDialog(false);
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
                this.filter.orderBy;
            axios
                .get(url)
                .then((response) => {
                    // console.log(response);
                    if (response.status == 200) {
                        this.data = response.data.data;
                        this.filter.page = response.data.data.current_page;
                        this.web.isTableLoad = false;
                        this.getCurrentUser();
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
        changeData(newdata) {
            this.data = newdata;
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
        this._url = window.location.origin + "/api/v1/rujukan/";
        this.filterPage("");


    },
    computed: {
        dialogState() {
            return this.dialog.state;
        },
    },
    watch: {
        dialogState: function (n, o) {
            // console.log(n);

            if (n && this.currentData) this.show(this.currentData.id);
            else this.clear();
        },
        modules: function (n, o) {
            let access = this.redirectIfNotHaveAccess(n, this.$route.fullPath);
            if (Object.keys(access).length === 1 && access.constructor === Object) {
                this.$router.push({ name: access.home });
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
