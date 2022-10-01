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
                                <v-container>
                                    <p class="text-h3">3</p>
                                    <p class="font-weight-bold">
                                        <v-icon small>far fa-edit</v-icon>Total Obat
                                    </p>
                                </v-container>
                            </v-card>
                        </v-col>
                        <v-col cols="12" sm="2" class="pa-0 ml-3">
                            <v-btn dense smal color="primary" @click="selectMethod(null, 'add')">
                                Tambah Obat
                                <v-icon right dark>
                                    far fa-plus
                                </v-icon>
                            </v-btn>
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
                                    <p class="text-h6"> Data Obat</p>
                                </v-card-text>
                                <v-card-text>
                                    <v-row>
                                        <v-col class="d-flex" cols="12" sm="3">
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
                                                    <th class="text-left">Nama</th>
                                                    <th class="text-left">Kandungan</th>
                                                    <th class="text-left">Kategori</th>
                                                    <th class="text-left">Stock</th>
                                                    <th class="text-left">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item, index) in data.data" :key="item.nama">
                                                    <td>{{ index + data.from }}</td>
                                                    <td>{{ item.nama }}</td>
                                                    <td>{{ item.kandungan }}</td>
                                                    <td>{{ item.kategori }}</td>
                                                    <td>{{ item.stock }}</td>
                                                    <td class="center-center">
                                                        <v-btn small @click="selectMethod(null, 'show')">
                                                            <v-icon small>far fa-eye</v-icon>
                                                        </v-btn>
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
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </div>
            <div>
                <v-dialog v-model="dialog.state" persistent max-width="600px">
                    <v-card>
                        <v-card-title class="text-h5"> Detail Data </v-card-title>

                        <v-form class="mx-3 my-3" ref="form" v-model="valid" lazy-validation :currentData="currentData">
                            <v-container>
                                <v-row>
                                    <v-col class="pa-0" cols="12" sm="12">
                                        <v-text-field label="Nama Obat" v-model="obat.nama" outlined dense small>
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="pa-0" cols="12" sm="12">
                                        <v-textarea label="Kandungan" auto-grow v-model="obat.kandungan" outlined
                                            rows="1" row-height="15">
                                        </v-textarea>
                                    </v-col>
                                    <v-col class="pa-0 mr-2" cols="12" sm="7">
                                        <v-select :items="kategori.items" @input="changeID('kategori_obat')"
                                            v-model="obat.kategori" label="Kategori Obat" dense outlined></v-select>
                                    </v-col>
                                    <v-col class="pa-0" cols="12" sm="4">
                                        <v-text-field label="Stock" v-model="obat.stock" outlined dense small>
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="pa-0" cols="12" sm="12">
                                        <v-text-field label="Harga" v-model="obat.harga" outlined dense small>
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="pa-0" cols="12" sm="12">
                                        <v-textarea label="Keterangan" auto-grow v-model="obat.keterangan" outlined
                                            rows="1" row-height="15">
                                        </v-textarea>
                                    </v-col>
                                    <v-col cols="12" sm="12">
                                        <v-btn class="mr-4" @click="selectStore"> Submit </v-btn>
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
                " @changeDialogState="dialogConfirmation.state = $event">
                </confirmation-dialog>
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
            total_obat: 0,
            obat: {},
            valid: false,
            web: {
                isTableLoad: false,
                filterOpen: false,
            },
            filter: {
                page: 1,
                searchQuery: "",
                limit: 10,
                sortBy: "obats.id",
                orderBy: "asc",
                role: [],
            },
            isDrawerOpen: true,
            data: {
                data: [],
                current_page: 1,
            },
            kategori: {
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
            if (event == "kategori_obat") {
                let currentID = this.obat.kategori;
                this.kategori.data.forEach((v) => {
                    // console.log(v);
                    if (v.kategori == currentID) {
                        this.obat.kategori_id = v.id;
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
                this.dialog.title = "Tambah";
                this.showDialog(false);
            } else if (item == "show") {
                this.condition = "show";
                this.dialog.title = "Data Menu";
                this.showDialog(false);
            } else if (item == "edit") {
                this.condition = "update";
                this.dialog.title = "Edit ";
                this.showDialog(false);
            }
        },
        setSelectedKategori() {
            axios.get(`/api/v1/list-kategori-obat/`).then((res) => {
                // console.log(res);
                if (res.status === 200) {
                    res.data.data.forEach((v) => {
                        this.kategori.items.push(v.kategori);
                    });
                    this.kategori.data = res.data.data;
                } else {
                    this.makeDefaultNotification(
                        response.data.status,
                        response.data.message
                    );
                }
            });
        },
        store() {
            let req = Object.assign(this.obat, this.filter);
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
            let req = Object.assign(this.obat, this.filter);
            axios
                .put(`${this._url}${this.obat.id}`, req)
                .then((response) => {
                    if (response.status == 200) {
                        // console.log(response);
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
            console.log(id);
            let url = `${this._url}${id}`;
            axios
                .get(url)
                .then((response) => {
                    if (response.status == 200) {
                        this.obat = response.data.data;
                        // console.log(this.obat);
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
            this.obat = {};
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
            this.dialog.title = "Edit data";
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
                        console.log(this.data.length);
                        this.total_obat = data.length;
                        // console.log(this.total_obat);
                        this.filter.page = response.data.data.current_page;
                        this.web.isTableLoad = false;
                        this.getCurrentUser(); // user terkini
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
        this._url = window.location.origin + "/api/v1/obat/";
        this.filterPage("");
        this.setSelectedKategori();
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
