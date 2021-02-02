<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Form Elements</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Form</li>
                <li class="breadcrumb-item">Elements</li>
                <li class="breadcrumb-item active"><a href="#">Switch</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END: Breadcrumbs-->

<!-- START: Card Data-->
<div class="row row-eq-height">
    <div class="col-12 col-lg-6 mt-3">
        <div class="card h-100">
            <div class="card-header">                               
                <h4 class="card-title">Sizes</h4>                                
            </div>
            <div class="card-content">
                <div class="card-body">
                    <input type="checkbox" checked data-toggle="toggle" data-size="lg">
                    <input type="checkbox" checked data-toggle="toggle">
                    <input type="checkbox" checked data-toggle="toggle" data-size="sm">
                    <input type="checkbox" checked data-toggle="toggle" data-size="xs">
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 mt-3">
        <div class="card">
            <div class="card-header">                               
                <h4 class="card-title">Custom Sizes</h4>                                
            </div>
            <div class="card-content">
                <div class="card-body">
                    <input type="checkbox" checked data-toggle="toggle" data-width="100" data-height="75">
                    <input type="checkbox" checked data-toggle="toggle" data-height="75">
                    <input type="checkbox" checked data-toggle="toggle" data-width="100">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row row-eq-height">
    <div class="col-12 col-lg-6 mt-3">
        <div class="card h-100">
            <div class="card-header">                               
                <h4 class="card-title">Colors</h4>                                
            </div>
            <div class="card-content">
                <div class="card-body">
                    <input type="checkbox" checked data-toggle="toggle" data-onstyle="primary">
                    <input type="checkbox" checked data-toggle="toggle" data-onstyle="secondary">
                    <input type="checkbox" checked data-toggle="toggle" data-onstyle="success">
                    <input type="checkbox" checked data-toggle="toggle" data-onstyle="danger">
                    <input type="checkbox" checked data-toggle="toggle" data-onstyle="warning">
                    <input type="checkbox" checked data-toggle="toggle" data-onstyle="info">
                    <input type="checkbox" checked data-toggle="toggle" data-onstyle="light">
                    <input type="checkbox" checked data-toggle="toggle" data-onstyle="dark">
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 mt-3">
        <div class="card">
            <div class="card-header">                               
                <h4 class="card-title">Outline Colors</h4>                                
            </div>
            <div class="card-content">
                <div class="card-body">
                    <input type="checkbox" checked data-toggle="toggle" data-onstyle="outline-primary" data-offstyle="outline-primary">
                    <input type="checkbox" checked data-toggle="toggle" data-onstyle="outline-secondary" data-offstyle="outline-secondary">
                    <input type="checkbox" checked data-toggle="toggle" data-onstyle="outline-success" data-offstyle="outline-success">
                    <input type="checkbox" checked data-toggle="toggle" data-onstyle="outline-danger" data-offstyle="outline-danger">
                    <input type="checkbox" checked data-toggle="toggle" data-onstyle="outline-warning" data-offstyle="outline-warning">
                    <input type="checkbox" checked data-toggle="toggle" data-onstyle="outline-info" data-offstyle="outline-info">
                    <input type="checkbox" checked data-toggle="toggle" data-onstyle="outline-light" data-offstyle="outline-light">
                    <input type="checkbox" checked data-toggle="toggle" data-onstyle="outline-dark" data-offstyle="outline-dark">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row row-eq-height">
    <div class="col-12 col-lg-6 mt-3">
        <div class="card h-100">
            <div class="card-header">                               
                <h4 class="card-title">Custom Text</h4>                                
            </div>
            <div class="card-content">
                <div class="card-body">
                    <input type="checkbox" checked data-toggle="toggle" data-on="Ready" data-off="Not Ready" data-onstyle="success" data-offstyle="danger">
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 mt-3">
        <div class="card">
            <div class="card-header">                               
                <h4 class="card-title">HTML, Icons, Images</h4>                                
            </div>
            <div class="card-content">
                <div class="card-body">
                    <input type="checkbox" checked data-toggle="toggle" data-on="<i class='fa fa-play'></i> Play" data-off="<i class='fa fa-pause'></i> Pause">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>
<?= $this->section('pagestyles') ?>
<!-- START: Page CSS-->
<link rel="stylesheet"  href="<?php echo base_url('dist/vendors/bootstrap4-toggle/css/bootstrap4-toggle.min.css'); ?>">
<!-- END: Page CSS-->
<?= $this->endSection() ?>
<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/bootstrap4-toggle/js/bootstrap4-toggle.min.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>
