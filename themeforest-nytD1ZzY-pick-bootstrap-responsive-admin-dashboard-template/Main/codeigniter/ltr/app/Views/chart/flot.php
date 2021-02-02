<?= $this->extend('layouts/admin') ?>


<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">Flot Chart</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Chart</li>
                    <li class="breadcrumb-item active"><a href="#">Flot</a></li>
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
                    <h6 class="card-title">Basic Chart</h6>                                   
                </div>
                <div class="card-body">                                   
                    <div id="flot-basic" class="height-300"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h6 class="card-title">Pie Chart</h6>                                   
                </div>
                <div class="card-body">                                        
                    <div id="float-pie" class="height-300"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h6 class="card-title">Bar Chart</h6>                                   
                </div>
                <div class="card-body">                                      
                    <div id="flot-bar" class="height-300"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h6 class="card-title">Real-time Chart</h6>                                   
                </div>
                <div class="card-body">                                      
                    <div id="flot-real-time" class="height-300"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h6 class="card-title">Time Axes</h6>                                   
                </div>
                <div class="card-body">                                      
                    <div id="flot-time-axes" class="height-300"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h6 class="card-title">Stacking</h6>                                   
                </div>
                <div class="card-body">                                      
                    <div id="flot-stacking" class="height-300"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Card DATA-->
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/jquery-flot/jquery.canvaswrapper.js'); ?>"></script>
<script src="<?php echo base_url('dist/vendors/jquery-flot/jquery.colorhelpers.js'); ?>"></script>
<script src="<?php echo base_url('dist/vendors/jquery-flot/jquery.flot.js'); ?>"></script>
<script src="<?php echo base_url('dist/vendors/jquery-flot/jquery.flot.saturated.js'); ?>"></script>
<script src="<?php echo base_url('dist/vendors/jquery-flot/jquery.flot.browser.js'); ?>"></script>
<script src="<?php echo base_url('dist/vendors/jquery-flot/jquery.flot.drawSeries.js'); ?>"></script>
<script src="<?php echo base_url('dist/vendors/jquery-flot/jquery.flot.uiConstants.js'); ?>"></script>
<script src="<?php echo base_url('dist/vendors/jquery-flot/jquery.flot.legend.js'); ?>"></script>
<script src="<?php echo base_url('dist/vendors/jquery-flot/jquery.flot.pie.js'); ?>"></script>
<script src="<?php echo base_url('dist/vendors/jquery-flot/jquery.flot.categories.js'); ?>"></script>
<script src="<?php echo base_url('dist/vendors/jquery-flot/jquery.flot.time.js'); ?>"></script>
<script src="<?php echo base_url('dist/vendors/jquery-flot/jquery.flot.crosshair.js'); ?>"></script>       
<script src="<?php echo base_url('dist/js/flot.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>