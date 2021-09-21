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
                    v-model="user.name"
                    label="Nama"
                    outlined
                    clearable
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field
                    dense
                    v-model="user.username"
                    label="Username"
                    outlined
                    clearable
                    :error-messages="errors.username"
                    :hint="
                      condition == 'update'
                        ? 'Kosongkan jika tidak ingin mengubah'
                        : ''
                    "
                    :rules="condition == 'update' ? [] : [rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field
                    dense
                    v-model="user.email"
                    label="Email"
                    outlined
                    clearable
                    :error-messages="errors.email"
                    :hint="
                      condition == 'update'
                        ? 'Kosongkan jika tidak ingin mengubah'
                        : ''
                    "
                    :rules="
                      condition == 'update' ? [] : [rules.required, rules.email]
                    "
                    :disabled="condition == 'show' ? true : false"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field
                    dense
                    v-model="user.password"
                    label="Password"
                    outlined
                    clearable
                    :hint="
                      condition == 'update'
                        ? 'Kosongkan jika tidak ingin mengubah'
                        : ''
                    "
                    :error-messages="errors.password"
                    :rules="
                      condition == 'update'
                        ? []
                        : [rules.required, rules.min(6)]
                    "
                    :append-icon="
                      input.password_state ? 'mdi-eye' : 'mdi-eye-off'
                    "
                    :type="input.password_state ? 'text' : 'password'"
                    :disabled="condition == 'show' ? true : false"
                    @click:append="input.password_state = !input.password_state"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field
                    dense
                    v-model="user.password_confirmation"
                    label="Konfirmasi Password"
                    outlined
                    clearable
                    :append-icon="
                      input.password_confirmation_state
                        ? 'mdi-eye'
                        : 'mdi-eye-off'
                    "
                    :type="
                      input.password_confirmation_state ? 'text' : 'password'
                    "
                    :hint="
                      condition == 'update'
                        ? 'Kosongkan jika tidak ingin mengubah'
                        : ''
                    "
                    :rules="
                      condition == 'update' ? [] : [rules.required, rules.match]
                    "
                    :disabled="condition == 'show' ? true : false"
                    @click:append="
                      input.password_confirmation_state =
                        !input.password_confirmation_state
                    "
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field-simplemask
                    v-model="user.phone"
                    label="Nomor Telepon"
                    v-bind:properties="{
                      disabled: condition == 'show' ? true : false,
                      outlined: true,
                      clearable: true,
                      dense: true,
                      rules: condition == 'update' ? [] : [rules.required],
                      hint:
                        condition == 'update'
                          ? 'Kosongkan jika tidak ingin mengubah'
                          : 'Contoh: (62) 838-xxxx-xxxx',
                      error_messages: errors.phone,
                    }"
                    v-bind:options="{
                      inputMask: '(##) ###-####-#####',
                      outputMask: '##############',
                      empty: null,
                      applyAfter: false,
                      alphanumeric: true,
                      lowerCase: false,
                    }"
                  />
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-select
                    v-model="user.status"
                    dense
                    label="Status User"
                    outlined
                    :disabled="condition == 'show' ? true : false"
                    :error-messages="errors.status"
                    :rules="[rules.required]"
                    :items="['aktif', 'tidak aktif']"
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-autocomplete
                    v-model="user.roles"
                    outlined
                    dense
                    chips
                    small-chips
                    label="Role User"
                    multiple
                    :disabled="condition == 'show' ? true : false"
                    :error-messages="errors.roles"
                    :rules="[rules.required]"
                    :items="roles"
                  ></v-autocomplete>
                </v-col>
                <v-col cols="12" sm="12" md="12">
                  <v-textarea
                    v-model="user.address"
                    outlined
                    clearable
                    rows="1"
                    label="Alamat"
                    :error-messages="errors.address"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-textarea>
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
      user: {},
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
    this._url = window.location.origin + "/api/v1/users/";
  },
  watch: {
    showDialog: function (n, o) {
      if (n && this.currentData) this.show(this.currentData.uuid);
      else this.clear();
    },
  },
};
</script>
