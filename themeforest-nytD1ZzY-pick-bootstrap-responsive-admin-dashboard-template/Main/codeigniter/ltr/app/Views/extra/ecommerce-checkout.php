<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
    <div class="row">
        <div class="col-12 align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">Checkout</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Ecommerce</li>
                    <li class="breadcrumb-item active"><a href="#">Checkout</a></li>
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
                    <div class="wizard mb-4">                                            
                        <div class="connecting-line"></div>
                        <ul class="nav nav-tabs d-flex mb-3">
                            <li class="nav-item mr-auto">
                                <a class="nav-link position-relative round-tab text-left p-0 active border-0" data-toggle="tab" href="#id1"> 
                                    <i class="icon-bag position-relative text-white h5 mb-3"></i>
                                    <small class="d-none d-md-block font-weight-bold">Cart</small>
                                </a>
                            </li>
                            <li class="nav-item mx-auto">
                                <a class="nav-link position-relative round-tab text-sm-center text-left p-0 border-0" data-toggle="tab" href="#id2"> 
                                    <i class="icon-map position-relative text-white h5 mb-3"></i>
                                    <small class="d-none d-md-block font-weight-bold">Address</small>
                                </a>
                            </li>
                            <li class="nav-item ml-auto">
                                <a class="nav-link position-relative round-tab text-sm-right text-left p-0 border-0" data-toggle="tab" href="#id3"> 
                                    <i class="icon-credit-card position-relative text-white h5 mb-3"></i>
                                    <small class="d-none d-md-block font-weight-bold">Payment</small>
                                </a>
                            </li>
                        </ul>                                          

                        <div class="tab-content mt-5">
                            <div class="tab-pane fade active show" id="id1">
                                <div class="form">
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
                                                        <div class="ml-auto">
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
                                            <div class="clearfix">
                                                <div class="float-left w-100 text-right">
                                                    <a href="#" class="btn btn-primary nexttab">Process To Checkout</a>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="id2">
                                <div class="form">
                                    <div class="row">
                                        <div class="col-12 col-md-9 mb-2">
                                            <div class=" border p-3">
                                                <h4>Add New Address</h4>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label >First name <span class="text-danger">*</span></label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label >Last name <span class="text-danger">*</span></label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label >Company Name <span class="text-danger">*</span></label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label >Country <span class="text-danger">*</span></label>
                                                        <div class="form-group">
                                                            <select class="style-select form-control">
                                                                <option label="select"></option>
                                                                <option>Australia</option>
                                                                <option>New York</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label >Street Address <span class="text-danger">*</span></label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="">
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <label >Town / City <span class="text-danger">*</span></label>
                                                        <div class="form-group">
                                                            <select class="style-select form-control">
                                                                <option label="select"></option>
                                                                <option>Australia</option>
                                                                <option>New York</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label >State / County  <span class="text-danger">*</span></label>
                                                        <div class="form-group">
                                                            <select class="style-select form-control">
                                                                <option label="select"></option>
                                                                <option>Australia</option>
                                                                <option>New York</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label >Postcode / Zip <span class="text-danger">*</span></label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label >Phone <span class="text-danger">*</span></label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label >Email address  <span class="text-danger">*</span></label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <button type="button" class="btn float-right btn-primary nexttab">Save Address</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="float-left w-100 border p-3">
                                                <b>John Deo</b>
                                                <address>
                                                    2940  Rainbow Road<br>Alhambra, CA<br>91801 California </address>
                                                <button type="button" class="btn float-right btn-block btn-primary nexttab">Place Order here</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="tab-pane fade" id="id3">
                                <div class="form  row justify-content-md-center">
                                    <div class="col-12 col-md-6">
                                        <div class="border mb-3">
                                            <div class="card-body border brd-gray border-top-0 border-right-0 border-left-0">
                                                <h4 class="f-weight-500 mb-0">Your Order</h4>
                                            </div>
                                            <div class="card-body border brd-gray border-top-0 border-right-0 border-left-0">
                                                <div class="clearfix">
                                                    <div class="float-left">
                                                        <p>Flowers Structured Coat x 1</p>
                                                        <p class="mb-0">Cotton white top x 1</p>
                                                    </div>
                                                    <div class="float-right">
                                                        <p>$398.00</p>
                                                        <p class="mb-0">$398.00</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body border brd-gray border-top-0 border-right-0 border-left-0">
                                                <div class="clearfix">
                                                    <div class="float-left">
                                                        <p class="dark-color ">Subtotal:</p>
                                                        <p class="mb-0 dark-color ">Shipping and Handling:</p>
                                                    </div>
                                                    <div class="float-right">
                                                        <p>$796.00</p>
                                                        <p class="mb-0">$20.00</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body border brd-gray border-top-0 border-right-0 border-left-0">
                                                <div class="clearfix">
                                                    <div class="float-left">
                                                        <p class="mb-0 dark-color ">Total:</p>
                                                    </div>
                                                    <div class="float-right">
                                                        <p class="mb-0 dark-color  h4">$816.00</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="media">
                                                    <div class="form-group d-flex mr-2 mt-2">
                                                        <label class="chkbox ml-2"> 
                                                            <input name="style" value=""  type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="media-body">
                                                        <p class="dark-color ">Direct Bank Transfer</p>
                                                        <p>Make Your Payment Directly Into Bank Account. Please Use Your Order ID as the payment referance. our order won't be shipped until the funds have cleared in our account.</p>
                                                    </div>
                                                </div>
                                                <div class="media mb-3">
                                                    <div class="form-group d-flex mr-2">
                                                        <label class="chkbox ml-2"> 
                                                            <input name="style" value=""  type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="media-body">
                                                        <p class="dark-color ">Check payments</p>
                                                    </div>
                                                </div>
                                                <div class="media mb-2">
                                                    <div class="form-group d-flex mr-2">
                                                        <label class="chkbox ml-2"> 
                                                            <input name="style" value=""  type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="media-body">
                                                        <p class="dark-color ">Cash on delivery</p>
                                                    </div>
                                                </div>
                                                <div class="media">
                                                    <div class="form-group d-flex mt-2 mr-2">
                                                        <label class="chkbox ml-2"> 
                                                            <input name="style" value=""  type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="media-body">
                                                        <p class="dark-color ">PayPal <span class="mx-3"><a href="#"><img src="<?php echo base_url('dist/images/paypal.png');?>" alt=""></a> </span> <a href="#" class="body-color"><u>What is PayPal?</u></a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#" class="btn btn-primary">Place Order</a>
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


