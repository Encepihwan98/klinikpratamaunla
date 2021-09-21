<template>
  <div class="text-center">
    <v-overlay :value="showProcess" :absolute="true">
      <v-progress-circular
        indeterminate
        size="50"
        color="primary"
      ></v-progress-circular>
    </v-overlay>
  </div>
</template>

<script>
export default {
  data: () => ({
    overlay: false,
  }),
  computed: {
    showProcess: {
      get() {
        return this.overlay;
      },
      set(value) {
        this.$emit("update", value);
      },
    },
  },
  watch: {
    overlay(val) {
      val &&
        setTimeout(() => {
          this.showProcess = false;
        }, 3000);
    },
  },
};
</script>
