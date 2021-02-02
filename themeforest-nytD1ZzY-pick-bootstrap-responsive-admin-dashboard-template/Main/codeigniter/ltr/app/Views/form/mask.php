<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">Form Mask</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Form</li>
                    <li class="breadcrumb-item active"><a href="#">Mask</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">                               
                            <h4 class="card-title">Masked Input</h4>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="text" data-masked="" data-inputmask="'mask': '999-99-999-9999-9'" placeholder="ISBN" class="form-control">
                                        <span>data-inputmask="'mask': '999-99-999-9999-9"'</span>
                                    </div>
                                </div> 
                                <div class="col-12 ">
                                    <div class="form-group">
                                        <input type="text" data-masked="" data-inputmask="'mask': '99/99/9999'" placeholder="Date" class="form-control">
                                        <span>data-inputmask="'mask': '99/99/9999"'</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="text" data-masked="" data-inputmask="'mask': '(999) 999-9999'" placeholder="Phone number" class="form-control">
                                        <span>data-inputmask="'mask': '(999) 999-9999"'</span>
                                    </div>
                                </div> 
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="text" data-masked="" data-inputmask="'mask': 'aaaa-9999-aa99-9999'" placeholder="Custom Key" class="form-control">
                                        <span>data-inputmask="'mask': 'aaaa-9999-aa99-9999"'</span>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" data-masked="" data-inputmask="'mask': '$ 999.999.999,99'" placeholder="Currency Dolar" class="form-control">
                                        <span>data-inputmask="'mask': '$ 999.999.999,99"'</span>
                                    </div>
                                </div> 
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="text" data-masked="" data-inputmask="'mask': '€ 999.999.999,99'" placeholder="Currency Euro" class="form-control">
                                        <span>data-inputmask="'mask': '€ 999.999.999,99"'</span>
                                    </div>
                                </div>
                            </div>




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
<script src="<?php echo base_url('dist/vendors/jquery-inputmask/jquery.inputmask.min.js'); ?>"></script>
<script src="<?php echo base_url('dist/js/inputmask.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>

