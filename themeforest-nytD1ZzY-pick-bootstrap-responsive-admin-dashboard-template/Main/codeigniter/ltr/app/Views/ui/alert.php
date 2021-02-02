<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">Alerts</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">UI</li>
                    <li class="breadcrumb-item active"><a href="#">Alert</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12 col-sm-6 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">                               
                    <h4 class="card-title">Alert Style</h4> 
                </div>
                <div class="card-body">                                     
                    <div class="alert alert-primary" role="alert">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit <a href="#" class="alert-link">Alert Link</a>
                    </div>
                    <div class="alert alert-secondary" role="alert">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit <a href="#" class="alert-link">Alert Link</a>
                    </div>
                    <div class="alert alert-success" role="alert">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit <a href="#" class="alert-link">Alert Link</a>
                    </div>
                    <div class="alert alert-danger" role="alert">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit <a href="#" class="alert-link">Alert Link</a>
                    </div>
                    <div class="alert alert-warning" role="alert">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit <a href="#" class="alert-link">Alert Link</a>
                    </div>
                    <div class="alert alert-dark mb-0" role="alert">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit <a href="#" class="alert-link">Alert Link</a>
                    </div>
                </div>
            </div> 

        </div>
        <div class="col-12 col-sm-6 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">                               
                    <h4 class="card-title">Alert Style</h4> 
                </div>
                <div class="card-body">

                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Holy guacamole!</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        <strong>Holy guacamole!</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Holy guacamole!</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Holy guacamole!</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Holy guacamole!</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="alert alert-dark alert-dismissible fade show mb-0" role="alert">
                        <strong>Holy guacamole!</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                </div>
            </div> 

        </div>
    </div>
    <!-- END: Card DATA-->
<?= $this->endSection() ?>

