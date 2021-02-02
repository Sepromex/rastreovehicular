<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
    <div class="row">
        <div class="col-12 align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">Cart</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Ecommerce</li>
                    <li class="breadcrumb-item active"><a href="#">Cart</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-xl-7 mb-4 mb-xl-0">
                            <table class="table table-bordered mb-0 table-responsive d-block border-bottom-0 border-top-0 border-left-0 border-right-0">
                                <thead>
                                    <tr class="bg-transparent">
                                        <th class="border-bottom-0">Image</th>
                                        <th class="border-bottom-0">Product</th>
                                        <th class="border-bottom-0">Price</th>
                                        <th class="border-bottom-0">Quantity</th>
                                        <th class="border-bottom-0"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><img src="<?php echo base_url('dist/images/ecommerce-img8.jpg');?>" alt="" class="img-fluid" width="60"></td>
                                        <td class="align-middle">Flowers Structured Coat</td>
                                        <td class="align-middle">$398.00</td>
                                        <td class="w-25 align-middle"><input type="number" class="form-control" value="1"></td>
                                        <td class="align-middle"><a href="#"><i class="icon-trash"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td><img src="<?php echo base_url('dist/images/ecommerce-img2.jpg');?>" alt="" class="img-fluid" width="60"></td>
                                        <td class="align-middle">Cotton White Top</td>
                                        <td class="align-middle">$398.00</td>
                                        <td class="w-25 align-middle"><input type="number" class="form-control" value="2"></td>
                                        <td class="align-middle"><a href="#"><i class="icon-trash"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="clearfix mt-4 float-left d-flex">
                                <div class="float-left">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter coupon code">
                                    </div>
                                </div>
                                <div class="float-left mr-4">
                                    <div class="form-group">
                                        <a href="#" class="btn btn-primary ">Apply</a>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix mt-4">
                                <div class="float-left">
                                    <a href="#" class="btn btn-primary">Update Cart</a>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-12 col-xl-5">
                            <div class=" border mb-3">
                                <div class="card-body border border-top-0 border-right-0 border-left-0">
                                    <h4 class="f-weight-500 mb-0">Cart Total</h4>
                                </div>
                                <div class="card-body border border-top-0 border-right-0 border-left-0">
                                    <div class="clearfix d-flex">
                                        <div class="float-left">
                                            <p>Subtotal:</p>
                                            <p class="mb-0">Shipping and Handling:</p>
                                        </div>
                                        <div class="float-right">
                                            <p>$796.00</p>
                                            <p>$20.00</p>
                                            <p class="mb-0"><a href="#" class="text-primary">Calculate shipping</a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <p class="mb-0 dark-color f-weight-600">Total:</p>
                                        </div>
                                        <div class="float-right">
                                            <p class="mb-0 dark-color f-weight-600 h4">$816.00</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix d-sm-flex">
                                <div class="float-left w-100 text-center text-sm-left mb-3">
                                    <a href="#" class="btn btn-primary">Process To Checkout</a>
                                </div>
                                <div class="float-right w-100 text-center text-sm-right">
                                    <p class="mb-0 h6"><a href="#" class="btn btn-success"><i class="icon-handbag h6"></i> Continue Shopping</a></p>
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


