<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
    <div class="row">
        <div class="col-12 align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">Order View</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Ecommerce</li>
                    <li class="breadcrumb-item active"><a href="#">Order View</a></li>
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
                    <h4 class="card-title">Details</h4> 
                </div>
                <div class="card-body">
                    <dl class="row mb-0 redial-line-height-2_5">
                        <dt class="col-sm-5">Order ID:</dt>
                        <dd class="col-sm-7">#987654</dd>

                        <dt class="col-sm-5">Purchased On:</dt>
                        <dd class="col-sm-7">03/11/2017 11:10</dd>

                        <dt class="col-sm-5">Client Name:</dt>
                        <dd class="col-sm-7">John Thomas Doe</dd>

                        <dt class="col-sm-5">Items:</dt>
                        <dd class="col-sm-7">547</dd>

                        <dt class="col-sm-5">Amount:</dt>
                        <dd class="col-sm-7">$515.20</dd>

                        <dt class="col-sm-5">Shipment:</dt>
                        <dd class="col-sm-7">04/10/2017</dd>

                        <dt class="col-sm-5">Status</dt>
                        <dd class="col-sm-7"><span class="badge badge-primary text-white">Shipped</span></dd>
                    </dl>
                </div>
            </div>


        </div>
        <div class="col-12 col-md-6 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">                               
                    <h4 class="card-title">Client</h4> 
                </div>
                <div class="card-body">
                    <dl class="row mb-0 redial-line-height-2_5">
                        <dt class="col-sm-5">Client ID :</dt>
                        <dd class="col-sm-7">#987654</dd>

                        <dt class="col-sm-5">Name:</dt>
                        <dd class="col-sm-7">John Thomas Doe</dd>

                        <dt class="col-sm-5">Email:</dt>
                        <dd class="col-sm-7">your@mail.com</dd>

                        <dt class="col-sm-5">Company:</dt>
                        <dd class="col-sm-7">Horizon-Admin co.</dd>

                        <dt class="col-sm-5">Phone:</dt>
                        <dd class="col-sm-7">(91) 123 456465</dd>

                        <dt class="col-sm-5">Status:</dt>
                        <dd class="col-sm-7"><span class="badge badge-danger text-white">Active</span></dd> 
                    </dl>
                </div>
            </div>


        </div>
        <div class="col-12 col-md-6 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">                               
                    <h4 class="card-title">Billing Address</h4> 
                </div>
                <div class="card-body">
                    <dl class="row mb-0 redial-line-height-2_5">
                        <dt class="col-sm-5">First Name:</dt>
                        <dd class="col-sm-7">John</dd>

                        <dt class="col-sm-5">Last Name:</dt>
                        <dd class="col-sm-7">Doe</dd>

                        <dt class="col-sm-5">Address:</dt>
                        <dd class="col-sm-7">186, Vaishali Nagar</dd>

                        <dt class="col-sm-5">Company:</dt>
                        <dd class="col-sm-7">Horizon-Admin co.</dd>

                        <dt class="col-sm-5">City:</dt>
                        <dd class="col-sm-7">Jaipur</dd>

                        <dt class="col-sm-5">State</dt>
                        <dd class="col-sm-7">N/a</dd>

                        <dt class="col-sm-5">ZIP/Post Code</dt>
                        <dd class="col-sm-7">302021</dd>

                        <dt class="col-sm-5">Country</dt>
                        <dd class="col-sm-7">India</dd>

                        <dt class="col-sm-5">Phone</dt>
                        <dd class="col-sm-7">(91) 123 34565</dd>
                    </dl>
                </div>
            </div>


        </div>
        <div class="col-12 col-md-6 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">                               
                    <h4 class="card-title">Shipping Address</h4> 
                </div>
                <div class="card-body">
                    <dl class="row mb-0 redial-line-height-2_5">
                        <dt class="col-sm-5">First Name:</dt>
                        <dd class="col-sm-7">John</dd>

                        <dt class="col-sm-5">Last Name:</dt>
                        <dd class="col-sm-7">Doe</dd>

                        <dt class="col-sm-5">Address:</dt>
                        <dd class="col-sm-7">186, Vaishali Nagar</dd>

                        <dt class="col-sm-5">Company:</dt>
                        <dd class="col-sm-7">Horizon-Admin co.</dd>

                        <dt class="col-sm-5">City:</dt>
                        <dd class="col-sm-7">Jaipur</dd>

                        <dt class="col-sm-5">State</dt>
                        <dd class="col-sm-7">N/a</dd>

                        <dt class="col-sm-5">ZIP/Post Code</dt>
                        <dd class="col-sm-7">302021</dd>

                        <dt class="col-sm-5">Country</dt>
                        <dd class="col-sm-7">India</dd>

                        <dt class="col-sm-5">Phone</dt>
                        <dd class="col-sm-7">(91) 123 34565</dd>
                    </dl>
                </div>
            </div>


        </div>
    </div>
    <!-- END: Card DATA--> 
<?= $this->endSection() ?>


