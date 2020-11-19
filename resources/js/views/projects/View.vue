<template>
    <div>
      <breadcrumbs :routePrefixName="routePrefixName" :action="action" :singularName="singularName" :pluralName="pluralName" :useName="useName"></breadcrumbs>

      <div class="card">
          <div class="card-body">
              <form-title :routePrefixName="routePrefixName" :title="title" :singularName="singularName" :apiPath="apiPath" :moduleID="parseInt($route.params.id)" :toastMessage="toastMessage" v-bind:showRightSide="false"></form-title>
              <hr />
              <form-view :apiPath="apiPath" :routePrefixName="routePrefixName" :singularName="singularName" :object="project" :selectedProperty="selectedProperty" :toastMessage="toastMessage">
                  <template v-bind:project="project">
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label for="name" class="ideal-font font-weight-bold"
                                >Name
                                </label
                              >
                              <input
                                id="name"
                                type="text"
                                class="form-control"
                                v-model="project.name"
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
                                </label
                              >
                              <input
                                id="role"
                                type="text"
                                class="form-control"
                                v-model="project.role"
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
                                </label
                              >
                              <div class="row">
                                <div class="col-md-4">
                                  <input
                                    type="radio"
                                    id="web-app"
                                    name="type"
                                    value="web-app"
                                    v-model="project.type"
                                  />
                                  <label for="web-app">Web App</label>
                                </div>
                                <div class="col-md-4">
                                  <input
                                    type="radio"
                                    id="website"
                                    name="type"
                                    value="website"
                                    v-model="project.type"
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
                            <div class="border field-boxes rounded p-2">
                              <span v-for="techUsed in project.tech_used" :key="techUsed.id" class="mx-1"><button type="button" class="btn btn-primary btn-sm">{{ techUsed.tech_stack_item.name }}</button></span>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label
                                for="date_deployed"
                                class="ideal-font font-weight-bold"
                                >Date Deployed / Released
                                </label
                              >
                              <datepicker
                                id="date_deployed"
                                v-model="project.date_deployed"
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
                                >Industry
                                </label>
                              <input
                                id="industry"
                                type="text"
                                class="form-control"
                                v-model="project.industry"
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
                                v-model="project.github_repository"
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
                                v-model="project.live"
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
                                v-model="project.reason_if_unavailable"
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
                                class="img-fluid img-thumbnail"
                                :src="'/storage/images/' + project.intro_image"
                                alt="Image"
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
                                class="img-fluid img-thumbnail"
                                :src="'/storage/images/' + project.screen_image"
                                alt="Image"
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
                            </div>
                            <div
                              id="carouselExampleControls"
                              class="carousel slide"
                              data-ride="carousel"
                              v-if="project.sample_page_images"
                            >
                              <div class="carousel-inner">
                                <div
                                  class="carousel-item"
                                  v-for="images in project.sample_page_images"
                                  :key="images.id"
                                  :class="{ active: images == project.sample_page_images[0] }"
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
                              <div class="border field-boxes rounded p-2" v-html="project.concept_description"></div>
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
                              <div class="border field-boxes rounded p-2" v-html="project.development_description"></div>
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
                              <div class="border field-boxes rounded p-2" v-html="project.overview"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </template>
              </form-view>
          </div>
      </div> 

    </div>
</template>

<script>
    export default {
        data() {
            return {
                ifReady:          false,
                action:           'View',
                title:            'View Project',
                singularName:     'Project',
                pluralName:       'Projects',
                apiPath:          '/api/projects',
                routePrefixName:  'projects',
                useName:          'singular',
                selectedProperty: 'name',
                toastMessage:     'Project',
                project:            {},

                showBack: true,
                showDelete: true,
                showButtons: true,
                hasContent: true
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get(this.apiPath + '/' + this.$route.params.id).then(res => {
                    this.project = res.data.project;
                    this.ifReady = true;
                    resolve();
                }).catch(err => {
                    reject();
                });
            });

            promise.then(() => {
                this.ifReady = true;
            });
        }
    }
</script>
