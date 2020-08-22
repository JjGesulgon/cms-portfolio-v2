<template>
  <div>
    <div class="card">
      <div class="card-header clearfix">
        <div class="float-left">
          <router-link class="text-primary" :to="{ name: 'contact.index' }">Contact</router-link>&nbsp;/
          <span class="text-secondary">Content</span>
        </div>
        <div v-if="ifReady">
          <div class="float-right" v-if="!hasContent">
            <router-link class="btn btn-primary btn-sm" :to="{ name: 'contact.create' }">
              <i class="fas fa-plus"></i>&nbsp; Create New Content
            </router-link>
          </div>
          <div class="float-right" v-else>
            <button
              type="button"
              class="btn btn-danger btn-sm"
              @click.prevent="openDeleteContactModal()"
            >
              <i class="fas fa-trash-alt"></i>&nbsp; Delete Content
            </button>
            <router-link
              class="btn btn-primary btn-sm"
              :to="{ name: 'contact.edit', params: { id: contact.id }}"
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
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">Email</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="contact.email"
                    autocomplete="off"
                    minlength="2"
                    maxlength="255"
                    required
                    disabled
                  />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="instagram_link">Instagram Link</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="contact.instagram_link"
                    autocomplete="off"
                    minlength="2"
                    maxlength="255"
                    required
                    disabled
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="twitter_link">Twitter Link</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="contact.twitter_link"
                    autocomplete="off"
                    minlength="2"
                    maxlength="255"
                    required
                    disabled
                  />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="linkedin_link">LinkedIn Link</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="contact.linkedin_link"
                    autocomplete="off"
                    minlength="2"
                    maxlength="255"
                    required
                    disabled
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="devto_link">Dev.to Link</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="contact.devto_link"
                    autocomplete="off"
                    minlength="2"
                    maxlength="255"
                    required
                    disabled
                  />
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Content</label>
              <editor
                disabled
                v-model="contact.content"
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
      aria-labelledby="deleteContact"
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
              @click.prevent="deleteContact()"
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
      contact: null,
      hasContent: false,
    };
  },
  mounted() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get("/api/contact")
        .then((res) => {
          console.log(res);
          this.contact = res.data.contact;
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
    openDeleteContactModal() {
      $("#delete-modal").modal("show");
    },
    deleteContact() {
      $("#delete-modal").modal("hide");
      this.ifReady = false;
      axios
        .delete("/api/contact/" + this.contact.id)
        .then((res) => {
          Broadcast.$emit("ToastMessage", {
            message: "Record Deleted Successfully",
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