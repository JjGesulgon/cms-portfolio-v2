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
            <br />
            <div class="border field-boxes rounded p-2 ideal-font" v-html="techStackContent.body"></div>
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
      techStackContent: null,
      hasContent: false,
      action: 'View',
      title: "Technology Stack Content",
      routePrefixName: 'tech-stack-content',
      useName: "plural",
      pluralName: "Technology Stack Content",
      singularName: "Technology Stack Content",
      apiPath: '/api/tech-stack-content',
      toastMessage: 'Technology Stack Content',
      moduleID: null,
      showButtons: true,
      showSearch: false,
      showDelete: true
    };
  },
  mounted() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get("/api/tech-stack-content")
        .then((res) => {
          this.techStackContent = res.data.techStackContent;
          this.moduleID = res.data.techStackContent.id;
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