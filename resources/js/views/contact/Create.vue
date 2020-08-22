<template>
  <div>
    <div class="card">
      <div class="card-header">
        <router-link class="text-primary" :to="{ name: 'users.index' }">Contact</router-link>&nbsp;/
        <span class="text-secondary">Create New Content</span>
      </div>
      <div class="card-body">
        <div v-if="ifReady">
          <form v-on:submit.prevent="createNewContact()">
            <div class="form-group">
              <label for="email">Email Address</label>
              <input
                type="email"
                class="form-control"
                v-model="email"
                autocomplete="off"
                minlength="2"
                maxlength="255"
                required
              />
            </div>
            <div class="form-group">
              <label>Content</label>
              <editor
                v-model="content"
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
            <div class="form-group">
              <label for="instagram_link">Instagram Link</label>
              <input
                type="text"
                class="form-control"
                v-model="instagram_link"
                autocomplete="off"
                minlength="2"
                maxlength="255"
                required
              />
            </div>
            <div class="form-group">
              <label for="twitter_link">Twitter Link</label>
              <input
                type="text"
                class="form-control"
                v-model="twitter_link"
                autocomplete="off"
                minlength="2"
                maxlength="255"
                required
              />
            </div>
            <div class="form-group">
              <label for="linkedin_link">LinkedIn Link</label>
              <input
                type="text"
                class="form-control"
                v-model="linkedin_link"
                autocomplete="off"
                minlength="2"
                maxlength="255"
                required
              />
            </div>
            <div class="form-group">
              <label for="devto_link">Dev.to Link</label>
              <input
                type="text"
                class="form-control"
                v-model="devto_link"
                autocomplete="off"
                minlength="2"
                maxlength="255"
                required
              />
            </div>
            <br />
            <router-link class="btn btn-outline-secondary btn-sm" :to="{ name: 'users.index' }">
              <i class="fas fa-chevron-left"></i> &nbsp;Back
            </router-link>
            <button type="submit" class="btn btn-primary btn-sm">
              <i class="fas fa-plus"></i> &nbsp;Create New Content
            </button>
          </form>
        </div>
        <div v-else>
          <div class="progress">
            <div
              class="progress-bar progress-bar-striped progress-bar-animated"
              role="progressbar"
              aria-valuenow="100"
              aria-valuemin="0"
              aria-valuemax="100"
              style="width: 100%;"
            ></div>
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
      contactContent: null,
      content: '',
      email: '',
      instagram_link: '',
      twitter_link: '',
      linkedin_link: '',
      devto_link: '',
      errors: [],
    };
  },
  created() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get("/api/contact")
        .then((res) => {
          this.contactContent = res.data.contact;
          if (this.contactContent) {
            this.$router.push({ name: "about-me.index" });
          } else {
            this.ifReady = true;
          }
          resolve();
        })
        .catch((error) => {
          this.ifReady = true;
        });
    });
  },
  methods: {
    onFileSelected(event) {
      this.image = event.target.files[0];
    },
    createNewContact() {
      this.ifReady = false;
      let formData = new FormData();
      formData.append("content", tinyMCE.activeEditor.getContent());
      formData.append("email", this.email);
      formData.append("instagram_link", this.instagram_link);
      formData.append("twitter_link", this.twitter_link);
      formData.append("linkedin_link", this.linkedin_link);
      formData.append("devto_link", this.devto_link);
      

      axios
        .post("/api/contact", formData)
        .then((res) => {
          Broadcast.$emit("ToastMessage", {
            message: "About Me Content Created Successfully",
          });
          this.$router.push({ name: "contact.index" });
        })
        .catch((err) => {
          this.ifReady = true;
          console.log(err);
        });
    },
  },
};
</script>