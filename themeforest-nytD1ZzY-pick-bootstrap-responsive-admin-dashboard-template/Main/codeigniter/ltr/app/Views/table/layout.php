<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Table Layout</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Table</li>
                <li class="breadcrumb-item active"><a href="#">Layout</a></li>
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
                <h4 class="card-title">Primary</h4>  
                Class <span class="text-primary">.layout-primary</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table layout-primary">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div> 

    </div>
    <div class="col-12 col-sm-6 mt-3">
        <div class="card">
            <div class="card-header justify-content-between align-items-center">                               
                <h4 class="card-title">Secondary</h4>
                Class <span class="text-secondary">.layout-secondary</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table layout-secondary">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div> 

    </div>
    <div class="col-12 col-sm-6 mt-3">
        <div class="card">
            <div class="card-header justify-content-between align-items-center">                               
                <h4 class="card-title">Danger</h4> 
                Class <span class="text-danger">.layout-danger</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table layout-danger">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div> 

    </div>
    <div class="col-12 col-sm-6 mt-3">
        <div class="card">
            <div class="card-header justify-content-between align-items-center">                               
                <h4 class="card-title">Warning</h4>  
                Class <span class="text-warning">.layout-warning</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table layout-warning">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div> 

    </div>
    <div class="col-12 col-sm-6 mt-3">
        <div class="card">
            <div class="card-header justify-content-between align-items-center">                               
                <h4 class="card-title">Info</h4>
                Class <span class="text-info">.layout-info</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table layout-info">
                        <thead>
                            <tr >
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div> 

    </div>                    
    <div class="col-12 col-sm-6 mt-3">
        <div class="card">
            <div class="card-header justify-content-between align-items-center">                               
                <h4 class="card-title">Success</h4>
                Class <span class="text-success">.layout-success</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table layout-success">
                        <thead>
                            <tr >
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div> 

    </div>
    <div class="col-12 col-sm-6 mt-3">
        <div class="card">
            <div class="card-header justify-content-between align-items-center">                               
                <h4 class="card-title">Dark</h4>
                Class <span class="text-dark">.layout-dark</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table layout-dark">
                        <thead>
                            <tr >
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div> 

    </div>                    
    <div class="col-12 col-sm-6 mt-3">
        <div class="card">
            <div class="card-header justify-content-between align-items-center">                               
                <h4 class="card-title">Border Primary</h4>
                Class <span class="text-primary">.layout-primary .bordered</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table layout-primary bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div> 

    </div>
    <div class="col-12 col-sm-6 mt-3">
        <div class="card">
            <div class="card-header justify-content-between align-items-center">                               
                <h4 class="card-title">Border Secondary</h4>
                Class <span class="text-secondary">.layout-secondary .bordered</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table layout-secondary bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div> 

    </div>
    <div class="col-12 col-sm-6 mt-3">
        <div class="card">
            <div class="card-header justify-content-between align-items-center">                               
                <h4 class="card-title">Border Danger</h4>
                Class <span class="text-danger">.layout-danger .bordered</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table layout-danger bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div> 

    </div>
    <div class="col-12 col-sm-6 mt-3">
        <div class="card">
            <div class="card-header justify-content-between align-items-center">                               
                <h4 class="card-title">Border Warning</h4>
                Class <span class="text-warning">.layout-warning .bordered</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table layout-warning bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div> 

    </div>
    <div class="col-12 col-sm-6 mt-3">
        <div class="card">
            <div class="card-header justify-content-between align-items-center">                               
                <h4 class="card-title">Border Info</h4>
                Class <span class="text-info">.layout-info .bordered</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table layout-info bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div> 

    </div>                    
    <div class="col-12 col-sm-6 mt-3">
        <div class="card">
            <div class="card-header justify-content-between align-items-center">                               
                <h4 class="card-title">Border Success</h4>
                Class <span class="text-success">.layout-success .bordered</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table layout-success bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div> 

    </div>
    <div class="col-12 col-sm-6 mt-3">
        <div class="card">
            <div class="card-header justify-content-between align-items-center">                               
                <h4 class="card-title">Border Dark</h4>
                Class <span class="text-dark">.layout-dark .bordered</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table layout-dark bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div> 

    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>

