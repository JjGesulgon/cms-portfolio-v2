<template>
    <div>
        <div class="card">
            <div class="card-header">
              <div class="float-left">
                <router-link class="text-primary" :to="{ name: 'users.index' }">Users</router-link>
                /
                <span class="text-secondary">User List</span>
                /
                <span class="text-secondary">User Details</span>
              </div>
              <div class="float-right">
                <router-link class="btn btn-outline-secondary btn-sm" :to="{ name: 'users.index' }"><i class="fas fa-chevron-left"></i>&nbsp; Back</router-link>
              </div>
            </div>
            <div class="card-body">
                <div v-if="ifReady">
                    <fieldset disabled>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" v-model="user.name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" v-model="user.email">
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <br>
                    <router-link class="btn btn-primary btn-sm" :to="{ name: 'users.edit' , params: { id: user.id }}"><i class="fas fa-edit"></i>&nbsp; Edit User</router-link>
                    <button type="button" class="btn btn-danger btn-sm" @click.prevent="openDeleteUserModal()"><i class="fas fa-trash-alt"></i>&nbsp; Delete User</button>
                </div>
                <div v-else>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="deleteUserTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">You're about to delete this User?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger btn-sm" @click.prevent="deleteUser()">Confirm Delete</button>
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
                user: ''
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get('/api/users/' + this.$route.params.id).then(res => {
                    this.user = res.data.user;
                    resolve();
                });
            });

            promise.then(() => {
                this.ifReady = true;
            });
        },

        methods: {
            openDeleteUserModal() {
                $('#delete-modal').modal('show');
            },
            deleteUser() {
                $('#delete-modal').modal('hide');
                
                axios.delete('/api/users/' + this.$route.params.id).then(res => {
                    Broadcast.$emit('ToastMessage', {
                        message: 'User Deleted Successfully'
                    });

                    this.$router.push({ name: 'users.index' });
                }).catch(err => {
                    console.log(err);
                });
            }
        }
    }
</script>
