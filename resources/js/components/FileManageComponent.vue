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
                    <hr>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <form @submit.prevent="fileSettings" @keydown="form.onKeydown($event)">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="fileManageTitle">File Manage</h5>
                                </div>
                                <div class="modal-body">
                                    <!-- <input v-model="form.user_id" value="{{Auth::id()}}" class="form-control" type="text" name="user_id"> -->
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Allow file format</label>
                                        <input v-model="form.allowFormat" class="form-control" type="text" name="allowFormat" placeholder="e.g. jpg,pdf" style="width: 100%;">
                                        <div v-if="form.errors.has('allowFormat')" v-html="form.errors.get('allowFormat')" />
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Maximum file size</label>
                                        <input v-model="form.maxFileSize" class="form-control" type="number" name="maxFileSize" placeholder="25mb" style="width: 100%;">
                                        <div v-if="form.errors.has('maxFileSize')" v-html="form.errors.get('maxFileSize')" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button type="submit" :disabled="form.busy" class="btn btn-primary">{{ btnText}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            // this.loadFileSettings();
            // Fire.$on("AfterCreate", () => this.loadFileSettings());
        },
        data: () => ({
            settings: {},
            btnText:"Create",
            form: new Form({
                allowFormat: '',
                maxFileSize: '',
                // user_id: '',
            })
        }),
        methods:{
            async fileSettings () {
                this.$Progress.start()
                const response = await this.form.post('/api/fileSettings')
                .then(() => {
                    Fire.$emit("AfterCreate");
                    Toast.fire({
                        icon: 'success',
                        title: 'File settings created'
                    })
                    this.btnText = "Update";
                    this.$Progress.finish()
                }).catch(()=>{
                    this.$Progress.fail()
                })
                          
            }
        }
    }
</script>
