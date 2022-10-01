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
                                        <v-icon small>far fa-edit</v-icon>Total Rekam Medis
                                    </p>
                                    <p class="text-h3">9</p>
                                </v-container>
                            </v-card>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <v-card>
                                <v-container>
                                    <p class="font-weight-bold">
                                        <v-icon small>far fa-edit</v-icon>Total Rekam Medis Hari ini
                                    </p>
                                    <p class="text-h3">1</p>
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
                                            <tr v-for="(item, index) in data.data" :key="item.nama">
                                                <td>{{ index + data.from }}</td>
                                                <td>{{ item.nama }}</td>
                                                <td>{{ item.tgl }}</td>
                                                <td class="center-center">
                                                    <v-btn small @click="selectMethod(item, 'show')">
                                                        <v-icon small>far fa-eye</v-icon>
                                                    </v-btn>
                                                    <!-- <v-btn small @click="selectMethod(item, 'edit')">
                                                        <v-icon small>far fa-edit</v-icon>
                                                    </v-btn> -->
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
                        <v-card-title class="text-h5"> Detail Data </v-card-title>

                        <v-form class="mx-3 my-3" ref="form" v-model="valid" lazy-validation :currentData="currentData">
                            <v-container>
                                <v-row>
                                    <v-col class="pa-0 mr-6" cols="12" sm="6">
                                        <v-text-field label="Berat Badan" :disabled="condition == 'show' ? true : false"
                                            v-model="rekamedis.bb" suffix="Kg" outlined dense small>
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="pa-0" cols="12" sm="5">
                                        <v-text-field label="Tensi Darah" :disabled="condition == 'show' ? true : false"
                                            v-model="rekamedis.tensi" suffix="mmHg" outlined dense small>
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="pa-0 mr-6" cols="12" sm="6">
                                        <v-text-field label="Tinggi Badan"
                                            :disabled="condition == 'show' ? true : false" v-model="rekamedis.tb"
                                            suffix="Cm" outlined dense small>
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="pa-0" cols="12" sm="12">
                                        <v-textarea label="Keluhan" :disabled="condition == 'show' ? true : false"
                                            v-model="rekamedis.keluhan" auto-grow outlined rows="1" row-height="15">
                                        </v-textarea>
                                    </v-col>
                                    <v-col class="pa-0" cols="12" sm="12">
                                        <v-textarea label="Anamnesis" :disabled="condition == 'show' ? true : false"
                                            v-model="rekamedis.anamnesis" auto-grow outlined rows="1" row-height="15">
                                        </v-textarea>
                                    </v-col>
                                    <v-col class="pa-0" cols="12" sm="12">
                                        <v-textarea label="Diagnosa" :disabled="condition == 'show' ? true : false"
                                            v-model="rekamedis.diagnosa" auto-grow outlined rows="1" row-height="15">
                                        </v-textarea>
                                    </v-col>
                                    <v-col class="d-flex pa-0 mr-2" cols="12" sm="12">
                                        <v-select :disabled="condition == 'show' ? true : false" :items="tindakan.items"
                                            @input="changeID('tindakan')" v-model="rekamedis.tindakan" label="Tindakan"
                                            dense outlined>
                                        </v-select>
                                    </v-col>
                                    <v-col class="pa-0" cols="12" sm="12">
                                        <v-textarea label="Keterangan" :disabled="condition == 'show' ? true : false"
                                            v-model="rekamedis.keterangan" auto-grow outlined rows="1" row-height="15">
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
            valid: false,
            rekamedis: {},
            web: {
                isTableLoad: false,
                filterOpen: false,
            },
            tindakan: {
                items: [],
                data: {}
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
        };
    },
    methods: {
        changeID(event) {
            if (event == "tindakan") {
                let currentID = this.rekamedis.tindakan;
                this.tindakan.data.forEach((v) => {
                    // console.log(v);
                    if (v.description == currentID) {
                        this.rekamedis.tindakan_id = v.id;
                    }
                });
            }
        },
        setSelectedTindakan() {
            axios.get(`/api/v1/list-tindakan/`).then((res) => {
                if (res.status === 200) {
                    res.data.data.forEach((v) => {
                        this.tindakan.items.push(v.description);
                    });
                    this.tindakan.data = res.data.data;
                } else {
                    this.makeDefaultNotification(
                        response.data.status,
                        response.data.message
                    );
                }
            });
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
                this.rekamedis = data;
                this.showDialog(false);
            } else if (item == "edit") {
                this.condition = "update";
                this.dialog.title = "Edit Menu";
                this.rekamedis = data;
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
            let req = Object.assign(this.rekamedis, this.filter);
            axios
                .put(`${this._url}${this.rekamedis.id}`, req)
                .then((response) => {
                    if (response.status == 200) {
                        this.dialog.state = false;
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
        show(id) {
            let url = `${this._url}${id}`;
            axios
                .get(url)
                .then((response) => {
                    if (response.status == 200) {
                        this.rekamedis = response.data.data;
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
            this.rekamedis = {};
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
        add() {
            this.currentData = null;
            this.condition = "store";
            this.dialog.title = "Tambah Data";
            this.showDialog(false);
        },
        edit(data) {
            this.currentData = data;
            this.condition = "update";
            this.dialog.title = "Edit Role";
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
        this._url = window.location.origin + "/api/v1/rekamedis/";
        this.filterPage("");
        this.setSelectedTindakan();
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
