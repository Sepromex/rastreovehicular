<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid site-width">
    <!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">Blank Page</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Page</li>
                    <li class="breadcrumb-item active"><a href="#">Blank Page</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12  mt-3">                          
            <div class="card">  
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h4 class="card-title">Heading Here</h4>                                   
                </div>
                <div class="card-body">
                    Content here
                </div>                                
            </div>
        </div>



    </div>
    <!-- END: Card DATA-->
</div>
<?= $this->endSection() ?>
