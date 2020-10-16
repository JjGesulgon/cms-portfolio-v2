<template>
  <div>
    <breadcrumbs
      :routePrefixName="routePrefixName"
      :action="action"
      :singularName="singularName"
      :pluralName="pluralName"
      :useName="useName"
      :alternateName="alternateName"
    ></breadcrumbs>

    <div class="card">
      <div class="card-body">
        <form-title
          :routePrefixName="routePrefixName"
          :title="title"
          :singularName="singularName"
          :apiPath="apiPath"
          :moduleID="moduleID"
          :toastMessage="toastMessage"
          :altRoute="altRoute"
          v-bind:showRightSide="false"
        ></form-title>
        <hr />
        <div class="card-columns" v-if="ifReady">
          <div
            class="card"
            v-for="samplePageImage in samplePageImages"
            :key="samplePageImage.id"
          >
            <div class="card-header clearfix mb-2">
              <label
                class="btn btn-outline-danger ideal-font float-right"
                @click.prevent="openDeleteModalTable(samplePageImage)"
              >
                <i class="fas fa-trash-alt"></i>&nbsp;
                <strong>Delete</strong>
              </label>
            </div>
            <div v-if="samplePageImage.image" class="text-center">
              <img
                class="img-fluid"
                :src="'/storage/images/' + samplePageImage.image"
                alt
              />
            </div>
          </div>
        </div>
        <div v-else>
          <div class="progress">
            <div
              class="progress-bar progress-bar-striped progress-bar-animated"
              role="progressbar"
              aria-valuenow="100"
              aria-valuemin="0"
              aria-valuemax="100"
              style="width: 100%"
            ></div>
          </div>
        </div>
      </div>
    </div>

    <div
      class="modal fade"
      id="delete-modal-table"
      tabindex="-1"
      role="dialog"
      aria-labelledby="delete-modal-title"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="delete-modal-title">
              <strong class="text-danger">WARNING:</strong> You're about to
              delete this.
            </h5>
          </div>
          <div class="modal-body">
            Are you sure you want to delete this image?
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary btn-sm"
              data-dismiss="modal"
            >
              Cancel
            </button>
            <button
              type="button"
              class="btn btn-danger btn-sm"
              @click.prevent="deleteItem()"
            >
              Confirm Delete
            </button>
          </div>
        </div>
      </div>
    </div>

    <div
      class="modal fade"
      id="create-modal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="create-modal"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="delete-modal-title">
              <label class="text-primary font-weight-light m-0"
                >Sample Page Image Upload</label
              >
            </h4>
          </div>
          <form v-on:submit.prevent="createSamplePageItem()">
            <div class="modal-body">
              <div class="form-group m-0">
                <input
                  id="image"
                  type="file"
                  class="form-control-file"
                  @change="onFileSelected"
                  required
                />
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary btn-sm"
                data-dismiss="modal"
                @click.prevent="CancelUpload()"
              >
                <i class="far fa-times-circle"></i>&nbsp; Cancel
              </button>
              <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-upload"></i>
                &nbsp; Upload Image
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      samplePageImages: null,
      samplePageImage: null,
      alternateName: "Sample Page Images",

      image: null,

      action: "Edit",
      altRoute: "projects",
      title: "Sample Page Images",
      routePrefixName: "projects",
      useName: "alternate",
      pluralName: "Projects",
      singularName: "Project",
      apiPath: "/api/sample-page-image/",
      toastMessage: "Sample Page Image",
      isSamplePageImage: true,
      hasContent: true,
      moduleID: null,
      showButtons: true,
      ifReady: false,
      showBack: true,
    };
  },
  mounted() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get(this.apiPath + "getAll/" + this.$route.params.id)
        .then((res) => {
          this.samplePageImages = res.data.samplePageImage;
          resolve();
        });
    });

    promise.then(() => {
      this.ifReady = true;
    });
  },
  methods: {
    openModal(modalID) {
        $(modalID).modal("show");
    },

    onFileSelected(event) {
      this.image = event.target.files[0];
    },

    CancelUpload(){
      this.image = null;
      $("#image").val('');
    },

    createSamplePageItem(){
      $("#create-modal").modal("hide");
      this.ifReady = false;

      let formData = new FormData();
    
      formData.append("image", this.image);
      formData.append("project_id", this.$route.params.id);

      axios
        .post(`${this.apiPath}`, formData)
        .then(() => {
          Broadcast.$emit("ToastMessage", {
            message: `${this.toastMessage} created successfully.`,
          });

          this.$router.go();
        })
        .catch((err) => {
          console.log(err);
          this.ifReady = true;
        });
    },

    openDeleteModalTable(item) {
      this.samplePageImage = item;
      $("#delete-modal-table").modal("show");
    },

    deleteItem() {
      $("#delete-modal-table").modal("hide");
      this.ifReady = false;

      axios
        .delete(`${this.apiPath}${this.samplePageImage.id}`)
        .then(() => {
          Broadcast.$emit("ToastMessage", {
            message: `${this.toastMessage} deleted successfully.`,
          });

          this.ifReady = true;

          const index = this.samplePageImages.indexOf(this.samplePageImage);
          this.samplePageImages.splice(index, 1);
        })
        .catch((err) => {
          console.log(err);
          this.$parent.ifReady = true;
        });
    },
  },
};
</script>
