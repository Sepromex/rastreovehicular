<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
     <!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">Contact us</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Page</li>
                    <li class="breadcrumb-item active"><a href="#">Contact us</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12  mt-3">                          
            <div class="card"> 
                <div class="card-body">
                    <iframe class="w-100 height-350 border-0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3105.457742418827!2d-77.00662848481065!3d38.89064655494741!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89b7b828d32c69bb%3A0xffb704728ee19592!2sSupreme%20Court%20of%20the%20United%20States!5e0!3m2!1sen!2sin!4v1575976537424!5m2!1sen!2sin"  allowfullscreen=""></iframe>
                </div>                                
            </div>
        </div>

        <div class="col-12 col-md-6 mt-4">                          
            <div class="card"> 
                <div class="card-header  justify-content-between align-items-center">                               
                    <h4 class="card-title">Feedback</h4> 
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Name:">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Email:">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" placeholder="Message:"></textarea>
                        </div>


                        <a href="#" class="btn btn-primary btn-default">Submit</a>
                    </form>
                </div>                                
            </div>
        </div>
        <div class="col-12 col-md-6 mt-4">                          
            <div class="card"> 
                <div class="card-header  justify-content-between align-items-center">                               
                    <h4 class="card-title">Contact us</h4> 
                </div>
                <div class="card-body">
                    <address>
                        <strong>Loop, Inc.</strong><br>
                        795 Park Ave, Suite 120<br>
                        San Francisco, CA 94107<br>
                        <abbr title="Phone">P: </abbr> (234) 145-1810 
                    </address>
                    <address>
                        <strong>Email</strong><br>
                        <a href="mailto:#" class="redial-primary redial-font-weight-600">first.last@email.com </a>
                    </address>
                    <div class="text-left">

                        <a href="#" class="btn btn-social btn-dropbox text-white mb-2">
                            <i class="ion ion-social-dropbox"></i>
                        </a>
                        <a href="#" class="btn btn-social btn-facebook text-white mb-2">
                            <i class="ion ion-social-facebook"></i>
                        </a>                                   
                        <a href="#" class="btn btn-social btn-github text-white mb-2">
                            <i class="ion ion-social-github"></i>
                        </a>
                        <a href="#" class="btn btn-social btn-google text-white mb-2">
                            <i class="ion ion-social-google"></i>
                        </a>
                        <a href="#" class="btn btn-social btn-instagram text-white mb-2">
                            <i class="ion ion-social-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-social btn-linkedin text-white mb-2">
                            <i class="ion ion-social-linkedin"></i>
                        </a>                                   
                        <a href="#" class="btn btn-social btn-pinterest text-white mb-2">
                            <i class="ion ion-social-pinterest"></i>
                        </a>
                        <a href="#" class="btn btn-social btn-tumblr text-white mb-2">
                            <i class="ion ion-social-tumblr"></i>
                        </a>
                        <a href="#" class="btn btn-social btn-twitter text-white mb-2">
                            <i class="ion ion-social-twitter"></i>
                        </a>
                    </div>
                </div>                               
            </div>
        </div>

    </div>
    <!-- END: Card DATA-->
<?= $this->endSection() ?>
