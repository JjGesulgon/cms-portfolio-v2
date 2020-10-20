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
                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="name" class="ideal-font font-weight-bold"
                      >Name
                      <small class="text-danger">* Required</small>
                      </label
                    >
                    <input
                      id="name"
                      type="text"
                      class="form-control"
                      v-model="$data.name"
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
                      >Role
                      <small class="text-danger">* Required</small>
                      </label
                    >
                    <input
                      id="role"
                      type="text"
                      class="form-control"
                      v-model="$data.role"
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
                      >Type
                      <small class="text-danger">* Required</small>
                      </label
                    >
                    <div class="row">
                      <div class="col-md-4">
                        <input
                          type="radio"
                          id="web-app"
                          name="type"
                          value="web-app"
                          v-model="$data.type"
                        />
                        <label for="web-app">Web App</label>
                      </div>
                      <div class="col-md-4">
                        <input
                          type="radio"
                          id="website"
                          name="type"
                          value="website"
                          v-model="$data.type"
                        />
                        <label for="website">Website</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br />
              <div class="row">
                <div class="col-md-8">
                  <label for="tech_used" class="ideal-font font-weight-bold"
                    >Technology Used</label
                  >
                  <multiselect
                    id="tech_used"
                    v-model="$data.techUsed"
                    tag-placeholder="Add this"
                    placeholder="Select the frameworks or languages used in this project"
                    label="name"
                    track-by="name"
                    :options="techStackItems"
                    :multiple="true"
                    :taggable="true"
                  ></multiselect>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label
                      for="date_deployed"
                      class="ideal-font font-weight-bold"
                      >Date Deployed / Released
                      <small class="text-danger">* Required</small>
                      </label
                    >
                    <datepicker
                      id="date_deployed"
                      v-model="$data.date_deployed"
                      class="ideal-font"
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
                <div class="col-md-3">
                  <div class="form-group">
                    <label
                      for="industry"
                      class="ideal-font font-weight-bold"
                      >Industry<small class="text-danger">* Required</small></label
                    >
                    <input
                      id="industry"
                      type="text"
                      class="form-control"
                      v-model="$data.industry"
                      autocomplete="off"
                      minlength="2"
                      maxlength="255"
                      required
                    />
                  </div>
                </div>
                <div class="col-md-3">
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
                      v-model="$data.github_repository"
                      autocomplete="off"
                      minlength="2"
                      maxlength="255"
                      required
                    />
                  </div>
                </div>
                <div class="col-md-3">
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
                <div class="col-md-3">
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
                      v-model="$data.reason_if_unavailable"
                      autocomplete="off"
                      minlength="2"
                      maxlength="255"
                      required
                    />
                  </div>
                </div>
              </div>
              <br />
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="intro_image" class="ideal-font font-weight-bold"
                      >Introduction Image</label
                    >
                    <img
                      v-if="showcurrentIntro"
                      class="img-fluid img-thumbnail"
                      :src="'/storage/images/' + currentIntroImage"
                      alt="Image"
                    />
                    <input
                      id="intro_image"
                      type="file"
                      class="form-control-file"
                      @change="onFileSelected"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label
                      for="screen_image"
                      class="ideal-font font-weight-bold"
                      >Screen Image</label
                    >
                    <img
                      v-if="showcurrentScreen"
                      class="img-fluid img-thumbnail"
                      :src="'/storage/images/' + currentScreenImage"
                      alt="Image"
                    />
                    <input
                      id="screen_image"
                      type="file"
                      class="form-control-file"
                      @change="onFileSelected"
                    />
                  </div>
                </div>
              </div>
              <br />
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-6">
                      <label
                        for="sample_page_images"
                        class="ideal-font font-weight-bold"
                        >Sample Page Images</label
                      >
                    </div>
                    <div class="col-md-6" v-if="sample_page_images">
                      <router-link
                        class="btn btn-dark btn-sm float-right"
                        :to="{
                          name: `sample-page-image.edit`,
                          params: { id: $route.params.id },
                        }"
                      >
                        <i class="fas fa-edit"></i>
                        &nbsp; Edit Sample Page Images
                      </router-link>
                    </div>
                  </div>
                  <div
                    id="carouselExampleControls"
                    class="carousel slide"
                    data-ride="carousel"
                    v-if="sample_page_images"
                  >
                    <div class="carousel-inner">
                      <div
                        class="carousel-item"
                        v-for="images in sample_page_images"
                        :key="images.id"
                        :class="{ active: images == sample_page_images[0] }"
                      >
                        <img
                          class="d-block w-100"
                          :src="'/storage/images/' + images.image"
                          alt="Image"
                        />
                      </div>
                    </div>
                    <a
                      class="carousel-control-prev"
                      href="#carouselExampleControls"
                      role="button"
                      data-slide="prev"
                    >
                      <span
                        class="carousel-control-prev-icon"
                        aria-hidden="true"
                      ></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a
                      class="carousel-control-next"
                      href="#carouselExampleControls"
                      role="button"
                      data-slide="next"
                    >
                      <span
                        class="carousel-control-next-icon"
                        aria-hidden="true"
                      ></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
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
      title: "Edit Project",
      singularName: "Project",
      pluralName: "Projects",
      apiPath: "/api/projects",
      routePrefixName: "projects",
      useName: "singular",
      selectedProperty: "name",
      toastMessage: "Project",

      name: "",
      role: "",
      type: "",
      currentIntroImage: null,
      currentScreenImage: null,
      sample_page_images: [],
      intro_image: null,
      screen_image: null,
      date_deployed: "",
      development_description: "",
      concept_description: "",
      overview: "",
      github_repository: "",
      live: "",
      reason_if_unavailable: "",
      industry: "",
      techUsed: [],

      techStackItems: [],
      showcurrentIntro: true,
      showcurrentScreen: true,

      tinyMCEReady: false,
      moduleID: null,
      showButtons: false,
      showSearch: false,
      showBack: true,
      aboutMeContent: null,
      errors: [],
    };
  },

  mounted() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get(`/api/tech-stack-item/getAll`)
        .then((res) => {
          this.techStackItems = res.data.techStackItems;
          this.ifReady = true;
        })
        .catch((err) => {
          console.log(err)
        });

      axios
        .get(`${this.apiPath}/${this.$route.params.id}`)
        .then((res) => {
          this.moduleID = res.data.project.id;
          this.body = res.data.project.body;
          this.name = res.data.project.name;
          this.role = res.data.project.role;
          this.industry = res.data.project.industry;
          this.currentIntroImage = res.data.project.intro_image;
          this.currentScreenImage = res.data.project.screen_image;
          this.type = res.data.project.type;
          this.date_deployed = res.data.project.date_deployed;
          this.development_description = res.data.project.development_description;
          this.concept_description = res.data.project.concept_description;
          this.overview = res.data.project.overview;
          this.github_repository = res.data.project.github_repository;
          this.live = res.data.project.live;
          this.reason_if_unavailable = res.data.project.reason_if_unavailable;
          this.sample_page_images = res.data.project.sample_page_images;

          var usedTech = res.data.project.tech_used;
          
          for (let item of usedTech) {
            this.techUsed.push(item.tech_stack_item);
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
    intro_image: function () {
      this.showcurrentIntro =
        this.intro_image != null
          ? (this.showcurrentIntro = false)
          : (this.showcurrentIntro = true);
    },

    screen_image: function () {
      this.showcurrentScreen =
        this.screen_image != null
          ? (this.showcurrentScreen = false)
          : (this.showcurrentScreen = true);
    },
  },

  methods: {
    getFieldColumns() {
      if (this.tinyMCEReady) {
        let formData = new FormData();
        formData.append("_method", "PATCH");
        if (this.intro_image != null) {
          formData.append("intro_image", this.intro_image);
        }
        if (this.screen_image != null) {
          formData.append("screen_image", this.screen_image);
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
        formData.append("industry", this.industry);
        formData.append("date_deployed", moment(this.date_deployed).format("YYYY-MM-DD"));
        formData.append("github_repository", this.github_repository);
        formData.append("live", this.live);
        formData.append("reason_if_unavailable", this.reason_if_unavailable);
        formData.append("development_description", tinyMCE.get("development_description").getContent());
        formData.append("concept_description", tinyMCE.get("concept_description").getContent());
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
          this.intro_image =
            event.target.value.length == 0
              ? (this.intro_image = null)
              : (this.intro_image = event.target.files[0]);
          break;
        case "screen_image":
          this.screen_image =
            event.target.value.length == 0
              ? (this.screen_image = null)
              : (this.screen_image = event.target.files[0]);
          break;
      }
    },
  },
};
</script>