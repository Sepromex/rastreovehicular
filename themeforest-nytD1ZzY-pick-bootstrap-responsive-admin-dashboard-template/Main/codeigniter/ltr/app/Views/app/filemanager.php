<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">File Manager</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">App</li>
                    <li class="breadcrumb-item active"><a href="#">File Manager</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row row-eq-height">
        <div class="col-12 col-lg-2 mt-3 todo-menu-bar flip-menu pr-lg-0">
            <a href="#" class="d-inline-block d-lg-none mt-1 flip-menu-close"><i class="icon-close"></i></a>
            <div class="card border h-100 document-menu-section">
                <div class="card-header d-flex justify-content-between align-items-center"> 

                    <a href="#"  class="bg-primary py-2 px-2 rounded ml-auto text-white w-100 text-center" data-toggle="modal" data-target="#newcontact">
                        <i class="icon-plus align-middle text-white"></i> <span class="d-none d-xl-inline-block">Add New File</span>
                    </a>                              

                </div>

                <ul class="nav flex-column document-menu">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-documenttype="document">
                            <i class="icon-list"></i> All
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-documenttype="image-documents">
                            <i class="icon-picture"></i> Images
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-documenttype="video-documents">
                            <i class="icon-camrecorder"></i> Video
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="#" data-documenttype="folder-documents">
                            <i class="icon-folder"></i> Folders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="#" data-documenttype="file-documents">
                            <i class="icon-docs"></i> Files
                        </a>
                    </li>

                </ul>         

            </div>  
        </div>
        <div class="col-12 col-lg-10 mt-3 pl-lg-0">
            <div class="card border h-100 document-list-section">
                <div class="card-header border-bottom p-1 d-flex">
                    <a href="#" class="d-inline-block d-lg-none flip-menu-toggle"><i class="icon-menu"></i></a>
                    <input type="text" class="form-control border-0 p-2 w-100 h-100 document-search" placeholder="Search ...">
                    <a href="#" class="list-style search-bar-menu border-0 active"><i class="icon-list"></i></a>
                    <a href="#" class="grid-style search-bar-menu"><i class="icon-grid"></i></a>
                </div>
                <div class="card-body p-0">

                    <div class="documents list">
                        <div class="document image-documents"> 
                            <div class="document-content">
                                <div class="document-profile">                                                   
                                    <img src="<?php echo base_url('dist/images/portfolio1.jpg');?>" alt="avatar" class="user-image img-fluid">
                                    <div class="document-info">
                                        <p class="document-name mb-0">portfolio1.jpg</p>                                                   
                                    </div>
                                </div>
                                <div class="document-email">
                                    <p class="mb-0 small">Size:  </p>
                                    <p class="user-email">59.5kb</p>
                                </div>

                                <div class="document-phone">
                                    <p class="mb-0 small">Date Added: </p>
                                    <p class="user-phone">29 June 2020</p>
                                </div>
                                <div class="line-h-1 h5">
                                    <a class="text-success edit-document" href="#" data-toggle="modal" data-target="#"><i class="icon-pencil"></i></a>
                                    <a class="text-danger delete-document" href="#"><i class="icon-trash"></i></a>                                 
                                </div>
                            </div>
                        </div>
                        <div class="document folder-documents"> 
                            <div class="document-content">
                                <div class="document-profile">                                                   
                                    <i class="icon-folder"></i>
                                    <div class="document-info">
                                        <p class="document-name mt-3">Product Images</p>                                                   
                                    </div>
                                </div>
                                <div class="document-email">
                                    <p class="mb-0 small">Size:  </p>
                                    <p class="user-email">59.5kb</p>
                                </div>

                                <div class="document-phone">
                                    <p class="mb-0 small">Date Added: </p>
                                    <p class="user-phone">29 June 2020</p>
                                </div>
                                <div class="line-h-1 h5">
                                    <a class="text-success edit-document" href="#" data-toggle="modal" data-target="#"><i class="icon-pencil"></i></a>
                                    <a class="text-danger delete-document" href="#"><i class="icon-trash"></i></a>                                 
                                </div>
                            </div>
                        </div>

                        <div class="document video-documents"> 
                            <div class="document-content">
                                <div class="document-profile">                                                   
                                    <i class="icon-camrecorder"></i>
                                    <div class="document-info">
                                        <p class="document-name mt-3">Introduction Video</p>                                                   
                                    </div>
                                </div>
                                <div class="document-email">
                                    <p class="mb-0 small">Size:  </p>
                                    <p class="user-email">59.5kb</p>
                                </div>

                                <div class="document-phone">
                                    <p class="mb-0 small">Date Added: </p>
                                    <p class="user-phone">29 June 2020</p>
                                </div>
                                <div class="line-h-1 h5">
                                    <a class="text-success edit-document" href="#" data-toggle="modal" data-target="#"><i class="icon-pencil"></i></a>
                                    <a class="text-danger delete-document" href="#"><i class="icon-trash"></i></a>                                 
                                </div>
                            </div>
                        </div>

                        <div class="document file-documents"> 
                            <div class="document-content">
                                <div class="document-profile">                                                   
                                    <i class="icon-doc"></i>
                                    <div class="document-info">
                                        <p class="document-name mt-3">Documentation</p>                                                   
                                    </div>
                                </div>
                                <div class="document-email">
                                    <p class="mb-0 small">Size:  </p>
                                    <p class="user-email">59.5kb</p>
                                </div>

                                <div class="document-phone">
                                    <p class="mb-0 small">Date Added: </p>
                                    <p class="user-phone">29 June 2020</p>
                                </div>
                                <div class="line-h-1 h5">
                                    <a class="text-success edit-document" href="#" data-toggle="modal" data-target="#"><i class="icon-pencil"></i></a>
                                    <a class="text-danger delete-document" href="#"><i class="icon-trash"></i></a>                                 
                                </div>
                            </div>
                        </div>
                        <div class="document image-documents"> 
                            <div class="document-content">
                                <div class="document-profile">                                                   
                                    <img src="<?php echo base_url('dist/images/portfolio2.jpg');?>" alt="avatar" class="user-image img-fluid">
                                    <div class="document-info">
                                        <p class="document-name mb-0">portfolio2.jpg</p>                                                   
                                    </div>
                                </div>
                                <div class="document-email">
                                    <p class="mb-0 small">Size:  </p>
                                    <p class="user-email">59.5kb</p>
                                </div>

                                <div class="document-phone">
                                    <p class="mb-0 small">Date Added: </p>
                                    <p class="user-phone">29 June 2020</p>
                                </div>
                                <div class="line-h-1 h5">
                                    <a class="text-success edit-document" href="#" data-toggle="modal" data-target="#"><i class="icon-pencil"></i></a>
                                    <a class="text-danger delete-document" href="#"><i class="icon-trash"></i></a>                                 
                                </div>
                            </div>
                        </div>
                        <div class="document image-documents"> 
                            <div class="document-content">
                                <div class="document-profile">                                                   
                                    <img src="<?php echo base_url('dist/images/portfolio3.jpg');?>" alt="avatar" class="user-image img-fluid">
                                    <div class="document-info">
                                        <p class="document-name mb-0">portfolio3.jpg</p>                                                   
                                    </div>
                                </div>
                                <div class="document-email">
                                    <p class="mb-0 small">Size:  </p>
                                    <p class="user-email">59.5kb</p>
                                </div>

                                <div class="document-phone">
                                    <p class="mb-0 small">Date Added: </p>
                                    <p class="user-phone">29 June 2020</p>
                                </div>
                                <div class="line-h-1 h5">
                                    <a class="text-success edit-document" href="#" data-toggle="modal" data-target="#"><i class="icon-pencil"></i></a>
                                    <a class="text-danger delete-document" href="#"><i class="icon-trash"></i></a>                                 
                                </div>
                            </div>
                        </div>
                        <div class="document image-documents"> 
                            <div class="document-content">
                                <div class="document-profile">                                                   
                                    <img src="<?php echo base_url('dist/images/portfolio4.jpg');?>" alt="avatar" class="user-image img-fluid">
                                    <div class="document-info">
                                        <p class="document-name mb-0">portfolio4.jpg</p>                                                   
                                    </div>
                                </div>
                                <div class="document-email">
                                    <p class="mb-0 small">Size:  </p>
                                    <p class="user-email">59.5kb</p>
                                </div>

                                <div class="document-phone">
                                    <p class="mb-0 small">Date Added: </p>
                                    <p class="user-phone">29 June 2020</p>
                                </div>
                                <div class="line-h-1 h5">
                                    <a class="text-success edit-document" href="#" data-toggle="modal" data-target="#"><i class="icon-pencil"></i></a>
                                    <a class="text-danger delete-document" href="#"><i class="icon-trash"></i></a>                                 
                                </div>
                            </div>
                        </div>
                        <div class="document image-documents"> 
                            <div class="document-content">
                                <div class="document-profile">                                                   
                                    <img src="<?php echo base_url('dist/images/portfolio5.jpg');?>" alt="avatar" class="user-image img-fluid">
                                    <div class="document-info">
                                        <p class="document-name mb-0">portfolio5.jpg</p>                                                   
                                    </div>
                                </div>
                                <div class="document-email">
                                    <p class="mb-0 small">Size:  </p>
                                    <p class="user-email">59.5kb</p>
                                </div>

                                <div class="document-phone">
                                    <p class="mb-0 small">Date Added: </p>
                                    <p class="user-phone">29 June 2020</p>
                                </div>
                                <div class="line-h-1 h5">
                                    <a class="text-success edit-document" href="#" data-toggle="modal" data-target="#"><i class="icon-pencil"></i></a>
                                    <a class="text-danger delete-document" href="#"><i class="icon-trash"></i></a>                                 
                                </div>
                            </div>
                        </div>



                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- END: Card DATA-->
<?= $this->endSection() ?>
<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/js/app.filemanager.js'); ?>"></script>  
<!-- END: Page JS-->
<?= $this->endSection() ?>