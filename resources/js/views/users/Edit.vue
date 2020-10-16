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
        <form-edit
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
                      disabled
                    />
                  </div>
                </div>
              </div>
            </div>
          </template>
        </form-edit>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      ifReady: false,
      action: "Edit",
      title: "Edit Users",
      singularName: "User",
      pluralName: "Users",
      apiPath: "/api/users",
      routePrefixName: "users",
      useName: "singular",
      selectedProperty: "name",
      toastMessage: "Users",

      name: '',
      email: '',

      moduleID: null,
      showButtons: false,
      showSearch: false,
      showBack: true,
      contactContent: null,
      errors: [],
      formData: new FormData(),
    };
  },

  mounted() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get(`${this.apiPath}/${this.$route.params.id}`)
        .then((res) => {
          this.moduleID = res.data.user.id;
          this.name = res.data.user.name;
          this.email = res.data.user.email;
          resolve();
        })
        .catch((err) => {
          reject();
        });
    });

    promise.then(() => {
      this.ifReady = true;
    });
  },

  methods: {
    getFieldColumns() {
      this.formData.append("_method", "PATCH");
      this.formData.append("name", this.name);
      this.formData.append("experience", this.email);
      return this.formData;
    },
  },
};
</script>
