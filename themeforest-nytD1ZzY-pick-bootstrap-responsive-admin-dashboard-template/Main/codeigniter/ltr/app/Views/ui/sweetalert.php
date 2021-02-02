<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Sweet Alert</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">UI</li>
                <li class="breadcrumb-item active"><a href="#">Sweet Alert</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END: Breadcrumbs-->

<!-- START: Card Data-->
<div class="row">
    <div class="col-12  mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Colors</h4> 
            </div>
            <div class="card-body">                                
                <div class="examples">
                    <button class="btn btn-lg btn-primary sweet-10 mb-2" >Primary</button>
                    <button class="btn btn-lg btn-info sweet-11 mb-2" >Info</button>
                    <button class="btn btn-lg btn-success sweet-12 mb-2">Success</button>
                    <button class="btn btn-lg btn-warning sweet-13 mb-2">Warning</button>
                    <button class="btn btn-lg btn-danger sweet-14 mb-2">Danger</button>
                </div>
            </div>                                
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Basic example</h4> 
            </div>
            <div class="card-body">                                
                <button class="btn btn-primary sweet-1">Try It</button>
            </div>                                
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">A title with a text under</h4> 
            </div>
            <div class="card-body">                                
                <button class="btn btn-primary sweet-2">Try It</button>
            </div>                                
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">A success message!</h4> 
            </div>
            <div class="card-body">                                
                <button class="btn btn-primary sweet-3">Try It</button>
            </div>                                
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">warning message</h4> 
            </div>
            <div class="card-body">                                
                <button class="btn btn-primary sweet-4">Try It</button>
            </div>                                
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">passing a parameter</h4> 
            </div>
            <div class="card-body">                                
                <button class="btn btn-primary sweet-5">Try It</button>
            </div>                                
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">message with a custom icon</h4> 
            </div>
            <div class="card-body">                                
                <button class="btn btn-primary sweet-6">Try It</button>
            </div>                                
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Alert Input</h4> 
            </div>
            <div class="card-body">                                
                <button class="btn btn-primary sweet-7">Try It</button>
            </div>                                
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">With a loader (for a AJAX requests)</h4> 
            </div>
            <div class="card-body">                                
                <button class="btn btn-primary sweet-8">Try It</button>
            </div>                                
        </div>
    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>
<?= $this->section('pagestyles') ?>
<!-- START: Page CSS-->
<link rel="stylesheet"  href="<?php echo base_url('dist/vendors/sweetalert/sweetalert.css'); ?>">
<!-- END: Page CSS-->
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/sweetalert/sweetalert.min.js'); ?>"></script>
<script src="<?php echo base_url('dist/js/sweetalert.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>


