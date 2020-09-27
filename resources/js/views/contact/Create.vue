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
        <form-title :routePrefixName="routePrefixName" :title="title" v-bind:showRightSide="false"></form-title>
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
              <label for="email" class="ideal-font font-weight-bold">
                Email
                <small class="text-danger">* Required</small>
              </label>
              <input
                id="email"
                type="email"
                class="form-control"
                v-model="$data.email"
                autocomplete="off"
                minlength="2"
                maxlength="255"
                required
              />
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="instagram_link" class="ideal-font font-weight-bold">
                    Instagram Link
                    <small class="text-danger">* Required</small>
                  </label>
                  <input
                    id="instagram_link"
                    type="text"
                    class="form-control"
                    v-model="$data.instagram_link"
                    autocomplete="off"
                    minlength="2"
                    maxlength="255"
                    required
                  />
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label for="twitter_link" class="ideal-font font-weight-bold">
                    Twitter Link
                    <small class="text-danger">* Required</small>
                  </label>
                  <input
                    id="twitter_link"
                    type="text"
                    class="form-control"
                    v-model="$data.twitter_link"
                    autocomplete="off"
                    minlength="2"
                    maxlength="255"
                    required
                  />
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label for="linkedin_link" class="ideal-font font-weight-bold">
                    LinkedIn Link
                    <small class="text-danger">* Required</small>
                  </label>
                  <input
                    id="linkedin_link"
                    type="text"
                    class="form-control"
                    v-model="$data.linkedin_link"
                    autocomplete="off"
                    minlength="2"
                    maxlength="255"
                    required
                  />
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label for="devto_link" class="ideal-font font-weight-bold">
                    Dev.to Link
                    <small class="text-danger">* Required</small>
                  </label>
                  <input
                    id="devto_link"
                    type="text"
                    class="form-control"
                    v-model="$data.devto_link"
                    autocomplete="off"
                    minlength="2"
                    maxlength="255"
                    required
                  />
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="content" class="ideal-font font-weight-bold">
                Content
                <small class="text-danger">* Required</small>
              </label>
              <textarea
                id="content"
                class="form-control"
                v-model="$data.content"
                maxlength="1000"
                required
              ></textarea>
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
      title: "Create New Contact",
      singularName: "Contact",
      pluralName: "Contacts",
      apiPath: "/api/contact",
      routePrefixName: "contact",
      useName: "singular",
      toastMessage: "Contact",

      content: "",
      email: "",
      instagram_link: "",
      twitter_link: "",
      linkedin_link: "",
      devto_link: "",

      showButtons: false,
      showSearch: false,
      showBack: true,
      contactContent: null,
      errors: [],
      formData: new FormData(),
    };
  },
  created() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get("/api/contact")
        .then((res) => {
          this.contactContent = res.data.contact;
          if (this.contactContent) {
            this.$router.push({ name: "contact.index" });
          } else {
            this.ifReady = true;
          }
          resolve();
        })
        .catch((error) => {
          this.ifReady = true;
        });
    });
  },
  methods: {
    getFieldColumns() {
      this.formData.append("content", this.content);
      this.formData.append("email", this.email);
      this.formData.append("instagram_link", this.instagram_link);
      this.formData.append("twitter_link", this.twitter_link);
      this.formData.append("linkedin_link", this.linkedin_link);
      this.formData.append("devto_link", this.devto_link);
      return this.formData;
    },
  },
};
</script>