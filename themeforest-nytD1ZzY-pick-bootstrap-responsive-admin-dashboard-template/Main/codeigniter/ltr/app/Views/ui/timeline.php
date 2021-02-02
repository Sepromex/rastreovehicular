<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">Timeline</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">UI</li>
                    <li class="breadcrumb-item active"><a href="#">Timeline</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12  mt-3">
            <ul class="timeline-app">

                <li class="timeline-item">
                    <div class="timeline-dot"><i class="icon-user icons"></i></div>
                    <div class="time-strip">
                        2012 
                    </div>

                    <div class="card w-100 overflow-hidden">
                        <div class="card-img-top cover">
                            <img class="cover-image img-fluid" src="<?php echo base_url('dist/images/portfolio13.jpg');?>" alt="...">
                        </div>
                        <div class="card-block p-3">
                            <h3 class="card-title">Lorem Ipsum Dolor</h3>
                            <p class="card-text">
                                <small>MAY 15, 2017</small>
                            </p>
                            <p>Novum formidines congressus atomorum nam permulta alterum delectatio
                                gaudeat statim. Necessariae dicturam perspexit utrum modo amicitiae
                                malum summumque, multis ante iudicia desiderat, civitas iudicare
                                attingere, amori perpaulum mediocrium, dicere notae litteras
                                plusque appareat, remotis fama futurove quandam assentiar integre
                                poenis. </p>
                            <a class="btn btn-primary btn-outline card-link" href="#">Read More</a>
                        </div>                                           
                    </div>
                </li>
                <li class="timeline-item reverse">
                    <div class="time-strip">
                        2013 
                    </div>
                    <div class="timeline-dot bg-success"><i class="icon-compass icons"></i></div>

                    <div class="card w-100 overflow-hidden">
                        <div class="card-img-top cover">
                            <img class="cover-image img-fluid" src="<?php echo base_url('dist/images/portfolio12.jpg');?>" alt="...">
                        </div>
                        <div class="card-block p-3">
                            <h3 class="card-title">Lorem Ipsum Dolor</h3>
                            <p class="card-text">
                                <small>MAY 15, 2017</small>
                            </p>
                            <p>Novum formidines congressus atomorum nam permulta alterum delectatio
                                gaudeat statim. Necessariae dicturam perspexit utrum modo amicitiae
                                malum summumque, multis ante iudicia desiderat, civitas iudicare
                                attingere, amori perpaulum mediocrium, dicere notae litteras
                                plusque appareat, remotis fama futurove quandam assentiar integre
                                poenis. </p>
                            <a class="btn btn-primary btn-outline card-link" href="#">Read More</a>
                        </div>                                           
                    </div>
                </li>

                <li class="timeline-item">
                    <div class="time-strip">
                        2014 
                    </div>
                    <div class="timeline-dot bg-danger"><i class="icon-emotsmile icons"></i></div>

                    <div class="card h-100 w-100 overflow-hidden">                      
                        <div class="card-content h-100">
                            <div class="card-body h-100 p-0">
                                <div class="info-card h-100">
                                    <div class="background-image-maker"></div>
                                    <div class="holder-image">
                                        <img src="<?php echo base_url('dist/images/cap1.jpg');?>" alt="" class="img-fluid">                                        
                                    </div>
                                    <div class="date  text-white">22<span>JAN</span></div>
                                    <div class="like"><i class="ion ion-heart"></i> 200   <i class="ml-3 ion ion-chatboxes"></i> 192</div>
                                    <div class="title px-4 text-white mb-3">
                                        <h3 class="text-white">Donec posuere vulputate arcu. Phasellus accumsan cursus velit.</h3>
                                        <img src="<?php echo base_url('dist/images/author.jpg');?>" alt="" class="border ml-2 img-fluid rounded-circle" width="35"> By John
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="timeline-item reverse">
                    <div class="time-strip">
                        2015 
                    </div>
                    <div class="timeline-dot bg-info"><i class="icon-map icons"></i></div>

                    <div class="card w-100 overflow-hidden">
                        <div class="card-img-top cover">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe src="https://player.vimeo.com/video/18661699"  allow="autoplay; fullscreen"></iframe>
                            </div>
                        </div>
                        <div class="card-block p-3">
                            <h3 class="card-title">Lorem Ipsum Dolor</h3>
                            <p class="card-text">
                                <small>MAY 15, 2017</small>
                            </p>
                            <p>Novum formidines congressus atomorum nam permulta alterum delectatio
                                gaudeat statim. Necessariae dicturam perspexit utrum modo amicitiae
                                malum summumque, multis ante iudicia desiderat, civitas iudicare
                                attingere, amori perpaulum mediocrium, dicere notae litteras
                                plusque appareat, remotis fama futurove quandam assentiar integre
                                poenis. </p>
                            <a class="btn btn-primary btn-outline card-link" href="#">Read More</a>
                        </div>                                           
                    </div>
                </li>
            </ul>                      
        </div>
        <div class="col-12 col-md-6  mt-3">

            <ul class="timeline-app-alt">
                <li class="timeline-item">
                    <div class="timeline-dot"><i class="icon-user icons"></i></div>                             

                    <div class="card w-100">                                  
                        <div class="card-block p-3">
                            <h3 class="card-title">Lorem Ipsum Dolor</h3>
                            <p class="card-text">
                                <small>MAY 15, 2017</small>
                            </p>
                            <p>Novum formidines congressus atomorum nam permulta alterum delectatio
                                gaudeat statim. Necessariae dicturam perspexit utrum modo amicitiae
                                malum summumque, multis ante iudicia desiderat, civitas iudicare
                                attingere, amori perpaulum mediocrium, dicere notae litteras
                                plusque appareat, remotis fama futurove quandam assentiar integre
                                poenis. </p>
                            <a class="btn btn-primary btn-outline card-link" href="#">Read More</a>
                        </div>                                           
                    </div>
                </li>
                <li class="timeline-item">
                    <div class="timeline-dot bg-success"><i class="icon-compass icons"></i></div>
                    <div class="card w-100">                                   
                        <div class="card-block p-3">
                            <h3 class="card-title">Lorem Ipsum Dolor</h3>
                            <p class="card-text">
                                <small>MAY 15, 2017</small>
                            </p>
                            <p>Novum formidines congressus atomorum nam permulta alterum delectatio
                                gaudeat statim. Necessariae dicturam perspexit utrum modo amicitiae
                                malum summumque, multis ante iudicia desiderat, civitas iudicare
                                attingere, amori perpaulum mediocrium, dicere notae litteras
                                plusque appareat, remotis fama futurove quandam assentiar integre
                                poenis. </p>
                            <a class="btn btn-primary btn-outline card-link" href="#">Read More</a>
                        </div>                                           
                    </div>
                </li>
                <li class="timeline-item">
                    <div class="timeline-dot bg-danger"><i class="icon-emotsmile icons"></i></div>                            
                    <div class="card w-100">                                 
                        <div class="card-block p-3">
                            <h3 class="card-title">Lorem Ipsum Dolor</h3>
                            <p class="card-text">
                                <small>MAY 15, 2017</small>
                            </p>
                            <p>Novum formidines congressus atomorum nam permulta alterum delectatio
                                gaudeat statim. Necessariae dicturam perspexit utrum modo amicitiae
                                malum summumque, multis ante iudicia desiderat, civitas iudicare
                                attingere, amori perpaulum mediocrium, dicere notae litteras
                                plusque appareat, remotis fama futurove quandam assentiar integre
                                poenis. </p>
                            <a class="btn btn-primary btn-outline card-link" href="#">Read More</a>
                        </div>                                           
                    </div>
                </li>
            </ul>


        </div>
        <div class="col-12 col-md-6 mt-3">
            <div class="card">                           
                <div class="card-body">
                    <div class="text-center">
                        <span class="bg-primary text-uppercase text-white py-2 px-3 rounded">Today</span>
                    </div>
                    <div class="row timeline position-relative">
                        <div class="col-12 col-md-6 text-left text-lg-right">
                            <div class="py-0 py-xl-5">
                                <small class="font-weight-bold">09:45  AM</small>
                                <span class="text-uppercase text-primary d-block">Lorem ipsum dolor sit</span>
                                <h5 class="text-uppercase">amet, consectetuer adipiscing elit</h5>
                                <p>Nullam quis risus eget urna mollis ornare vel eu leo. Donec ullamcorper nulla non metus auctor fringilla</p>
                                <div class="card text-white">
                                    <div class="card-body bg-primary rounded">
                                        <div class="follow">
                                            <ul class="list-inline text-center mb-0">
                                                <li class="list-inline-item">
                                                    <div class="counter-box">
                                                        <h2 class="counter_number mb-0 text-white font-weight-bold">51</h2>
                                                        <small class="text-uppercase">following</small>
                                                    </div>
                                                </li>
                                                <li class="list-inline-item">
                                                    <div class="counter-box">
                                                        <h3 class="counter_number mb-0 text-white font-weight-bold">20</h3>
                                                        <small class="text-uppercase">comments</small>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="py-5">
                                <small class="font-weight-bold">08:20  AM</small>
                                <span class="text-uppercase text-primary d-block">montes, nascetur ridiculus </span>
                                <h5 class="text-uppercase">Nulla consequat massa quis enim</h5>
                                <p>Nullam quis risus eget urna mollis ornare vel eu leo. Donec ullamcorper nulla non metus auctor fringilla</p>
                                <div class="card text-white text-left">
                                    <div class="card-body bg-primary rounded">
                                        <a href="#"><h6 class="text-white mb-0" data-toggle="collapse" data-target="#demo2">Reply To Monica P. <span class="float-right"><i class="icofont icofont-caret-down"></i></span></h6> <span class="text-white">7:51 Pm</span></a>
                                        <p class="mb-0 py-3">Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum fermentum.</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="pt-5 mt-0 mt-xl-5">
                                <div class="timeline-point timeline-point2  position-relative"></div>
                                <small class="font-weight-bold">03:15 PM </small>
                                <span class="text-uppercase text-primary d-block">commodo ligula eget</span>
                                <h5 class="text-uppercase">Aenean massa Cum sociis natoque</h5>
                                <p>Nullam quis risus eget urna mollis ornare vel eu leo. Donec ullamcorper nulla non metus auctor fringilla</p>
                            </div>
                            <div class="pt-5 pt-xl-0">
                                <div class="timeline-point timeline-point2  position-relative"></div>
                                <small class="font-weight-bold">06:31 PM </small>
                                <span class="text-uppercase text-primary d-block">et magnis dis parturient</span>
                                <h5 class="text-uppercase">Donec quam felis pellentesque</h5>
                                <p>Nullam quis risus eget urna mollis ornare vel eu leo. Donec ullamcorper nulla non metus auctor fringilla</p>
                                <div class="card  text-white">
                                    <div class="card-body bg-primary rounded">
                                        <div class="follow">
                                            <ul class="list-inline text-center mb-0">
                                                <li class="list-inline-item">
                                                    <div class="counter-box">
                                                        <h2 class="counter_number mb-0 text-white font-weight-bold">465</h2>
                                                        <small class="text-uppercase">following</small>
                                                    </div>
                                                </li>
                                                <li class="list-inline-item position-relative">
                                                    <div class="counter-box">
                                                        <h3 class="counter_number mb-0 text-white font-weight-bold">350</h3>
                                                        <small class="text-uppercase">comments</small>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-5">
                                <div class="timeline-point timeline-point2  position-relative"></div>
                                <small class="font-weight-bold">10:59 PM </small>
                                <span class="text-uppercase text-primary d-block">NEW EVENT POSTED</span>
                                <h5 class="text-uppercase">DTAIL STUDIO PORTFOLIO REVIEW</h5>
                                <p>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum fermentum.</p>
                            </div>
                        </div>
                    </div>
                </div>                                
            </div>
        </div>
    </div>
    <!-- END: Card DATA-->
<?= $this->endSection() ?>



