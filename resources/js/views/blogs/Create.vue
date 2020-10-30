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
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="image" class="ideal-font font-weight-bold">Image</label>
                  <input id="image" type="file" class="form-control-file" @change="onFileSelected" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="content" class="ideal-font font-weight-bold">
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
      title: "Create New Blog",
      singularName: "Blog",
      pluralName: "Blog",
      apiPath: "/api/blogs",
      routePrefixName: "blogs",
      useName: "singular",
      toastMessage: "Blog",

      content: "",
      published_at: "",
      header_image: "",
      author: "",
      category: "",
      title: "",

      showButtons: false,
      showSearch: false,
      showBack: true,
      contactContent: null,
      errors: [],
      tinyMCEReady: false,
    };
  },
  methods: {
    onFileSelected(event) {
      this.image = event.target.files[0];
    },
    getFieldColumns() {
      if (this.tinyMCEReady) {
        let formData = new FormData();
        if (this.image != null) {
          formData.append("header_image", this.header_image);
        }
        formData.append("content", tinyMCE.activeEditor.getContent());
        formData.append("title", this.title);
        formData.append("author", this.author);
        formData.append("category", this.category);
        
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