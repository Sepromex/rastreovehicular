<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><span class="h4 my-auto">Form Typehead</span></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item" aria-current="page">Form</li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Typehead</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END: Breadcrumbs-->

<!-- START: Card Data-->
<div class="row">
    <div class="col-12 col-sm-6 mt-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h4 class="card-title">The Basics</h4>                                   
            </div>
            <div class="card-body">
                <div id="the-basics">
                    <input class="typeahead form-control rounded" type="text" placeholder="States of USA">
                </div>
            </div>
        </div> 

    </div>
    <div class="col-12 col-sm-6 mt-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h4 class="card-title">Bloodhound (Suggestion Engine)</h4>                                   
            </div>
            <div class="card-body">
                <div id="bloodhound">
                    <input class="typeahead form-control rounded" type="text" placeholder="States of USA">
                </div>
            </div>
        </div> 

    </div>   

</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/typeahead/handlebars-v4.5.3.js'); ?>"></script>
<script src="<?php echo base_url('dist/vendors/typeahead/typeahead.bundle.js'); ?>"></script>
<script src="<?php echo base_url('dist/js/typeahead.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>

