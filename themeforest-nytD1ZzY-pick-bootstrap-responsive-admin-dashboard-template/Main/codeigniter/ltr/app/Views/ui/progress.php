<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Progress</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">UI</li>
                <li class="breadcrumb-item active"><a href="#">Progress</a></li>
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
                <h4 class="card-title">Default</h4> 
            </div>
            <div class="card-body">
                <div class="progress mb-2">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress mb-2">
                    <div class="progress-bar w-25" role="progressbar"  aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress mb-2">
                    <div class="progress-bar w-50" role="progressbar"  aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress mb-2">
                    <div class="progress-bar w-75" role="progressbar"  aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress">
                    <div class="progress-bar w-100" role="progressbar"  aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

            </div>                                
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Labels</h4> 
            </div>
            <div class="card-body">
                <div class="progress mb-2">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
                <div class="progress mb-2">
                    <div class="progress-bar w-25" role="progressbar"  aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                </div>
                <div class="progress mb-2">
                    <div class="progress-bar w-50" role="progressbar"  aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                </div>
                <div class="progress mb-2">
                    <div class="progress-bar w-75" role="progressbar"  aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                </div>
                <div class="progress">
                    <div class="progress-bar w-100" role="progressbar"  aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                </div>
            </div>                                
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Backgrounds</h4> 
            </div>
            <div class="card-body">
                <div class="progress mb-2">
                    <div class="progress-bar bg-success w-25" role="progressbar"  aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress mb-2">
                    <div class="progress-bar bg-info w-50" role="progressbar"  aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress mb-2">
                    <div class="progress-bar bg-warning w-75" role="progressbar"  aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-danger w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>                                
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Striped</h4> 
            </div>
            <div class="card-body">
                <div class="progress mb-2">
                    <div class="progress-bar progress-bar-striped w-25" role="progressbar"  aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress mb-2">
                    <div class="progress-bar progress-bar-striped bg-success w-50" role="progressbar"  aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress mb-2">
                    <div class="progress-bar progress-bar-striped bg-info w-75" role="progressbar"  aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped bg-warning w-100" role="progressbar"  aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

            </div>                                
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Animated stripes</h4> 
            </div>
            <div class="card-body">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated w-75" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" ></div>
                </div>
            </div>                                
        </div>
    </div>
    <div class="col-12 col-md-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Multiple bars</h4> 
            </div>
            <div class="card-body">
                <div class="progress">
                    <div class="progress-bar w-25" role="progressbar"  aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-success w-25" role="progressbar"  aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-info w-25" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>                                
        </div>
    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>


