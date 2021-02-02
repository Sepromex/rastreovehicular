<?= $this->extend('layouts/front') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row vh-100 justify-content-between align-items-center">
        <div class="col-12">
            <form action="#" class="row row-eq-height lockscreen  mt-5 mb-5">
                <div class="lock-image col-12 col-sm-5"></div>
                <div class="login-form col-12 col-sm-7">
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" placeholder="Username">
                    </div>

                    <div class="form-group mb-3">
                        <input type="text" class="form-control" placeholder="E-mail">
                    </div>

                    <div class="form-group mb-3">
                        <input type="password" class="form-control" placeholder="password">
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" class="form-control" placeholder="Confirm password">
                    </div>

                    <div class="form-group mb-0">
                        <button class="btn btn-primary" type="submit"> Register </button>
                    </div>
                    <p class="my-2 text-muted">--- Or register with ---</p>
                    <a class="btn btn-social btn-dropbox text-white mb-2">
                        <i class="icon-social-dropbox align-middle"></i>
                    </a>
                    <a class="btn btn-social btn-facebook text-white mb-2">
                        <i class="icon-social-facebook align-middle"></i>
                    </a>                                   
                    <a class="btn btn-social btn-github text-white mb-2">
                        <i class="icon-social-github align-middle"></i>
                    </a>
                    <a class="btn btn-social btn-google text-white mb-2">
                        <i class="icon-social-google align-middle"></i>
                    </a>
                    <div class="mt-2">Already have an account? <a href="page-login">Sign In</a></div>
                </div>
            </form>
        </div>

    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('pagestyles') ?>
<!-- START: Page CSS-->
<link rel="stylesheet"  href="<?php echo base_url('dist/vendors/social-button/bootstrap-social.css'); ?>">
<!-- END: Page CSS-->
<?= $this->endSection() ?>