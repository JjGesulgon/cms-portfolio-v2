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
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="name" class="ideal-font">Name</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="name"
                      autocomplete="off"
                      minlength="2"
                      maxlength="255"
                      required
                    />
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="experience" class="ideal-font">Experience</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="experience"
                      autocomplete="off"
                      minlength="2"
                      maxlength="255"
                      required
                    />
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="proficiency" class="ideal-font">Proficiency</label>
                    <input type="text" class="form-control" v-model="proficiency" />
                  </div>
                </div>
              </div>
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
      title: "Edit Technology Stack Item",
      singularName: "Technology Stack Item",
      pluralName: "Technology Stack Items",
      apiPath: "/api/tech-stack-item",
      routePrefixName: "tech-stack-item",
      useName: "singular",
      selectedProperty: "name",
      toastMessage: "Technology Stack Item",

      name: "",
      experience: "",
      proficiency: "",

      moduleID: null,
      showButtons: false,
      showSearch: false,
      showBack: true,
      contactContent: null,
      errors: [],
      formData: new FormData(),
    };
  },

  mounted() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get(`${this.apiPath}/${this.$route.params.id}`)
        .then((res) => {
          this.moduleID = res.data.techStackItem.id;
          this.name = res.data.techStackItem.name;
          this.experience = res.data.techStackItem.experience;
          this.proficiency = res.data.techStackItem.proficiency;
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
    getFieldColumns() {
      this.formData.append("_method", "PATCH");
      this.formData.append("name", this.name);
      this.formData.append("experience", this.experience);
      this.formData.append("proficiency", this.proficiency);
      return this.formData;
    },
  },
};
</script>
