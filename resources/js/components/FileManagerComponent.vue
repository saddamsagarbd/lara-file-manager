<template>
    <div class="container">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-10">
                        <h1 class="m-0 text-dark">
                        <i class="fas fa-folder"></i>
                        Directories
                        </h1>                        
                    </div><!-- /.col -->
                    <div class="col-sm-2">
                        <button class="btn btn-success" @click="createDirectoryModal()"><i class="fa fa-plus fa-fw"></i>Create Directory</button>
                    </div>
                    <hr>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4" v-for="directory in directories" :key="directory.id">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <router-link :to="{ name:'folder', params:{ id: directory.id }}">
                                    {{ directory.directory_name }}
                                    </router-link>
                                </h5>

                                <p class="card-text">
                                Number of files:#
                                </p>

                                <a href="#" class="card-link" @click="renameDirectory(directory)">Rename</a>
                                <a href="#" class="card-link" @click="deleteDirectory(directory.id)">Delete</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="createDirectory" tabindex="-1" role="dialog" aria-labelledby="createDirectoryTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form @submit.prevent="createDirectory" @keydown="form.onKeydown($event)">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createDirectoryTitle">Create Directory</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <input v-model="form.directory_name" class="form-control" type="text" name="directory_name" placeholder="Directory Title" style="width: 100%;">
                                <div v-if="form.errors.has('directory_name')" v-html="form.errors.get('directory_name')" />
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
            directories: {},
            form: new Form({
                directory_name: '',
            })
        }),
        mounted() {
            this.displayDirectories();
            Fire.$on("AfterCreate", () => this.displayDirectories());
            Fire.$on("AfterDelete", ()=> this.displayDirectories());
        },
        methods: {
            createDirectoryModal(){
                this.form.reset();
                $('#createDirectory').modal('show');
            },
            renameDirectory(directory){
                this.form.reset();
                $('#createDirectory').modal('show');
                this.form.fill(directory);
            },
            displayDirectories(){
                axios.get('/api/directories').then(({ data }) => (this.directories = data));
            },
            async createDirectory () {
                this.$Progress.start()
                const response = await this.form.post('/api/directories')
                .then(() => {
                    Fire.$emit("AfterCreate");
                    Toast.fire({
                        icon: 'success',
                        title: 'Directory successfully created'
                    })
                    this.hideModal();
                    this.$Progress.finish()
                }).catch(()=>{
                    this.$Progress.fail()
                })
                          
            },
            deleteDirectory(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        this.$Progress.start()
                        // send the request to server
                        this.form.delete('api/directories/'+id)
                        .then(({ data }) => {
                            Fire.$emit("AfterDelete");
                            Toast.fire({
                                icon: data.status,
                                title: data.message
                            })
                            this.$Progress.finish()
                        }).catch(()=>{
                            this.$Progress.fail()
                        });
                    }
                })

            },
            hideModal(){
                $('#createDirectory').modal('hide');
            }
        }
    }
</script>
