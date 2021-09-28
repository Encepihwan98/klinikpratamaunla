<template>
  <v-menu
    offset-y
    left
    nudge-bottom="14"
    min-width="230"
    content-class="user-profile-menu-content"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-badge
        bottom
        color="success"
        overlap
        offset-x="12"
        offset-y="12"
        class="ms-4"
        dot
      >
        <v-avatar size="40px" v-bind="attrs" v-on="on">
          <v-img
            src="https://png.pngtree.com/png-vector/20190704/ourlarge/pngtree-businessman-user-avatar-free-vector-png-image_1538405.jpg"
          ></v-img>
        </v-avatar>
      </v-badge>
    </template>
    <v-list>
      <div class="pb-3 pt-2">
        <v-badge
          bottom
          color="success"
          overlap
          offset-x="12"
          offset-y="12"
          class="ms-4"
          dot
        >
          <v-avatar size="40px">
            <v-img
              src="https://png.pngtree.com/png-vector/20190704/ourlarge/pngtree-businessman-user-avatar-free-vector-png-image_1538405.jpg"
            ></v-img>
          </v-avatar>
        </v-badge>
        <div
          class="d-inline-flex flex-column justify-center ms-3"
          style="vertical-align: middle"
        >
          <span class="text--primary font-weight-semibold mb-n1">
            {{ name }}
          </span>
          <small class="text--disabled text-capitalize">
            {{ email }}
          </small>
        </div>
      </div>

      <v-divider></v-divider>

      <!-- Profile -->
      <v-list-item link>
        <v-list-item-icon class="me-2">
          <v-icon size="22"> far fa-user-circle </v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>Profile</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-divider class="my-2"></v-divider>

      <!-- Settings -->
      <v-list-item link>
        <v-list-item-icon class="me-2">
          <v-icon size="22"> far fa-cogs </v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>Settings</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <!-- Logout -->
      <v-list-item link>
        <v-list-item-icon class="me-2">
          <v-icon size="22"> far fa-sign-out-alt </v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title @click="logout">Logout</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </v-menu>
</template>

<script>
export default {
  props: {
    currentUser: null,
  },
  methods: {
    logout() {
      this.isLoad = true;
      axios
        .post(window.location.origin + "/api/v1/logout")
        .then((response) => {
          console.log(response);
          if (response.status == 200) {
            localStorage.removeItem("token");
            this.isLoad = false;
            this.$router.push({
              name: "login",
            });
            this.makeDefaultNotification(
              response.data.status,
              response.data.message
            );
          }
        })
        .catch((err) => {
          this.errors = err.response.data.errors;
          this.isLoad = false;
          this.makeDefaultNotification(
            err.response.data.errors.status[0],
            err.response.data.errors.message[0]
          );
        });
    },
  },
  computed: {
    name() {
      return this.currentUser ? this.currentUser.name : "";
    },
    email() {
      return this.currentUser ? this.currentUser.email : "";
    },
  },
};
</script>

<style lang="scss">
.user-profile-menu-content {
  .v-list-item {
    min-height: 2.5rem !important;
  }
}
</style>
