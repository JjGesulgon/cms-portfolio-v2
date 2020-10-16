<template>
  <div>
    <breadcrumbs
      :routePrefixName="routePrefixName"
      :action="action"
      :singularName="singularName"
      :pluralName="pluralName"
      :useName="useName"
    ></breadcrumbs>

    <div class="card">
      <div class="card-body">
        <form-title
          :routePrefixName="routePrefixName"
          :title="title"
          v-bind:showRightSide="false"
        ></form-title>
        <hr />
        <form-create
          :apiPath="apiPath"
          :routePrefixName="routePrefixName"
          :singularName="singularName"
          :toastMessage="toastMessage"
          :fieldColumns="getFieldColumns()"
        >
          <template v-bind:data="$data">
            <div class="form-group">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="name" class="ideal-font font-weight-bold">Name</label>
                    <input
                      id="name"
                      type="text"
                      class="form-control"
                      v-model="name"
                      autocomplete="off"
                      minlength="2"
                      maxlength="255"
                      required
                    />
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="email" class="ideal-font font-weight-bold">Email Address</label>
                    <input
                      id="email"
                      type="email"
                      class="form-control"
                      v-model="email"
                      autocomplete="off"
                      minlength="2"
                      maxlength="255"
                      required
                    />
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="password" class="ideal-font font-weight-bold">Password</label>
                    <input
                      id="password"
                      type="password"
                      class="form-control"
                      v-model="password"
                      autocomplete="off"
                      minlength="2"
                      maxlength="255"
                      required
                    />
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="password_confirmation" class="ideal-font font-weight-bold"
                      >Password Confirmation</label
                    >
                    <input
                      id="password_confirmation"
                      type="password"
                      class="form-control"
                      v-model="password_confirmation"
                      autocomplete="off"
                      minlength="2"
                      maxlength="255"
                      required
                    />
                  </div>
                </div>
              </div>
            </div>
          </template>
        </form-create>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      createbuttonShow: false,
      ifReady: true,
      action: "Create New",
      title: "Create New User",
      singularName: "User",
      pluralName: "Users",
      apiPath: "/api/users",
      routePrefixName: "users",
      useName: "singular",
      toastMessage: "User",

      name: '',
      email: '',
      password: '',
      password_confirmation: '',

      showButtons: false,
      showSearch: false,
      showBack: true,
      errors: [],
    };
  },
  methods: {
    getFieldColumns() {
      return {
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation
      };
    },
  },
};
</script>