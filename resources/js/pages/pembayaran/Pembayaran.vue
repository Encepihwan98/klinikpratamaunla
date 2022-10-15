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
                                <v-row>
                                    <v-col class="d-flex" cols="12" sm="2">
                                        <v-select v-model="filter.limit" dense :items="['1', '2', '3', '4']"
                                            label="Tampilkan" outlined></v-select>
                                    </v-col>

                                    <v-col class="d-flex" cols="12" sm="6">
                                        <v-text-field v-model="filter.searchQuery" dense append-icon="far fa-search"
                                            outlined clearable label="Search" type="text"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="4">
                                        <v-btn dense smal color="red">
                                            Export To PDF
                                            <v-icon right dark>
                                                far fa-file-pdf
                                            </v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <v-simple-table dense>
                                    <template v-slot:default>
                                        <thead>
                                            <tr>
                                                <th class="text-left">No</th>
                                                <th class="text-left">No Kunjungan</th>
                                                <th class="text-left">Nama</th>
                                                <th class="text-left">Waktu</th>
                                                <th class="text-left">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in data.data" :key="item.id">
                                                <td>{{ index + data.from }}</td>
                                                <td>{{ item.pasien_id }}</td>
                                                <td>{{ item.nama }}</td>
                                                <td>{{ item.tgl }}</td>
                                                <td class="center-center">
                                                    <v-btn
                                                        :to="{ name: 'pembayaran-detail', params: { id: item.resep_id } }">
                                                        <v-icon small>far fa-eye</v-icon>
                                                    </v-btn>
                                                    <v-btn @click="printNota(item)" small>
                                                        <v-icon small>far fa-print</v-icon>
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
            urlPrint: "",
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
            pembayaran: {},
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

            dialogConfirmation: {
                state: false,
                message: null,
            },
            condition: "store",
            selectItem: ["10", "25", "50", "100"],
        };
    },
    methods: {
        printNota(data, item) {
            this.pembayaran = data;
            axios.get(window.location.origin + `api/v1/print-nota/${this.pembayaran.id}`, { responseType: 'blob' }).then(response => {

                const url = window.location.origin.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'remaining_fee.pdf'); //or any other extension
                document.body.appendChild(link);
                link.click();

            })
                .catch(error => {
                    console.log(error);
                })
        },
        // printNota(data, item) {
        //     this.pembayaran = data;
        //     let req = Object.assign(this.pembayaran, this.filter);
        //     console.log(this.pembayaran.id);
        //     this.urlPrint = window.location.origin + "/api/v1/print-nota/";
        //     axios
        //         .get(`${this.urlPrint}${this.pembayaran.id}`, {
        //         }, req)
        //         .then((response) => {
        //             doc.save("nota.pdf");
        //             const content = response.headers['content-type'];
        //             download(response.data, file.file_name, content)
        //              window.print();
        //             if (response.status == 'success') {
        //                 // this.dialogs.dialogDataPasien.state = false;
        //                 this.retriveData = response.data.data;
        //                 this.makeDefaultNotification(
        //                     response.data.status,
        //                     response.data.message
        //                 );
        //             }
        //         })
        //         .catch((e) => {
        //             this.errorState(e);
        //         });
        // },
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
    created() {
        if (this.modules.length > 0) {
            let access = this.redirectIfNotHaveAccess(this.modules, this.$route.path);
            if (Object.keys(access).length === 1 && access.constructor === Object) {
                this.$router.push({ name: access.home });
            } else {
                this.web = access;
            }
        }
        this._url = window.location.origin + "/api/v1/list-pembayaran/";
        this.filterPage("");

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
