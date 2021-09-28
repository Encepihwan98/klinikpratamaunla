<template>
  <div>
    <v-dialog
      v-model="showDialog"
      transition="dialog-bottom-transition"
      persistent
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
                <v-col cols="12" sm="12" md="12">
                  <v-text-field
                    dense
                    v-model="role.name"
                    label="Nama"
                    outlined
                    clearable
                    :error-messages="errors.name"
                    :rules="[rules.required]"
                    :disabled="condition == 'show' ? true : false"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="12">
                  <v-textarea
                    v-model="role.description"
                    outlined
                    clearable
                    label="Keterangan"
                    :error-messages="errors.description"
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
      role: {},
      valid: false,
      data: {},
      dialogConfirmation: {
        state: false,
        message: null,
      },
      errors: [],
      rules: {
        required: (v) => !!v || "Tolong isi form.",
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
      let req = Object.assign(this.role, this.filter);
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
      let req = Object.assign(this.role, this.filter);
      axios
        .put(`${this._url}${this.role.uuid}`, req)
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
            this.role = response.data.data;
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
      this.role = {};
      this.errors = {};
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
    this._url = window.location.origin + "/api/v1/roles/";
  },
  watch: {
    showDialog: function (n, o) {
      if (n && this.currentData) this.show(this.currentData.uuid);
      else this.clear();
    },
  },
};
</script>
