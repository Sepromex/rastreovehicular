<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Badges</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">UI</li>
                <li class="breadcrumb-item active"><a href="#">Badges</a></li>
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
                <h4 class="card-title">Default</h4> 
            </div>
            <div class="card-body">                                     
                <h1>Example heading <span class="badge badge-primary">New</span></h1>
                <h2>Example heading <span class="badge badge-primary">New</span></h2>
                <h3>Example heading <span class="badge badge-primary">New</span></h3>
                <h4>Example heading <span class="badge badge-primary">New</span></h4>
                <h5>Example heading <span class="badge badge-primary">New</span></h5>
                <h6>Example heading <span class="badge badge-primary">New</span></h6>
            </div>
        </div> 

    </div>
    <div class="col-12 col-sm-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Contextual variations</h4> 
            </div>
            <div class="card-body">

                <span class="badge p-2 badge-primary mb-1">Primary</span><br/>
                <span class="badge p-2 badge-secondary mb-1">Secondary</span><br/>
                <span class="badge p-2 badge-success mb-1">Success</span><br/>
                <span class="badge p-2 badge-danger mb-1">Danger</span><br/>
                <span class="badge p-2 badge-warning mb-1">Warning</span><br/>
                <span class="badge p-2 badge-info mb-1">Info</span><br/>
                <span class="badge p-2 badge-light mb-1">Light</span><br/>
                <span class="badge p-2 badge-dark mb-1">Dark</span><br/>
            </div>
        </div> 

    </div>
    <div class="col-12 col-sm-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Pill badges</h4> 
            </div>
            <div class="card-body">

                <span class="badge badge-pill badge-primary p-2 mb-1">Primary</span><br/>
                <span class="badge badge-pill badge-secondary p-2 mb-1">Secondary</span><br/>
                <span class="badge badge-pill badge-success p-2 mb-1">Success</span><br/>
                <span class="badge badge-pill badge-danger p-2 mb-1">Danger</span><br/>
                <span class="badge badge-pill badge-warning p-2 mb-1">Warning</span><br/>
                <span class="badge badge-pill badge-info p-2 mb-1">Info</span><br/>
                <span class="badge badge-pill badge-light p-2 mb-1">Light</span><br/>
                <span class="badge badge-pill badge-dark p-2 mb-1">Dark</span><br/>
            </div>
        </div> 

    </div>
    <div class="col-12 col-sm-6 mt-3">
        <div class="card">
            <div class="card-header  justify-content-between align-items-center">                               
                <h4 class="card-title">Link badges</h4> 
            </div>
            <div class="card-body">

                <a href="#" class="badge p-2 badge-primary mb-1">Primary</a><br/>
                <a href="#" class="badge p-2 badge-secondary mb-1">Secondary</a><br/>
                <a href="#" class="badge p-2 badge-success mb-1">Success</a><br/>
                <a href="#" class="badge p-2 badge-danger mb-1">Danger</a><br/>
                <a href="#" class="badge p-2 badge-warning mb-1">Warning</a><br/>
                <a href="#" class="badge p-2 badge-info mb-1">Info</a><br/>
                <a href="#" class="badge p-2 badge-light mb-1">Light</a><br/>
                <a href="#" class="badge p-2 badge-dark mb-1">Dark</a><br/>
            </div>
        </div> 

    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>

