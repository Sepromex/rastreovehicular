<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<div class="container">
            <div class="row vh-100 justify-content-between align-items-center">
                <div class="col-12">
                    <div  class="lockscreen  mt-5 mb-5">
                        <div class="jumbotron mb-0 text-center theme-background rounded">
                            <h1 class="display-3 font-weight-bold"> 404</h1>
                            <h5><i class="ion ion-alert pr-2"></i>Oops! Something went wrong</h5>
                            <p>The page you are looking for is not found, please try after some time or go back to home</p>
                            <a href="index.html" class="btn btn-primary">Go To Home</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
<?= $this->endSection() ?>
