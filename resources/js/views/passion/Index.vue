<template>
  <div>
    <div class="card">
      <div class="card-header clearfix">
        <div class="row">
          <div class="float-left col-md-6">
            <router-link class="text-primary" :to="{ name: 'tech-stack-item.index' }">Passion</router-link>&nbsp;/
            <span class="text-secondary">Passion List</span>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="card-columns" v-if="passions">
          <div class="card" v-for="passion in passions" :key="passion.id">
            <div v-if="passion.image" class="text-center">
              <img class="card-img-top imageCard" :src="'storage/images/' + image" alt />
            </div>
            <div class="card-body">
              <h5 class="card-title">{{ passion.name }}</h5>
              <div v-html="passion.description"></div>
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
    };
  },
  mounted() {
    let promise = new Promise((resolve, reject) => {
      axios.get("/api/passion/").then((res) => {
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
