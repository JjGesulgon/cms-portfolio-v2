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
            <img
              class="img-fluid about-me-image "
              :src="'storage/images/' + aboutMe.image"
              alt="Image"
            />
            <br />
            <div class="border field-boxes rounded p-2" v-html="aboutMe.body"></div>
            <br />
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
      aboutMe: null,
      hasContent: false,
      action: 'View',
      title: "About Me",
      routePrefixName: 'about-me',
      useName: "plural",
      pluralName: "About Me",
      singularName: "About Me",
      apiPath: '/api/about-me',
      toastMessage: 'About Me Content',
      moduleID: null,
      showButtons: true,
      showSearch: false,
    };
  },
  mounted() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get("/api/about-me")
        .then((res) => {
          this.aboutMe = res.data.aboutMe;
          this.moduleID = res.data.aboutMe.id;
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
  .about-me-image {
    display: block;
    max-width: 25%;
    margin-left: auto;
    margin-right: auto;
    height: auto;
  }
</style>