<?= $this->extend('layouts/admin') ?>


<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Peity Chart</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Chart</li>
                <li class="breadcrumb-item active"><a href="#">Peity</a></li>
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
                <div class="row text-center">
                    <div class="col-12 col-lg-6 my-2 px-4">
                        <span class="peity-bar" data-peity='{ "fill": ["#76c335"], "height": 120, "width": 150 }'>10,4,4,7,5,9,10,1,4,4,7,5,9,10</span>
                    </div>
                    <div class="col-12 col-lg-6 my-2 px-4">
                        <span class="peity-bar" data-peity='{ "fill": ["#17b3a3"], "height": 120, "width": 150 }'>10,4,4,7,5,9,10,1,4,4,7,5,9,10</span>
                    </div>
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
                <div class="row text-center">
                    <div class="col-12 col-lg-6 my-2 px-4">
                        <span class="peity-line" data-peity='{ "fill": false, "stroke": "#76c335", "height": 120, "width": 150 }'>10,4,4,7,5,9,10,1,4,4,7,5,9,10</span>
                    </div>
                    <div class="col-12 col-lg-6 my-2 px-4">
                        <span class="peity-line" data-peity='{ "fill": false, "stroke": "#17b3a3", "height": 120, "width": 150 }'>10,4,4,7,5,9,10,1,4,4,7,5,9,10</span>
                    </div>
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
                <div class="row text-center">
                    <div class="col-12 col-lg-6 my-2 px-4">
                        <span class="peity-line" data-peity='{ "fill": "rgba(0,123,255,.2)", "stroke": "#76c335", "height": 120, "width": 150 }'>10,4,4,7,5,9,10,1,4,4,7,5,9,10</span>
                    </div>
                    <div class="col-12 col-lg-6 my-2 px-4">
                        <span class="peity-line" data-peity='{ "fill": "rgba(241,0,117,.2)", "stroke": "#17b3a3", "height": 120, "width": 150 }'>10,4,4,7,5,9,10,1,4,4,7,5,9,10</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Pie and Donut</h6>                                    
            </div>
            <div class="card-body text-center">                                                                
                <div class="row text-center">
                    <div class="col-12 col-lg-6 my-2 px-4">
                        <span class="peity-pie" data-peity='{ "fill": ["#76c335","#17b3a3","#25B1DE"], "height": 120, "width": 150 }'>10,4,4</span>
                    </div>
                    <div class="col-12 col-lg-6 my-2 px-4">
                        <span class="peity-donut" data-peity='{ "fill": ["#76c335","#17b3a3","#25B1DE"], "height": 120, "width": 150 }'>10,4,4</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/jquery-peity/jquery.peity.min.js'); ?>"></script>
<script src="<?php echo base_url('dist/js/peity.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>