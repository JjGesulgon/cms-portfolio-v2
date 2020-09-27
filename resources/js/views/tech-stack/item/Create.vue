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
        <form-create
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
                    <label for="name" class="ideal-font font-weight-bold">Name</label>
                    <input
                      id="name"
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
                    <label for="proficiency" class="ideal-font font-weight-bold">Proficiency (1-10)</label>
                    <input
                      id="proficiency"
                      type="number"
                      class="form-control"
                      v-model="proficiency"
                      autocomplete="off"
                      step=".01"
                      required
                    />
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="experience" class="ideal-font font-weight-bold">Experience length</label>
                    <input
                      id="experience"
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
              </div>
            </div>
          </template>
        </form-create>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      createbuttonShow: false,
      ifReady: true,
      action: "Create New",
      title: "Create New Technology Stack Item",
      singularName: "Technology Stack Item",
      pluralName: "Technology Stack Items",
      apiPath: "/api/tech-stack-item",
      routePrefixName: "tech-stack-item",
      useName: "singular",
      toastMessage: "Technology Stack Item",

      name: "",
      experience: "",
      proficiency: "",

      showButtons: false,
      showSearch: false,
      showBack: true,
      errors: [],
    };
  },
  methods: {
    getFieldColumns() {
      return {
        name: this.name,
        experience: this.experience,
        proficiency: this.proficiency,
      };
    },
  },
};
</script>