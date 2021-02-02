<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Select2</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">UI</li>
                <li class="breadcrumb-item active"><a href="#">Select2</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END: Breadcrumbs-->

<!-- START: Card Data-->
<div class="row">
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Select2 single select</h4> 
            </div>
            <div class="card-body">
                <select>
                    <option label="Choose on thing">Choose on thing</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>                                
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Select2 multi select</h4> 
            </div>
            <div class="card-body">
                <select multiple  data-allow-clear="1">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>                                
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Example of disabled select</h4> 
            </div>
            <div class="card-body">
                <select disabled>
                </select>
            </div>                                
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Example of select with optgroup</h4> 
            </div>
            <div class="card-body">
                <select>
                    <option label="Choose on thing">Choose on thing</option>
                    <optgroup label="Group A">
                        <option>A1</option>
                        <option>A2</option>
                        <option>A3</option>
                    </optgroup>
                    <optgroup label="Group B">
                        <option>B1</option>
                        <option>B2</option>
                        <option>B3</option>
                    </optgroup>
                </select>
            </div>                                
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Example of input-group</h4> 
            </div>
            <div class="card-body">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Prepend</span>
                    </div>
                    <select>
                        <option label="Choose on thing">Choose on thing</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                </div>
                <div class="input-group mt-2">
                    <select>
                        <option label="Choose on thing">Choose on thing</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                    <div class="input-group-append">
                        <span class="input-group-text">Append</span>
                    </div>
                </div>
                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Prepend</span>
                    </div>
                    <select>
                        <option label="Choose on thing">Choose on thing</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                    <div class="input-group-append">
                        <span class="input-group-text">Append</span>
                    </div>
                </div>
            </div>                                
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Example of validated select</h4> 
            </div>
            <div class="card-body">
                <select  class="form-control is-invalid">
                    <option label="Invalid Example"></option>
                </select>
                <div class="invalid-feedback">
                    Something is wrong.
                </div>
            </div>                                
        </div>
    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>
<?= $this->section('pagestyles') ?>
<!-- START: Page CSS-->
<link rel="stylesheet"  href="<?php echo base_url('dist/vendors/select2/css/select2.min.css'); ?>">
<link rel="stylesheet"  href="<?php echo base_url('dist/vendors/select2/css/select2-bootstrap.min.css'); ?>">
<!-- END: Page CSS-->
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/select2/js/select2.full.min.js'); ?>"></script>
<script src="<?php echo base_url('dist/js/select2.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>


