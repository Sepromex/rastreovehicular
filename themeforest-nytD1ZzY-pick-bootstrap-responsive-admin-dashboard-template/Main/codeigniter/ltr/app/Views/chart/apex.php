<?= $this->extend('layouts/admin') ?>


<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Apex Chart</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Chart</li>
                <li class="breadcrumb-item active"><a href="#">Apex</a></li>
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
                <h6 class="card-title">Line Chart</h6>                                    
            </div>
            <div class="card-body text-center">
                <div id="apex_line_chart" class="height-500"></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Area Chart</h6>                                    
            </div>
            <div class="card-body text-center">
                <div id="apex_area_chart" class="height-500"></div>
            </div>
        </div>
    </div>                    
    <div class="col-12 col-md-6 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Column Charts</h6>                                    
            </div>
            <div class="card-body text-center">
                <div id="apex_column_chart" class="height-500"></div>
            </div>
        </div>
    </div>  
    <div class="col-12 col-md-6 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Bar Chart</h6>                                    
            </div>
            <div class="card-body text-center">
                <div id="apex_bar_chart" class="height-500"></div>
            </div>
        </div>
    </div>   
    <div class="col-12 col-md-6 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Mixed Chart</h6>                                    
            </div>
            <div class="card-body text-center">
                <div id="apex_mixed_chart" class="height-500"></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Candlestick Charts</h6>                                    
            </div>
            <div class="card-body text-center">
                <div id="apex_candlestick_chart" class="height-500"></div>
            </div>
        </div>
    </div>                    
    <div class="col-12 col-md-6 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Pie Charts</h6>                                    
            </div>
            <div class="card-body text-center">
                <div id="apex_pie_chart" class="height-500"></div>
            </div>
        </div>
    </div>                    
    <div class="col-12 col-md-6 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Donut Charts</h6>                                    
            </div>
            <div class="card-body text-center">
                <div id="apex_donut_chart" class="height-500"></div>
            </div>
        </div>
    </div>                    
    <div class="col-12 col-md-6 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Radar Charts</h6>                                    
            </div>
            <div class="card-body text-center">
                <div id="apex_radar_chart" class="height-500"></div>
            </div>
        </div>
    </div>                    
    <div class="col-12 col-md-6 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Radial Bar Charts </h6>                                    
            </div>
            <div class="card-body text-center">
                <div id="apex_radial_chart" class="height-500"></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Bubble Charts </h6>                                    
            </div>
            <div class="card-body text-center">
                <div id="apex_bubble_chart" class="height-500"></div>
            </div>
        </div>
    </div>                    
    <div class="col-12 col-md-6 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Scatter Charts </h6>                                    
            </div>
            <div class="card-body text-center">
                <div id="apex_scatter_chart" class="height-500"></div>
            </div>
        </div>
    </div>                    
    <div class="col-12 mt-3">
        <div class="card">  
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Heatmap Charts </h6>                                    
            </div>
            <div class="card-body text-center">
                <div id="apex_heatmap_chart" class="height-500"></div>
            </div>
        </div>
    </div>     
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/apexcharts/apexcharts.min.js'); ?>"></script>
<script src="<?php echo base_url('dist/js/apex.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>