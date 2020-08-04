<template>
  <div>
    <div class="card">
      <div class="card-header clearfix">
        <div class="float-left">
          <router-link class="text-primary" :to="{ name: 'about-me.index' }">About Me</router-link>&nbsp;/
          <span class="text-secondary">Content</span>
        </div>
        <div v-if="ifReady">
          <div class="float-right" v-if="!hasContent">
            <router-link class="btn btn-primary btn-sm" :to="{ name: 'about-me.create' }">
              <i class="fas fa-plus"></i>&nbsp; Create New Content
            </router-link>
          </div>
          <div class="float-right" v-else>
            <button
              type="button"
              class="btn btn-danger btn-sm"
              @click.prevent="openDeleteAboutMeModal()"
            >
              <i class="fas fa-trash-alt"></i>&nbsp; Delete Content
            </button>
            <router-link
              class="btn btn-primary btn-sm"
              :to="{ name: 'about-me.edit', params: { id: aboutMe.id }}"
            >
              <i class="fas fa-edit"></i>&nbsp; Edit Content
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
          <div v-if="!hasContent">
            <div class="image-container">
              <img class="img-fluid accent-image" src="/images/undraw_not_found.svg" alt="Image" />
            </div>
            <p class="text-center display-4">No Content</p>
          </div>
          <div v-else>
            <img
              class="img-fluid about-me-image"
              :src="'storage/images/' + aboutMe.image"
              alt="Image"
            />
            <br />
            <div class="body mt-5" v-html="aboutMe.body"></div>
            <br />
          </div>
        </div>
      </div>
    </div>
    <div
      class="modal fade"
      id="delete-modal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="deleteAboutMe"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">You're about to delete this content?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">Are you sure?</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button
              type="button"
              class="btn btn-danger btn-sm"
              @click.prevent="deleteAboutMe()"
            >Confirm Delete</button>
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
      ifReady: false,
      aboutMe: "",
      hasContent: false,
    };
  },
  mounted() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get("/api/about-me")
        .then((res) => {
          console.log(res);
          this.aboutMe = res.data.aboutMe;
          this.hasContent = true;
          this.ifReady = true;
          resolve();
        })
        .catch((error) => {
          this.ifReady = true;
        });
    });
  },
  methods: {
    openDeleteAboutMeModal() {
      $("#delete-modal").modal("show");
    },
    deleteAboutMe() {
      $("#delete-modal").modal("hide");
      this.ifReady = false;
      axios
        .delete("/api/aboutMe/" + this.aboutMe.id)
        .then((res) => {
          Broadcast.$emit("ToastMessage", {
            message: "User Deleted Successfully",
          });

          this.$router.go();
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
<style scoped>
  .about-me-image {
    max-width: 25%;
    height: auto;
  }
</style>