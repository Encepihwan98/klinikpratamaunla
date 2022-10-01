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
                                    <p class="text-h6">Daftar Dokter</p>
                                </v-card-text>
                                <v-row>
                                    <v-col class="d-flex" cols="12" sm="2">
                                        <v-select v-model="filter.limit" dense :items="['1', '2', '3', '4']"
                                            label="Tampilkan" outlined></v-select>
                                    </v-col>

                                    <v-col class="d-flex" cols="12" sm="7">
                                        <v-text-field v-model="filter.searchQuery" dense append-icon="far fa-search"
                                            outlined clearable label="Search" type="text"></v-text-field>
                                    </v-col>
                                    <v-col class="d-flex" cols="12" sm="3">
                                        <v-btn dense smal color="primary" @click="selectMethod(null, 'add')">
                                            Tambah Data
                                            <v-icon right dark>
                                                far fa-plus
                                            </v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <v-simple-table dense>
                                    <template v-slot:default>
                                        <thead>
                                            <tr>
                                                <th class="text-left">No</th>
                                                <th class="text-left">Nama</th>
                                                <th class="text-left">Spesialis</th>
                                                <th class="text-left">No_Hp</th>
                                                <th class="text-left">Alamat</th>
                                                <th class="text-left">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in data.data" :key="item.spesialis">
                                                <td>{{ index + data.from }}</td>
                                                <td>{{ item.name }}</td>
                                                <td>{{ item.spesialis }}</td>
                                                <td>{{ item.no_hp }}</td>
                                                <td>{{ item.alamat }}</td>
                                                <td class="center-center">
                                                    <v-btn small @click="selectMethod(item, 'edit')" v-if="web.update">
                                                        <v-icon small>far fa-edit</v-icon>
                                                    </v-btn>
                                                    <v-btn small @click="selectMethod(item, 'delete')"
                                                        v-if="web.delete">
                                                        <v-icon small>far fa-trash</v-icon>
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
                <v-dialog v-model="dialog.state" persistent max-width="600px">
                    <v-card>
                        <v-card-title class="text-h5"> Pegawai DOkter </v-card-title>

                        <v-form class="mx-3 my-3" ref="form" v-model="valid" lazy-validation :currentData="currentData">
                            <v-container>
                                <v-row>
                                    <v-col class="pa-0 mr-6" cols="12" sm="12">
                                        <v-select :items="users.items" @input="changeID('users')" v-model="dokter.nama"
                                            label="User Id" dense outlined></v-select>
                                    </v-col>
                                    <v-col class="pa-0 mr-6" cols="12" sm="12">
                                        <v-select :items="['laki-laki', 'perempuan']" v-model="dokter.jenis_kelamin"
                                            label="Jenis Kelamin" dense outlined></v-select>
                                    </v-col>
                                    <v-col class="pa-0 mr-6" cols="12" sm="12">
                                        <v-text-field label="Spesialis" dense outlined v-model="dokter.spesialis" small>
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="pa-0 mr-6" cols="12" sm="12">
                                        <v-text-field label="No Hp" dense outlined v-model="dokter.no_hp" small>
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="pa-0 mr-6" cols="12" sm="12">
                                        <v-text-field label="email" dense outlined v-model="dokter.email" small>
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="pa-0 mr-6" cols="12" sm="12">
                                        <v-text-field label="Alamat" dense outlined v-model="dokter.alamat" small>
                                        </v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="12">
                                        <v-btn v-if="condition != 'show'" color="blue darken-1" text
                                            @click="selectStore">
                                            Simpan
                                        </v-btn>
                                        <v-btn @click="dialog.state = false"> Close </v-btn>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-form>
                    </v-card>
                </v-dialog>
                <confirmation-dialog :confirmationDialog="dialogConfirmation" :method="
                    condition == 'store'
                        ? store
                        : condition == 'update'
                            ? update
                            : remove
                " @changeDialogState="dialogConfirmation.state = $event"></confirmation-dialog>
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
            dokter: {},
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
        changeID(event) {
            if (event == "users") {
                let currentID = this.dokter.nama;
                this.users.data.forEach((v) => {
                    // console.log(v);
                    if (v.name == currentID) {
                        this.dokter.user_id = v.id;
                    }
                });
            }
        },
        selectStore() {
            if (this.$refs.form.validate()) {
                if (this.condition == "store") {
                    this.dialogConfirmation.message = "menyimpan";
                    this.popDialog();
                } else {
                    this.dialogConfirmation.message = "mengubah";
                    this.popDialog();
                }
            }
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
        setSelectedUser() {
            axios.get(`/api/v1/list-users/`).then((res) => {
                // console.log(res);
                if (res.status === 200) {
                    res.data.data.forEach((v) => {
                        this.users.items.push(v.name);
                    });
                    this.users.data = res.data.data;
                } else {
                    this.makeDefaultNotification(
                        response.data.status,
                        response.data.message
                    );
                }
            });
        },
        store() {
            let req = Object.assign(this.dokter, this.filter);
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
            let req = Object.assign(this.dokter, this.filter);
            axios
                .put(`${this._url}${this.dokter.id}`, req)
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
                        this.dokter = response.data.data;
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
            this.dokter = {};
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
        if (this.modules.length > 0) {
            let access = this.redirectIfNotHaveAccess(this.modules, this.$route.path);
            if (Object.keys(access).length === 1 && access.constructor === Object) {
                this.$router.push({ name: access.home });
            } else {
                this.web = access;
            }
        }
        this._url = window.location.origin + "/api/v1/dokter/";
        this.filterPage("");
        this.setSelectedUser();
    },
    computed: {
        dialogState() {
            return this.dialog.state;
        },
    },
    watch: {
        dialogState: function (n, o) {
            // console.log(n);
            this.setSelectedUser();
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
