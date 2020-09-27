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
        <form-edit
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
      title: "Edit Contact",
      singularName: "Contact",
      pluralName: "Contacts",
      apiPath: "/api/contact",
      routePrefixName: "contact",
      useName: "singular",
      selectedProperty: "email",
      toastMessage: "Contact",

      content: '',
      email: '',
      instagram_link: '',
      twitter_link: '',
      linkedin_link: '',
      devto_link: '',

      moduleID: null,
      showButtons: false,
      showSearch: false,
      showBack: true,
      contactContent: null,
      errors: [],
      formData: new FormData()
    };
  },

  mounted() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get(this.apiPath)
        .then((res) => {
          this.moduleID = res.data.contact.id;
          this.content = res.data.contact.content,
          this.email = res.data.contact.email,
          this.instagram_link = res.data.contact.instagram_link,
          this.twitter_link = res.data.contact.twitter_link,
          this.linkedin_link = res.data.contact.linkedin_link,
          this.devto_link = res.data.contact.devto_link,

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
      this.formData.append('_method','PATCH');
      this.formData.append('content', this.content);
      this.formData.append('email', this.email);
      this.formData.append('instagram_link', this.instagram_link);
      this.formData.append('twitter_link', this.twitter_link);
      this.formData.append('linkedin_link', this.linkedin_link);
      this.formData.append('devto_link', this.devto_link);
      return this.formData;
    },
  },
};
</script>
