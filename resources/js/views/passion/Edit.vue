<template>
  <div>
    <div class="card">
      <div class="card-header">
        <div class="float-left">
          <router-link class="text-primary" :to="{ name: 'passion.index' }">Passion</router-link>/
          <span class="text-secondary">Passion List</span>
          /
          <span class="text-secondary">Edit Passion</span>
        </div>
        <div class="float-right">
          <router-link class="btn btn-outline-secondary btn-sm" :to="{ name: 'passion.index' }">
            <i class="fas fa-chevron-left"></i>&nbsp; Back
          </router-link>
        </div>
      </div>
      <div class="card-body">
        <div v-if="ifReady">
          <form v-on:submit.prevent="updatePassion()">
            <div class="form-group">
              <label>Image (optional)</label>
              <input type="file" class="form-control-file" @change="onFileSelected">
            </div>
            <div class="form-group">
              <label for="name">Name</label>
              <input
                type="text"
                class="form-control"
                v-model="passion.name"
                autocomplete="off"
                minlength="2"
                maxlength="255"
                required
              />
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <editor
                v-model="passion.description"
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
              <i class="fas fa-edit"></i>&nbsp; Update Passion
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
      passion: null,
      image: null,
    };
  },
  mounted() {
    let retrievePassionPromise = new Promise((resolve, reject) => {
      axios.get("/api/passion/" + this.$route.params.id).then((res) => {
        this.passion = res.data.passion;
        resolve();
      });
    });

    Promise.all([retrievePassionPromise]).then(() => {
      this.ifReady = true;
    });
  },
  methods: {
    onFileSelected(event) {
      this.image = event.target.files[0];
    },

    updatePassion() {
      this.ifReady = false;

      let formData = new FormData();
      formData.append('_method','PATCH');
      formData.append('name', this.passion.name);
      formData.append('description', tinyMCE.activeEditor.getContent());

      if (this.image != null) {
        formData.append('image', this.image);
      }

      axios
        .post("/api/passion/" + this.$route.params.id, formData)
        .then((res) => {
          Broadcast.$emit("ToastMessage", {
            message: "Passion Updated Successfully",
          });

          this.$router.push({ name: "passion.index" });
        })
        .catch((err) => {
          this.ifReady = true;
          console.log(err);
        });
    },
  },
};
</script>
