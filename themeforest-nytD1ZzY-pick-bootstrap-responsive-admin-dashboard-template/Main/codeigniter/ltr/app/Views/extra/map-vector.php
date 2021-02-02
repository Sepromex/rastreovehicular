<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">Vector Map</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Map</li>
                    <li class="breadcrumb-item active"><a href="#">Vector</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12  mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h4 class="card-title">World map</h4>
                </div>
                <div class="card-body">   
                    <div id="world-map-gdp" class="w-100 height-350" style="height: 500px"></div>
                </div>
            </div>

        </div>
        <div class="col-12  mt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h4 class="card-title">Markers on the world map</h4>
                </div>
                <div class="card-body">                               
                    <div id="world-map-markers" class="w-100 height-350" style="height: 500px"></div>
                </div>
            </div>

        </div>
        <div class="col-12  mt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h4 class="card-title">Regions selection</h4>
                </div>
                <div class="card-body">                               
                    <div id="map-region" class="w-100 height-350" style="height: 500px"></div>
                </div>
            </div>

        </div>
        <div class="col-12  mt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h4 class="card-title">Region labels</h4>
                </div>
                <div class="card-body">                               
                    <div id="map_region" class="w-100 height-350" style="height: 500px"></div>
                </div>
            </div>

        </div>
    </div>
    <!-- END: Card DATA-->
<?= $this->endSection() ?>
    <?= $this->section('pagestyles') ?>
<!-- START: Page CSS-->
<link rel="stylesheet"  href="<?php echo base_url('dist/vendors/jquery-jvectormap/jquery-jvectormap-2.0.3.css'); ?>">
<!-- END: Page CSS-->
<?= $this->endSection() ?>
<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/jquery-jvectormap/jquery-jvectormap-2.0.3.min.js'); ?>"></script>
<script src="<?php echo base_url('dist/vendors/jquery-jvectormap/jquery-jvectormap-world-mill.js'); ?>"></script>
<script src="<?php echo base_url('dist/vendors/jquery-jvectormap/jquery-jvectormap-de-merc.js'); ?>"></script>
<script src="<?php echo base_url('dist/vendors/jquery-jvectormap/jquery-jvectormap-us-aea.js'); ?>"></script>
<script src="<?php echo base_url('dist/js/jvectormap.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>

