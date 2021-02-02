<?= $this->extend('layouts/admin') ?>


<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Knob Chart</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Chart</li>
                <li class="breadcrumb-item active"><a href="#">Knob</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END: Breadcrumbs-->

<!-- START: Card Data-->
<div class="row">
    <div class="col-12 col-md-4 mt-3">
        <div class="card">

            <div class="card-body text-center">   
                <h6 class="font-weight-bold">Disable display input</h6>                                
                <input class="knob" data-width="200" data-fgColor="#0bb2d4" data-bgColor="#292b3a" data-displayInput=false value="35">
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4 mt-3">
        <div class="card">                           
            <div class="card-body  text-center">  
                <h6 class="font-weight-bold">Cursor mode</h6>
                <input class="knob" data-width="200" data-cursor=true data-fgColor="#0bb2d4" data-bgColor="#292b3a" data-thickness=.3 value="29">
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4 mt-3">
        <div class="card">                           
            <div class="card-body text-center">   
                <h6 class="font-weight-bold">Display previous value</h6>
                <input class="knob" data-width="200" data-min="-100" data-fgColor="#0bb2d4" data-bgColor="#292b3a" data-displayPrevious=true value="44">
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4 mt-3">
        <div class="card">                           
            <div class="card-body text-center">  
                <h6 class="font-weight-bold">Angle offset</h6>
                <input class="knob" data-angleOffset=90 data-linecap=round value="35" data-width="200"  data-fgColor="#0bb2d4" data-bgColor="#292b3a">
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4 mt-3">
        <div class="card">                           
            <div class="card-body text-center">    
                <h6 class="font-weight-bold">Angle offset and arc</h6>
                <input class="knob" data-angleOffset=-125 data-angleArc=250 data-fgColor="#66EE66" data-bgColor="#292b3a" data-rotation="anticlockwise" value="35">
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4 mt-3">
        <div class="card">                           
            <div class="card-body text-center"> 
                <h6 class="font-weight-bold">4-digit, step 0.1</h6>
                <input class="knob" data-min="-10000" data-displayPrevious=true data-max="10000" data-fgColor="#66EE66" data-bgColor="#292b3a" data-step=".1" value="0">
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4 mt-3">
        <div class="card">                           
            <div class="card-body text-center"> 
                <h6 class="font-weight-bold">Overloaded 'draw' method</h6>
                <input class="knob" data-width="200" data-displayPrevious=true data-fgColor="#0bb2d4" data-skin="tron" data-thickness=".2" value="75">
            </div>
        </div>
    </div>                    
    <div class="col-12 col-md-4 mt-3">
        <div class="card">                           
            <div class="card-body text-center"> 
                <h6 class="font-weight-bold">Readonly</h6>
                <input class="knob" data-fgColor="chartreuse" data-thickness=".4" readonly value="22">                                
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4 mt-3">
        <div class="card">                           
            <div class="card-body text-center"> 
                <h6 class="font-weight-bold">Infinite || iPod click wheel</h6>
                <input class="infinite" value="0" data-width="200" data-thickness=".5" data-fgColor="#0bb2d4"  data-displayInput="false" data-cursor=true>                               
            </div>
        </div>
    </div> 
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/jquery-knob/jquery.knob.min.js'); ?>"></script>
<script src="<?php echo base_url('dist/js/knob.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>