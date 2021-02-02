<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Form Elements</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Form</li>
                <li class="breadcrumb-item">Elements</li>
                <li class="breadcrumb-item active"><a href="#">Radio</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END: Breadcrumbs-->

<!-- START: Card Data-->
<div class="row row-eq-height">
    <div class="col-12 mt-3">
        <div class="card h-100">
            <div class="card-header">
                <h4 class="card-title">States</h4>
            </div>
            <div class="card-content">
                <div class="card-body py-5">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1">Inactive</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="checkbox" class="custom-control-input" checked="checked" id="customCheck2">
                        <label class="custom-control-label" for="customCheck2">Active</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="checkbox" class="custom-control-input" checked="checked" disabled="disabled" id="customCheck3">
                        <label class="custom-control-label" for="customCheck3">Active/Disabled</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="checkbox" class="custom-control-input" disabled="disabled" id="customCheck4">
                        <label class="custom-control-label" for="customCheck4">Disabled</label>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Colors</h4>
            </div>
            <div class="card-content">
                <div class="card-body py-5">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="primary">
                        <label class="custom-control-label checkbox-primary" for="primary">Primary</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="checkbox" class="custom-control-input" checked="checked" id="chksecondary">
                        <label class="custom-control-label checkbox-secondary" for="chksecondary">Secondary</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="checkbox" class="custom-control-input" checked="checked" id="chkwarning">
                        <label class="custom-control-label checkbox-warning" for="chkwarning">Warning</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="checkbox" class="custom-control-input" checked="checked"  id="chkdanger">
                        <label class="custom-control-label checkbox-danger" for="chkdanger">Danger</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="checkbox" class="custom-control-input" checked="checked"  id="chkinfo">
                        <label class="custom-control-label checkbox-info" for="chkinfo">Ingo</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="checkbox" class="custom-control-input" checked="checked"  id="chkdark">
                        <label class="custom-control-label checkbox-dark" for="chkdark">Dark</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="checkbox" class="custom-control-input" checked="checked"  id="chksuccess">
                        <label class="custom-control-label checkbox-success" for="chksuccess">Success</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Outlines</h4>
            </div>
            <div class="card-content">
                <div class="card-body py-5">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="checkbox" checked="checked" class="custom-control-input" id="outprimary">
                        <label class="custom-control-label checkbox-primary outline" for="outprimary">Primary</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="checkbox" class="custom-control-input" checked="checked" id="outlinesecondary">
                        <label class="custom-control-label checkbox-secondary outline" for="outlinesecondary">Secondary</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="checkbox" class="custom-control-input" checked="checked" id="outlinewarning">
                        <label class="custom-control-label checkbox-warning outline" for="outlinewarning">Warning</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="checkbox" class="custom-control-input" checked="checked"  id="outlinedanger">
                        <label class="custom-control-label checkbox-danger outline" for="outlinedanger">Danger</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="checkbox" class="custom-control-input" checked="checked"  id="outlineinfo">
                        <label class="custom-control-label checkbox-info outline" for="outlineinfo">Ingo</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="checkbox" class="custom-control-input" checked="checked"  id="outlinedark">
                        <label class="custom-control-label checkbox-dark outline" for="outlinedark">Dark</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="checkbox" class="custom-control-input" checked="checked"  id="outlinesuccess">
                        <label class="custom-control-label checkbox-success outline" for="outlinesuccess">Success</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>

