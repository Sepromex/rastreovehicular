<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">Google Map</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Map</li>
                    <li class="breadcrumb-item active"><a href="#">Google</a></li>
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
                    <h4 class="card-title">Iframe</h4>
                </div>
                <div class="card-body">                               
                    <iframe class="w-100 height-350 border-0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3105.457742418827!2d-77.00662848481065!3d38.89064655494741!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89b7b828d32c69bb%3A0xffb704728ee19592!2sSupreme%20Court%20of%20the%20United%20States!5e0!3m2!1sen!2sin!4v1575976537424!5m2!1sen!2sin"  allowfullscreen=""></iframe>
                </div>
            </div>

        </div>
        <div class="col-12  mt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h4 class="card-title">Marker</h4>
                </div>
                <div class="card-body">                               
                    <div id="marker" class="w-100 height-350"></div>
                </div>
            </div>

        </div>
        <div class="col-12  mt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h4 class="card-title">Marker Clustering</h4>
                </div>
                <div class="card-body">                               
                    <div id="marker_clustering" class="w-100 height-350"></div>
                </div>
            </div>

        </div>

    </div>
    <!-- END: Card DATA-->
<?= $this->endSection() ?>
<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="<?php echo base_url('dist/js/googlemap.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>

