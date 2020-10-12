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
        <form-create
          :apiPath="apiPath"
          :routePrefixName="routePrefixName"
          :singularName="singularName"
          :toastMessage="toastMessage"
          :fieldColumns="getFieldColumns()"
        >
          <template v-bind:data="$data">
            <div class="form-group">
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="name" class="ideal-font font-weight-bold"
                      >Name</label
                    >
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
                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="role" class="ideal-font font-weight-bold"
                      >Role</label
                    >
                    <input
                      id="role"
                      type="text"
                      class="form-control"
                      v-model="role"
                      autocomplete="off"
                      minlength="2"
                      maxlength="255"
                      required
                    />
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="type" class="ideal-font font-weight-bold"
                      >Type</label
                    >
                    <div class="row">
                      <div class="col-md-4">
                        <input
                          type="radio"
                          id="web-app"
                          name="type"
                          value="web-app"
                          v-model="type"
                        />
                        <label for="web-app">Web App</label>
                      </div>
                      <div class="col-md-4">
                        <input
                          type="radio"
                          id="website"
                          name="type"
                          value="website"
                          v-model="type"
                        />
                        <label for="website">Website</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br />
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="intro_image" class="ideal-font font-weight-bold"
                      >Introduction Image</label
                    >
                    <input
                      id="intro_image"
                      type="file"
                      class="form-control-file"
                      @change="onFileSelected"
                      
                    />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label
                      for="screen_image"
                      class="ideal-font font-weight-bold"
                      >Screen Image</label
                    >
                    <input
                      id="screen_image"
                      type="file"
                      class="form-control-file"
                      @change="onFileSelected"
                    />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label
                      for="sample_page_images"
                      class="ideal-font font-weight-bold"
                      >Sample Page Images</label
                    >
                    <input
                      id="sample_page_images"
                      type="file"
                      class="form-control-file"
                      multiple
                      @change="onFileSelected"
                    />
                  </div>
                </div>
              </div>
              <br />
              <div class="row">
                <div class="col-md-12">
                  <label for="tech_used" class="ideal-font font-weight-bold"
                    >Technology Used</label
                  >
                  <multiselect
                    id="tech_used"
                    v-model="techUsed"
                    tag-placeholder="Add this"
                    placeholder="Select the frameworks or languages used in this project"
                    label="name"
                    track-by="name"
                    :options="techStackItems"
                    :multiple="true"
                    :taggable="true"
                  ></multiselect>
                </div>
              </div>
              <br />
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label
                      for="concept_description"
                      class="ideal-font font-weight-bold"
                    >
                      Concept Description
                    </label>
                    <editor
                      @onInit="initFunction"
                      id="concept_description"
                      selector="concept_description"
                      v-model="$data.concept_description"
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
                <div class="col-md-6">
                  <div class="form-group">
                    <label
                      for="concept_description"
                      class="ideal-font font-weight-bold"
                    >
                      Development Description
                    </label>
                    <editor
                      @onInit="initFunction"
                      id="development_description"
                      selector="development_description"
                      v-model="$data.development_description"
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
              <br />
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="overview" class="ideal-font font-weight-bold">
                      Overview
                    </label>
                    <editor
                      @onInit="initFunction"
                      id="overview"
                      v-model="$data.overview"
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
              <br />
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label
                      for="github_repository"
                      class="ideal-font font-weight-bold"
                      >Github Repository</label
                    >
                    <input
                      id="github_repository"
                      type="text"
                      class="form-control"
                      v-model="github_repository"
                      autocomplete="off"
                      minlength="2"
                      maxlength="255"
                      required
                    />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="live" class="ideal-font font-weight-bold"
                      >Live</label
                    >
                    <input
                      id="live"
                      type="text"
                      class="form-control"
                      v-model="live"
                      autocomplete="off"
                      minlength="2"
                      maxlength="255"
                      required
                    />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label
                      for="date_deployed"
                      class="ideal-font font-weight-bold"
                      >Date Deployed / Released</label
                    >
                    <datepicker
                      v-model="date_deployed"
                      input-class="vue-datepicker"
                      :bootstrap-styling="true"
                      placeholder="Select Due Date"
                      required
                    ></datepicker>
                  </div>
                </div>
              </div>
              <br />
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label
                      for="reason_if_unavailable"
                      class="ideal-font font-weight-bold"
                      >Reason If Unavailable</label
                    >
                    <input
                      id="reason_if_unavailable"
                      type="text"
                      class="form-control"
                      v-model="reason_if_unavailable"
                      autocomplete="off"
                      minlength="2"
                      maxlength="255"
                      required
                    />
                  </div>
                </div>
              </div>
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
      ifReady: false,
      action: "Create New",
      title: "Create New Project",
      singularName: "Project",
      pluralName: "Projects",
      apiPath: "/api/projects",
      routePrefixName: "projects",
      useName: "singular",
      toastMessage: "Project",

      name: "",
      role: "",
      type: "web-app",
      intro_image: "",
      screen_image: "",
      date_deployed: "",
      development_description: "",
      concept_description: "",
      overview: "",
      github_repository: "",
      live: "",
      reason_if_unavailable: "",
      sample_page_images: [],
      techUsed: [],

      techStackItems: null,
      showButtons: false,
      showSearch: false,
      showBack: true,
      errors: [],
      tinyMCEReady: false,
    };
  },

  mounted() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get(`/api/tech-stack-item/getAll`)
        .then((res) => {
          this.techStackItems = res.data.techStackItems;
          this.ifReady = true;
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
      if (this.tinyMCEReady) {
        let formData = new FormData();
        if (this.intro_image != null) {
          formData.append("intro_image", this.intro_image);
        }
        if (this.screen_image != null) {
          formData.append("screen_image", this.screen_image);
        }

        if (this.sample_page_images.length > 1) {
          for (let file in this.sample_page_images) {
            formData.append("image[]", this.sample_page_images[file]);
          }
        } else {
          formData.append("image[]", this.sample_page_images[0]);
        }

        
        if (this.techUsed.length > 1) {
          for (let file in this.techUsed) {
            formData.append("tech_used[]", this.techUsed[file].id);
          }
        } else if (this.techUsed.length == 1) {
          formData.append("tech_used[]", this.techUsed[0].id);
        }        

        formData.append("name", this.name);
        formData.append("role", this.role);
        formData.append("type", this.type);
        formData.append(
          "date_deployed",
          moment(this.date_deployed).format("YYYY-MM-DD")
        );
        formData.append("github_repository", this.github_repository);
        formData.append("live", this.live);
        formData.append("reason_if_unavailable", this.reason_if_unavailable);
        formData.append(
          "development_description",
          tinyMCE.get("development_description").getContent()
        );
        formData.append(
          "concept_description",
          tinyMCE.get("concept_description").getContent()
        );
        formData.append("overview", tinymce.get("overview").getContent());

        return formData;
      } else {
        return null;
      }
    },

    initFunction() {
      this.tinyMCEReady = true;
    },

    onFileSelected(event) {
      switch (event.target.id) {
        case "intro_image":
          this.intro_image = event.target.files[0];
          break;
        case "screen_image":
          this.screen_image = event.target.files[0];
          break;
        case "sample_page_images":
          if (event.target.files.length > 1) {
            for (let file in event.target.files) {
              this.sample_page_images.push(event.target.files[file]);
            }
          } else {
            this.sample_page_images.push(event.target.files[0]);
          }
          break;
      }
    },
  },
};
</script>