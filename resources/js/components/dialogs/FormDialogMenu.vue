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
                    v-model="menu.parent_id"
                    outlined
                    dense
                    chips
                    small-chips
                    label="Induk Menu"
                    :disabled="condition == 'show' ? true : false"
                    :rules="[rules.required]"
                    :items="roles"
                  ></v-autocomplete>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field
                    dense
                    v-model="menu.slug"
                    label="Slug"
                    outlined
                    clearable
                    :hint="
                      condition == 'update'
                        ? 'Kosongkan jika tidak ingin mengubah'
                        : ''
                    "
                    :rules="
                      condition == 'update'
                        ? []
                        : [rules.required, rules.min(6)]
                    "
                    :disabled="condition == 'show' ? true : false"
                    @input="replaceUrl($event)"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field
                    dense
                    v-model="menu.url"
                    label="URL (otomatis)"
                    outlined
                    :error-messages="errors.url"
                    :hint="
                      condition == 'update'
                        ? 'Kosongkan jika tidak ingin mengubah'
                        : `${menu.url}`
                    "
                    :rules="condition == 'update' ? [] : [rules.required]"
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
                    :rules="
                      condition == 'update' ? [] : [rules.required, rules.match]
                    "
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
                    :error-messages="errors.status"
                    :rules="[rules.required]"
                    :items="['aktif', 'tidak aktif']"
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field
                    v-model="menu.component"
                    dense
                    label="Nama Komponen"
                    outlined
                    :disabled="condition == 'show' ? true : false"
                    :error-messages="errors.status"
                    :rules="[rules.required]"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-select
                    v-model="menu.mustLogin"
                    dense
                    label="Perlu Login"
                    outlined
                    :disabled="condition == 'show' ? true : false"
                    :error-messages="errors.loginNeeded"
                    :rules="[rules.required]"
                    :items="['Ya', 'Tidak']"
                  ></v-select>
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
      menu: {},
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
    replaceUrl(param) {
      let value = param.split("").map((v) => {
          v = v.replace(" ", "-")
          v = v.replace("@", "-")
          v = v.replace("/", "-")
          v = v.replace("\\", "-")
          v = v.replace("+", "-")
          v = v.replace("?", "-")
          v = v.replace("=", "-")
          v = v.replace("&", "-")
          v = v.replace("^", "-")
          v = v.replace("%", "-")
          v = v.replace("*", "-")
          v = v.replace("(", "-")
          v = v.replace(")", "-")
          v = v.replace("[", "-")
          v = v.replace("]", "-")
          v = v.replace("{", "-")
          v = v.replace("}", "-")
          v = v.replace(".", "-")
          v = v.replace(",", "-")
          v = v.replace("<", "-")
          v = v.replace(">", "-")
          v = v.replace("`", "-")
          v = v.replace("$", "-")
          v = v.replace("#", "-")
          v = v.replace("!", "-")
          return v;
      });
      this.menu.slug = value.join('').toLowerCase()
      this.menu.url = `${this._baseUrl}/${this.menu.slug}`
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
      let req = Object.assign(this.user, this.filter);
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
      let req = Object.assign(this.user, this.filter);
      let url = `${this._url}${this.user.uuid}`;
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
            this.user = response.data.data;
            if (this.condition == "update") {
              this.user.username = "";
              this.user.email = "";
              this.user.phone = "";
            }
            this.user.status =
              response.data.data.status == 1 ? "aktif" : "tidak aktif";
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
      this.user = {};
      if (this.$refs.form) this.$refs.form.resetValidation();
    },
    errorState(e) {
      if (e.response.status == 401) {
        localStorage.removeItem("token");
        this._token = "";
        this.$router.push({ name: "index" });
      } else if (e.response.status == 400) {
        this.errors = e.response.data.errors;
        this.makeDefaultNotification(
          e.response.data.status,
          e.response.data.message
        );
      }
    },
  },
  created() {
    this._baseUrl = window.location.origin;
    this._url = this._baseUrl + "/api/v1/users/";
  },
  watch: {
    showDialog: function (n, o) {
      if (n && this.currentData) this.show(this.currentData.uuid);
      else this.clear();
    },
  },
};
</script>
