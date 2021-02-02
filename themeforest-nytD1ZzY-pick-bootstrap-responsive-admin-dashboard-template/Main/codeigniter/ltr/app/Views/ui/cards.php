<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Cards</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">UI</li>
                <li class="breadcrumb-item active"><a href="#">Cards</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END: Breadcrumbs-->

<!-- START: Card Data-->
<div class="row">
    <div class="col-12 col-lg-6 col-xl-4 mt-3">
        <div class="card">                      
            <div class="card-content">


                <div class="card-image business-card">
                    <div class="background-image-maker"></div>
                    <div class="holder-image">
                        <img src="<?php echo base_url('dist/images/ceif.jpg'); ?>" alt="" class="img-fluid">                                        
                    </div>  
                    <div class="like"><i class="ion ion-clock"></i> 10:30am  to  11:00pm</div>
                    <div class="rating-block">
                        <div class="starrr"></div>
                        <h6 class="text-warning">3.5<small>(85 Ratings)</small></h6>
                    </div>
                </div>
                <div class="card-body">  
                    <h5 class="card-title mb-3 mt-2">Vintage Italian Restaurant</h5>
                    <p class="card-text">Phasellus ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia. Phasellus ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia.</p>
                    <div class="row mt-4 mb-3">
                        <div class="col-6">
                            <b><i class="ion ion-android-call"></i> Phone</b><br>
                            +88 123 123 1234 
                        </div>
                        <div class="col-6">
                            <b><i class="ion ion-android-pin"></i> Location</b><br> 
                            Akron, OH 44308
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6  col-xl-4 mt-3">
        <div class="card h-100">                      
            <div class="card-content h-100">
                <div class="card-body h-100 p-0">
                    <div class="info-card h-100">
                        <div class="background-image-maker"></div>
                        <div class="holder-image">
                            <img src="<?php echo base_url('dist/images/chip.jpg'); ?>" alt="" class="img-fluid">                                        
                        </div>
                        <div class="date  text-white">22<span>JAN</span></div>
                        <div class="like"><i class="ion ion-heart"></i> 200   <i class="ml-3 ion ion-chatboxes"></i> 192</div>
                        <div class="title px-4 text-white mb-3">
                            <h3 class="text-white">Donec posuere vulputate arcu. Phasellus accumsan cursus velit.</h3>
                            <img src="<?php echo base_url('dist/images/author.jpg'); ?>" alt="" class="border ml-2 img-fluid rounded-circle" width="35"> By John
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12  col-lg-5 col-xl-4 mt-3">
        <div class="twitter-gradient p-5 text-center h-100">
            <div id="demo" class="carousel slide" data-ride="carousel">
                <!-- The slideshow -->
                <div class="carousel-inner">
                    <div class="carousel-item py-3 active">
                        <i class="ion ion-social-twitter p-3  border rounded-circle h1 mb-4 mx-auto d-table"></i>
                        In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.
                        <br><small>24 January, 2018</small><br><br>
                        <div class="love px-2 py-1 d-inline-block"><i class="ion ion-heart"></i> 200   <i class="ml-3 ion ion-chatboxes"></i> 192</div>
                    </div>
                    <div class="carousel-item py-3">
                        <i class="ion ion-social-twitter p-3  border rounded-circle h1 mb-4 mx-auto d-table"></i>
                        In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.
                        <br><small>24 January, 2018</small><br><br>
                        <div class="love px-2 py-1 d-inline-block"><i class="ion ion-heart"></i> 200   <i class="ml-3 ion ion-chatboxes"></i> 192</div>
                    </div>
                    <div class="carousel-item py-3">
                        <i class="ion ion-social-twitter p-3  border rounded-circle h1 mb-4 mx-auto d-table"></i>
                        In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.
                        <br><small>24 January, 2018</small><br><br>
                        <div class="love px-2 py-1 d-inline-block"><i class="ion ion-heart"></i> 200   <i class="ml-3 ion ion-chatboxes"></i> 192</div>
                    </div>

                </div>

                <!-- Indicators -->
                <ul class="carousel-indicators position-relative mb-0">
                    <li data-target="#demo" data-slide-to="0" class="active"></li>
                    <li data-target="#demo" data-slide-to="1" class=""></li>
                    <li data-target="#demo" data-slide-to="2" class=""></li>
                </ul>

            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6  col-xl-4 mt-3">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Featured</h4>
            </div>
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6  col-xl-4 mt-3">
        <div class="card text-center">
            <div class="card-header">
                <h4 class="card-title">Featured</h4>
            </div>
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
            <div class="card-footer text-muted">
                2 days ago
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6  col-xl-4 mt-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6  col-xl-4 mt-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6  col-xl-4 mt-3">
        <div class="card text-right" >
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6  col-xl-4 mt-3">
        <div class="card text-white bg-primary">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Primary card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6  col-xl-4 mt-3">
        <div class="card text-white bg-secondary">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Secondary card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6  col-xl-4 mt-3">
        <div class="card text-white bg-success">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Success card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6  col-xl-4 mt-3">
        <div class="card text-white bg-danger">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Danger card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6  col-xl-4 mt-3">
        <div class="card text-white bg-warning">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Warning card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6  col-xl-4 mt-3">
        <div class="card text-white bg-info">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Info card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6  col-xl-4 mt-3">
        <div class="card bg-light">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Light card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6  col-xl-4 mt-3">
        <div class="card text-white bg-dark">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Dark card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>
<?= $this->section('pagestyles') ?>
<!-- START: Page CSS-->
<link rel="stylesheet"  href="<?php echo base_url('dist/vendors/ionicons/css/ionicons.min.css'); ?>">
<!-- END: Page CSS-->
<?= $this->endSection() ?>
