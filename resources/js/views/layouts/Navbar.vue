<template>
  <nav class="navbar navbar-expand-md navbar-light navbar-laravel bg-primary text-white">
    <div class="container-fluid">
      <router-link
        class="navbar-brand d-none d-sm-block text-white"
        :to="{ name: 'overview' }"
      >Project Snowflake</router-link>

      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav flex-row ml-md-auto d-md-flex">
          <li class="nav-item dropdown">
            <a
              class="nav-item nav-link dropdown-toggle mr-md-2 text-white"
              href="#"
              role="button"
              id="navbarDropdown"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              v-if="ifReady"
            >
              {{ user.name }}
              <span class="caret"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#" v-on:click.stop.prevent="logout">
                <i class="fas fa-sign-out-alt text-secondary"></i>&nbsp;Logout
              </a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      user: "",
      ifReady: false
    };
  },

  mounted() {
    axios.get("/api/auth/user").then((res) => {
      this.user = res.data.user;
      localStorage.setItem("user", JSON.stringify(res.data.user));
      this.ifReady = true;
    });
  },

  methods: {
    logout() {
      axios
        .post("/logout")
        .then((res) => {
          localStorage.clear();
          location.reload();
        })
        .catch(function (error) {
          localStorage.clear();
          location.reload();
        });
    },
  },
};
</script>
