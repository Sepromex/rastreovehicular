<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Form iCheck</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Form</li>
                <li class="breadcrumb-item active"><a href="#">iCheck</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END: Breadcrumbs-->

<!-- START: Card Data-->
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="row">

            <div class="col-12 col-md-6 mt-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">                               
                        <h4 class="card-title">Minimal skin</h4>
                    </div>
                    <div class="card-body">                                       

                        <div class="skin skin-minimal">    


                            <ul class="list list-unstyled mr-3">
                                <li>
                                    <input tabindex="5" type="checkbox" id="minimal-checkbox-1">
                                    <label for="minimal-checkbox-1">Checkbox 1</label>
                                </li>
                                <li>
                                    <input tabindex="6" type="checkbox" id="minimal-checkbox-22" checked>
                                    <label for="minimal-checkbox-22">Checkbox 2</label>
                                </li>
                                <li>
                                    <input type="checkbox" id="minimal-checkbox-disabled" disabled>
                                    <label for="minimal-checkbox-disabled">Disabled</label>
                                </li>
                                <li>
                                    <input type="checkbox" id="minimal-checkbox-disabled-checked" checked disabled>
                                    <label for="minimal-checkbox-disabled-checked">Disabled &amp; checked</label>
                                </li>
                            </ul>
                            <ul class="list list-unstyled  mr-3">
                                <li>
                                    <input tabindex="7" type="radio" id="minimal-radio-13" name="minimal-radio">
                                    <label for="minimal-radio-13">Radio button 1</label>
                                </li>
                                <li>
                                    <input tabindex="8" type="radio" id="minimal-radio-23" name="minimal-radio" checked>
                                    <label for="minimal-radio-23">Radio button 2</label>
                                </li>
                                <li>
                                    <input type="radio" id="minimal-radio-disabled" disabled>
                                    <label for="minimal-radio-disabled">Disabled</label>
                                </li>
                                <li>
                                    <input type="radio" id="minimal-radio-disabled-checked" checked disabled>
                                    <label for="minimal-radio-disabled-checked">Disabled &amp; checked</label>
                                </li>
                            </ul>


                            <ul class="list list-unstyled">
                                <li>
                                    <div class="state icheckbox_minimal"></div>
                                    <div class="state iradio_minimal"></div>
                                    Normal
                                </li>
                                <li>
                                    <div class="state icheckbox_minimal hover"></div>
                                    <div class="state iradio_minimal hover"></div>
                                    Hover
                                </li>
                                <li>
                                    <div class="state icheckbox_minimal checked"></div>
                                    <div class="state iradio_minimal checked"></div>
                                    Checked
                                </li>
                                <li>
                                    <div class="state icheckbox_minimal disabled"></div>
                                    <div class="state iradio_minimal disabled"></div>
                                    Disabled
                                </li>
                                <li>
                                    <div class="state icheckbox_minimal checked disabled"></div>
                                    <div class="state iradio_minimal checked disabled"></div>
                                    Disabled &amp; checked
                                </li>
                            </ul>


                        </div>              

                    </div>
                </div> 
            </div>
            <div class="col-12 col-md-6 mt-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">                               
                        <h4 class="card-title">Square skin</h4>
                    </div>
                    <div class="card-body">                                       

                        <div class="skin skin-square ">    


                            <ul class="list list-unstyled mr-3">
                                <li>
                                    <input tabindex="5" type="checkbox" id="minimal-checkbox-11">
                                    <label for="minimal-checkbox-11">Checkbox 1</label>
                                </li>
                                <li>
                                    <input tabindex="6" type="checkbox" id="minimal-checkbox-21" checked>
                                    <label for="minimal-checkbox-21">Checkbox 2</label>
                                </li>
                                <li>
                                    <input type="checkbox" id="minimal-checkbox-disabled1" disabled>
                                    <label for="minimal-checkbox-disabled1">Disabled</label>
                                </li>
                                <li>
                                    <input type="checkbox" id="minimal-checkbox-disabled-checked1" checked disabled>
                                    <label for="minimal-checkbox-disabled-checked1">Disabled &amp; checked</label>
                                </li>
                            </ul>
                            <ul class="list list-unstyled  mr-3">
                                <li>
                                    <input tabindex="7" type="radio" id="minimal-radio-12" name="minimal-radio">
                                    <label for="minimal-radio-12">Radio button 1</label>
                                </li>
                                <li>
                                    <input tabindex="8" type="radio" id="minimal-radio-22" name="minimal-radio" checked>
                                    <label for="minimal-radio-22">Radio button 2</label>
                                </li>
                                <li>
                                    <input type="radio" id="minimal-radio-disabled1" disabled>
                                    <label for="minimal-radio-disabled1">Disabled</label>
                                </li>
                                <li>
                                    <input type="radio" id="minimal-radio-disabled-checked1" checked disabled>
                                    <label for="minimal-radio-disabled-checked1">Disabled &amp; checked</label>
                                </li>
                            </ul>

                            <ul class="list list-unstyled">
                                <li class="mb-2">
                                    <div class="state icheckbox_square-red"></div>
                                    <div class="state iradio_square-red"></div>
                                    Normal
                                </li>
                                <li class="mb-2">
                                    <div class="state icheckbox_square-red hover"></div>
                                    <div class="state iradio_square-red hover"></div>
                                    Hover
                                </li>
                                <li class="mb-2">
                                    <div class="state icheckbox_square-red checked"></div>
                                    <div class="state iradio_square-red checked"></div>
                                    Checked
                                </li>
                                <li class="mb-2">
                                    <div class="state icheckbox_square-red disabled"></div>
                                    <div class="state iradio_square-red disabled"></div>
                                    Disabled
                                </li>
                                <li class="mb-2">
                                    <div class="state icheckbox_square-red checked disabled"></div>
                                    <div class="state iradio_square-red checked disabled"></div>
                                    Disabled &amp; checked
                                </li>
                            </ul>

                        </div>              

                    </div>
                </div> 
            </div>
            <div class="col-12 col-md-6 mt-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">                               
                        <h4 class="card-title">Flat skin</h4>
                    </div>
                    <div class="card-body">                                       

                        <div class="skin skin-flat">    


                            <ul class="list list-unstyled mr-3">
                                <li>
                                    <input tabindex="5" type="checkbox" id="minimal-checkbox-12">
                                    <label for="minimal-checkbox-12">Checkbox 1</label>
                                </li>
                                <li>
                                    <input tabindex="6" type="checkbox" id="minimal-checkbox-2" checked>
                                    <label for="minimal-checkbox-2">Checkbox 2</label>
                                </li>
                                <li>
                                    <input type="checkbox" id="minimal-checkbox-disabled2" disabled>
                                    <label for="minimal-checkbox-disabled2">Disabled</label>
                                </li>
                                <li>
                                    <input type="checkbox" id="minimal-checkbox-disabled-checked2" checked disabled>
                                    <label for="minimal-checkbox-disabled-checked2">Disabled &amp; checked</label>
                                </li>
                            </ul>
                            <ul class="list list-unstyled  mr-3">
                                <li>
                                    <input tabindex="7" type="radio" id="minimal-radio-11" name="minimal-radio">
                                    <label for="minimal-radio-11">Radio button 1</label>
                                </li>
                                <li>
                                    <input tabindex="8" type="radio" id="minimal-radio-21" name="minimal-radio" checked>
                                    <label for="minimal-radio-21">Radio button 2</label>
                                </li>
                                <li>
                                    <input type="radio" id="minimal-radio-disabled2" disabled>
                                    <label for="minimal-radio-disabled2">Disabled</label>
                                </li>
                                <li>
                                    <input type="radio" id="minimal-radio-disabled-checked2" checked disabled>
                                    <label for="minimal-radio-disabled-checked2">Disabled &amp; checked</label>
                                </li>
                            </ul>

                            <ul class="list list-unstyled">
                                <li class="mb-2">
                                    <div class="state icheckbox_flat-green"></div>
                                    <div class="state iradio_flat-green"></div>
                                    Normal
                                </li>
                                <li class="mb-2">
                                    <div class="state icheckbox_flat-green hover"></div>
                                    <div class="state iradio_flat-green hover"></div>
                                    Hover
                                </li>
                                <li class="mb-2">
                                    <div class="state icheckbox_flat-green checked"></div>
                                    <div class="state iradio_flat-green checked"></div>
                                    Checked
                                </li>
                                <li class="mb-2">
                                    <div class="state icheckbox_flat-green disabled"></div>
                                    <div class="state iradio_flat-green disabled"></div>
                                    Disabled
                                </li>
                                <li class="mb-2">
                                    <div class="state icheckbox_flat-green checked disabled"></div>
                                    <div class="state iradio_flat-green checked disabled"></div>
                                    Disabled &amp; checked
                                </li>
                            </ul>

                        </div>              

                    </div>
                </div> 
            </div>
            <div class="col-12 col-md-6 mt-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">                               
                        <h4 class="card-title">Line skin</h4>
                    </div>
                    <div class="card-body">                                       

                        <div class="skin skin-line">    


                            <ul class="list list-unstyled mr-3">
                                <li>
                                    <input tabindex="17" type="checkbox" id="line-checkbox-1">
                                    <label for="line-checkbox-1">Checkbox 1</label>
                                </li>
                                <li>
                                    <input tabindex="18" type="checkbox" id="line-checkbox-2" checked>
                                    <label for="line-checkbox-2">Checkbox 2</label>
                                </li>
                                <li>
                                    <input type="checkbox" id="line-checkbox-disabled" disabled>
                                    <label for="line-checkbox-disabled">Disabled</label>
                                </li>
                                <li>
                                    <input type="checkbox" id="line-checkbox-disabled-checked" checked disabled>
                                    <label for="line-checkbox-disabled-checked">Disabled &amp; checked</label>
                                </li>


                            </ul>
                            <ul class="list list-unstyled  mr-3">
                                <li>
                                    <input tabindex="19" type="radio" id="line-radio-1" name="line-radio">
                                    <label for="line-radio-1">Radio button 1</label>
                                </li>
                                <li>
                                    <input tabindex="20" type="radio" id="line-radio-2" name="line-radio" checked>
                                    <label for="line-radio-2">Radio button 2</label>
                                </li>
                                <li>
                                    <input type="radio" id="line-radio-disabled" disabled>
                                    <label for="line-radio-disabled">Disabled</label>
                                </li>
                                <li>
                                    <input type="radio" id="line-radio-disabled-checked" checked disabled>
                                    <label for="line-radio-disabled-checked">Disabled &amp; checked</label>
                                </li>
                            </ul>

                            <ul class="list list-unstyled">
                                <li>
                                    <div class="state icheckbox_line-blue">
                                        <div class="icheck_line-icon"></div>
                                        Normal
                                    </div>
                                </li>
                                <li>
                                    <div class="state icheckbox_line-blue hover">
                                        <div class="icheck_line-icon"></div>
                                        Hover
                                    </div>
                                </li>
                                <li>
                                    <div class="state icheckbox_line-blue checked">
                                        <div class="icheck_line-icon"></div>
                                        Checked
                                    </div>
                                </li>
                                <li>
                                    <div class="state icheckbox_line-blue disabled">
                                        <div class="icheck_line-icon"></div>
                                        Disabled
                                    </div>
                                </li>
                                <li>
                                    <div class="state icheckbox_line-blue checked disabled">
                                        <div class="icheck_line-icon"></div>
                                        Disabled &amp; checked
                                    </div>
                                </li>
                            </ul>

                        </div>              

                    </div>
                </div> 
            </div>
            <div class="col-12 col-md-6 mt-3">
                <div class="card bg-dark text-white">
                    <div class="card-header d-flex justify-content-between align-items-center">                               
                        <h4 class="card-title">Polaris skin</h4>
                    </div>
                    <div class="card-body">                                       

                        <div class="skin skin-polaris">    


                            <ul class="list list-unstyled mr-3">
                                <li>
                                    <input tabindex="21" type="checkbox" id="polaris-checkbox-1">
                                    <label for="polaris-checkbox-1">Checkbox 1</label>
                                </li>
                                <li>
                                    <input tabindex="22" type="checkbox" id="polaris-checkbox-2" checked>
                                    <label for="polaris-checkbox-2">Checkbox 2</label>
                                </li>
                                <li>
                                    <input type="checkbox" id="polaris-checkbox-disabled" disabled>
                                    <label for="polaris-checkbox-disabled">Disabled</label>
                                </li>
                                <li>
                                    <input type="checkbox" id="polaris-checkbox-disabled-checked" checked disabled>
                                    <label for="polaris-checkbox-disabled-checked">Disabled &amp; checked</label>
                                </li>


                            </ul>
                            <ul class="list list-unstyled  mr-3">
                                <li>
                                    <input tabindex="23" type="radio" id="polaris-radio-1" name="polaris-radio">
                                    <label for="polaris-radio-1">Radio button 1</label>
                                </li>
                                <li>
                                    <input tabindex="24" type="radio" id="polaris-radio-2" name="polaris-radio" checked>
                                    <label for="polaris-radio-2">Radio button 2</label>
                                </li>
                                <li>
                                    <input type="radio" id="polaris-radio-disabled" disabled>
                                    <label for="polaris-radio-disabled">Disabled</label>
                                </li>
                                <li>
                                    <input type="radio" id="polaris-radio-disabled-checked" checked disabled>
                                    <label for="polaris-radio-disabled-checked">Disabled &amp; checked</label>
                                </li>
                            </ul>

                            <ul class="list list-unstyled">
                                <li>
                                    <div class="state icheckbox_polaris"></div>
                                    <div class="state iradio_polaris"></div>
                                    Normal
                                </li>
                                <li>
                                    <div class="state icheckbox_polaris hover"></div>
                                    <div class="state iradio_polaris hover"></div>
                                    Hover
                                </li>
                                <li>
                                    <div class="state icheckbox_polaris checked"></div>
                                    <div class="state iradio_polaris checked"></div>
                                    Checked
                                </li>
                                <li>
                                    <div class="state icheckbox_polaris disabled"></div>
                                    <div class="state iradio_polaris disabled"></div>
                                    Disabled
                                </li>
                                <li>
                                    <div class="state icheckbox_polaris checked disabled"></div>
                                    <div class="state iradio_polaris checked disabled"></div>
                                    Disabled &amp; checked
                                </li>
                            </ul>

                        </div>              

                    </div>
                </div> 
            </div>
            <div class="col-12 col-md-6 mt-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">                               
                        <h4 class="card-title">Default</h4>
                    </div>
                    <div class="card-body">
                        <div class="demo-list clear">
                            <ul class="list-unstyled">
                                <li>
                                    <input tabindex="1" type="checkbox" id="input-1">
                                    <label for="input-1">Checkbox, <span>#input-1</span></label>
                                </li>
                                <li>
                                    <input tabindex="2" type="checkbox" id="input-2" checked>
                                    <label for="input-2">Checkbox, <span>#input-2</span></label>
                                </li>
                            </ul>
                            <ul class="list-unstyled">
                                <li>
                                    <input tabindex="3" type="radio" id="input-3" name="demo-radio">
                                    <label for="input-3">Radio button, <span>#input-3</span></label>
                                </li>
                                <li>
                                    <input tabindex="4" type="radio" id="input-4" name="demo-radio" checked>
                                    <label for="input-4">Radio button, <span>#input-4</span></label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> 
            </div>

        </div>

    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>
<?= $this->section('pagestyles') ?>
<!-- START: Page CSS-->
<link rel="stylesheet"  href="<?php echo base_url('dist/vendors/icheck/skins/all.css'); ?>">
<!-- END: Page CSS-->
<?= $this->endSection() ?>
<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/icheck/icheck.min.js'); ?>"></script>
<script src="<?php echo base_url('dist/js/icheck.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>

