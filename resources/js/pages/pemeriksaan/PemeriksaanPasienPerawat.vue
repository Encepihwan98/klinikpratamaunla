<template>
    <v-app>
        <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen" :modules="modules"></vertical-nav-menu>
        <app-bar :isDrawerOpen="isDrawerOpen" :currentUser="currentUser" @updateNavbar="isDrawerOpen = $event">
        </app-bar>
        <v-main>
            <div class="app-content-container boxed-container pa-6">
                <v-form class="mx-3 my-3" ref="form" v-model="valid" lazy-validation :currentData="currentData">
                    <v-container>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <v-card>
                                    <v-card-text>
                                        <p class="text-h6 font-weight-bold">Data Pasien</p>
                                    </v-card-text>
                                    <v-container>

                                        <v-container>
                                            <v-row>
                                                <v-col class="pa-0" cols="12" sm="12">
                                                    <v-text-field label="ID" v-model="pasien.pasien_id"
                                                        placeholder="PS001" outlined dense small disabled>
                                                    </v-text-field>
                                                </v-col>
                                                <v-col class="pa-0 mr-6" cols="12" sm="6">
                                                    <v-text-field label="Nama" v-model="pasien.nama"
                                                        placeholder="Maman Abdul" disabled outlined dense small>
                                                    </v-text-field>
                                                </v-col>
                                                <v-col class="pa-0" cols="12" sm="5">
                                                    <v-text-field label="Umur" v-model="pasien.umur" placeholder="24"
                                                        disabled outlined dense small></v-text-field>
                                                </v-col>
                                                <v-col cols="12" class="pa-0 mb-5" sm="12">
                                                    <v-btn @click="selectMethod(item, 'show')" color="success">Lihat
                                                        Riwayat Rekam Medis</v-btn>
                                                </v-col>
                                            </v-row>
                                        </v-container>

                                    </v-container>
                                </v-card>
                                <v-card>
                                    <v-card-text>
                                        <p class="text-h6 font-weight-bold">
                                            Rekam Medis Pasien <v-chip color="blue">{{this.pasien.pasien_id}}</v-chip>
                                        </p>
                                    </v-card-text>
                                    <v-container>

                                        <v-container>
                                            <v-row>
                                                <v-col class="pa-0 mr-6" cols="12" sm="6">
                                                    <v-text-field v-model="form.bb" label="Berat Badan"
                                                        suffix="Kg" outlined dense :error-messages="errors.name"
                                                        :rules="[rules.required]" small>
                                                    </v-text-field>
                                                </v-col>
                                                <v-col class="pa-0" cols="12" sm="5">
                                                    <v-text-field v-model="form.td" label="Tensi Darah"
                                                        suffix="mmHg" outlined dense :error-messages="errors.name"
                                                        :rules="[rules.required]" small>
                                                    </v-text-field>
                                                </v-col>
                                                <v-col class="pa-0 mr-6" cols="12" sm="6">
                                                    <v-text-field v-model="form.tb" label="Tinggi Badan"
                                                        suffix="Cm" outlined dense :error-messages="errors.name"
                                                        :rules="[rules.required]" small>
                                                    </v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="8">
                                                    <v-btn  @click="selectStore" color="primary">
                                                        Simpan
                                                    </v-btn>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                    </v-container>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-form>
            </div>
            <div>
                <v-dialog v-model="dialog.state" persistent max-width="600px">
                    <v-card>
                        <v-card-title class="text-h5"> Detail Rekamedik </v-card-title>
                        <v-simple-table dense>
                            <template v-slot:default>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="text-left">Data Rekamedik pasien</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in rekamedisPasien.data" :key="item.id">
                                        <td>{{ index + rekamedisPasien.from }} </td>
                                        <td>
                                            Tgl : {{item.tgl}},
                                            BB : {{item.bb}},
                                            TB : {{item.tb}},
                                            Anamnesis : {{item.tensi}},
                                            Keluhan : {{item.keluhan}},
                                            Tensi : {{item.tensi}}
                                        </td>
                                    </tr>

                                </tbody>
                            </template>
                        </v-simple-table>
                        <v-col cols="12" sm="12">
                            <!-- <v-btn class="mr-4" @click="submit"> Submit </v-btn> -->
                            <v-btn @click="dialog.state = false"> Close </v-btn>
                        </v-col>
                    </v-card>
                </v-dialog>
            </div>
            <div>
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
            urlTmbh : "",
            param: "",
            pasien: {
                umur: 0,
            },

            tindakan: {
                items: [
                    { header: 'Pilih salah satu' },
                ],
                data: {}
            },
            valid: false,
            obat: {
                items: [],
                data: {}
            },

            web: {
                isTableLoad: false,
                filterOpen: false,
            },
            form: {},
            rekamedisPasien: {},
            jumlahObat: 1,
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
            errors: [],
            rules: {
                required: (v) => !!v || "Tolong isi form.",
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
            activator: null,
            attach: null,
            colors: ['green', 'purple', 'indigo', 'cyan', 'teal', 'orange'],
            editing: null,
            editingIndex: -1,
            items: [
                { header: 'Select an option or create one' },
                {
                    text: 'Foo',
                    color: 'blue',
                },
                {
                    text: 'Bar',
                    color: 'red',
                },
            ],
            nonce: 1,
            menu: false,
            model: [
                {
                    text: 'Foo',
                    color: 'blue',
                },
            ],
            x: 0,
            search: null,
            y: 0,
        };
    },
    methods: {
        orderAvailable(param) {
            this.orderItem.length = 0;
            this.parentData.forEach((v, i) => {
                if (v.name == param) {
                    for (let index = 0; index <= v.count; index++) {
                        this.orderItem.push(index + 1);
                    }
                }
            });
        },
        filterTindakan(item, queryText, itemText) {
            if (item.header) return false

            const hasValue = val => val != null ? val : ''

            const text = hasValue(itemText)
            const query = hasValue(queryText)

            return text.toString()
                .toLowerCase()
                .indexOf(query.toString().toLowerCase()) > -1
        },
        changeID(event, index = 0) {
            console.log("masuk sini!");
            if (event == "tindakan") {
                let currentID = this.form.rekamedis.tindakan;
                let index = currentID.length;
                this.tindakan.data.forEach((v) => {
                    // console.log(v);
                    if (v.description == currentID[index].text) {
                        this.form.rekamedis.tindakan[index].tindakan_id = v.id;
                    }
                });
            } else if (event == "obat") {
                // console.log(`obat index = ${index}`)
                let currentID = this.form.obat[index].name;
                this.obatChange(index);
                this.obat.data.forEach((v) => {
                    if (v.nama == currentID) {
                        this.form.obat[index].obat_id = v.id;
                    }
                });
            }
        },
        obatChange(data) {
            console.log(data);
            let obat = this.form.obat[data];
            if (this.form.obat.length > 0) {
                for (let index = 0; index < this.form.obat.length; index++) {
                    if (obat.name == this.form.obat[index].name && index != data) {
                        alert("Obat sudah di dipilih");
                        this.form.obat.splice(data, 1);
                    }
                }
            }
        },
        addObat() {
            this.form.obat.push({ name: "", desc: "", total: 0 });
        },
        setSelectedPasien() {
            axios
                .get(`/api/v1/daftar-pasien?param=` + this.param)
                .then((res) => {
                    if (res.status === 200) {
                        // console.log(res.data.umur);
                        this.pasien = res.data.data;
                        this.pasien.umur = res.data.umur;
                        this.form.pasien_id = this.pasien.pasien_id;
                        this.form.regis_id = this.pasien.regis_id;
                    } else {
                        this.makeDefaultNotification(
                            response.data.status,
                            response.data.message
                        );
                    }
                });
        },
        setSelectedObat() {
            axios.get(`/api/v1/list-obat/`).then((res) => {
                if (res.status === 200) {
                    res.data.data.forEach((v) => {
                        this.obat.items.push(`${v.id}-${v.nama}-${v.satuan}`);
                    });
                    this.obat.data = res.data.data;
                } else {
                    this.makeDefaultNotification(
                        response.data.status,
                        response.data.message
                    );
                }
            });
        },
        setSelectedTindakan() {
            axios.get(`/api/v1/list-tindakan/`).then((res) => {
                if (res.status === 200) {
                    res.data.data.forEach((v) => {
                        this.tindakan.items.push({ "text": v.description, "color": "blue" });
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
                this.condition = "store";
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
                this.dialog.title = "Data Rekamedis";
                this.currentData = this.pasien;
                this.showDialog(false);
            } else if (item == "edit") {
                this.condition = "update";
                this.dialog.title = "Edit Menu";
                this.showDialog(false);
            }
        },
        popDialog() {
            this.dialogConfirmation.state = !this.dialogConfirmation.state;
        },
        clear() {
            this.form = {};
            this.errors = {};
            if (this.$refs.form) this.$refs.form.resetValidation();
        },
        show(pasien_id) {
            this._urlRekamedis = window.location.origin + "/api/v1/detail-rekamedis-pasien/";
            let url = `${this._urlRekamedis}${pasien_id}`;
            axios
                .get(url)
                .then((response) => {
                    if (response.status == 200) {
                        this.rekamedisPasien = response.data.data;
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
        showDialog(isConfirmation) {
            if (isConfirmation) {
                this.dialogConfirmation.state = !this.dialogConfirmation.state;
            } else {
                this.dialog.state = !this.dialog.state;
            }
        },
        store() {
            let req = Object.assign(this.form, this.filter);
            this.urlTmbh = window.location.origin + "/api/v1/rekamedis-perawat/";
            this.currentData = null;
            axios
                .post(this.urlTmbh, req)
                .then((response) => {
                    if (response.status == 200) {
                        // this.clear();
                        this.data = response.data.data;
                        this.makeDefaultNotification(
                            response.data.status,
                            response.data.message
                        );
                        this.clear();
                        this.$router.push({path: '/pemeriksaan/pemeriksaan-perawat'});
                        this.filterPage();
                    }
                })
                .catch((e) => {
                    this.errorState(e);
                });
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
                        this.data.data = response.data.data;
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
                this.$router.push({ name: "rawat-jalan-detail" });
            }
        }
        this.filterPage("");
        this.setSelectedPasien();
    },
    computed: {
        modelTindakan() {
            return this.form.rekamedis.tindakan;
        },
        dialogState() {
            return this.dialog.state;
        },
    },
    watch: {
        dialogState: function (n, o) {
            console.log(n);

            if (n && this.currentData) this.show(this.currentData.pasien_id);
            // else this.clear();
        },
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
        modelTindakan(val, prev) {
            if (val.length === prev.length) return

            this.form.rekamedis.tindakan = val.map(v => {
                if (typeof v === 'string') {
                    v = {
                        text: v,
                        color: this.colors[this.nonce - 1],
                    }
                    this.nonce++
                }
                return v
            })

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
  