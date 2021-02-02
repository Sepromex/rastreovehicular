<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<div class="container">
            <div class="row vh-100 justify-content-between align-items-center">
                <div class="col-12">
                    <form action="#" class="row row-eq-height lockscreen  mt-5 mb-5">
                        <div class="lock-image col-12 col-sm-5"></div>
                        <div class="login-form col-12 col-sm-7">                            
                            <img src="<?php echo base_url('dist/images/author9.jpg');?>" alt="" class="img-fluid rounded-circle mb-3" width="100">
                            <div class="form-group mb-3">

                                <input class="form-control" type="password" required="" id="password" placeholder="Enter your password">
                            </div>
                            <div class="form-group mb-0">
                                <button class="btn btn-primary" type="submit"> Log In </button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
<?= $this->endSection() ?>

