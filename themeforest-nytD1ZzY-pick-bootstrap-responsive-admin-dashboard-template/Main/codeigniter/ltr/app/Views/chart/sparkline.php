<?= $this->extend('layouts/admin') ?>


<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Sparkline Chart</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Chart</li>
                <li class="breadcrumb-item active"><a href="#">Sparkline</a></li>
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
                <h6 class="card-title">Bar Chart</h6>                                    
            </div>
            <div class="card-body text-center">  
                <div class="row">
                    <div class="col-12 col-lg-6 mb-3"> <span class="sparkbar">10,8,9,3,5,8,5</span></div>
                    <div class="col-12 col-lg-6">  <span class="sparkbar ml-3">0:2,2:4,4:2,4:1</span></div>    
                </div> 
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Line Chart</h6>                                    
            </div>
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12 col-lg-6 mb-3"> <span class="sparkline">8,4,0,0,0,0,1,4,4,10,10,10,10,0,0,0,4,6,5,9,10</span></div>
                    <div class="col-12 col-lg-6"> <span class="sparkline2">8,4,0,0,0,0,1,4,4,10,10,10,10,0,0,0,4,6,5,9,10</span></div>    
                </div>

            </div>

        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Area Chart</h6>                                    
            </div>
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12 col-lg-6 mb-3"> <span class="areachart">8,4,0,0,0,0,1,4,4,10,10,10,10,0,0,0,4,6,5,9,10</span></div>
                    <div class="col-12 col-lg-6"> <span class="areachart2">8,4,0,0,0,0,1,4,4,10,10,10,10,0,0,0,4,6,5,9,10</span></div>    
                </div>

            </div>

        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h4 class="card-title">Pie Chart</h4>                                    
            </div>
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12 col-lg-6 mb-3"> <span class="piechart">8,4,6,5,9,10</span></div>
                    <div class="col-12 col-lg-6"> <span class="piechart2">8,4,6,5,9,10</span></div>    
                </div>

            </div>

        </div>
    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/jquery-sparkline/jquery.sparkline.min.js'); ?>"></script>
<script src="<?php echo base_url('dist/js/sparkline.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>