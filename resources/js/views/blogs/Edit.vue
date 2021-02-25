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
        <form-title :routePrefixName="routePrefixName" :title="pageTitle" v-bind:showRightSide="false"></form-title>
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
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="header_image" class="ideal-font font-weight-bold"
                      >Header Image</label
                    >
                    <img
                      v-if="showHeaderImage"
                      class="img-fluid"
                      :src="'/storage/images/' + currentHeaderImage"
                      alt="Image"
                    />
                    <input
                      id="header_image"
                      type="file"
                      class="form-control-file"
                      @change="onFileSelected"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="title" class="ideal-font font-weight-bold">Title</label>
                    <input
                      id="title"
                      type="text"
                      class="form-control"
                      v-model="title"
                      autocomplete="off"
                      minlength="2"
                      maxlength="255"
                      required
                    />
                  </div>
                  <div class="form-group">
                    <label for="author" class="ideal-font font-weight-bold">Author</label>
                    <input
                      id="author"
                      type="text"
                      class="form-control"
                      v-model="author"
                      autocomplete="off"
                      minlength="2"
                      maxlength="255"
                      required
                    />
                  </div>
                  <div class="form-group">
                    <label for="category" class="ideal-font font-weight-bold"
                      >Category</label
                    >
                    <vue-select
                      class="form-control"
                      v-model="category"
                      label="name"
                      :options="categories"
                      required
                    ></vue-select>
                  </div>
                  <div class="form-group" v-if="published_at">
                    <label for="category" class="ideal-font font-weight-bold"
                      >Published At</label
                    >
                    <div class="ideal-font">{{ published_at }}</div>
                  </div>
                  <div class="form-group" v-if="!published_at">
                    <label for="type" class="ideal-font font-weight-bold"
                      >Publish?
                    </label>
                    <div class="row">
                      <div class="col-md-2">
                        <input
                          type="radio"
                          id="no"
                          name="isPublish"
                          value=false
                          v-model="isPublish"
                        />
                        <label for="no">No</label>
                      </div>
                      <div class="col-md-2">
                        <input
                          type="radio"
                          id="yes"
                          name="isPublish"
                          value=true
                          v-model="isPublish"
                        />
                        <label for="yes">Yes</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label
                      for="content"
                      class="ideal-font font-weight-bold"
                    >
                      Content
                    </label>
                    <editor
                      @onInit="initFunction"
                      id="content"
                      selector="content"
                      v-model="content"
                      api-key="v8631ogi6aq7uc2h9z8tr72t2r3krmwlsbj5k4swk4i448f9"
                      :init="{
                        height: 500,
                        menubar: false,
                        plugins: [
                          'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
                        ],
                        menubar:
                          'file edit view insert format tools table help',
                        toolbar:
                          'undo redo | bold italic underline strikethrough | fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
                        toolbar_sticky: true,
                      }"
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
      pageTitle: "Edit Blog",
      singularName: "Blog",
      pluralName: "Blogs",
      apiPath: "/api/blogs",
      routePrefixName: "blogs",
      useName: "singular",
      selectedProperty: "title",
      toastMessage: "Blog",

      content: "",
      isPublish: null,
      header_image: "",
      author: "",
      category: "",
      title: "",
      categories: [],
      currentHeaderImage: "",
      published_at: "",

      showHeaderImage: true,
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
        .get(`/api/categories/getAll`)
        .then((res) => {
          this.categories = res.data.category;
        })
        .catch((err) => {
          reject();
        });

      axios
        .get(`${this.apiPath}/${this.$route.params.id}`)
        .then((res) => {
          this.moduleID = res.data.blog.id;
          this.title = res.data.blog.title;
          this.author = res.data.blog.author;
          this.category = res.data.blog.category;
          this.currentHeaderImage = res.data.blog.header_image;
          this.content = res.data.blog.content;
          this.published_at = res.data.blog.published_at;
          if(res.data.blog.published_at){
            this.isPublish = true;
          }else{
            this.isPublish = false
          }

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

  watch: {
    header_image: function () {
      this.showHeaderImage =
        this.header_image != null
          ? (this.showHeaderImage = false)
          : (this.showHeaderImage = true);
    },
  },

  methods: {
    getFieldColumns() {
      if (this.tinyMCEReady) {
        this.formData.append("_method", "PATCH");
        this.formData.append("content", tinyMCE.get("content").getContent());
        this.formData.append("title", this.title);
        this.formData.append("author", this.author);
        this.formData.append("category_id", this.category.id);
        this.formData.append("isPublish", this.isPublish);
        if (this.header_image != "") {
          this.formData.append("header_image", this.header_image);
        }
        return this.formData;
      } else {
        return null;
      }
    },
    onFileSelected(event) {
      switch (event.target.id) {
        case "header_image":
          this.header_image =
            event.target.value.length == 0
              ? (this.header_image = null)
              : (this.header_image = event.target.files[0]);
          break;
      }
    },
    initFunction() {
      this.tinyMCEReady = true;
    },

  },
};
</script>
