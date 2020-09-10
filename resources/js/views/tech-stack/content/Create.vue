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
              <label for="content">
                Content
                <small class="text-danger">* Required</small>
              </label>
              <editor
                @onInit="initFunction"
                id="body"
                v-model="$data.body"
                api-key="v8631ogi6aq7uc2h9z8tr72t2r3krmwlsbj5k4swk4i448f9"
                :init="{
                  height: 500,
                  menubar: false,
                  plugins: [
                  'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
                  ],
                  menubar: 'file edit view insert format tools table help',
                  toolbar: 'undo redo | bold italic underline strikethrough | fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
                  toolbar_sticky: true,
                }"
              />
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
      title: "Create New Technology Stack Content",
      singularName: "Technology Stack Content",
      pluralName: "Technology Stack Content",
      apiPath: "/api/tech-stack-content",
      routePrefixName: "tech-stack-content",
      useName: "singular",
      toastMessage: "Technology Stack Content",

      techStackContent: null,
      body: '',

      showButtons: false,
      showSearch: false,
      showBack: true,
      contactContent: null,
      errors: [],
      tinyMCEReady: false,
    };
  },
  created() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get("/api/tech-stack-content")
        .then((res) => {
          this.techStackContent = res.data.techStackContent;
          if (this.aboutMeContent) {
            this.$router.push({ name: "tech-stack-content.index" });
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
      if (this.tinyMCEReady) {
        let formData = new FormData();
        formData.append("body", tinyMCE.activeEditor.getContent());
        
        return formData;
      } else {
        return null;
      }
    },
    initFunction() {
      this.tinyMCEReady = true;
    },
  },
};
</script>