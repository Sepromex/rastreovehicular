<?= $this->extend('layouts/admin') ?>

<?= $this->section('pagestyles') ?>
<!-- START: Page CSS-->
<link rel="stylesheet"  href="<?php echo base_url('dist/vendors/chartjs/Chart.min.css'); ?>">
<!-- END: Page CSS-->
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Chartjs</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Chart</li>
                <li class="breadcrumb-item active"><a href="#">Chartjs</a></li>
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
                <h6 class="card-title">Scatter</h6>                                    
            </div>
            <div class="card-body text-center">                                                                
                <canvas id="chartjs-other-scatter" ></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Doughnut</h6>                                    
            </div>
            <div class="card-body text-center">                                                                
                <canvas id="chartjs-other-doughnut" ></canvas>
            </div>

        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Pie</h6>                                    
            </div>
            <div class="card-body text-center">                                                                
                <canvas id="chartjs-other-pie"></canvas>
            </div>

        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Polar</h6>                                    
            </div>
            <div class="card-body text-center">                                                                
                <canvas id="chartjs-other-polar"></canvas>
            </div>

        </div>
    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/chartjs/Chart.min.js'); ?>"></script>
<script src="<?php echo base_url('dist/js/chartjs.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>