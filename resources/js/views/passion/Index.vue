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
        <form-title :routePrefixName="routePrefixName" :title="title" :singularName="singularName" :apiPath="apiPath" :moduleID="moduleID" :toastMessage="toastMessage" v-bind:showRightSide="false"></form-title>
        <hr>
        <div class="card-columns" v-if="passions">
          <div class="card" v-for="passion in passions" :key="passion.id">
            <div class="card-header clearfix mb-2">
              <router-link class="btn btn-primary btn-sm float-right" :to="{ name: 'passion.edit', params: { id: passion.id }}">
                <i class="fas fa-edit"></i>&nbsp; Edit
              </router-link>
            </div>
            <div v-if="passion.image" class="text-center">
              <img class="img-fluid mw-50 h-auto" :src="'storage/images/' + passion.image" alt />
            </div>
            <div class="card-body"> 
              <h5 class="card-title text-center">{{ passion.name }}</h5>
              <div class="text-center" v-html="passion.description"></div>
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
      passions: null,

      action: 'View',
      title: 'Passion',
      routePrefixName: 'passion',
      useName: "plural",
      pluralName: "Passions",
      singularName: "Passion",
      apiPath: '/api/passion/',
      toastMessage: 'Passion Content',
      moduleID: null,
      showButtons: false
    };
  },
  mounted() {
    let promise = new Promise((resolve, reject) => {
      axios.get(this.apiPath).then((res) => {
        this.passions = res.data.data;
        resolve();
      });
    });

    promise.then(() => {
      this.ifReady = true;
    });
  },
  methods: {
    
  },
};
</script>
