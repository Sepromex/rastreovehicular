<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
 <!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">Pricing</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Page</li>
                    <li class="breadcrumb-item active"><a href="#">Pricing</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12  mt-3">                          
            <div class="card"> 

                <div class="card-body">

                    <div class="row justify-content-md-center">
                        <div class="col-12 col-md-4 col-xl-3 mb-4 mb-lg-0">
                            <div class="price-table border rounded  text-center  p-3">                          
                                <h5 class="font-weight-bold mb-3">Standard  Plan </h5> 
                                <div class="price-block">$7.99  </div>
                                Per Month
                                <div class="divider-default my-3"></div>
                                <ul class="list-unstyled">
                                    <li class="mb-3"><i class="fa fa-check"></i> 500 GB Bandwidth</li>
                                    <li class="mb-3"><i class="fa fa-check"></i> 15 MB Max File Size</li>
                                    <li class="mb-3"><i class="fa fa-check"></i>  6 GHZ CPU</li>
                                    <li class="mb-3"><i class="fa fa-check"></i> 1024 MB Memory</li>
                                    <li class="mb-3"><i class="fa fa-check"></i> 10 MySQL Databases</li>
                                    <li><a href="#" class="btn btn-primary btn-circle btn-default mt-3">Purchase Now</a></li>
                                </ul>                           
                            </div>  
                        </div>
                        <div class="col-12 col-md-4 col-xl-3 mb-4 mb-lg-0">
                            <div class="price-table bg-primary rounded text-white text-center  p-3">                          
                                <h5 class="font-weight-bold mb-3">Premium Plan </h5> 
                                <div class="price-block active">$8.99  </div>
                                Per Month
                                <div class="divider-default my-3"></div>
                                <ul class="list-unstyled">
                                    <li class="mb-3"><i class="fa fa-check"></i> 500 GB Bandwidth</li>
                                    <li class="mb-3"><i class="fa fa-check"></i> 15 MB Max File Size</li>
                                    <li class="mb-3"><i class="fa fa-check"></i>  6 GHZ CPU</li>
                                    <li class="mb-3"><i class="fa fa-check"></i> 1024 MB Memory</li>
                                    <li class="mb-3"><i class="fa fa-check"></i> 10 MySQL Databases</li>
                                    <li><a href="#" class="btn btn-light btn-circle btn-outline-default mt-3">Purchase Now</a></li>
                                </ul>                           
                            </div> 
                        </div>
                        <div class="col-12 col-md-4 col-xl-3">
                            <div class="price-table border rounded  text-center  p-3">                          
                                <h5 class="font-weight-bold mb-3">Business  Plan </h5> 
                                <div class="price-block">$9.99  </div>
                                Per Month
                                <div class="divider-default my-3"></div>
                                <ul class="list-unstyled">
                                    <li class="mb-3"><i class="fa fa-check"></i> 500 GB Bandwidth</li>
                                    <li class="mb-3"><i class="fa fa-check"></i> 15 MB Max File Size</li>
                                    <li class="mb-3"><i class="fa fa-check"></i>  6 GHZ CPU</li>
                                    <li class="mb-3"><i class="fa fa-check"></i> 1024 MB Memory</li>
                                    <li class="mb-3"><i class="fa fa-check"></i> 10 MySQL Databases</li>
                                    <li><a href="#" class="btn btn-primary btn-circle btn-default mt-3">Purchase Now</a></li>
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
