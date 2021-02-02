<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
    <div class="row">
        <div class="col-12 align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">Orders</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Ecommerce</li>
                    <li class="breadcrumb-item active"><a href="#">Orders</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">                               
                    <h4 class="card-title">Orders</h4> 
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered  table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Purchased</th>
                                <th>Client Name</th>
                                <th>Amount</th>
                                <th>Quantity</th>
                                <th>Shipment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>0001</td>
                                <td>03/11/2015</td>
                                <td>Addison Nichols</td>
                                <td>$ 515.20</td>
                                <td>547</td>
                                <td>04/10/2017</td>
                                <td><span class="badge badge-primary text-white">Standby</span></td>
                            </tr>
                            <tr class="ng-scope">
                                <td>0002</td>
                                <td>05/11/2015</td>
                                <td>Albert Watkins</td>
                                <td>$ 22.30</td>
                                <td>122</td>
                                <td>06/10/2017</td>
                                <td><span class="badge badge-dark text-white">Paid</span></td>
                            </tr>
                            <tr class="ng-scope">
                                <td>0003</td>
                                <td>07/09/2015</td>
                                <td>Johnny Fernandez</td>
                                <td>$ 31.4</td>
                                <td>68</td>
                                <td>28/09/2017</td>
                                <td><span class="badge badge-success text-white">Standby</span></td>
                            </tr>
                            <tr class="ng-scope">
                                <td>0011</td>
                                <td>19/09/2015</td>
                                <td>Gilbert Edwards</td>
                                <td>$ 5115.12</td>
                                <td>51</td>
                                <td>-</td>
                                <td><span class="badge badge-danger text-white">Canceled</span></td>
                            </tr>
                            <tr class="ng-scope">
                                <td>0012</td>
                                <td>20/09/2015</td>
                                <td>Norman Hill</td>
                                <td>$ 5124.13</td>
                                <td>41</td>
                                <td>-</td>
                                <td><span class="badge badge-warning text-white">Shipped</span></td>
                            </tr>
                            <tr class="ng-scope">
                                <td>0013</td>
                                <td>22/09/2015</td>
                                <td>Samantha Murphy</td>
                                <td>$ 513.214</td>
                                <td>54</td>
                                <td>-</td>
                                <td><span class="badge badge-danger text-white">Canceled</span></td>
                            </tr>
                            <tr class="ng-scope">
                                <td>0014</td>
                                <td>30/09/2015</td>
                                <td>Nora Lambert</td>
                                <td>$ 147.15</td>
                                <td>65</td>
                                <td>23/11/2017</td>
                                <td><span class="badge badge-info text-white">Paid</span></td>
                            </tr>
                            <tr class="ng-scope">
                                <td>0015</td>
                                <td>29/07/2015</td>
                                <td>Shelly Robertson</td>
                                <td>$ 15.016</td>
                                <td>12</td>
                                <td>-</td>
                                <td><span class="badge badge-danger text-white">Canceled</span></td>
                            </tr>
                            <tr class="ng-scope">
                                <td>0016</td>
                                <td>22/07/2015</td>
                                <td>Everett Garcia</td>
                                <td>$ 188.19</td>
                                <td>65</td>
                                <td>029/11/2017</td>
                                <td><span class="badge badge-primary text-white">Paid</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>


    </div>
    <!-- END: Card DATA-->
<?= $this->endSection() ?>


