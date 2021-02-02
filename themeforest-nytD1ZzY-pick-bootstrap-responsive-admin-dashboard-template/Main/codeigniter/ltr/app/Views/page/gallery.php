<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">Gallery</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Page</li>
                    <li class="breadcrumb-item active"><a href="#">Gallery</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12  mt-3">                          
            <div class="card"> 

                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <ul class="filter p-0">
                                <li class="d-inline-block"><a class="filter-button active" href="#" data-group="all">All</a></li>
                                <li class="d-inline-block"><a href="#" class="filter-button" data-group="Branding">Branding</a></li>
                                <li class="d-inline-block"><a href="#" class="filter-button" data-group="Designing">Designing</a></li>
                                <li class="d-inline-block"><a href="#" class="filter-button" data-group="Photography">Photography</a></li>
                                <li class="d-inline-block"><a href="#" class="filter-button" data-group="Development">Development</a></li>
                            </ul>
                        </div> 
                        <div class="clearfix"></div>
                    </div>
                    <div id="grid" class="row">
                        <div class="item col-12 col-md-6 col-lg-4 mb-4 text-center Branding">                                       
                            <img src="<?php echo base_url('dist/images/portfolio1.jpg');?>" alt="" class="portfolioImage img-fluid">
                            <div class="d-flex">
                                <a data-fancybox-group="gallery" href="<?php echo base_url('dist/images/portfolio1.jpg');?>" class="fancybox btn rounded-0 btn-dark w-50">View Large</a>
                                <a href="#" class="btn btn-primary rounded-0 w-50">More Details</a>                                                   
                            </div>

                        </div>
                        <div class="item col-12 col-md-6 col-lg-4 mb-4 cation-hover text-center Designing">
                            <div class="modImage">
                                <img src="<?php echo base_url('dist/images/portfolio2.jpg');?>" alt="" class="portfolioImage img-fluid">
                                <div class="d-flex">
                                    <a data-fancybox-group="gallery" href="<?php echo base_url('dist/images/portfolio2.jpg');?>" class="fancybox btn rounded-0 btn-dark w-50">View Large</a>
                                    <a href="#" class="btn btn-primary rounded-0 w-50">More Details</a>                                                   
                                </div>
                            </div>
                        </div>
                        <div class="item col-12 col-md-6 col-lg-4 mb-4 cation-hover text-center Photography">
                            <div class="modImage">
                                <img src="<?php echo base_url('dist/images/portfolio3.jpg');?>" alt="" class="portfolioImage img-fluid">
                                <div class="d-flex">
                                    <a data-fancybox-group="gallery" href="<?php echo base_url('dist/images/portfolio3.jpg');?>" class="fancybox btn rounded-0 btn-dark w-50">View Large</a>
                                    <a href="#" class="btn btn-primary rounded-0 w-50">More Details</a>                                                   
                                </div>
                            </div>
                        </div>
                        <div class="item col-12 col-md-6 col-lg-4 mb-4 cation-hover text-center Development">
                            <div class="modImage">
                                <img src="<?php echo base_url('dist/images/portfolio4.jpg');?>" alt="" class="portfolioImage img-fluid">
                                <div class="d-flex">
                                    <a data-fancybox-group="gallery" href="<?php echo base_url('dist/images/portfolio4.jpg');?>" class="fancybox btn rounded-0 btn-dark w-50">View Large</a>
                                    <a href="#" class="btn btn-primary rounded-0 w-50">More Details</a>                                                   
                                </div>
                            </div>
                        </div>
                        <div class="item col-12 col-md-6 col-lg-4 mb-4 cation-hover text-center Designing">
                            <div class="modImage">
                                <img src="<?php echo base_url('dist/images/portfolio5.jpg');?>" alt="" class="portfolioImage img-fluid">
                                <div class="d-flex">
                                    <a data-fancybox-group="gallery" href="<?php echo base_url('dist/images/portfolio5.jpg');?>" class="fancybox btn rounded-0 btn-dark w-50">View Large</a>
                                    <a href="#" class="btn btn-primary rounded-0 w-50">More Details</a>                                                   
                                </div>
                            </div>
                        </div>
                        <div class="item col-12 col-md-6 col-lg-4 mb-4 cation-hover text-center Photography">
                            <div class="modImage">
                                <img src="<?php echo base_url('dist/images/portfolio6.jpg');?>" alt="" class="portfolioImage img-fluid">
                                <div class="d-flex">
                                    <a data-fancybox-group="gallery" href="<?php echo base_url('dist/images/portfolio6.jpg');?>" class="fancybox btn rounded-0 btn-dark w-50">View Large</a>
                                    <a href="#" class="btn btn-primary rounded-0 w-50">More Details</a>                                                   
                                </div>
                            </div>
                        </div>

                        <div class="item col-12 col-md-6 col-lg-4 mb-4 cation-hover text-center Branding">
                            <div class="modImage">
                                <img src="<?php echo base_url('dist/images/portfolio13.jpg');?>" alt="" class="portfolioImage img-fluid">
                                <div class="d-flex">
                                    <a data-fancybox-group="gallery" href="<?php echo base_url('dist/images/portfolio13.jpg');?>" class="fancybox btn rounded-0 btn-dark w-50">View Large</a>
                                    <a href="#" class="btn btn-primary rounded-0 w-50">More Details</a>                                                   
                                </div>
                            </div>
                        </div>
                        <div class="item col-12 col-md-6 col-lg-4 mb-4 cation-hover text-center Designing">
                            <div class="modImage">
                                <img src="<?php echo base_url('dist/images/portfolio14.jpg');?>" alt="" class="portfolioImage img-fluid">
                                <div class="d-flex">
                                    <a data-fancybox-group="gallery" href="<?php echo base_url('dist/images/portfolio14.jpg');?>" class="fancybox btn rounded-0 btn-dark w-50">View Large</a>
                                    <a href="#" class="btn btn-primary rounded-0 w-50">More Details</a>                                                   
                                </div>
                            </div>
                        </div>
                        <div class="item col-12 col-md-6 col-lg-4 mb-4 cation-hover text-center Photography">
                            <div class="modImage">
                                <img src="<?php echo base_url('dist/images/portfolio15.jpg');?>" alt="" class="portfolioImage img-fluid">
                                <div class="d-flex">
                                    <a data-fancybox-group="gallery" href="<?php echo base_url('dist/images/portfolio15.jpg');?>" class="fancybox btn rounded-0 btn-dark w-50">View Large</a>
                                    <a href="#" class="btn btn-primary rounded-0 w-50">More Details</a>                                                   
                                </div>
                            </div>
                        </div>
                        <div class="item col-12 col-md-6 col-lg-4 mb-4 cation-hover text-center Development">
                            <div class="modImage">
                                <img src="<?php echo base_url('dist/images/portfolio16.jpg');?>" alt="" class="portfolioImage img-fluid">
                                <div class="d-flex">
                                    <a data-fancybox-group="gallery" href="<?php echo base_url('dist/images/portfolio16.jpg');?>" class="fancybox btn rounded-0 btn-dark w-50">View Large</a>
                                    <a href="#" class="btn btn-primary rounded-0 w-50">More Details</a>                                                   
                                </div>
                            </div>
                        </div>
                        <div class="item col-12 col-md-6 col-lg-4 mb-4 cation-hover text-center Designing">
                            <div class="modImage">
                                <img src="<?php echo base_url('dist/images/portfolio17.jpg');?>" alt="" class="portfolioImage img-fluid">
                                <div class="d-flex">
                                    <a data-fancybox-group="gallery" href="<?php echo base_url('dist/images/portfolio17.jpg');?>" class="fancybox btn rounded-0 btn-dark w-50">View Large</a>
                                    <a href="#" class="btn btn-primary rounded-0 w-50">More Details</a>                                                   
                                </div>
                            </div>
                        </div>
                        <div class="item col-12 col-md-6 col-lg-4 mb-4 cation-hover text-center Photography">
                            <div class="modImage">
                                <img src="<?php echo base_url('dist/images/portfolio18.jpg');?>" alt="" class="portfolioImage img-fluid">
                                <div class="d-flex">
                                    <a data-fancybox-group="gallery" href="<?php echo base_url('dist/images/portfolio18.jpg');?>" class="fancybox btn rounded-0 btn-dark w-50">View Large</a>
                                    <a href="#" class="btn btn-primary rounded-0 w-50">More Details</a>                                                   
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
<?= $this->section('pagestyles') ?>
<!-- START: Page CSS-->
<link rel="stylesheet"  href="<?php echo base_url('dist/vendors/fancybox/jquery.fancybox.min.css'); ?>">
<!-- END: Page CSS-->
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/fancybox/jquery.fancybox.min.js'); ?>"></script>
<script src="<?php echo base_url('dist/js/gallery.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>
