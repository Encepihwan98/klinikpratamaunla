<template>
  <div>
    <router-view
      :modules="modules"
      @onUpdateModule="modules = $event"
    ></router-view>
  </div>
</template>
<script>
export default {
  data() {
    return {
      modules: {},
    };
  },
  created() {
    if (localStorage.getItem("token")) {
        this.modules = this.requestModule();
    }
  },
};
</script>
