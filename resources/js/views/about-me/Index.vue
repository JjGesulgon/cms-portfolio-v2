<template>
  <div>
    <div class="card">
      <div class="card-header clearfix">
        <div class="float-left">
          <router-link class="text-primary" :to="{ name: 'about-me.index' }">About Me</router-link> /
          <span class="text-secondary">Content</span>
        </div>
        <div v-if="ifReady">
          <div class="float-right" v-if="!hasContent">
            <router-link class="btn btn-success btn-sm" :to="{ name: 'about-me.create' }">
              <i class="fas fa-plus"></i>&nbsp; Create New Content
            </router-link>
          </div>
          <div class="float-right" v-else>
            <router-link class="btn btn-success btn-sm" :to="{ name: 'about-me.create' }">
              <i class="fas fa-edit"></i>&nbsp; Edit Content
            </router-link>
            <router-link class="btn btn-danger btn-sm" :to="{ name: 'about-me.create' }">
              <i class="fas fa-trash-alt"></i>&nbsp; Delete Content
            </router-link>
          </div>
        </div>
      </div>
      <div class="card-body">
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
          <p class="text-center" v-if="!hasContent">No Content</p>
          <br />
          <div class="body" v-html="about.body"></div>
          <br />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      ifReady: false,
      aboutMe: "",
      hasContent: false,
    };
  },
  mounted() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get("/api/aboutMe")
        .then((res) => {
          console.log(res);
          this.about = res.data.aboutMe;
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