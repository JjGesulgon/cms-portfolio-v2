<template>
  <div>
    <div class="card">
      <div class="card-header">
        <div class="float-left">
          <router-link class="text-primary" :to="{ name: 'tech-stack-content.index' }">Tech Stack Content</router-link>&nbsp;/
          <span class="text-secondary">Update Content</span>
        </div>
        <div class="float-right">
          <router-link class="btn btn-outline-secondary btn-sm" :to="{ name: 'tech-stack-content.index' }">
            <i class="fas fa-chevron-left"></i> &nbsp;Back
          </router-link>
        </div>
      </div>
      <div class="card-body">
        <div v-if="ifReady">
          <form v-on:submit.prevent="updateTechStackContent()">
            <div class="form-group">
              <label>Content</label>
              <editor
                v-model="techStackContent.body"
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
            <button type="submit" class="btn btn-primary btn-sm">
              <i class="fas fa-edit"></i> &nbsp;Update Content
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
      techStackContent:'',
      errors: [],
    };
  },
  mounted() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get("/api/tech-stack-content")
        .then((res) => {
          this.techStackContent = res.data.techStackContent;
          tinyMCE.activeEditor.setContent(this.techStackContent.body);
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
    onFileSelected(event) {
      this.image = event.target.files[0];
    },

    updateTechStackContent() {
      this.ifReady = false;

      let formData = new FormData();
      formData.append('_method','PATCH');
      formData.append('body', tinyMCE.activeEditor.getContent());

      if (this.image != null) {
        formData.append('image', this.image);
      }

      axios
        .post("/api/tech-stack-content/" + this.techStackContent.id, formData)
        .then((res) => {
          Broadcast.$emit("ToastMessage", {
            message: "Tech Stack Content Updated Successfully",
          });

          this.$router.push({ name: "tech-stack-content.index" });
        })
        .catch((err) => {
          this.ifReady = true;
          console.log(err);
        });
    },
  },
};
</script>