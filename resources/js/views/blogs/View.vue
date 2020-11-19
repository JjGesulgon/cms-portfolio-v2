<template>
    <div>
      <breadcrumbs :routePrefixName="routePrefixName" :action="action" :singularName="singularName" :pluralName="pluralName" :useName="useName"></breadcrumbs>

      <div class="card">
          <div class="card-body">
              <form-title :routePrefixName="routePrefixName" :title="title" :singularName="singularName" :apiPath="apiPath" :moduleID="parseInt($route.params.id)" :toastMessage="toastMessage" v-bind:showRightSide="false"></form-title>
              <hr />
              <form-view :apiPath="apiPath" :routePrefixName="routePrefixName" :singularName="singularName" :object="blog" :selectedProperty="selectedProperty" :toastMessage="toastMessage">
                  <template v-bind:blog="blog">
                      <img class="mt-2 img-fluid blog-image" :src="'/storage/images/' + blog.header_image" alt="Image"/>
                      <div class="text-center mt-3">
                        <h4 class="font-weight-light">
                          {{ blog.title }}
                          <slot name="title-small"></slot>
                        </h4>
                        <h6 class="font-weight-light">
                          {{ blog.author }}
                          <slot name="title-small"></slot>
                        </h6>
                      </div>
                      <div class="mt-5 p-2 container" v-html="blog.content"></div>
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
                title:            'View Blog',
                singularName:     'Blog',
                pluralName:       'Blogs',
                apiPath:          '/api/blogs',
                routePrefixName:  'blogs',
                useName:          'singular',
                selectedProperty: 'title',
                toastMessage:     'Blog',
                blog:            {},

                showBack: true,
                showDelete: true,
                showButtons: true,
                hasContent: true
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get(this.apiPath + '/' + this.$route.params.id).then(res => {
                    this.blog = res.data.blog;
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
<style scoped>
  .blog-image {
    display: block;
    max-width: 50%;
    margin-left: auto;
    margin-right: auto;
    height: auto;
  }
</style>