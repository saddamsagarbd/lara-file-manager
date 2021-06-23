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
                    style="float: right; margin-top: 10px"
                    @click="uploadFiles"
                >
                  Upload Files
                </button>
            </div><!-- /.container-fluid -->
        </div>
        <div class="clr" style="height: 60px;"></div>
        <!-- /.content-header -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4" v-for="file in files" :key="file.id">
                        <div class="card">
                            <div class="card-body">
                                <a href="#" class="card-link" @click="previewFile(file.file_path)">
                                    <img :src="'/storage/'+file.file_path" alt="" class="img-thumbnail" style="width: 100px; height: 100px" />
                                    <h5 class="card-title" style="overflow:hidden;">{{ file.file_name }}</h5>
                                </a>

                                <a href="#" class="card-link" @click="previewFile(file.file_path)">Preview</a>
                                <a href="#" @click.prevent="download(file)">
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="previewImg" tabindex="-1" role="dialog" aria-labelledby="createDirectoryTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="previewImgTitle">Preview</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img :src="imgSrc" alt="" class="img-thumbnail" style="width: 100%; margin: 0px auto; display: block;" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    export default { 
        data (){
            return {
                files:{},
                imgSrc:'',
                dropzoneOptions: {
                    url: 'http://127.0.0.1:8000/api/upload',
                    params: {
                        'directory_id' : this.$route.params.id // Your directory Id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    thumbnailWidth: 150,
                    maxFilesize: 2,
                    parallelUploads: 3,
                    maxFiles: 3,
                    uploadMultiple: true,
                    autoProcessQueue: false,
                    addRemoveLinks: true,
                    removeFile:true,
                    dictDefaultMessage: "<i class='fas fa-cloud-upload-alt'></i>UPLOAD FILES"
                }
            }
        },
        components:{
            vueDropzone: vue2Dropzone
        },
        created: function(){
            this.loadFiles();
            Fire.$on("afterUploadSuccess", () => this.loadFiles());
            
        },
        methods:{
            loadFiles(){
                axios.get('/api/folder/'+ this.$route.params.id +'/files')
                .then(({ data }) => (this.files = data));
            },
            afterUploadComplete:async function (response){
                if(response.status == "success"){
                    Fire.$emit("afterUploadSuccess");
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
            previewFile(file_path){
                $('#previewImg').modal('show');
                this.imgSrc = '/storage/'+file_path;
            },
            download(file){
                axios({
                    url: '/api/download/'+ this.$route.params.id,
                    method: 'GET',
                    responseType: 'blob',
                })
                .then((res) => {
                    var blob = new Blob([res.data], {type: "octet/stream"}),
                        url = window.URL.createObjectURL(blob),
                        a = document.createElement("a");
                    a.href = url;
                    a.download = file.file_name;
                    a.click();
                    window.URL.revokeObjectURL(url);
                })
                .catch(err => console.log(err))
            },
        },
        
    }
</script>
