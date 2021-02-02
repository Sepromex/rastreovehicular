<?= $this->extend('layouts/admin') ?>


<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">eChart</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Chart</li>
                <li class="breadcrumb-item active"><a href="#">eChart</a></li>
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
                <h6 class="card-title">Basic Line Chart</h6>                                   
            </div>
            <div class="card-body">                                   
                <div id="e-basic-line" class="height-300"></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Bar Chart</h6>                                   
            </div>
            <div class="card-body">                                        
                <div id="e-basic-bar" class="height-300"></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Doughnut Chart</h6>                                   
            </div>
            <div class="card-body">                                      
                <div id="e-doughnut-chart" class="height-300"></div>
            </div>
        </div>
    </div>                    
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Bubble Chart</h6>                                   
            </div>
            <div class="card-body">                                      
                <div id="e-bubble-chart" class="height-300"></div>
            </div>
        </div>
    </div>                    
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Radar Chart</h6>                                   
            </div>
            <div class="card-body">                                      
                <div id="e-radar-chart" class="height-500"></div>
            </div>
        </div>
    </div>   
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/echarts/echarts.min.js'); ?>"></script>
<script src="<?php echo base_url('dist/js/echart.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>