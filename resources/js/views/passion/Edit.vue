<template>
  <div>
    <breadcrumbs
      :routePrefixName="routePrefixName"
      :action="action"
      :singularName="singularName"
      :pluralName="pluralName"
      :useName="useName"
    ></breadcrumbs>

    <div class="card">
      <div class="card-body">
        <form-title :routePrefixName="routePrefixName" :title="title" v-bind:showRightSide="false"></form-title>
        <hr />
        <form-edit
          :apiPath="apiPath"
          :routePrefixName="routePrefixName"
          :singularName="singularName"
          :toastMessage="toastMessage"
          :fieldColumns="getFieldColumns()"
        >
          <template v-bind:data="$data">
            <div class="form-group">
              <label>Image (optional)</label>
              <input type="file" class="form-control-file" @change="onFileSelected">
            </div>
            <div class="row">
              <div class="form-group col-md-3">
                <label for="name" class="ideal-font font-weight-bold">Name</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="$data.name"
                  autocomplete="off"
                  minlength="2"
                  maxlength="255"
                  required
                />
              </div>
            </div>
            <div class="form-group">
              <label class="ideal-font font-weight-bold">Content <small class="text-danger">* Required</small></label>
              <editor
                v-model="$data.description"
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
          </template>
        </form-edit>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      ifReady: false,
      action: "Edit",
      title: "Edit Passion",
      singularName: "Passion",
      pluralName: "Passions",
      apiPath: "/api/passion",
      routePrefixName: "passion",
      useName: "singular",
      selectedProperty: "name",
      toastMessage: "Passion Content",

      description: '',
      name: '',
      image: null,

      moduleID: null,
      showButtons: false,
      showSearch: false,
      showBack: true,
      aboutMeContent: null,
      errors: [],
    };
  },

  mounted() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get(`${this.apiPath}/${this.$route.params.id}`)
        .then((res) => {
          this.moduleID = res.data.passion.id;
          this.description = res.data.passion.description,
          this.name = res.data.passion.name

          resolve();
        })
        .catch((err) => {
          reject();
        });
    });

    promise.then(() => {
      this.ifReady = true;
    });
  },

  methods: {
    onFileSelected(event) {
      this.image = event.target.files[0];
    },

    getFieldColumns() {
      let formData = new FormData()
      formData.append('_method','PATCH');
      formData.append('description', this.description);
      formData.append('name', this.name);
      if (this.image != null) {
        formData.append('image', this.image);
      }
      
      return formData;
    },
  },
};
</script>
