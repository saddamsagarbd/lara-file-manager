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
                    <div class="col-lg-4" v-for="file in files" :key="file.id">
                        <div class="card">
                            <div class="card-body">
                                <!-- <img :src="getFile()" alt="{{ file.file_name }}" class="img-thumbnail" /> -->
                                <h5 class="card-title" style="overflow:hidden;">{{ file.file_name }}</h5>

                                <p class="card-text">
                                File size:#
                                </p>

                                <a href="#" class="card-link">Preview</a>
                                <a href="#" class="card-link" @click="download">Download</a>
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
        data (){
            return {
                files:{},
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
                    dictDefaultMessage: "<i class='fas fa-cloud-upload-alt'></i>UPLOAD FILES"
                }
            }
        },
        components:{
            vueDropzone: vue2Dropzone
        },
        created:function(){
            let id = this.$route.params.id;
            this.loadFiles();
            Fire.$on("afterUploadSuccess", () => this.loadFiles());
            // Fire.$on("AfterFileDelete", ()=> this.loadFiles());
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
            download(){
                axios({
                    url: '/api/download/'+ this.$route.params.id,
                    method: 'GET',
                    responseType: 'blob',
                })
                .then((res) => {
                    // var fileURL = window.URL.createObjectURL(new Blob([res.data]));
                    // var fileLink = document.createElement('a');
                    // fileLink.href = fileURL;
                    // fileLink.setAttribute('download', 'file.jpeg');                    
                    // document.body.appendChild(fileLink);
                    // fileLink.click();
                    let blob = new Blob([res.data], { type: res.headers['content-type'] });
                    let link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download =blob.type.slice(blob.type.lastIndexOf('i'));
                    link.click()
                })
                .catch(err => console.log(err))
            }
        },
        
    }
</script>
