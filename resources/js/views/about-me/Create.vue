<template>
  <div>
    <div class="card">
      <div class="card-header">
        <router-link class="text-primary" :to="{ name: 'users.index' }">About Me</router-link>/
        <span class="text-secondary">Create New Content</span>
      </div>
      <div class="card-body">
        <div v-if="ifReady">
          <form v-on:submit.prevent="createNewAboutMe()">
            <div class="form-group">
              <label>Image (optional)</label>
              <input type="file" class="form-control-file" @change="onFileSelected">
            </div>
            <div class="form-group">
              <label>Content</label>
              <editor
                v-model="body"
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
            <router-link class="btn btn-outline-secondary btn-sm" :to="{ name: 'users.index' }">
              <i class="fas fa-chevron-left"></i> &nbsp;Back
            </router-link>
            <button type="submit" class="btn btn-success btn-sm">
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
      ifReady: true,
      body: '',
      image: '',
      errors: [],
    };
  },
  methods: {
    onFileSelected(event) {
      this.image = event.target.files[0];
    },
    createNewAboutMe() {
      this.ifReady = false;
      let formData = new FormData();
      formData.append('body', tinyMCE.activeEditor.getContent());

      if (this.image != null) {
        formData.append('image', this.image);
      }

      axios
        .post("/api/aboutMe", formData)
        .then((res) => {
          Broadcast.$emit("ToastMessage", {
            message: "About Me Content Created Successfully",
          });
          this.$router.push({ name: "about-me.index" });
        })
        .catch((err) => {
          this.ifReady = true;
          console.log(err);
        });
    },
  },
};
</script>