<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">Blog List</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Blog</li>
                    <li class="breadcrumb-item active"><a href="#">List</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row mt-3">
        <div class="col-12 col-sm-12">
            <div class="row mb-5">
                <div class="col-12 col-sm-6 col-xl-4 mb-4">
                    <div class="card redial-border-light redial-shadow">
                        <img class="img-fluid rounded-top" src="<?php echo base_url('dist/images/blog1.jpg');?>" alt="">
                        <div class="card-body">
                            <h4 class="card-title">Heading</h4>    
                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis.
                            <div class="clearfix"></div>
                            <a href="#" class="btn btn-primary mt-2">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4 mb-4">
                    <div class="card redial-border-light redial-shadow">
                        <img class="img-fluid rounded-top" src="<?php echo base_url('dist/images/blog2.jpg');?>" alt="">
                        <div class="card-body">
                            <h4 class="card-title">Heading</h4>    
                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis.
                            <div class="clearfix"></div>
                            <a href="#" class="btn btn-primary mt-2">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4 mb-4">
                    <div class="card redial-border-light redial-shadow">
                        <img class="img-fluid rounded-top" src="<?php echo base_url('dist/images/blog3.jpg');?>" alt="">
                        <div class="card-body">
                            <h4 class="card-title">Heading</h4>    
                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis.
                            <div class="clearfix"></div>
                            <a href="#" class="btn btn-primary mt-2">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4 mb-4 mb-md-0">
                    <div class="card redial-border-light redial-shadow">
                        <img class="img-fluid rounded-top" src="<?php echo base_url('dist/images/blog4.jpg');?>" alt="">
                        <div class="card-body">
                            <h4 class="card-title">Heading</h4>    
                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis.
                            <div class="clearfix"></div>
                            <a href="#" class="btn btn-primary mt-2">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4 mb-4 mb-sm-0">
                    <div class="card redial-border-light redial-shadow">
                        <img class="img-fluid rounded-top" src="<?php echo base_url('dist/images/blog5.jpg');?>" alt="">
                        <div class="card-body">
                            <h4 class="card-title">Heading</h4>    
                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis.
                            <div class="clearfix"></div>
                            <a href="#" class="btn btn-primary mt-2">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="card redial-border-light redial-shadow">
                        <img class="img-fluid rounded-top" src="<?php echo base_url('dist/images/blog6.jpg');?>" alt="">
                        <div class="card-body">
                            <h4 class="card-title">Heading</h4>    
                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis.
                            <div class="clearfix"></div>
                            <a href="#" class="btn btn-primary mt-2">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12">
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true"><<</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">>></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Card DATA-->
<?= $this->endSection() ?>


