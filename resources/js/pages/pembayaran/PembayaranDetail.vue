<template>
    <v-app>
        <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen" :modules="modules"></vertical-nav-menu>
        <app-bar :isDrawerOpen="isDrawerOpen" :currentUser="currentUser" @updateNavbar="isDrawerOpen = $event">
        </app-bar>
        <v-main>
            <v-container>
                <v-row>
                    <v-col cols="12" sm="12">
                        <v-expansion-panels focusable v-model="disable">
                            <v-expansion-panel>
                                <v-expansion-panel-header>Data Pasien</v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    <v-from>
                                        <v-container>
                                            <v-row>
                                                <v-col cols="12" sm="6" md="4">
                                                    <v-text-field label="Nama Pasien" placeholder="Pasien" outlined
                                                        dense small></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="4">
                                                    <v-text-field label="ID Pasien" placeholder="PS0007" outlined dense
                                                        small>
                                                    </v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="4">
                                                    <v-text-field label="Alamat" placeholder="Alamat" outlined dense
                                                        small></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                    </v-from>
                                </v-expansion-panel-content>
                            </v-expansion-panel>
                        </v-expansion-panels>
                        <br>
                        <v-card>
                            <v-container>
                                <div class="d-flex flex-column mt-9">
                                    <v-card class="pa-2 font-weight-bold" outlined tile> Rincian Transaksi </v-card>
                                </div>
                                <v-simple-table dense>
                                    <template v-slot:default>
                                        <thead>
                                            <tr>
                                                <th colspan="4" class="font-weight-bold text-center">TINDAKAN</th>
                                            </tr>
                                            <tr>
                                                <th>No</th>
                                                <th class="text-left">Nama Tindakan</th>
                                                <th colspan="2" class="text-left">Biaya</th>
                                                <th colspan="2" class="text-left">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in bayar.resep.data" :key="item.id">
                                                <td>{{  index + data.current_page  }}</td>
                                                <td>{{item.description}}</td>
                                                <td colspan="2">{{item.harga}}</td>
                                                <td colspan="2">{{item.harga}}</td>
                                            </tr>
                                        </tbody>
                                        <thead>
                                            <tr>
                                                <th colspan="4" class="font-weight-bold text-center">OBAT</th>
                                            </tr>
                                            <tr>
                                                <th class="text-left">No</th>
                                                <th class="text-left">Nama Obat</th>
                                                <th class="text-left">Jumlah</th>
                                                <th class="text-left">Biaya</th>
                                                <th class="text-left">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in bayar.resep.data" :key="item.id">
                                                <td>{{  index + data.current_page  }}</td>
                                                <td>{{  item.nama  }}</td>
                                                <td>{{  item.jumlah  }}</td>
                                                <td>{{  item.harga  }}</td>
                                                <td>{{  item.harga * item.jumlah  }}</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">Total Semua</td>
                                                <td>Rp. {{  totalHarga  }}</td>
                                            </tr>
                                        </tfoot>
                                    </template>
                                </v-simple-table>

                            </v-container>
                        </v-card>
                        <v-card>
                            <v-card-text>
                                <v-form>
                                    <v-col class="pa-0 mr-2" cols="12" sm="6">
                                        <v-text-field @input="kembalian" v-model="pembayaran.jumlah_bayar"
                                            label="Jumlah Bayar" outlined dense small>
                                        </v-text-field>
                                    </v-col>
                                    <v-col class="pa-0" cols="12" sm="4">
                                        <v-text-field v-model="pembayaran.kembalian" disabled label="Kembalian" outlined
                                            dense small>
                                        </v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6">
                                        <v-btn class="mr-4" @click="selectMethod()"> Bayar </v-btn>
                                    </v-col>
                                </v-form>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
            <confirmation-dialog :confirmationDialog="dialogConfirmation" :method="store"
                @changeDialogState="dialogConfirmation.state = $event"></confirmation-dialog>
        </v-main>
    </v-app>
</template>
<script>
import { defineComponent } from '@vue/composition-api'

export default {
    props: {
        modules: [],
    },
    data() {
        return {
            _url: "",
            totalObat: 0,
            web: {
                isTableLoad: false,
                filterOpen: false,
            },
            totalHarga: 0,
            pembayaran: {
                total: 0,
                kembalian: 0,
            },
            bayar: {
                resep: {
                    data: {},
                    items: []
                },
            },
            tindakan: {
                data: {},
                items: [],
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
        }
    },
    methods: {
        kembalian() {
            this.pembayaran.kembalian = this.pembayaran.jumlah_bayar - this.totalHarga;
        },
        selectMethod(data, item) {
            // this.condition == "update"
            this.dialogConfirmation.message = "mengkonfirmasi resep";
            // this.popDialog();
            this.showDialog(true);
        },
        store() {
            let req = Object.assign(this.pembayaran, this.filter);
            this.urlStatus = window.location.origin + "/api/v1/pembayaran/";
            this.currentData = null;
            axios
                .post(`${this.urlStatus}`, req)
                .then((response) => {
                    if (response.status == 200) {
                        this.dialogs.dialogAntrian.state = false;
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
        setDetailObat() {
            axios.get(`/api/v1/detail-resep/?param=` + this.param).then((res) => {
                if (res.status === 200) {
                    res.data.data.forEach((v) => {
                        this.bayar.resep.items.push(v.nama);
                        this.totalHarga += v.jumlah * v.harga;
                    });
                    // console.log(this.pembayaran.totalHarga);
                    this.bayar.resep.data = res.data.data;
                    this.pembayaran = res.data.value;
                    this.pembayaran.total = this.totalHarga;
                    this.data.data = res.data.value;
                } else {
                    this.makeDefaultNotification(
                        response.data.status,
                        response.data.message
                    );
                }
            });
        },
        setTindakan() {
            axios.get(`/api/v1/daftar-tindakan-pembayaran/?param=` + this.param).then((res) => {
                if (res.status === 200) {
                    console.log(res.data.data);
                    res.data.data.forEach((v) => {
                        this.tindakan.items.push(v.harga);
                        // console.log(v);

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
        // filterPage(sort_by) {
        //     this.web.isTableLoad = true;
        //     if (sort_by) {
        //         this.filter.sortBy == sort_by
        //             ? this.filter.orderBy == "asc"
        //                 ? (this.filter.orderBy = "desc")
        //                 : (this.filter.orderBy = "asc")
        //             : (this.filter.sortBy = sort_by);
        //     }

        //     let url =
        //         this._url +
        //         "?page=" +
        //         this.filter.page +
        //         "&limit=" +
        //         this.filter.limit +
        //         "&searchQuery=" +
        //         this.filter.searchQuery +
        //         "&sortBy=" +
        //         this.filter.sortBy +
        //         "&orderBy=" +
        //         this.filter.orderBy +
        //         "&role=" +
        //         this.module.role;
        //     axios
        //         .get(url)
        //         .then((response) => {
        //             if (response.status == 200) {
        //                 this.clearModules();
        //                 this.data.data = response.data.data;
        //                 response.data.data.forEach((v) => {

        //                 });
        //                 if (!this.module.role) this.clearModules();
        //                 this.filter.page = response.data.data.current_page;
        //                 this.web.isTableLoad = false;
        //                 this.currentUser = this.requestCurrentUser();
        //                 if (!this.roles || this.roles < 1) {
        //                     this.roles = this.requestRole();
        //                 }
        //             }
        //         })
        //         .catch((e) => {
        //             this.errorState(e);
        //         });
        // },
        showDialog(isConfirmation) {
            if (isConfirmation) {
                this.dialogConfirmation.state = !this.dialogConfirmation.state;
            } else {
                this.dialog.state = !this.dialog.state;
            }
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
        // console.log(this.$route.params.id);
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
        this.setTindakan();

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
    }
}
</script>
