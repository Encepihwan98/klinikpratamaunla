<template>
  <v-row justify="center">
    <v-dialog v-model="showDialog" persistent max-width="290">
      <v-card>
        <v-card-title class="text-h5"> Konfirmasi </v-card-title>
        <v-card-text>
          Apakah anda yakin akan {{ confirmationDialog.message }} data ?
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red darken-1" text @click="showDialog = false">
            Batal
          </v-btn>
          <v-btn color="green darken-1" text @click="changeReturn">
            Simpan
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
export default {
  props: {
    confirmationDialog: {
      state: false,
      message: null,
    },
    method: { type: Function },
  },
  methods: {
    changeReturn() {
      this.method();
      this.showDialog = false;
    },
  },
  computed: {
    showDialog: {
      get() {
        return this.confirmationDialog.state;
      },
      set(value) {
        this.$emit("changeDialogState", value);
      },
    },
  },
};
</script>
