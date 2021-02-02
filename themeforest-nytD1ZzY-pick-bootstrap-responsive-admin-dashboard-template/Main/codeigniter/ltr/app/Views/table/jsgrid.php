<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Jsgrid</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Table</li>
                <li class="breadcrumb-item active"><a href="#">Jsgrid</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END: Breadcrumbs-->

<!-- START: Card Data-->
<div class="row">
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Basic Scenario</h4> 
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="jsGrid"></div>
                </div>
            </div>
        </div> 

    </div>
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Sorting Scenario</h4> 
            </div>
            <div class="card-body">

                <div class="sort-panel">
                    <div class="form-group row">
                        <label for="sortingField" class="col-sm-1 col-form-label">Sorting:</label>
                        <div class="col-sm-2 d-flex">
                            <select id="sortingField" class="form-control">
                                <option>Name</option>
                                <option>Age</option>
                                <option>Address</option>
                                <option>Country</option>
                                <option>Married</option>
                            </select>
                            <button type="button" class="btn btn-primary ml-2" id="sort">Sort</button>
                        </div>

                    </div>

                </div>
                <div id="jsGridSorting"></div>

            </div>
        </div> 

    </div>
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Loading Data by Page Scenario</h4> 
            </div>
            <div class="card-body">

                <div class="pager-panel">
                    <div class="form-group row">
                        <label for="pager" class="col-sm-1 col-form-label">Sorting :</label>
                        <div class="col-sm-2">
                            <select id="pager" class="form-control">
                                <option>Name</option>
                                <option selected>Age</option>
                                <option>Address</option>
                            </select>
                        </div>

                    </div>

                </div>
                <div id="jsGridSortpage"></div>

            </div>
        </div> 

    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>


<?= $this->section('pagestyles') ?>
<!-- START: Page CSS-->
<link rel="stylesheet"  href="<?php echo base_url('dist/vendors/jsgrid/jsgrid.min.css'); ?>">
<link rel="stylesheet"  href="<?php echo base_url('dist/vendors/jsgrid/jsgrid-theme.css'); ?>">
<!-- END: Page CSS-->
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/jsgrid/jsgrid.min.js'); ?>"></script> 
<script src="<?php echo base_url('dist/vendors/jsgrid/db.js'); ?>"></script>
<script src="<?php echo base_url('dist/js/jsgrid.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>

