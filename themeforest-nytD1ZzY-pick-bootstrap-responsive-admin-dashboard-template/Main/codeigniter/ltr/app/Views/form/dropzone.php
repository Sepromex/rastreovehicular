<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Form Dropzone</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Form</li>
                <li class="breadcrumb-item active"><a href="#">Dropzone</a></li>
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
                        <h4 class="card-title">Dropzone Primary</h4>
                    </div>
                    <div class="card-body">
                        <form action="/file-upload" class="dropzone dropzone-primary">
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
            <div class="col-12 col-md-6 mt-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">                               
                        <h4 class="card-title">Dropzone Secondary</h4>
                    </div>
                    <div class="card-body">
                        <form action="/file-upload" class="dropzone dropzone-secondary">
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
            <div class="col-12 col-md-6 mt-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">                               
                        <h4 class="card-title">Dropzone Danger</h4>
                    </div>
                    <div class="card-body">
                        <form action="/file-upload" class="dropzone dropzone-danger">
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
            <div class="col-12 col-md-6 mt-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">                               
                        <h4 class="card-title">Dropzone Warning</h4>
                    </div>
                    <div class="card-body">
                        <form action="/file-upload" class="dropzone dropzone-warning">
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
            <div class="col-12 col-md-6 mt-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">                               
                        <h4 class="card-title">Dropzone Success</h4>
                    </div>
                    <div class="card-body">
                        <form action="/file-upload" class="dropzone dropzone-success">
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
            <div class="col-12 col-md-6 mt-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">                               
                        <h4 class="card-title">Dropzone Info</h4>
                    </div>
                    <div class="card-body">
                        <form action="/file-upload" class="dropzone dropzone-info">
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>
                        </form>
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
<script src="<?php echo base_url('dist/vendors/dropzone/dropzone.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>

