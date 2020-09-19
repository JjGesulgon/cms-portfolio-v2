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
        <form-title :routePrefixName="routePrefixName" :title="title" :singularName="singularName" :apiPath="apiPath" :moduleID="moduleID" :toastMessage="toastMessage" v-bind:showRightSide="false"></form-title>
        <hr />
        <div class="progress" height="30px;" v-if="!ifReady">
          <div
            class="progress-bar progress-bar-striped progress-bar-animated"
            role="progressbar"
            aria-valuenow="100"
            aria-valuemin="0"
            aria-valuemax="100"
            style="width: 100%;"
          ></div>
        </div>
        <div v-if="ifReady">
          <div v-if="!hasContent">
            <div class="image-container">
              <img class="img-fluid accent-image" src="/images/undraw_not_found.svg" alt="Image" />
            </div>
            <p class="text-center display-4">No Content</p>
          </div>
          <div v-else>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email" class="ideal-font">Email</label>
                  <input
                    type="text"
                    class="form-control ideal-font"
                    v-model="contact.email"
                    autocomplete="off"
                    minlength="2"
                    maxlength="255"
                    required
                    disabled
                  />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="instagram_link" class="ideal-font">Instagram Link</label>
                  <input
                    type="text"
                    class="form-control ideal-font"
                    v-model="contact.instagram_link"
                    autocomplete="off"
                    minlength="2"
                    maxlength="255"
                    required
                    disabled
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="twitter_link" class="ideal-font">Twitter Link</label>
                  <input
                    type="text"
                    class="form-control ideal-font"
                    v-model="contact.twitter_link"
                    autocomplete="off"
                    minlength="2"
                    maxlength="255"
                    required
                    disabled
                  />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="linkedin_link" class="ideal-font">LinkedIn Link</label>
                  <input
                    type="text"
                    class="form-control ideal-font"
                    v-model="contact.linkedin_link"
                    autocomplete="off"
                    minlength="2"
                    maxlength="255"
                    required
                    disabled
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="devto_link" class="ideal-font">Dev.to Link</label>
                  <input
                    type="text"
                    class="form-control ideal-font"
                    v-model="contact.devto_link"
                    autocomplete="off"
                    minlength="2"
                    maxlength="255"
                    required
                    disabled
                  />
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="ideal-font">Content</label>
              <div class="border field-boxes rounded p-2 ideal-font" v-html="contact.content"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</template>
<script>
export default {
  data() {
    return {
      showBack: false,
      ifReady: false,
      contact: null,
      hasContent: false,
      action: 'View',
      title: "Contact Details",
      routePrefixName: 'contact',
      useName: "plural",
      pluralName: "Contact Details",
      singularName: "Contact Details",
      apiPath: '/api/contact',
      toastMessage: 'Contact Details',
      moduleID: null,
      showButtons: true,
      showSearch: false,
      showDelete: true
    };
  },
  mounted() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get("/api/contact")
        .then((res) => {
          this.contact = res.data.contact;
          this.moduleID = res.data.contact.id;
          this.hasContent = true;
          this.ifReady = true;
          resolve();
        })
        .catch((error) => {
          this.ifReady = true;
        });
    });
  },
};
</script>
<style scoped>
.field-boxes {
  border-color: #ced4da;
  background-color: #e9ecef;
}
</style>