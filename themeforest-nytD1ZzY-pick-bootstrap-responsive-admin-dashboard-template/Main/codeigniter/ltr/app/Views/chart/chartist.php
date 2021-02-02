<?= $this->extend('layouts/admin') ?>

<?= $this->section('pagestyles') ?>
<!-- START: Page CSS-->
<link rel="stylesheet" href="<?php echo base_url('dist/vendors/chartist-js/chartist.min.css'); ?>"> 
<!-- END: Page CSS-->
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">Chartist Chart</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Chart</li>
                    <li class="breadcrumb-item active"><a href="#">Chartist</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12 col-md-6 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h6 class="card-title">SIMPLE LINE CHART</h6>                                   
                </div>
                <div class="card-body">                                   
                    <div class="ct-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h6 class="card-title">LINE CHART WITH AREA</h6>                                   
                </div>
                <div class="card-body">                                        
                    <div class="ct-area-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h6 class="card-title">BI-POLAR LINE CHART WITH AREA ONLY</h6>                                   
                </div>
                <div class="card-body">                                      
                    <div class="ct-bi-polar"></div>
                </div>
            </div>
        </div>                    
        <div class="col-12 col-md-6 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h6 class="card-title">ADVANCED SMIL ANIMATIONS</h6>                                   
                </div>
                <div class="card-body">                                      
                    <div class="ct-advance-slim"></div>
                </div>
            </div>
        </div>                    
        <div class="col-12 col-md-6 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h6 class="card-title">SVG PATH ANIMATION</h6>                                   
                </div>
                <div class="card-body">                                      
                    <div class="ct-svg-animation"></div>
                </div>
            </div>
        </div>                    
        <div class="col-12 col-md-6 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h6 class="card-title">OVERLAPPING BARS ON MOBILE</h6>                                   
                </div>
                <div class="card-body">                                      
                    <div class="ct-bar"></div>
                </div>
            </div>
        </div>                    
    </div>
    <!-- END: Card DATA-->
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/chartist-js/chartist.min.js'); ?>"></script>
<script src="<?php echo base_url('dist/js/chartist.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>