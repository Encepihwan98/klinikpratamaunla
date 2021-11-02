<template>
  <div>
    <v-dialog
      v-model="showDialog"
      persistent
      scrollable
      transition="dialog-bottom-transition"
      max-width="600px"
    >
      <v-card>
        <v-card-title class="d-flex">
          <span class="text-h5">{{ dialog.title }}</span>
          <v-icon class="ml-auto" @click="showDialog = false" color="red"
            >fas fa-times-circle</v-icon
          >
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field
                    dense
                    v-model="menu.name"
                    label="Nama Menu"
                    outlined
                    clearable
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-autocomplete
                    v-model="menu.parent"
                    outlined
                    dense
                    chips
                    small-chips
                    label="Induk Menu"
                    :error-messages="errors.parent"
                    :disabled="condition == 'show' ? true : false"
                    :rules="[rules.required]"
                    :items="parentName"
                    @input="orderAvailable($event)"
                  ></v-autocomplete>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field
                    dense
                    v-model="menu.path"
                    label="URL"
                    outlined
                    clearable
                    :error-messages="errors.url"
                    :hint="
                      condition == 'update'
                        ? 'Kosongkan jika tidak ingin mengubah'
                        : `${this._baseUrl}/${this.menu.path}`
                    "
                    :rules="
                      menu.isParent
                        ? []
                        : condition == 'update'
                        ? []
                        : [rules.required]
                    "
                    :disabled="condition == 'show' ? true : false"
                    :readonly="menu.isParent"
                    @input="replaceUrl($event)"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field
                    dense
                    v-model="menu.slug"
                    label="Slug (otomatis)"
                    outlined
                    :hint="
                      condition == 'update'
                        ? 'Kosongkan jika tidak ingin mengubah'
                        : ''
                    "
                    :rules="
                      menu.isParent
                        ? []
                        : condition == 'update'
                        ? []
                        : [rules.required]
                    "
                    :error-messages="errors.slug"
                    :disabled="condition == 'show' ? true : false"
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field
                    dense
                    v-model="menu.icon"
                    label="Icon"
                    outlined
                    clearable
                    :hint="
                      condition == 'update'
                        ? 'Kosongkan jika tidak ingin mengubah'
                        : ''
                    "
                    :rules="condition == 'update' ? [] : [rules.required]"
                    :error-messages="errors.icon"
                    :disabled="condition == 'show' ? true : false"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-select
                    v-model="menu.order"
                    dense
                    label="Urutan"
                    outlined
                    :disabled="condition == 'show' ? true : false"
                    :error-messages="errors.order"
                    :rules="[rules.required]"
                    :items="orderItem"
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field
                    v-model="menu.component"
                    dense
                    label="Nama Komponen"
                    outlined
                    :disabled="condition == 'show' ? true : false"
                    :error-messages="errors.component"
                    :rules="menu.isParent ? [] : [rules.required]"
                    :readonly="menu.isParent"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field
                    v-model="menu.api_module"
                    dense
                    label="Api Module"
                    outlined
                    :disabled="condition == 'show' ? true : false"
                    :error-messages="errors.api_module"
                    :rules="menu.isParent ? [] : [rules.required]"
                    :readonly="menu.isParent"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-select
                    v-model="menu.mustLogin"
                    dense
                    label="Perlu Login"
                    outlined
                    :disabled="condition == 'show' ? true : false"
                    :error-messages="errors.mustLogin"
                    :rules="[rules.required]"
                    :items="['Ya', 'Tidak']"
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-select
                    v-model="menu.isActive"
                    dense
                    label="Status Menu"
                    outlined
                    :disabled="condition == 'show' ? true : false"
                    :error-messages="errors.isActive"
                    :rules="[rules.required]"
                    :items="['Aktif', 'Tidak Aktif']"
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-checkbox
                    v-model="menu.isParent"
                    label="Jadikan Induk Menu"
                    :disabled="condition == 'show' ? true : false"
                  ></v-checkbox>
                </v-col>
              </v-row>
            </v-form>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="showDialog = false">
            Tutup
          </v-btn>
          <v-btn
            v-if="condition != 'show'"
            color="blue darken-1"
            text
            @click="selectMethod"
          >
            Simpan
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <confirmation-dialog
      :confirmationDialog="dialogConfirmation"
      :method="condition == 'store' ? store : update"
      @changeDialogState="dialogConfirmation.state = $event"
    ></confirmation-dialog>
  </div>
</template>

<script>
export default {
  props: {
    dialog: {
      state: false,
      title: null,
    },
    filter: {},
    roles: {},
    parentData: [],
    parentName: [],
    condition: null,
    currentData: {},
    dialogItems: [
      {
        name: "",
        outline: false,
        clearable: false,
        lable: "",
        value: "",
        model: "",
        type: "",
        sizeSM: "",
        sizeMD: "",
        cols: "",
      },
    ],
  },
  data() {
    return {
      _url: "",
      _baseUrl: "",
      user: {},
      menu: {
        isParent: false,
      },
      
      orderItem: [],
      valid: false,
      dialogConfirmation: {
        state: false,
        message: null,
      },
      data: {},
      errors: [],
      input: {
        password_state: false,
        password_confirmation_state: false,
      },
      rules: {
        email: (v) => /.+@.+\..+/.test(v) || "Format email tidak valid.",
        required: (v) => !!v || "Tolong isi form.",
        match: (v) =>
          v == this.user.password || "Password konfirmasi tidak sesuai.",
        min: (len) => (v) =>
          (v && v.length >= len) || "Tolong isi minimal " + len + " karakter",
      },
    };
  },
  computed: {
    showDialog: {
      get() {
        return this.dialog.state;
      },
      set(value) {
        this.$emit("updateDialog", value);
      },
    },
    retriveData: {
      get() {
        return this.data;
      },
      set(value) {
        this.$emit("updateData", value);
      },
    },
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
    replaceUrl(param) {
      let value = param.split("").map((v) => {
        v = v.replace(" ", "-");
        v = v.replace("@", "-");
        v = v.replace("\\", "-");
        v = v.replace("+", "-");
        v = v.replace("?", "-");
        v = v.replace("=", "-");
        v = v.replace("&", "-");
        v = v.replace("^", "-");
        v = v.replace("%", "-");
        v = v.replace("*", "-");
        v = v.replace("(", "-");
        v = v.replace(")", "-");
        v = v.replace("[", "-");
        v = v.replace("]", "-");
        v = v.replace("{", "-");
        v = v.replace("}", "-");
        v = v.replace(".", "-");
        v = v.replace(",", "-");
        v = v.replace("<", "-");
        v = v.replace(">", "-");
        v = v.replace("`", "-");
        v = v.replace("$", "-");
        v = v.replace("#", "-");
        v = v.replace("!", "-");
        return v;
      });
      let slug = value.join("").split("/");
      this.menu.slug = slug.at(-1).toLowerCase();
      this.menu.path = value.join("").toLowerCase();
    },
    selectMethod() {
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
    store() {
      let req = Object.assign(this.menu, this.filter, {
        url: !this.menu.path ? "" : `${this._baseUrl}/${this.menu.path}`,
      });
      axios
        .post(this._url, req)
        .then((response) => {
          if (response.status == 200) {
            this.showDialog = false;
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
    update() {
      let req = Object.assign(this.menu, this.filter, {
        url: !this.menu.path ? "" : `${this._baseUrl}/${this.menu.path}`,
      });
      let url = `${this._url}${this.menu.uuid}`;
      axios
        .put(url, req)
        .then((response) => {
          if (response.status == 200) {
            this.showDialog = false;
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
            let resData = response.data.data;
            this.menu = resData;
            let urlSplit = resData.url.split("/");
            this.menu.path = urlSplit
              .slice(3, urlSplit.length)
              .join("/")
              .toLowerCase();
            this.orderItem.push(resData.order);
            this.menu.isActive =
              resData.is_active == 1 ? "Aktif" : "Tidak Aktif";
            this.menu.mustLogin = resData.must_login == 1 ? "Ya" : "Tidak";
            this.menu.isParent = resData.is_parent == 1 ? true : false;
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
      this.menu = {};
      if (this.$refs.form) this.$refs.form.resetValidation();
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
  },
  created() {
    this._baseUrl = window.location.origin;
    this._url = this._baseUrl + "/api/v1/modules/";
  },
  watch: {
    showDialog: function (n, o) {
      if (n && this.currentData) {
        this.show(this.currentData.uuid);
        if (this.$refs.form) this.$refs.form.resetValidation();
      } else this.clear();
    },
  },
};
</script>
