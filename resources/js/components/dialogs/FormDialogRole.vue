<template>
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
          <v-row>
            <v-col cols="12" sm="12" md="12">
              <v-text-field
                dense
                v-model="role.name"
                label="Nama"
                outlined
                clearable
                :disabled="condition == 'show' ? true : false"
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="12" md="12">
              <v-textarea
                v-model="role.description"
                outlined
                clearable
                label="Keterangan"
                :disabled="condition == 'show' ? true : false"
              ></v-textarea>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="showDialog = false">
          Tutup
        </v-btn>
        <v-btn v-if="condition != 'show'" color="blue darken-1" text @click="selectMethod"> Simpan </v-btn>
      </v-card-actions>
      <confirmation-dialog
        :confirmationDialog="dialogConfirmation"
        :method="condition == 'store' ? store : update"
        @changeDialogState="dialogConfirmation.state = $event"
      ></confirmation-dialog>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    dialog: {
      state: false,
      title: null,
    },
    condition: null,
    data: {},
    currentData: {},
    refreshData: false,
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
      role: {},
      dialogConfirmation: {
        state: false,
        message: null,
      },
    };
  },
  computed: {
    setData: {
      get() {
        return this.currentData;
      },
    },
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
        return this.refreshData;
      },
      set(value) {
        this.$emit("updateData", value);
      },
    },
  },
  methods: {
    selectMethod() {
      if (this.condition == "store") {
        this.dialogConfirmation.message = "menyimpan";
        this.popDialog();
      } else {
        this.dialogConfirmation.message = "mengubah";
        this.popDialog();
      }
    },
    store() {
      let url = window.location.origin + "/api/v1/roles";
      axios.post(url, this.role).then((response) => {
        if (response.status == 200) {
          this.showDialog = false;
          this.retriveData = true;
          this.makeDefaultNotification(response.data.status, response.data.message)
        }
      });
    },
    update() {
      let url = window.location.origin + "/api/v1/roles/" + this.role.uuid;
      axios.put(url, this.role).then((response) => {
        if (response.status == 200) {
          this.showDialog = false;
          this.retriveData = true;
          this.makeDefaultNotification(response.data.status, response.data.message)
        }
      });
    },
    popDialog() {
      this.dialogConfirmation.state = !this.dialogConfirmation.state;
    },
    clear() {
      this.roles.name = "";
      this.roles.description = "";
    },
  },
  watch: {
    currentData: function (newValue, oldValue) {
        if(newValue != null) this.role = newValue
        else this.role = {}
    },
  },
};
</script>
