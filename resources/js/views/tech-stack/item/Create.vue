<template>
    <div>
        <div class="card">
            <div class="card-header">
              <div class="float-left">
                <router-link class="text-primary" :to="{ name: 'tech-stack-item.index' }">Tech Stack Item</router-link>
                /
                <span class="text-secondary">Tech Stack Item List</span> 
                /
                <span class="text-secondary">Add Tech Stack Item</span>
              </div>
              <div class="float-right">
                <router-link class="btn btn-outline-secondary btn-sm" :to="{ name: 'tech-stack-item.index' }">
                  <i class="fas fa-chevron-left"></i> &nbsp;Back
                </router-link>
              </div>
            </div>
            <div class="card-body">
                <div v-if="ifReady">
                    <form v-on:submit.prevent="createNewtechStackItem()">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" v-model="name" autocomplete="off" minlength="2" maxlength="255" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="proficiency">Proficiency (1-10)</label>
                                    <input type="number" class="form-control" v-model="proficiency" autocomplete="off" step=".01" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="experience">Experience length</label>
                                    <input type="text" class="form-control" v-model="experience" autocomplete="off" minlength="2" maxlength="255" required>
                                </div>
                            </div>
                        </div>

                        <br>

                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> &nbsp;Add Tech Stack Item</button>
                    </form>
                </div>

                <div v-else>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
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
                name: '',
                experience: '',
                proficiency: '',
            };
        },
        methods: {
            createNewtechStackItem() {
                this.ifReady = false;

                axios.post('/api/tech-stack-item', this.$data).then(res => {
                    Broadcast.$emit('ToastMessage', {
                        message: 'Tech Stack Item Added Successfully'
                    });

                    this.$router.push({ name: 'tech-stack-item.index' });
                }).catch(err => {
                    this.ifReady = true;
                    console.log(err);
                });
            }
        }
    }
</script>