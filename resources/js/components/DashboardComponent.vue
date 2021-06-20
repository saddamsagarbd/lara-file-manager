<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">
                    <i class="fas fa-file"></i>
                    Recent Files
                    </h1>
                    <hr>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
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
        <!-- /.content -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">
                    <i class="fas fa-folder"></i>
                    Folders
                    </h1>
                    <hr>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Folder title</h5>

                                <p class="card-text">
                                Number of files:#
                                </p>

                                <a href="#" class="card-link">Rename</a>
                                <a href="#" class="card-link">Delete</a>
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
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
