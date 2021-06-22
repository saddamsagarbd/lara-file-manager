<template>
    <div class="container">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-10">
                        <h1 class="m-0 text-dark">
                        <i class="fas fa-file"></i>
                        Uploaded Files
                        </h1>                        
                    </div><!-- /.col -->
                    <hr>
                </div><!-- /.row -->
                <vue-dropzone 
                    ref="myVueDropzone" 
                    id="dropzone" 
                    :options="dropzoneOptions"
                    @vdropzone-complete="afterUploadComplete"
                >

                </vue-dropzone>
                <button
                    type="button"
                    class="btn btn-success"
                    style="float: right;"
                    @click="uploadFiles"
                >
                  Upload Files
                </button>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">File title</h5>

                                <p class="card-text">
                                File size:#
                                </p>

                                <a href="#" class="card-link">Preview</a>
                                <a href="#" class="card-link">Download</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    </div>
</template>

<script>
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    export default {
        data(){
            return {
                dropzoneOptions: {
                    url: 'http://127.0.0.1:8000/api/upload',
                    thumbnailWidth: 150,
                    maxFilesize: 2,
                    parallelUploads: 3,
                    maxFiles: 3,
                    uploadMultiple: true,
                    autoProcessQueue: false,
                    dictDefaultMessage: "<i class='fas fa-cloud-upload-alt'></i>UPLOAD FILES"
                }
            }
        },
        components:{
            vueDropzone: vue2Dropzone
        },
        methods:{
            afterUploadComplete:async function (response){
                if(response.status == "success"){
                    Toast.fire({
                        icon: "success",
                        title: "Successfully uploaded"
                    })
                    this.$refs.myVueDropzone.removeAllFiles();
                }else{
                    Toast.fire({
                        icon: "error",
                        title: "Error in upload"
                    })
                }
                
                
            },
            uploadFiles: async function () {
                this.$refs.myVueDropzone.processQueue();
            },
        },
        
    }
</script>
