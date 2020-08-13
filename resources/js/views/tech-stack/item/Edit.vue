<template>
  <div>
    <div class="card">
      <div class="card-header">
        <div class="float-left">
         <router-link class="text-primary" :to="{ name: 'tech-stack-item.index' }">Tech Stack Item</router-link>
                /
                <span class="text-secondary">Tech Stack Item List</span> 
                /
                <span class="text-secondary">Edit Tech Stack Item</span>
        </div>
        <div class="float-right">
          <router-link class="btn btn-outline-secondary btn-sm" :to="{ name: 'tech-stack-item.index' }">
            <i class="fas fa-chevron-left"></i>&nbsp; Back
          </router-link>
        </div>
      </div>
      <div class="card-body">
        <div v-if="ifReady">
          <form v-on:submit.prevent="updateTechStackItem()">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="name">Name</label>
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
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="proficiency">Proficiency</label>
                  <input type="text" class="form-control" v-model="proficiency"/>
                </div>
              </div>
            </div>

            <br />

            <button type="submit" class="btn btn-primary btn-sm">
              <i class="fas fa-edit"></i>&nbsp; Update Tech Stack Item
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
      name: "",
      proficiency: "",
    };
  },

  mounted() {
    let retrieveTechStackItemPromise = new Promise((resolve, reject) => {
      axios.get("/api/tech-stack-item/" + this.$route.params.id).then((res) => {
        this.id = res.data.techStackItem.id;
        this.name = res.data.techStackItem.name;
        this.proficiency = res.data.techStackItem.proficiency;

        resolve();
      });
    });

    Promise.all([retrieveTechStackItemPromise]).then(() => {
      this.ifReady = true;
    });
  },

  methods: {
    updateTechStackItem() {
      this.ifReady = false;

      let data = {
        name: this.name,
        proficiency: this.proficiency
      };

      axios
        .patch("/api/tech-stack-item/" + this.$route.params.id, data)
        .then((res) => {
          Broadcast.$emit("ToastMessage", {
            message: "Tech Stack Item Updated Successfully",
          });

          this.$router.push({
            name: "tech-stack-item.index",
          });
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
