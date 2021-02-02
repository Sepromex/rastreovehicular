<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">Toastr Alert</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">UI</li>
                    <li class="breadcrumb-item active"><a href="#">Toastr Alert</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">                               
                    <h4 class="card-title">TOASTR ALERT</h4> 
                </div>
                <div class="card-body">
                    <div class="text-center float-e-margins">
                        <p>toastr is a Javascript library for Gnome / Growl type non-blocking notifications. jQuery is required. The goal is to create a simple core library that can be customized and extended</p>
                        <div class="m c-white mb-5">Use toastr to display a toast for info, success, warning or error</div>
                        <button class="homerDemo3 btn btn-warning">Warning</button>
                        <button class="homerDemo1 btn btn-info">Info</button>
                        <button class="homerDemo2 btn btn-success">Success</button>
                        <button class="homerDemo4 btn btn-danger">Error</button>
                    </div>
                </div>                                
            </div>
        </div>    
    </div>
    <!-- END: Card DATA-->
<?= $this->endSection() ?>
<?= $this->section('pagestyles') ?>
<!-- START: Page CSS-->
<link rel="stylesheet"  href="<?php echo base_url('dist/vendors/toastr/toastr.min.css'); ?>">
<!-- END: Page CSS-->
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/toastr/toastr.min.js'); ?>"></script>
<script src="<?php echo base_url('dist/js/toastr.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>



