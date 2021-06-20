<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users List</h3>

                <div class="card-tools">
                    <!-- <button class="btn btn-success" data-toggle="modal" data-target="#addNewUser"><i class="fa fa-plus fa-fw"></i>Add user</button> -->
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>SL</th>
                      <th>User Name</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td><span class="tag tag-success">Approved</span></td>
                      <td>
                          <a href="#"><i class="fa fa-edit"></i></a>
                          <a href="#"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="addNewUserCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form @submit.prevent="authenticateUser" @keydown="form.onKeydown($event)">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNewUserTitle">Authenticate User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Username</label>
                                <input v-model="form.username" type="text" name="username" placeholder="Username">
                                <div v-if="form.errors.has('username')" v-html="form.errors.get('username')" />
                            </div>
                            

                            <div class="form-group">
                                <label for="auth_user">Authenticate User</label>
                                <select class="form-control" v-model="form.auth_user" name="auth_user">
                                    <option value="1">Accept</option>
                                    <option value="2">Pending</option>
                                    <option value="3">Suspend</option>
                                    <option value="4">Decline</option>                                    
                                </select>
                                <div v-if="form.errors.has('auth_user')" v-html="form.errors.get('auth_user')" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" :disabled="form.busy" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            form: new Form({
            
            })
        }),
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            async authenticateUser () {
            const response = await this.form.post('/api/authenticateUser')
            
            }
        }
    }
</script>
