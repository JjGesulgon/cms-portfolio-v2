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
              <label>Image (optional)</label>
              <input type="file" class="form-control-file" @change="onFileSelected">
            </div>
            <div class="form-group">
              <label>Content</label>
              <editor
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
      title: "Edit About Me",
      singularName: "About Me",
      pluralName: "About Me",
      apiPath: "/api/about-me",
      routePrefixName: "about-me",
      useName: "singular",
      selectedProperty: "body",
      toastMessage: "About Me Content",

      body: '',
      image: null,

      moduleID: null,
      showButtons: false,
      showBack: true,
      aboutMeContent: null,
      errors: [],
    };
  },

  mounted() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get(this.apiPath)
        .then((res) => {
          this.moduleID = res.data.aboutMe.id;
          this.body = res.data.aboutMe.body,

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
    onFileSelected(event) {
      this.image = event.target.files[0];
    },

    getFieldColumns() {
      let formData = new FormData()
      formData.append('_method','PATCH');
      formData.append('body', this.body);
      if (this.image != null) {
        formData.append('image', this.image);
      }
      
      return formData;
    },
  },
};
</script>
