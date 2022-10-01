<template>
  <div class="auth-wrapper auth-v1">
    <div class="auth-inner">
      <v-card class="auth-card">
        <!-- logo -->
        <v-card-title class="d-flex align-center justify-center">
          <router-link to="/" class="d-flex align-center mx-auto">
            <!-- <v-img
              src="/assets/images/logos/logo.svg"
              max-height="30px"
              max-width="30px"
              alt="logo"
              contain
              class="mr-3"
            ></v-img> -->

            <h2 class="text-2xl font-weight-semibold">KLINIK</h2>
          </router-link>
        </v-card-title>

        <!-- title -->
        <v-card-text>
          <!-- <p class="text-2xl font-weight-semibold text--primary mb-2">
            PRATAMA UNLA!  -->
            <!-- 👋🏻 -->
          <!-- </p> -->
          <h2 class="text-2xl text-center font-weight-semibold">PRATAMA UNLA</h2>
          <p class="mb-2">
            Please sign-in to your account and start the adventure
          </p>
        </v-card-text>

        <!-- login form -->
        <v-card-text>
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-text-field
              v-model="user.email"
              outlined
              label="Email"
              placeholder="john@example.com"
              :rules="[rules.required, rules.email]"
              class="mb-3"
            ></v-text-field>

            <v-text-field
              v-model="user.password"
              outlined
              :type="isPasswordVisible ? 'text' : 'password'"
              label="Password"
              :rules="[rules.required]"
              placeholder="············"
              :append-icon="
                isPasswordVisible ? 'far fa-eye' : 'far fa-eye-slash'
              "
              @click:append="isPasswordVisible = !isPasswordVisible"
            ></v-text-field>

            <div class="d-flex justify-space-between align-center">
              <v-checkbox label="Remember Me" hide-details class="pa-2 mt-1">
              </v-checkbox>

              <!-- forgot link -->
              <a href="javascript:void(0)" class="pa-2 mt-2 ml-auto">
                Forgot Password?
              </a>
            </div>

            <v-btn block color="blue darken-1" class="mt-6" @click="login">
              Login
            </v-btn>
          </v-form>
        </v-card-text>

        <!-- create new account  -->
        <v-card-text class="d-flex align-center justify-center flex-wrap mt-2">
          <span class="me-2"> New on our platform? </span>
          <router-link :to="{ name: 'pages-register' }">
            Create an account
          </router-link>
        </v-card-text>

        <!-- divider -->
        <v-card-text class="d-flex align-center mt-2">
          <v-divider></v-divider>
          <span class="mx-5">or</span>
          <v-divider></v-divider>
        </v-card-text>

        <!-- social links -->
        <v-card-actions class="d-flex justify-center">
          <!-- <v-btn v-for="link in socialLink" :key="link.icon" icon class="ms-1">
            <v-icon
              :color="$vuetify.theme.dark ? link.colorInDark : link.color"
            >
              {{ link.icon }}
            </v-icon>
          </v-btn> -->
        </v-card-actions>
        <loading-overlay
          :overlay="isLoad"
          @update="isLoad = $event"
        ></loading-overlay>
      </v-card>
    </div>

    <!-- background triangle shape  -->
    <img
      class="auth-mask-bg"
      height="173"
      src="/assets/images/misc/mask-light.png"
    />

    <!-- tree -->
    <v-img
      class="auth-tree"
      width="247"
      height="185"
      src="/assets/images/misc/tree.png"
    ></v-img>

    <!-- tree  -->
    <v-img
      class="auth-tree-3"
      width="377"
      height="289"
      src="/assets/images/misc/tree-3.png"
    ></v-img>
  </div>
</template>

<script>
export default {
  props: {
    modules: [],
  },
  data: () => ({
    rules: {
      email: (v) => /.+@.+\..+/.test(v) || "Format email tidak valid.",
      required: (v) => !!v || "Tolong isi form.",
    },
    isLoad: false,
    valid: false,
    isPasswordVisible: false,
    module: {},
    user: {},
    errors: [],
  }),
  computed: {
    retriveData: {
      get() {
        return this.module;
      },
      set(value) {
        this.$emit("onUpdateModule", value);
      },
    },
  },
  methods: {
    login() {
      if (this.$refs.form.validate()) {
        this.isLoad = true;
        axios.get("/sanctum/csrf-cookie").then((response) => {
          if (response.status == 204) {
            axios
              .post(window.location.origin + "/api/v1/login", this.user)
              .then((response) => {
                console.log(response);
                if (response.status == 200) {
                  localStorage.setItem("token", response.data.data);
                  axios.defaults.headers.common[
                    "Authorization"
                  ] = `Bearer ${localStorage.getItem("token")}`;
                  this.retriveData = this.requestModule();
                  this.isLoad = false;
                  this.makeDefaultNotification(
                    response.data.status,
                    response.data.message
                  );
                  this.$router.push({
                    name: response.data.home,
                  });
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
          }
        });
      }
    },
    clear() {
      this.user = {};
      if (this.$refs.form) this.$refs.form.resetValidation();
    },
  },
  created() {
    if (this.modules.length > 0) {
      let access = this.redirectIfNotHaveAccess(this.modules, this.$route.path);
      if (this.isLoggedIn()) {
        this.$router.push({ name: access.home });
      }
    }
  },
  watch: {
    modules: function (n, o) {
      let access = this.redirectIfNotHaveAccess(n, this.$route.fullPath);
      if (this.isLoggedIn()) {
        this.$router.push({ name: access.home });
      }
    },
  },
};
</script>

<style lang="scss">
@import "./resources/js/plugins/vuetify/default-preset/preset/pages/auth.scss";
@import "./resources/js/plugins/vuetify/default-preset/preset/variables.scss";
</style>
